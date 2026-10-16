<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: ProductController
 * 
 * Automatically generated via CLI.
 */
class ProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->model('ProductModel');
    }

    public function read()
    {
        $data['products'] = $this->ProductModel->read();
        $data['user_role'] = $this->session->userdata('user_role');
        $data['username'] = $this->session->userdata('username');
        $data['message'] = $this->session->flashdata('notification');
        $this->call->view('product/index', $data);
    }

    public function create()
    {
        $this->require_admin();

        if ($this->form_validation->submitted()) {
            $this->validate_product();
            if ($this->form_validation->run() && $this->valid_quantity($this->io->post('quantity'))) {
                $product_name = $this->io->post('product_name');
                $description = $this->io->post('description');
                $price = $this->io->post('price');
                $quantity = $this->io->post('quantity');
                $this->ProductModel->create($product_name, $description, $price, $quantity);
                $this->session->set_flashdata('notification', 'Product added successfully.');
                header('Location: ' . site_url('/product/display'));
                exit;
            }
        }

        $data['product'] = [
            'product_name' => $this->io->post('product_name') ?? '',
            'description' => $this->io->post('description') ?? '',
            'price' => $this->io->post('price') ?? '',
            'quantity' => $this->io->post('quantity') ?? '',
        ];
        $data['errors'] = $this->product_errors();
        $this->call->view('product/form', $data);
    }

    public function edit($id)
    {
        $this->require_admin();
        $product = $this->ProductModel->find((int) $id);

        if (!$product) {
            show_404();
            return;
        }

        if ($this->form_validation->submitted()) {
            $this->validate_product();

            if ($this->form_validation->run() && $this->valid_quantity($this->io->post('quantity'))) {
                $this->ProductModel->update(
                    (int) $id,
                    $this->io->post('product_name'),
                    $this->io->post('description'),
                    $this->io->post('price'),
                    $this->io->post('quantity')
                );

                $this->session->set_flashdata('notification', 'Product updated successfully.');
                header('Location: ' . site_url('/product/display'));
                exit;
            }
        }

        $data['product'] = $product;
        $data['errors'] = $this->product_errors();
        $this->call->view('product/form', $data);
    }

    public function delete($id)
    {
        $this->require_admin();
        $this->ProductModel->delete((int) $id);
        $this->session->set_flashdata('notification', 'Product deleted successfully.');
        header('Location: ' . site_url('/product/display'));
        exit;
    }

    private function validate_product()
    {
        $this->form_validation
            ->name('product_name')->required()->max_length(100)
            ->name('description')->max_length(255)
            ->name('price')->required()->numeric()->greater_than_equal_to(0)
            ->name('quantity')->required()->numeric()->greater_than_equal_to(0);
    }

    private function require_admin()
    {
        if ($this->session->userdata('user_role') !== 'admin') {
            show_error('403 Forbidden', 'Administrator access is required for this action.', 'error_general', 403);
            exit;
        }
    }

    private function valid_quantity($quantity)
    {
        return is_string($quantity)
            && ctype_digit($quantity)
            && (float) $quantity <= 4294967295;
    }

    private function product_errors()
    {
        $errors = $this->form_validation->get_errors() ?: [];
        if ($this->form_validation->submitted() && !$this->valid_quantity($this->io->post('quantity'))) {
            $errors[] = 'Quantity must be a non-negative whole number.';
        }

        return $errors;
    }
}