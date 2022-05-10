<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Penjualan controllers class
 *
 * @package     GROOT
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Sale_admin extends CI_Controller
{
    public function __construct() {
        parent::__construct(TRUE);
        if ($this->session->userdata('logged_admin') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model(array('Sale_model', 'catalog/Catalog_model', 'activity_log/Activity_log_model', 'customer/Customer_model', 'user/User_model'));
        $this->load->library('upload');
    }

    public function index($offset = NULL)
    {
        $this->load->library('pagination');
        $data['sale'] = $this->Sale_model->get(array('limit' => 10, 'offset' => $offset));
        $config['base_url'] = site_url('admin/sale/index');
        $config['total_rows'] = $this->db->count_all('sale');
        $this->pagination->initialize($config);

        $data['title'] = 'Daftar Penjualan';
        $data['page'] = 'sale/sale_list';
        $this->load->view('admin/layout/main', $data);
    }

    public function expired($offset = NULL)
    {
        $this->load->library('pagination');
        $data['expired'] = $this->Sale_model->get(array('limit' => 10, 'status' => 2, 'order_by' => 'sale_id'));
        $config['base_url'] = site_url('admin/sale/expired/index');
        $config['total_rows'] = count($this->Sale_model->get(array('limit' => 10, 'status' => 2, 'order_by' => 'sale_id')));
        $this->pagination->initialize($config);

        $data['title'] = 'Daftar Transaksi Expired';
        $data['page'] = 'sale/sale_expired';
        $this->load->view('admin/layout/main', $data);
    }

    function view($id = NULL)
    {
        if ($id == null) {
            redirect('admin/sale');
        }
        if ($this->Sale_model->get(array('id' => $id)) == NULL) {
            redirect('admin/sale');
        }
        
        $item = $this->Sale_model->get_sale_item(array('sale_id' => $id));
        
        if(count($item) != 0){
            $data['item'] = $item;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        $data['show_modal_confirmation'] = false;

        if ($this->input->post('confirming', TRUE)) {

            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            if ($this->form_validation->run()) {
                $password = $this->input->post('password');
                
                $params['id'] = $this->session->userdata('user_id_admin');

                $ret = $this->User_model->get($params);

                if (password_verify($password, $ret['user_password'])) {
                    $uptd['sale_id'] = $id;
                    $uptd['sale_status_id'] = STATUS_PAYMENT_CONFIRMED;
                    
                    $this->Sale_model->add($uptd);


                    foreach ($item as $key) {
                        $real['catalog_id'] = $key['catalog_catalog_id'];
                        $real['decrease_real_stock'] = $key['sale_count'];
                        $this->Catalog_model->add($real);
                    }

                    $params['sale'] = $this->Sale_model->get(array('id' => $id));
                    $params['cart_content'] = $this->Sale_model->get_sale_item(array('sale_id' => $id));
                    $params['inv_num'] = $params['sale']['sale_inv_num'];
                    $params['shipping_address'] = $params['sale']['sale_shipping_address'];

                    $params['ongkir'] = $params['sale']['sale_ongkir'];
                    $params['courier'] = $params['sale']['sale_courier'];
                    $params['service'] = $params['sale']['sale_courier_service'];

                    $params['sale_total_price'] = $params['sale']['sale_total_price'];
                    $params['recipient_name'] = $params['sale']['sale_recipient_name'];
                    $params['recipient_phone'] = $params['sale']['sale_recipient_phone'];
                    $params['postal_code'] = $params['sale']['sale_postal_code'];

                    $setting = $this->setting->general();
                    $params['address_office'] = $setting['address']['setting_value'];

                    $getEmailSett = $this->setting->email();

                    $this->email->set_mailtype('html');
                    $this->email->from($getEmailSett['email_from']['setting_value'], $getEmailSett['email_from_name']['setting_value']);
                    $this->email->to($params['sale']['customer_email']);
                    $this->email->subject('Pembayaran #'.$params['sale']['sale_inv_num']. ' Telah dikonfirmasi');
                    $mail_body = $this->load->view('email/email_validate_to_buyer', array('params' => $params), TRUE);
                    $this->email->message($mail_body);
                    $this->email->send();

                    $this->session->set_flashdata('success', 'Berhasil Validasi Konfirmasi Pembayaran');

                    redirect(current_url());
                }else{
                    $data['show_modal_confirmation'] = TRUE;
                }

            }
        } elseif ($this->input->post('tracking', TRUE)) {

            $uptd['sale_id'] = $id;
            $uptd['sale_status_id'] = STATUS_SHIPPED;
            $uptd['tracking_id'] = $this->input->post('tracking_id', TRUE);
            
            $this->Sale_model->add($uptd);

            $params['sale'] = $this->Sale_model->get(array('id' => $id));
            $params['cart_content'] = $this->Sale_model->get_sale_item(array('sale_id' => $id));
            $params['inv_num'] = $params['sale']['sale_inv_num'];
            $params['shipping_address'] = $params['sale']['sale_shipping_address'];
            $params['tracking_id'] = $params['sale']['sale_tracking_id'];

            $params['ongkir'] = $params['sale']['sale_ongkir'];
            $params['courier'] = $params['sale']['sale_courier'];
            $params['service'] = $params['sale']['sale_courier_service'];

            $params['sale_total_price'] = $params['sale']['sale_total_price'];
            $params['recipient_name'] = $params['sale']['sale_recipient_name'];
            $params['recipient_phone'] = $params['sale']['sale_recipient_phone'];
            $params['postal_code'] = $params['sale']['sale_postal_code'];

            $setting = $this->setting->general();
            $params['address_office'] = $setting['address']['setting_value'];

            $getEmailSett = $this->setting->email();

            $this->email->set_mailtype('html');
            $this->email->from($getEmailSett['email_from']['setting_value'], $getEmailSett['email_from_name']['setting_value']);
            $this->email->to($params['sale']['customer_email']);
            $this->email->subject('Barang dengan No. Invoice #'.$params['sale']['sale_inv_num']. ' Telah dikirim');
            $mail_body = $this->load->view('email/email_shipping_to_buyer', array('params' => $params), TRUE);
            $this->email->message($mail_body);
            $this->email->send();

            $this->session->set_flashdata('success', 'Berhasil Kirim Tracking ID');

            redirect(current_url());

        } elseif ($this->input->post('checkout', TRUE)) {

            $this->form_validation->set_rules('inputName', 'Nama Penerima', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputPhone', 'Nomor Telepon', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputProvince', 'Povinsi', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputKabupaten', 'Kabupaten', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputAddress', 'Alamat Lengkap', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputPostCode', 'Kode POS', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputCourier', 'Kurir', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputService', 'Layanan', 'trim|required|xss_clean');
            
            if ($this->form_validation->run()) {

                $province = $this->input->post('inputProvince', TRUE);
                $province = explode('-', $province);

                $kabupaten = $this->input->post('inputKabupaten', TRUE);
                $kabupaten = explode('-', $kabupaten);

                $params['sale_id'] = $id;
                $params['sale_date'] = date('Y-m-d H:i:s');
                $params['shipping_address'] = $this->input->post('inputAddress', TRUE);

                $params['ongkir'] = $this->input->post('inputOngkir', TRUE);
                $params['province'] = $province[1];
                $params['kabupaten'] = $kabupaten[1];
                $params['courier'] = $this->input->post('inputCourier', TRUE);
                $params['service'] = $this->input->post('inputService', TRUE);

                $params['recipient_name'] = $this->input->post('inputName', TRUE);
                $params['recipient_phone'] = $this->input->post('inputPhone', TRUE);
                $params['postal_code'] = $this->input->post('inputPostCode', TRUE);

                $ret = $this->Sale_model->add($params);

                $this->session->set_flashdata('success', 'Berhasil Update Data Pembeli');
                redirect('admin/sale/view/'.$ret);
            }
        } elseif ($this->input->post('setOngkir', TRUE)) {
            $this->form_validation->set_rules('sale_ongkir', 'Ongkos Kirim', 'required|decimal');

            if ($_POST && $this->form_validation->run() == TRUE) {
                $param['sale_id'] = $this->input->post('sale_id');
                $param['ongkir'] = $this->input->post('sale_ongkir');
                $param['sale_last_update'] = date('Y-m-d H:i:s', strtotime('+2 days'));
                $param['sale_status_id'] = STATUS_WAITING_PAYMENT;

                $status = $this->Sale_model->add($param);

                $this->Activity_log_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('user_id_admin'),
                        'log_module' => 'Sale',
                        'log_action' => 'Set Ongkir',
                        'log_info' => 'ID:'.$status.';Tanggal Update:' . $param['sale_last_update']
                    )
                );

                $params['cart_content'] = $this->Sale_model->get_sale_item(array('sale_id' => $id));
                $params['sale'] = $this->Sale_model->get_sale(array('id' => $id));
                $params['inv_num'] = $params['sale']['sale_inv_num'];
                $params['shipping_address'] = $params['sale']['sale_shipping_address'];

                $params['ongkir'] = $params['sale']['sale_ongkir'];
                $params['courier'] = $params['sale']['sale_courier'];
                $params['service'] = $params['sale']['sale_courier_service'];

                $params['sale_total_price'] = $params['sale']['sale_total_price'];
                $params['recipient_name'] = $params['sale']['sale_recipient_name'];
                $params['recipient_phone'] = $params['sale']['sale_recipient_phone'];
                $params['postal_code'] = $params['sale']['sale_postal_code'];

                $setting = $this->setting->general();
                $params['rekening_1'] = $setting['bank_1']['setting_value'];
                $params['rekening_2'] = $setting['bank_2']['setting_value'];
                $params['rekening_3'] = $setting['bank_3']['setting_value'];
                $params['address_office'] = $setting['address']['setting_value'];

                $getEmailSett = $this->setting->email();

                $this->email->set_mailtype('html');
                $this->email->from($getEmailSett['email_from']['setting_value'], $getEmailSett['email_from_name']['setting_value']);
                $this->email->to($params['sale']['customer_email']);
                $this->email->subject('Biaya Kirim No. Invoice #'.$params['sale']['sale_inv_num']);
                $mail_body = $this->load->view('email/email_postage_to_buyer', array('params' => $params), TRUE);
                $this->email->message($mail_body);
                $this->email->send();

                $this->session->set_flashdata('success', 'Set ongkos kirim berhasil');
                redirect(current_url());
            }
        }
        
        $data['catalog'] = $this->Catalog_model->get();
        $data['sale'] = $this->Sale_model->get(array('id' => $id));
        $data['title'] = 'Detail penjualan';
        $data['page'] = 'sale/sale_view';
        $this->load->view('admin/layout/main', $data);
    }

    public function add($id = NULL)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('sale_date', 'Tanggal ', 'required');
        $this->form_validation->set_rules('customer_id', 'Pelanggan', 'required');
        $this->form_validation->set_rules('sale_status_id', 'Status', 'required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {
            if ($this->input->post('sale_id')) {
                $params['sale_id'] = $this->input->post('sale_id');
            } else {
                $params['sale_created_date'] = date('Y-m-d H:i:s');
            }
            
            $sale_date = $params['sale_date'] = $this->input->post('sale_date');
            $params['user_id'] = $this->session->userdata('user_id_admin');
            $params['sale_last_update'] = date('Y-m-d H:i:s');
            $params['customer_id'] = $this->input->post('customer_id');
            $params['payment_id'] = $this->input->post('payment_id');
            $params['sale_status_id'] = $this->input->post('sale_status_id');
            
            $status = $this->Sale_model->add($params);
            
            $param['sale_id'] = $status;
            list($year, $month, $day) = explode('-', $sale_date);
            $param['sale_inv_num'] = 'JTY/'.$year.'/'.$month.'/'.$status;
            
            $status = $this->Sale_model->add($param);

            // activity log
            $this->Activity_log_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id_admin'),
                    'log_module' => 'Sale',
                    'log_action' => $data['operation'],
                    'log_info' => 'ID:'.$status.';Tanggal Penjualan:' . $params['sale_date']
                )
            );

            $this->session->set_flashdata('success', $data['operation'] . ' penjualan berhasil');
            redirect('admin/sale/view/' .$status);
        } 

            // Edit mode
        if (!is_null($id)) {
            $data['sale'] = $this->Sale_model->get(array('id' => $id));
        }
        $data['ngApp'] = 'ng-app';
        $data['customer'] = $this->Customer_model->get();
        $data['payment'] = $this->Sale_model->get_payment();
        $data['shipping'] = $this->Sale_model->get_shipping();
        $data['status'] = $this->Sale_model->get_sale_status();
        $data['title'] = $data['operation'] . ' Penjualan';
        $data['widgets'] = ['widgets/tinymce'];
        $data['page'] = 'sale/sale_add';
        $this->load->view('admin/layout/main', $data);
        
    }

    // Delete Penjualan
    public function delete($id = NULL) {
        if ($_POST) {
            $this->Sale_model->delete($this->input->post('del_id'));
            // activity log
            $this->Activity_log_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id_admin'),
                    'log_module' => 'Sale',
                    'log_action' => 'Hapus',
                    'log_info' => 'ID:' . $this->input->post('del_id') . ';Tanggal Penjualan:' . $this->input->post('del_name')
                )
            );
            $this->session->set_flashdata('success', 'Hapus penjualan berhasil');
            redirect('admin/sale');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/sale/edit/' . $id);
        }
    }

    function form($id = NULL) {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');

        if ($_POST) {

            $params['increase_total_price'] = $this->input->post('total_price');
            $params['sale_last_update'] = date('Y-m-d H:i:s');
            $params['sale_id'] = $id;
            $status = $this->Sale_model->add($params);

            //Add Item Name as array
            $cpt = count($_POST['catalog_id']);
            for ($i = 0; $i < $cpt; $i++) {
                if ($_POST['catalog_id'][$i] != '') {

                    $params['catalog_id'] = $_POST['catalog_id'][$i];
                    $params['sale_id'] = $id;
                    $params['sale_price'] = $_POST['item_price'][$i];
                    $params['sale_count'] = $_POST['qty'][$i];
                    $params['sale_total_price'] = $_POST['price'][$i];
                    $status = $this->Sale_model->add_sale_item($params);

                    $params['decrease_real_stock'] = $_POST['qty'][$i];
                    $params['decrease_virtual_stock'] = $_POST['qty'][$i];
                    $status = $this->Catalog_model->add($params);
                }
            }

            $this->session->set_flashdata('success','Tambah penjualan item berhasil');
            redirect('admin/sale/view/'.$id);
        } else {
            redirect('admin/sale/view/' . $id);
            
        }
    }

    public function delExpiredTransaction()
    {
        $sale = $this->Sale_model->get_sale_item(array('sale_id' => $this->input->post('id')));

        if ($_POST) {
            $this->Sale_model->delete($this->input->post('id'));
            $this->session->set_flashdata('success', 'Hapus transaksi expired berhasil');

            foreach ($sale as $key) {
                $virtual['catalog_id'] = $key['catalog_catalog_id'];
                $virtual['increase_virtual_stock'] = $key['sale_count'];
                $this->Catalog_model->add($virtual);
            }

            redirect('admin/sale/expired');
        }
    }
    
    function invoice($id = NULL) {
        $this->load->helper('dompdf');
        $data['item'] = $this->Sale_model->get_sale_item(array('sale_id' => $id));
        $data['master'] = $this->Sale_model->get(array('id' => $id));
        $html = $this->load->view('sale/invoice', $data, true);
        $data = pdf_create($html, '', TRUE, 'potrait');
    }

}

/* End of file sale.php */
/* Location: ./application/controllers/admin/sale.php */
