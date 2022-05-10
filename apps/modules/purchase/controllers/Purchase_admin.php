<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Pembelian controllers class
 *
 * @package     GROOT
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Purchase_admin extends CI_Controller {

    public function __construct() {
        parent::__construct(TRUE);
        if ($this->session->userdata('logged_admin') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model(array('Purchase_model', 'supplier/Supplier_model', 'catalog/Catalog_model', 'activity_log/Activity_log_model'));
        $this->load->library('upload');
    }

    // Pembelian view in list
    public function index($offset = NULL) {
        $this->load->library('pagination');
        $data['purchase'] = $this->Purchase_model->get(array('limit' => 10, 'offset' => $offset));
        $config['base_url'] = site_url('admin/purchase/index');
        $config['total_rows'] = $this->db->count_all('purchase');
        $this->pagination->initialize($config);

        $data['title'] = 'Purchase';
        $data['main'] = 'purchase/purchase_list';
        $this->load->view('admin/layout', $data);
    }

    function view($id = NULL) {
        if ($this->Purchase_model->get(array('id' => $id)) == NULL) {
            redirect('admin/purchase');
        }
        $item = $this->Purchase_model->get_purchase_item(array('item_id' => $id));
        if(count($item) != 0){
            $data['item'] = $item;
        }
        $data['ngApp'] = 'ng-app';
        $data['catalog'] = $this->Catalog_model->get();
        $data['purchase'] = $this->Purchase_model->get(array('id' => $id));
        $data['title'] = 'Detail pembelian';
        $data['main'] = 'purchase/purchase_view';
        $this->load->view('admin/layout', $data);
    }

    // Add Pembelian and Update
    public function add($id = NULL) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('purchase_date', 'Tanggal ', 'required');
        $this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {
            if ($this->input->post('purchase_id')) {
                $params['purchase_id'] = $this->input->post('purchase_id');
            } else {
                $params['purchase_created_date'] = date('Y-m-d H:i:s');
            }

            $params['user_id'] = $this->session->userdata('user_id_admin');
            $params['purchase_last_update'] = date('Y-m-d H:i:s');
            $params['purchase_date'] = $this->input->post('purchase_date');
            $params['supplier_id'] = $this->input->post('supplier_id');
            $status = $this->Purchase_model->add($params);


            // activity log
            $this->Activity_log_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id_admin'),
                    'log_module' => 'Purchase',
                    'log_action' => $data['operation'],
                    'log_info' => 'ID:'.$status.';Tanggal Pembelian:' . $params['purchase_date']
                    )
                );

            $this->session->set_flashdata('success', $data['operation'] . ' pembelian berhasil');
            redirect('admin/purchase/view/' . $status);
        } else {
            if ($this->input->post('purchase_id')) {
                redirect('admin/purchase/edit/' . $this->input->post('purchase_id'));
            }

            // Edit mode
            if (!is_null($id)) {
                $data['purchase'] = $this->Purchase_model->get(array('id' => $id));
            }
            $data['supplier'] = $this->Supplier_model->get();
            $data['title'] = $data['operation'] . ' Pembelian';
            $data['main'] = 'purchase/purchase_add';
            $this->load->view('admin/layout', $data);
        }
    }

    // Delete Pembelian
    public function delete($id = NULL) {
        if ($_POST) {
            $this->Purchase_model->delete($this->input->post('del_id'));
            // activity log
            $this->Activity_log_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id_admin'),
                    'log_module' => 'Purchase',
                    'log_action' => 'Hapus',
                    'log_info' => 'ID:' . $this->input->post('del_id') . ';Tanggal Pembelian:' . $this->input->post('del_name')
                    )
                );
            $this->session->set_flashdata('success', 'Hapus pembelian berhasil');
            redirect('admin/purchase');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/purchase/edit/' . $id);
        }
    }

    function form($id = NULL) {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');

        if ($this->input->post('total_price', TRUE) == '') {
            $this->session->set_flashdata('success', 'Anda belum input barang');
            redirect('admin/purchase/view/'.$id);
        }

        if ($_POST) {

            $param['increase_total_price'] = $this->input->post('total_price');
            $param['purchase_last_update'] = date('Y-m-d H:i:s');
            $param['purchase_id'] = $id;
            $status = $this->Purchase_model->add($param);

            $cpt = count($_POST['catalog_id']);
            for ($i = 0; $i < $cpt; $i++) {
                if ($_POST['catalog_id'][$i] != '') {

                    $params['catalog_id'] = $_POST['catalog_id'][$i];
                    $params['purchase_id'] = $id;
                    $params['item_price'] = $_POST['item_price'][$i];
                    $params['item_count'] = $_POST['qty'][$i];
                    $params['item_total_price'] = $_POST['price'][$i];
                    $status = $this->Purchase_model->add_purchase_item($params);

                    $params['increase_real_stock'] = $_POST['qty'][$i];
                    $params['increase_virtual_stock'] = $_POST['qty'][$i];
                    $params['catalog_buying_price'] = $_POST['item_price'][$i];
                    $status = $this->Catalog_model->add($params);
                }
            }

            $this->session->set_flashdata('success','Tambah pembelian item berhasil');
            redirect('admin/purchase/view/'.$id);
        } else {
            redirect('admin/purchase/view/' . $id);
            
        }
    }

}

/* End of file purchase.php */
/* Location: ./application/controllers/admin/purchase.php */
