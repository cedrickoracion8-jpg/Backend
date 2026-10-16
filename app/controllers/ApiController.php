<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ApiController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->library('api');
    }

    public function login()
    {
        $this->api->require_method('POST');
        $input    = $this->api->body();
        $username = is_string($input['username'] ?? null) ? $input['username'] : '';
        $password = is_string($input['password'] ?? null) ? $input['password'] : '';

        $stmt = $this->db->raw('SELECT * FROM users WHERE username = ?', [$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && !empty($user['is_active']) && password_verify($password, $user['password'])) {
            $tokens = $this->api->issue_tokens([
                'id'   => $user['id'],
                'role' => $user['role'],
            ]);
            $this->api->respond($tokens);
        } else {
            $this->api->respond_error('Invalid credentials', 401);
        }
    }

    public function register()
    {
        $this->api->require_method('POST');
        $input = $this->api->body();

        $username = trim(is_string($input['username'] ?? null) ? $input['username'] : '');
        $email = trim(is_string($input['email'] ?? null) ? $input['email'] : '');
        $password = $input['password'] ?? '';

        if ($username === '' || strlen($username) > 100) {
            $this->api->respond_error('Username is required and must be 100 characters or fewer', 422);
        }

        if (strlen($email) > 255 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->api->respond_error('A valid email is required', 422);
        }

        if (!is_string($password) || strlen($password) < 8) {
            $this->api->respond_error('Password must be at least 8 characters', 422);
        }

        $existing = $this->db->raw(
            'SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1',
            [$username, $email]
        )->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            $this->api->respond_error('Username or email already exists', 409);
        }

        $this->db->raw(
            'INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())',
            [$username, $email, password_hash($password, PASSWORD_BCRYPT), 'user']
        );

        $this->api->respond(['message' => 'User registered'], 201);
    }

    public function logout()
    {
        $this->api->require_method('POST');
        $this->api->require_jwt();
        $input = $this->api->body();
        $refreshToken = $input['refresh_token'] ?? '';
        if (!is_string($refreshToken) || $refreshToken === '') {
            $this->api->respond_error('Refresh token is required', 422);
        }
        $this->api->revoke_refresh_token($refreshToken);
        $this->api->respond(['message' => 'Logged out']);
    }

    public function list()
    {
        $this->require_admin();
        $this->api->rate_limit();

        $users = $this->db->table('users')
                          ->select('id, username, email, role, created_at')
                          ->get_all();
        $this->api->respond($users);
    }

    public function create()
    {
        $this->api->require_method('POST');
        $this->require_admin();
        $input = $this->api->body();

        $username = trim(is_string($input['username'] ?? null) ? $input['username'] : '');
        $email = trim(is_string($input['email'] ?? null) ? $input['email'] : '');
        $password = $input['password'] ?? '';
        $role = $input['role'] ?? 'user';

        if ($username === '' || strlen($username) > 100) {
            $this->api->respond_error('Username is required and must be 100 characters or fewer', 422);
        }
        if (strlen($email) > 255 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->api->respond_error('A valid email is required', 422);
        }
        if (!is_string($password) || strlen($password) < 8) {
            $this->api->respond_error('Password must be at least 8 characters', 422);
        }
        if (!in_array($role, ['admin', 'user'], true)) {
            $this->api->respond_error('Role must be admin or user', 422);
        }
        if ($this->user_exists($username, $email)) {
            $this->api->respond_error('Username or email already exists', 409);
        }

        $this->db->raw(
            "INSERT INTO users (username, email, password, role, created_at)
             VALUES (?, ?, ?, ?, NOW())",
            [
                $username,
                $email,
                password_hash($password, PASSWORD_BCRYPT),
                $role,
            ]
        );

        $this->api->respond(['message' => 'User created'], 201);
    }

    public function update($id)
    {
        $this->api->require_method('PUT');
        $this->require_admin();
        $input = $this->api->body();
        $id = $this->validated_id($id);

        $username = trim(is_string($input['username'] ?? null) ? $input['username'] : '');
        $email = trim(is_string($input['email'] ?? null) ? $input['email'] : '');
        $role = $input['role'] ?? '';
        if ($username === '' || strlen($username) > 100) {
            $this->api->respond_error('Username is required and must be 100 characters or fewer', 422);
        }
        if (strlen($email) > 255 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->api->respond_error('A valid email is required', 422);
        }
        if (!in_array($role, ['admin', 'user'], true)) {
            $this->api->respond_error('Role must be admin or user', 422);
        }
        if ($this->user_exists($username, $email, $id)) {
            $this->api->respond_error('Username or email already exists', 409);
        }
        if (!$this->row_exists('users', $id)) {
            $this->api->respond_error('User not found', 404);
        }

        $this->db->raw(
            "UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?",
            [$username, $email, $role, $id]
        );

        $this->api->respond(['message' => 'User updated']);
    }

    public function delete($id)
    {
        $this->api->require_method('DELETE');
        $this->require_admin();
        $id = $this->validated_id($id);
        if (!$this->row_exists('users', $id)) {
            $this->api->respond_error('User not found', 404);
        }
        $this->db->raw('DELETE FROM users WHERE id = ?', [$id]);
        $this->api->respond(['message' => 'User deleted']);
    }

    public function profile()
    {
        $auth = $this->api->require_jwt();

        $stmt = $this->db->raw(
            "SELECT id, username, email, role, created_at, is_active FROM users WHERE id = ?",
            [$auth['sub']]
        );
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || empty($user['is_active'])) {
            $this->api->respond_error('Unauthorized', 401);
        }

        unset($user['is_active']);
        $this->api->respond($user);
    }

    public function refresh()
    {
        $this->api->require_method('POST');
        $input = $this->api->body();
        $refreshToken = is_string($input['refresh_token'] ?? null) ? $input['refresh_token'] : '';
        $payload = $this->api->validate_jwt($refreshToken);
        if (!$payload || ($payload['type'] ?? '') !== 'refresh') {
            $this->api->respond_error('Invalid refresh token', 403);
        }

        $user = $this->db->raw(
            'SELECT id, role, is_active FROM users WHERE id = ? LIMIT 1',
            [$payload['sub']]
        )->fetch(PDO::FETCH_ASSOC);
        if (!$user || empty($user['is_active'])) {
            $this->api->respond_error('User not found', 401);
        }

        $this->api->refresh_access_token($refreshToken, $user);
    }

    public function products()
    {
        $auth = $this->api->require_jwt();
        $userId = $this->validated_id($auth['sub'] ?? null);
        $activeUser = $this->db->raw(
            'SELECT id FROM users WHERE id = ? AND is_active = 1 LIMIT 1',
            [$userId]
        )->fetch(PDO::FETCH_ASSOC);
        if (!$activeUser) {
            $this->api->respond_error('Unauthorized', 401);
        }
        $this->api->rate_limit();
        $this->api->respond($this->db->table('products')->get_all());
    }

    public function product_create()
    {
        $this->api->require_method('POST');
        $this->require_admin();
        $product = $this->validated_product($this->api->body());
        $this->db->raw(
            'INSERT INTO products (product_name, description, price, quantity) VALUES (?, ?, ?, ?)',
            [$product['product_name'], $product['description'], $product['price'], $product['quantity']]
        );
        $this->api->respond(['message' => 'Product created'], 201);
    }

    public function product_update($id)
    {
        $this->api->require_method('PUT');
        $this->require_admin();
        $id = $this->validated_id($id);
        if (!$this->row_exists('products', $id)) {
            $this->api->respond_error('Product not found', 404);
        }
        $product = $this->validated_product($this->api->body());
        $this->db->raw(
            'UPDATE products SET product_name = ?, description = ?, price = ?, quantity = ? WHERE id = ?',
            [$product['product_name'], $product['description'], $product['price'], $product['quantity'], $id]
        );
        $this->api->respond(['message' => 'Product updated']);
    }

    public function product_delete($id)
    {
        $this->api->require_method('DELETE');
        $this->require_admin();
        $id = $this->validated_id($id);
        if (!$this->row_exists('products', $id)) {
            $this->api->respond_error('Product not found', 404);
        }
        $this->db->raw('DELETE FROM products WHERE id = ?', [$id]);
        $this->api->respond(['message' => 'Product deleted']);
    }

    private function require_admin()
    {
        $auth = $this->api->require_jwt();
        $userId = $this->validated_id($auth['sub'] ?? null);
        $user = $this->db->raw(
            'SELECT id, role, is_active FROM users WHERE id = ? LIMIT 1',
            [$userId]
        )->fetch(PDO::FETCH_ASSOC);
        if (!$user || empty($user['is_active'])) {
            $this->api->respond_error('Unauthorized', 401);
        }
        if (($user['role'] ?? '') !== 'admin') {
            $this->api->respond_error('Administrator access is required', 403);
        }
        return $user;
    }

    private function validated_id($id)
    {
        $id = (string) $id;
        if (!ctype_digit($id) || (int) $id < 1) {
            $this->api->respond_error('A valid id is required', 422);
        }

        return (int) $id;
    }

    private function row_exists($table, $id)
    {
        $stmt = $this->db->raw("SELECT id FROM {$table} WHERE id = ? LIMIT 1", [$id]);
        return (bool) $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function user_exists($username, $email, $exceptId = null)
    {
        $sql = 'SELECT id FROM users WHERE (username = ? OR email = ?)';
        $params = [$username, $email];
        if ($exceptId !== null) {
            $sql .= ' AND id != ?';
            $params[] = $exceptId;
        }
        $sql .= ' LIMIT 1';

        return (bool) $this->db->raw($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }

    private function validated_product(array $input)
    {
        $name = trim(is_string($input['product_name'] ?? null) ? $input['product_name'] : '');
        $description = trim(is_string($input['description'] ?? null) ? $input['description'] : '');
        $price = $input['price'] ?? null;
        $quantity = $input['quantity'] ?? null;

        if ($name === '' || strlen($name) > 100) {
            $this->api->respond_error('Product name is required and must be 100 characters or fewer', 422);
        }
        if (strlen($description) > 255) {
            $this->api->respond_error('Description must be 255 characters or fewer', 422);
        }
        if (!is_scalar($price) || !is_numeric($price) || (float) $price < 0 || (float) $price > 99999999.99) {
            $this->api->respond_error('Price must be a non-negative number', 422);
        }
        if (
            (!is_string($quantity) && !is_int($quantity)) ||
            filter_var($quantity, FILTER_VALIDATE_INT) === false ||
            (int) $quantity < 0 ||
            (float) $quantity > 4294967295
        ) {
            $this->api->respond_error('Quantity must be a non-negative integer', 422);
        }

        return [
            'product_name' => $name,
            'description' => $description,
            'price' => number_format((float) $price, 2, '.', ''),
            'quantity' => (int) $quantity,
        ];
    }
}