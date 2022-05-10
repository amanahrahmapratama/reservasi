<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'User_model', 'customer/Customer_model',
            'wilayah/Wilayah_model', 'sale/Sale_model',
            'catalog/Catalog_model', 'posting/Posting_model',
            'reservasi/Reservasi_model',
        ));
        $this->id = $this->session->userdata('user_id_customer');
        if (!$this->session->userdata('logged_customer')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        if (!$this->session->userdata('logged_customer')) {
            header("Location:" . site_url('auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>', '</div>');
        $data['edit'] = false;
        $data['cpw']  = false;

        if ($this->input->post('edit', true)) {
            $this->form_validation->set_rules('inputName', 'Nama Lengkap', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputAlamat', 'Alamat', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputEmail', 'Email', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputHp', 'Nomor Hp', 'trim|required|xss_clean');
            if ($this->form_validation->run()) {

                $params['customer_id']        = $this->id;
                $params['customer_full_name'] = $this->input->post('inputName', true);
                $params['customer_address']   = $this->input->post('inputAlamat', true);
                $params['customer_email']     = $this->input->post('inputEmail', true);
                $params['customer_phone']     = $this->input->post('inputHp', true);
                $this->Customer_model->add($params);

                $this->session->set_flashdata('success', 'Berhasil edit profil');
                redirect('user');
            } else {
                $data['edit'] = true;
            }

        } elseif ($this->input->post('cpw', true)) {
            $this->form_validation->set_rules('inputPasswordOld', 'Password Lama', 'required|callback_check_current_password');
            $this->form_validation->set_rules('inputPassword', 'Password Baru', 'required|min_length[6]');
            $this->form_validation->set_rules('inputPasswordConf', 'Konfirmasi Password Baru', 'required|matches[inputPassword]');
            if ($this->form_validation->run()) {
                $params['customer_id']          = $this->id;
                $params['customer_password']    = password_hash($this->input->post('inputPassword'), PASSWORD_BCRYPT);
                $params['customer_last_update'] = date('Y-m-d H:i:s');

                $ret = $this->Customer_model->add($params);

                $this->session->set_flashdata('success', 'Berhasil mengganti password');
                redirect('user');
            } else {
                $data['cpw'] = true;
            }
        }

        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

        $data['popular_post'] = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
        $data['user']         = $this->Customer_model->get(array('id' => $this->id));
        $data['title']        = 'Profil';
        $data['page']         = 'public/profile';
        $this->load->view('layout', $data);
    }

    public function transaction()
    {
        if (!$this->session->userdata('logged_customer')) {
            header("Location:" . site_url('auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }

        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

        $this->load->library('pagination');
        $params['customer_id'] = $this->id;
        $params['limit']       = 7;
        $data['transaction']   = $this->Sale_model->get_sale($params);
        $config['uri_segment'] = 4;
        $config['per_page']    = 7;
        $config['base_url']    = site_url('user/transaction/index');
        $config['total_rows']  = count($this->Sale_model->get_sale(array('customer_id' => $this->id)));
        $this->pagination->initialize($config);

        $data['popular_post'] = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
        $data['title']        = 'Transaksi';
        $data['page']         = 'public/transaction';
        $this->load->view('layout', $data);
    }

    public function view_transaction($id = null)
    {
        if (!$this->session->userdata('logged_customer')) {
            header("Location:" . site_url('auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }

        if ($id == null) {
            redirect('user/transaction');
        }

        if ($this->input->post('confirmation', true)) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('inputTransferDate', 'Tanggal Transfer', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputTransferName', 'Tanggal Transfer', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputTransferTo', 'No Rekening TUjuan', 'trim|required|xss_clean');
            if (empty($_FILES['inputFile']['name'])) {
                $this->form_validation->set_rules('inputFile', 'Bukti Transfer', 'trim|required|xss_clean');
            }
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>', '</div>');

            if ($_POST && $this->form_validation->run() == true) {
                $params['sale_status_id'] = 3;
                $params['sale_id']        = $id;
                $params['transfer_date']  = $this->input->post('inputTransferDate', true);
                $params['transfer_to']    = $this->input->post('inputTransferTo', true);
                $params['transfer_name']  = $this->input->post('inputTransferName', true);
                $params['transfer_file']  = $this->do_upload_transfer('inputFile');

                $this->Sale_model->add($params);

                $params['sale']      = $this->Sale_model->get_sale(array('id' => $id));
                $params['sale_item'] = $this->Sale_model->get_sale_item(array('sale_id' => $id));

                $rekening                 = $this->setting->general();
                $params['address_office'] = $rekening['address']['setting_value'];

                // Sent mail into Customer
                $getEmailSett = $this->setting->email();

                $this->email->set_mailtype('html');
                $this->email->from($getEmailSett['email_from']['setting_value'], $getEmailSett['email_from_name']['setting_value']);
                $this->email->to($params['sale']['customer_email']);
                $this->email->subject('Konfirmasi Pembayaran #' . $params['sale']['sale_inv_num']);
                $mail_body = $this->load->view('email/email_payment_to_buyer', array('params' => $params), true);
                $this->email->message($mail_body);
                $this->email->send();

                // Sent mail into Admin
                $this->email->set_mailtype('html');
                $this->email->from($getEmailSett['email_from']['setting_value'], $getEmailSett['email_from_name']['setting_value']);
                $this->email->to($this->config->item('email_admin'));
                $this->email->subject('Konfirmasi Pembayaran');
                $mail_body = $this->load->view('email/email_payment_to_admin', array('params' => $params), true);
                $this->email->message($mail_body);
                $this->email->send();

                $this->session->set_flashdata('success', 'Berhasil konfirmasi pembayaran');

                redirect(current_url());

            }

        }

        $data['sale'] = $this->Sale_model->get_sale(array('id' => $id));
        if (count($data['sale']) == 0) {
            redirect('user/transaction');
        }
        if ($data['sale']['customer_customer_id'] != $this->session->userdata('user_id_customer')) {
            $this->session->set_flashdata('success', 'Tidak ada data');
            redirect('user/transaction');
        }

        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

        $data['sale_item'] = $this->Sale_model->get_sale_item(array('sale_id' => $id));

        $rekening = $this->setting->general();

        $data['rekening_1']   = $rekening['bank_1']['setting_value'];
        $data['rekening_2']   = $rekening['bank_2']['setting_value'];
        $data['rekening_3']   = $rekening['bank_3']['setting_value'];
        $data['popular_post'] = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
        $data['title']        = 'Detail Transaksi';
        $data['page']         = 'public/view_transaction';
        $this->load->view('layout', $data);
    }

    public function confirmAccepted()
    {
        if ($this->Sale_model->get(array('id' => $this->input->post('sale_id'))) == null) {
            redirect('user/transaction');
        }

        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

        $params['sale_id']        = $this->input->post('sale_id');
        $params['customer_id']    = $this->id;
        $params['sale_status_id'] = 6;
        $this->Sale_model->add($params);
        $this->session->set_flashdata('success', 'Konfirmasi barang diterima berhasil');
        redirect('user/transaction');
    }

    public function check_current_password()
    {
        $id   = $this->id;
        $pass = $this->input->post('inputPasswordOld');
        $user = $this->Customer_model->get(array('id' => $id));

        if (password_verify($pass, $user['customer_password'])) {
            return true;
        } else {
            $this->form_validation->set_message('check_current_password', 'The Old password did not match with the current password');
            return false;
        }
    }

    public function confirmation($offset = null)
    {
        if (!$this->session->userdata('logged_customer')) {
            header("Location:" . site_url('auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }

        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

        $params['status']      = 1;
        $params['customer_id'] = $this->id;
        $data['unconfirmed']   = $this->Sale_model->get_sale($params);
        $data['popular_post']  = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
        $data['title']         = 'Confirmation';
        $data['page']          = 'public/confirmation';
        $this->load->view('layout', $data);
    }

    public function view_confirmation($id = null)
    {
        if (!$this->session->userdata('logged_customer')) {
            header("Location:" . site_url('auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }

        if ($id == null) {
            redirect('user/confirmation');
        }

        if ($this->input->post('confirmation', true)) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('inputTransferDate', 'Tanggal Transfer', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputTransferName', 'Tanggal Transfer', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputTransferTo', 'No Rekening TUjuan', 'trim|required|xss_clean');
            if (empty($_FILES['inputFile']['name'])) {
                $this->form_validation->set_rules('inputFile', 'Bukti Transfer', 'trim|required|xss_clean');
            }
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>', '</div>');

            if ($this->form_validation->run()) {
                $params['sale_status']   = 3;
                $params['id']            = $id;
                $params['transfer_date'] = $this->input->post('inputTransferDate', true);
                $params['transfer_to']   = $this->input->post('inputTransferTo', true);
                $params['transfer_name'] = $this->input->post('inputTransferName', true);
                $params['transfer_file'] = $this->do_upload_transfer('inputFile');

                $this->Sale_model->add($params);

                $params['sale']      = $this->Sale_model->get_sale(array('id' => $id));
                $params['sale_item'] = $this->Sale_model->get_sale_item(array('sale_id' => $id));

                $rekening                 = $this->setting->general();
                $params['address_office'] = $rekening['address']['setting_value'];

                // Sent mail into Customer
                $getEmailSett = $this->setting->email();

                $this->email->set_mailtype('html');
                $this->email->from($getEmailSett['email_from']['setting_value'], $getEmailSett['email_from_name']['setting_value']);
                $this->email->to($params['sale']['customer_email']);
                $this->email->subject('Konfirmasi Pembayaran #' . $params['sale']['sale_inv_num']);
                $mail_body = $this->load->view('email/email_payment_to_buyer', array('params' => $params), true);
                $this->email->message($mail_body);
                $this->email->send();

                // Sent mail into Admin
                $this->email->set_mailtype('html');
                $this->email->from($getEmailSett['email_from']['setting_value'], $getEmailSett['email_from_name']['setting_value']);
                $this->email->to($this->config->item('email_admin'));
                $this->email->subject('Pembelian Baru');
                $mail_body = $this->load->view('email/email_payment_to_admin', array('params' => $params), true);
                $this->email->message($mail_body);
                $this->email->send();

                $this->session->set_flashdata('success', 'Berhasil konfirmasi pembayaran');

                redirect(current_url());

            }

        }

        $data['sale'] = $this->Sale_model->get_sale(array('id' => $id));
        if (count($data['sale']) == 0) {
            redirect('user/confirmation');
        }
        if ($data['sale']['customer_customer_id'] != $this->session->userdata('user_id_customer')) {
            $this->session->set_flashdata('success', 'Tidak ada data');
            redirect('user/confirmation');
        }

        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

        $data['sale_item'] = $this->Sale_model->get_sale_item(array('sale_id' => $id));

        $rekening = $this->setting->general();

        $data['rekening_1']   = $rekening['bank_1']['setting_value'];
        $data['rekening_2']   = $rekening['bank_2']['setting_value'];
        $data['rekening_3']   = $rekening['bank_3']['setting_value'];
        $data['popular_post'] = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
        $data['title']        = 'View Confirmation';
        $data['page']         = 'public/view_confirmation';
        $this->load->view('layout', $data);
    }

    public function do_upload_transfer($input = 'inputFile')
    {
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|pdf';
        $this->load->library('upload', $config);

        $this->upload->do_upload($input);
        $data = $this->upload->data();

        return $data['file_name'];

    }

    public function view_cart()
    {

        if ($this->input->post('checkout', true)) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('inputName', 'Nama Penerima', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputPhone', 'Nomor Telepon', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputProvince', 'Povinsi', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputKabupaten', 'Kabupaten', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputAddress', 'Alamat Lengkap', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputPostCode', 'Kode POS', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputCourier', 'Kurir', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputService', 'Layanan', 'trim|required|xss_clean');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>', '</div>');
            if ($this->form_validation->run()) {

                if ($this->cart->total_items() == 0) {
                    $this->session->set_flashdata('success', 'Anda harus melakukan pembelian terlebih dahulu');
                    redirect();
                }

                $ret = $this->checkout();

                $this->cart->destroy();

                $this->session->set_flashdata('success', 'Berhasil Checkout Belanja');
                redirect('user/transaction/view/' . $ret);

            }
        } elseif ($this->input->post()) {
            $this->update_cart();
            $this->session->set_flashdata('success', 'Update keranjang belanja berhasil');
            redirect(current_url());
        }

        if ($this->input->get('id', true) != '' and $this->input->get('count', true) == 0) {
            $this->delete_item($this->input->get('id', true));
            redirect('user/cart/view');
        }

        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

        $data['popular_post'] = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
        $data['title']        = 'Shopping Cart';
        $data['page']         = 'public/view_cart';
        $this->load->view('layout', $data);
    }

    public function update_cart($id = null)
    {

        unset($_POST['update_cart']);
        $content = $this->input->post();
        foreach ($content as $key) {
            $info = array(
                'rowid' => $key['rowid'],
                'qty'   => $key['qty'],
            );

            $this->cart->update($info);
        }
    }

    public function checkout()
    {
        if (!$this->session->userdata('logged_customer')) {
            header("Location:" . site_url('auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        if ($this->cart->total_items() == 0) {
            $this->session->set_flashdata('success', 'Anda belum melakukan belanja');
            redirect('user/cart/view');
        }

        $province = $this->input->post('inputProvince', true);
        $province = explode('-', $province);

        $kabupaten = $this->input->post('inputKabupaten', true);
        $kabupaten = explode('-', $kabupaten);

        $params['sale_date']        = date('Y-m-d H:i:s');
        $params['customer_id']      = $this->session->userdata('user_id_customer');
        $params['shipping_address'] = $this->input->post('inputAddress', true);

        $params['ongkir']    = $this->input->post('inputOngkir', true);
        $params['province']  = $province[1];
        $params['kabupaten'] = $kabupaten[1];
        $params['courier']   = $this->input->post('inputCourier', true);
        $params['service']   = $this->input->post('inputService', true);

        $params['sale_status_id']   = 1;
        $params['sale_total_price'] = $this->cart->total();
        $params['recipient_name']   = $this->input->post('inputName', true);
        $params['recipient_phone']  = $this->input->post('inputPhone', true);
        $params['postal_code']      = $this->input->post('inputPostCode', true);

        $params['sale_created_date'] = date('Y-m-d H:i:s');

        $ret = $this->Sale_model->add($params);

        $inv_num = 'INV/' . date('Y') . '/' . date('m') . '/' . $ret;
        $this->Sale_model->add(array('sale_id' => $ret, 'sale_inv_num' => $inv_num));

        if ($this->cart->total_items() > 0) {
            $item['sale_id'] = $ret;
            foreach ($this->cart->contents() as $key) {
                $item['catalog_id']       = $key['id'];
                $item['sale_count']       = $key['qty'];
                $item['sale_price']       = $key['price'];
                $item['sale_total_price'] = $key['subtotal'];

                $this->Sale_model->add_sale_item($item);

                $virtual['catalog_id']             = $key['id'];
                $virtual['decrease_virtual_stock'] = $key['qty'];
                $this->Catalog_model->add($virtual);
            }
        }

        $params['inv_num']      = $inv_num;
        $params['cart_content'] = $this->Sale_model->get_sale_item(array('sale_id' => $ret));

        $params['sale'] = $this->Sale_model->get_sale(array('id' => $ret));

        $setting                  = $this->setting->general();
        $params['address_office'] = $setting['address']['setting_value'];

        // Sent mail into Customer
        $getEmailSett = $this->setting->email();

        $this->email->set_mailtype('html');
        $this->email->from($getEmailSett['email_from']['setting_value'], $getEmailSett['email_from_name']['setting_value']);
        $this->email->to($params['sale']['customer_email']);
        $this->email->subject('Invoice #' . $inv_num);
        $mail_body = $this->load->view('email/email_checkout_to_buyer', array('params' => $params), true);
        $this->email->message($mail_body);
        $this->email->send();

        // Sent mail into Admin
        $this->email->set_mailtype('html');
        $this->email->from($getEmailSett['email_from']['setting_value'], $getEmailSett['email_from_name']['setting_value']);
        $this->email->to($this->config->item('email_admin'));
        $this->email->subject('Pembelian Baru');
        $mail_body = $this->load->view('email/email_checkout_to_admin', array('params' => $params), true);
        $this->email->message($mail_body);
        $this->email->send();

        return $ret;
    }

    public function delete_item($id = null)
    {

        $info = array(
            'rowid' => $id,
            'qty'   => 0,
        );

        $this->cart->update($info);

    }

    public function pending($offset = null)
    {
        if (!$this->session->userdata('logged_customer')) {
            header("Location:" . site_url('auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $data['title']         = 'Pending Transactions';
        $data['page']          = 'public/pending';
        $params['customer_id'] = $this->session->userdata('user_id_customer');
        $params['status']      = STATUS_PAYMENT_CONFIRMED;

        $this->load->library('pagination');

        $config['base_url']    = site_url('user/pending');
        $config['total_rows']  = count($this->Sale_model->get_sale($params));
        $config['per_page']    = 5;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);

        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

        $params['limit']      = 5;
        $params['offset']     = $offset;
        $data['pending']      = $this->Sale_model->get_sale($params);
        $data['popular_post'] = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
        $this->load->view('layout', $data);
    }

    public function view_pending($id = null)
    {
        if (!$this->session->userdata('logged_customer')) {
            $this->session->set_flashdata('success', 'Anda harus login untuk mengakses halaman tersebut');
            redirect();
        }

        $params['id']          = $id;
        $params['customer_id'] = $this->session->userdata('user_id_customer');
        $data['history']       = $this->Sale_model->get_sale($params);

        if (count($data['history']) == 0) {
            $this->session->set_flashdata('success', 'Data kosong');
            redirect('user/pending');
        }

        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

        $data['sale_item']    = $this->Sale_model->get_sale_item(array('sale_id' => $id));
        $data['popular_post'] = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
        $data['title']        = 'View Pending Payment Confirmation';
        $data['page']         = 'public/view_pending';

        $this->load->view('layout', $data);
    }

    public function history($offset = null)
    {
        if (!$this->session->userdata('logged_customer')) {
            header("Location:" . site_url('auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }

        $data['title']         = 'Histori Transaksi';
        $data['page']          = 'public/history';
        $params['customer_id'] = $this->session->userdata('user_id_customer');
        $params['status']      = STATUS_COMPLETED;
        $params['limit']       = 7;

        $this->load->library('pagination');

        $config['base_url']    = site_url('user/history/index');
        $config['total_rows']  = count($this->Sale_model->get_sale($params));
        $config['per_page']    = 7;
        $config['uri_segment'] = 4;
        $this->pagination->initialize($config);

        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

        $params['limit']      = 5;
        $params['offset']     = $offset;
        $data['history']      = $this->Sale_model->get_sale($params);
        $data['popular_post'] = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
        $this->load->view('layout', $data);
    }

    public function view_history($id = null)
    {
        if (!$this->session->userdata('logged_customer')) {
            $this->session->set_flashdata('success', 'Anda harus login untuk mengakses halaman tersebut');
            redirect();
        }

        $params['id']          = $id;
        $params['customer_id'] = $this->session->userdata('user_id_customer');
        $data['history']       = $this->Sale_model->get_sale($params);

        if (count($data['history']) == 0) {
            $this->session->set_flashdata('success', 'Data kosong');
            redirect('user/history');
        }

        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

        $data['sale_item'] = $this->Sale_model->get_sale_item(array('sale_id' => $id));

        $data['title']        = 'Detail Histori Transaksi';
        $data['page']         = 'public/view_history';
        $data['popular_post'] = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
        $this->load->view('layout', $data);
    }

    public function try_catch()
    {
        $id                = 8;
        $data['sale']      = $this->Sale_model->get_sale(array('id' => $id));
        $data['sale_item'] = $this->Sale_model->get_sale_item(array('sale_id' => $id));

        $this->load->view('email/confirmation_to_customer', $data);
    }

    public function reservasi()
    {
        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $this->load->library('pagination');

        $params['customer_id'] = $this->id;

        $config['base_url']             = current_url();
        $config['total_rows']           = count($this->Reservasi_model->get());
        $config['per_page']             = 10;
        $config['page_query_string']    = true;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);

        $params['limit']  = $config['per_page'];
        $params['offset'] = $this->input->get('page');

        $data['reservasi'] = $this->Reservasi_model->get($params);

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

        $data['user']  = $this->Customer_model->get(array('id' => $this->id));
        $data['title'] = 'Reservasi Anda';
        $data['page']  = 'public/reservasi';
        $this->load->view('layout', $data);
    }

    public function view_reservasi($id = null)
    {
        if (is_null($id)) {
            redirect('user/reservasi');
        }
        $params['id']          = $id;
        $params['customer_id'] = $this->id;
        $reservasi             = $this->Reservasi_model->get($params);
        if (count($reservasi) == 0) {
            redirect('user/reservasi');
        }

        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

        $data['reservasi'] = $reservasi;

        $data['title'] = 'Detail Reservasi Ruangan';
        $data['page']  = 'public/view_reservasi';
        $this->load->view('layout', $data);
    }

    public function edit_reservasi($id = null)
    {
        if (is_null($id)) {
            redirect('user/reservasi');
        }
        $params['id']          = $id;
        $params['customer_id'] = $this->id;
        $reservasi             = $this->Reservasi_model->get($params);

        if (count($reservasi) == 0) {
            redirect('user/reservasi');
        }

        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('inputJenis', 'Jenis Kegiatan', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputDateStart', 'Tanggal Mulai', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputDateEnd', 'Tanggal Selesai', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputAttendance', 'Perkiraan Jumlah Peserta', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputOtherRequest', 'Kebutuhan Lainnya', 'trim|xss_clean');
            if ($_FILES['inputFile']['name'] != '') {
                $this->form_validation->set_rules('inputFile', 'Scan Surat Permohonan', 'trim|xss_clean|callback_check_request_file');
            }
            if ($_FILES['inputProposal']['name'] != '') {
                $this->form_validation->set_rules('inputProposal', 'Scan Proposal', 'trim|xss_clean|callback_check_proposal_file');
            }
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            if ($this->form_validation->run()) {
                $params['id']            = $id;
                $params['jenis']         = $this->input->post('inputJenis', true);
                $params['date_start']    = $this->input->post('inputDateStart', true);
                $params['date_end']      = $this->input->post('inputDateEnd', true);
                $params['attendance']    = $this->input->post('inputAttendance', true);
                $params['other_request'] = $this->input->post('inputOtherRequest', true);
                $params['customer_id']   = $this->session->userdata('user_id_customer');
                // $params['catalog_id']    = $id;
                $params['status_id']   = STATUS_NEW;
                $params['position_id'] = POSITION_KAMUS;
                $params['created_at']  = date('Y-m-d H:i:s');
                $params['updated_at']  = date('Y-m-d H:i:s');

                $ret          = $this->Reservasi_model->add($params);
                $params['id'] = $ret;
                if ($_FILES['inputFile']['name'] != '') {
                    $params['request_file'] = $this->do_upload('inputFile', $ret);
                }
                if ($_FILES['inputProposal']['name'] != '') {
                    $params['proposal_file'] = $this->do_upload('inputProposal', $ret);
                }

                $ret = $this->Reservasi_model->add($params);

                $this->load->library('sendMail');

                $data['nama']             = $this->session->userdata('user_full_name_customer');
                $data['email']            = $this->session->userdata('user_email_customer');
                $data['nama_ruangan']     = $reservasi['catalog_name'];
                $data['date_start']       = $params['date_start'];
                $data['date_end']         = $params['date_end'];
                $data['type']             = $params['jenis'];
                $data['estimasi_peserta'] = $params['attendance'];

                $tanggal = 'Tanggal ' . pretty_date($params['date_start'], ' d F Y', false) . ' s.d ' . pretty_date($params['date_start'], ' d F Y', false);
                $this->sendmail->send($data['email'], 'Update Reservasi Ruangan Museum ' . $tanggal, $data, 'email/update_reservasi_to_customer');

                $admin    = $this->User_model->get();
                $adminArr = array();
                foreach ($admin as $key) {
                    $adminArr[] = $key['user_email'];
                }

                if (count($adminArr) > 0) {
                    $this->sendmail->send($adminArr, 'Update Reservasi Ruangan Museum ' . $tanggal, $data, 'email/update_reservasi_to_admin');
                }

                $this->session->set_flashdata('success', 'Berhasil submit permohonan pinjam ruangan');
                redirect('user/reservasi/view/' . $ret);
            }
        }

        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

        $data['reservasi'] = $reservasi;

        $data['title'] = 'Detail Reservasi Ruangan';
        $data['page']  = 'public/add_reservasi';
        $this->load->view('layout', $data);
    }

    public function do_upload($field = 'inputFile', $id = null)
    {
        $config['upload_path'] = './uploads/reservasi/' . $id . '/';
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true);
        }
        $config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG|pdf|PDF';

        $this->load->library('upload', $config);
        $this->upload->do_upload($field);

        $data = $this->upload->data();

        return $data['file_name'];
    }

    public function check_request_file()
    {
        $allowed = $this->check_image_extension('inputFile');
        if (!$allowed) {
            $this->form_validation->set_message('check_request_file', 'The file extension that you uploaded is not allowed');
            return false;
        }

        return true;
    }

    public function check_proposal_file()
    {
        $allowed = $this->check_image_extension('inputProposal');
        if (!$allowed) {
            $this->form_validation->set_message('check_proposal_file', 'The file extension that you uploaded is not allowed');
            return false;
        }

        return true;
    }

    public function check_image_extension($field)
    {
        $allowed = true;

        $allowedExts  = array("jpeg", "jpg", "png", "JPG", "JPEG", "PNG", "pdf", "PDF");
        $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG);
        $extension    = pathinfo($_FILES[$field]["name"], PATHINFO_EXTENSION);
        $detectedType = exif_imagetype($_FILES[$field]['tmp_name']);
        $type         = $_FILES[$field]['type'];

        if (!in_array($extension, $allowedExts)) {
            $allowed = false;
        }

        return $allowed;
    }

}

/* End of file User.php */
/* Location: .//Applications/MAMP/htdocs/jatayu/storeapp/modules/user/controllers/User.php */
