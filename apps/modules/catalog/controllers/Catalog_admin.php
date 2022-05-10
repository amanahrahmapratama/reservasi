<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Posting controllers class
 *
 * @package     GROOT
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Catalog_admin extends CI_Controller {

    public function __construct() {
        parent::__construct(TRUE);
        if ($this->session->userdata('logged_admin') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model(array('Catalog_model', 'activity_log/Activity_log_model', 'brand/Brand_model'));
    }

    // Posting view in list
    public function index($offset = NULL) {
        $this->load->library('pagination');
        $data['catalog'] = $this->Catalog_model->get(array('limit' => 10, 'offset' => $offset));
        $data['category'] = $this->Catalog_model->get_category();
        $config['base_url'] = site_url('admin/catalog/index');
        $config['total_rows'] = $this->db->count_all('catalog');
        $this->pagination->initialize($config);

        $data['title'] = 'Daftar Ruangan';
        $data['page'] = 'catalog/catalog_list';
        $this->load->view('admin/layout/main', $data);
    }

    function view($id = NULL) {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        
        if ($this->Catalog_model->get(array('id' => $id)) == NULL) {
            redirect('admin/catalog');
        }

        $data['catalog'] = $this->Catalog_model->get(array('id' => $id));
        
        if (count($data['catalog']) == 0) {
            redirect('admin/catalog');
        }

        if ($this->input->post('stockUpdate', TRUE)) {
            $params['catalog_id'] = $id;
            $params['catalog_real_stock'] = $this->input->post('stock');
            $params['catalog_virtual_stock'] = $this->input->post('stock');

            $this->Catalog_model->add($params);
            $this->session->set_flashdata('success', 'Update stok produk berhasil');
            redirect('admin/catalog/view/'.$id);
        }

        if ($this->input->post('setCategory', TRUE)) {

            $this->form_validation->set_rules('inputCategory[]', 'Kategori', 'trim|required|xss_clean');
            if ($this->form_validation->run()) {

                $category = $this->input->post('inputCategory', TRUE);
                $category_slug = '-' . implode('-', $category) . '-';
                $params['catalog_id'] = $id;
                $params['category_slug'] = $category_slug;

                $this->Catalog_model->add($params);

                $this->Catalog_model->delete_has_category($id);

                $category = $this->input->post('inputCategory', TRUE);
                foreach ($category as $key) {
                    $cat['catalog_id'] = $id;
                    $cat['catalog_category_id'] = $key;
                    $this->Catalog_model->add_has_category($cat);
                }
            }
        }

        $arr_chc = array();
        
        $category = $this->Catalog_model->get_category();
        foreach ($category as $key) {
            if (in_array($key['catalog_category_id'], $arr_chc)) {
                $arr_category[] = array(
                    'catalog_category_id' => $key['catalog_category_id'],
                    'catalog_category_name' => $key['catalog_category_name'],
                    'ticked' => true
                );
            }else{
                $arr_category[] = array(
                    'catalog_category_id' => $key['catalog_category_id'],
                    'catalog_category_name' => $key['catalog_category_name'],
                    'ticked' => false
                );
            }
        }

        
        $data['image'] = $this->Catalog_model->get_image(array('catalog_id' => $id));
        $data['category'] = json_encode($arr_category);

        $data['title'] = 'Detail ruangan';
        $data['page'] = 'catalog/catalog_view';
        $this->load->view('admin/layout/main', $data);
    }

    // Category view in list
    public function category($offset = NULL) {
        $this->load->library('pagination');
        $data['categories'] = $this->Catalog_model->get_category(array('limit' => 10, 'offset' => $offset));
        $config['base_url'] = site_url('admin/catalog/category');
        $config['total_rows'] = $this->db->count_all('catalog_category');
        $this->pagination->initialize($config);
        $data['title'] = 'Daftar Kategori Catalog';
        $data['page'] = 'catalog/category_list';
        $this->load->view('admin/layout/main', $data);
    }

    // Add Posting and Update
    public function add($id = NULL) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('catalog_name', 'Name ', 'required');
        $this->form_validation->set_rules('catalog_desc', 'Description', 'required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {

            if (!empty($_FILES['inputGambar']['name'])) {
                $params['catalog_image'] = $this->do_upload('inputGambar');
            } elseif ($this->input->post('inputGambarExisting')) {
                $params['catalog_image'] = $this->input->post('inputGambarExisting');
            } else {
                if ($this->input->post('catalog_id')) {
                    $params['catalog_image'] = $this->input->post('inputGambarCurrent');
                } else {
                    $params['catalog_image'] = '';
                }
            }

            if ($this->input->post('catalog_id')) {
                $params['catalog_id'] = $this->input->post('catalog_id');
            } else {
                $params['catalog_created_date'] = date('Y-m-d H:i:s');
            }

            if ($id != null) {
                // $this->Catalog_model->delete_has_category($id);
            }

            $params['user_id'] = $this->session->userdata('user_id_admin');
            $params['catalog_last_update'] = date('Y-m-d H:i:s');
            $params['catalog_name'] = $this->input->post('catalog_name');
            $params['catalog_desc'] = stripslashes($this->input->post('catalog_desc'));
            
            // $category = $this->input->post('inputCategory', TRUE);
            // $category_slug = '-' . implode('-', $category) . '-';
            // $params['category_slug'] = $category_slug;

            $status = $this->Catalog_model->add($params);

            // $category = $this->input->post('inputCategory', TRUE);
            // foreach ($category as $key) {
            //     $cat['catalog_id'] = $status;
            //     $cat['catalog_category_id'] = $key;
            //     $this->Catalog_model->add_has_category($cat);
            // }

            $this->upload_image($status);


            $this->Activity_log_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id_admin'),
                    'log_module' => 'Ruangan',
                    'log_action' => $data['operation'],
                    'log_info' => 'ID:'.$status.';Title:' . $params['catalog_name']
                )
            );

            $this->session->set_flashdata('success', $data['operation'] . ' ruangan berhasil');
            redirect('admin/catalog/view/'.$status);
        } else {
            // if ($this->input->post('catalog_id')) {
            //     redirect('admin/catalog/edit/' . $this->input->post('catalog_id'));
            // }

            // Edit mode
            if (!is_null($id)) {
                $data['catalog'] = $this->Catalog_model->get(array('id' => $id));
                if (count($data['catalog']) == 0) {
                    redirect('admin/catalog');
                }

                $data['image'] = $this->Catalog_model->get_image(array('catalog_id' => $id));
            }

            $chc = array();
            $arr_chc = array();

            $category = $this->Catalog_model->get_category();
            $arr_category = array();
            foreach ($category as $key) {
                if (in_array($key['catalog_category_id'], $arr_chc)) {
                    $arr_category[] = array(
                        'catalog_category_id' => $key['catalog_category_id'],
                        'catalog_category_name' => $key['catalog_category_name'],
                        'ticked' => true
                    );
                }else{
                    $arr_category[] = array(
                        'catalog_category_id' => $key['catalog_category_id'],
                        'catalog_category_name' => $key['catalog_category_name'],
                        'ticked' => false
                    );
                }
            }

            $data['category'] = json_encode($arr_category);
            $data['catalog_has_category'] = $chc;
            $data['title'] = $data['operation'] . ' Ruangan';
            $data['widgets'] = ['widgets/tinymce'];
            $data['page'] = 'catalog/catalog_add';
            $this->load->view('admin/layout/main', $data);
        }
    }

    public function do_upload($name = NULL)
    {
        $this->load->library('upload');

        $config['upload_path'] = FCPATH . './uploads';

        /* create directory if not exist */
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, TRUE);
        }

        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '32000';
        $this->upload->initialize($config);
        // $this->load->library('upload', $config);

        if (!$this->upload->do_upload($name)) {
            $this->session->set_flashdata('error_upload', $this->upload->display_errors(''));

            redirect(uri_string());
        }

        $upload_data = $this->upload->data();

        return $upload_data['file_name'];
    }

    private function upload_image($id = null)
    {
        if (is_null($id)) {
            return FALSE;
        }


        $config['upload_path'] = './uploads';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|JPG';
        
        $this->load->library('upload', $config);

        $files = $_FILES['catalogImage'];

        $no = 0;
        $cpt = count($_FILES['catalogImage']['name']);
        
        for ($i = 0; $i < $cpt; $i++) {

            $_FILES['catalogImage']['name'] = $files['name'][$i];
            $_FILES['catalogImage']['type'] = $files['type'][$i];
            $_FILES['catalogImage']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['catalogImage']['error'] = $files['error'][$i];
            $_FILES['catalogImage']['size'] = $files['size'][$i];

            $this->upload->do_upload('catalogImage');

            $data = $this->upload->data();

            $input['name'] = $data['file_name'];
            $input['catalog_id'] = $id;

            if ($input['name'] != NULL) {
                if ($i == 0) {
                    $cover['catalog_id'] = $id;
                    $cover['catalog_image'] = $input['name'];

                    $this->Catalog_model->add($cover);
                }

                $error = $this->upload->display_errors();

                $this->Catalog_model->add_catalog_image($input);
            }
        }
        
        return TRUE;
    }

    // Add Category
    public function add_category($id = NULL) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('category_name', 'Name', 'required|callback_check_category_name');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {
            if ($this->input->post('category_id')) {
                $params['category_id'] = $this->input->post('category_id');
            } else {
                $params['category_created_date'] = date('Y-m-d H:i:s');
            }
            $params['category_last_update'] = date('Y-m-d H:i:s');
            $params['category_name'] = $this->input->post('category_name');
            $params['user_id'] = $this->session->userdata('user_id_admin');
            $res = $this->Catalog_model->add_category($params);

            // activity log
            $this->Activity_log_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id_admin'),
                    'log_module' => 'Ruangan',
                    'log_action' => $data['operation'],
                    'log_info' => 'ID:' . $res . ';Title:' . $params['category_name']
                )
            );

            if ($this->input->is_ajax_request()) {
                echo $res;
            } else {
                $this->session->set_flashdata('success', $data['operation'] . ' kategori ruangan berhasil');
                redirect('admin/catalog/category');
            }
        } else {
            // if ($this->input->post('category_id')) {
            //     redirect('admin/catalog/category/edit/' . $this->input->post('category_id'));
            // }

            // Edit mode
            if (!is_null($id)) {
                $data['category'] = $this->Catalog_model->get_category(array('id' => $id));
            }
            $data['title'] = $data['operation'].' Kategori Catalog';
            $data['page'] = 'catalog/category_add';
            $this->load->view('admin/layout/main', $data);
        }
    }

    protected function get_category() {
        $res = json_encode($this->Catalog_model->get_category());
        return $res;
    }

    // Delete Posting
    public function delete($id = NULL) {
        if ($_POST) {
            $this->Catalog_model->delete($this->input->post('del_id'));
            // activity log
            $this->Activity_log_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id_admin'),
                    'log_module' => 'Ruangan',
                    'log_action' => 'Hapus',
                    'log_info' => 'ID:' . $this->input->post('del_id') . ';Title:' . $this->input->post('del_name')
                )
            );
            $this->session->set_flashdata('success', 'Hapus ruangan berhasil');
            redirect('admin/catalog');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/catalog/edit/' . $id);
        }
    }

    // Delete Category
    public function delete_category($id = NULL) {
        if ($_POST) {
            $this->Catalog_model->delete_has_category($id);

            $this->Catalog_model->delete_category($this->input->post('del_id'));
            // activity log
            $this->Activity_log_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id_admin'),
                    'log_module' => 'Kategori Posting',
                    'log_action' => 'Hapus',
                    'log_info' => 'ID:' . $this->input->post('del_id') . ';Title:' . $this->input->post('del_name')
                )
            );
            $this->session->set_flashdata('success', 'Hapus kategori ruangan berhasil');
            redirect('admin/catalog/category');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/catalog/category/edit/' . $id);
        }
    }

    public function getCatalogJson()
    {
        if ($this->input->post('term')) {
            $params['catalog_name'] = $this->input->post('term');
            $params['autocomplete'] = TRUE;
            $ret = $this->Catalog_model->get($params);
            echo json_encode($ret);
            // $this->output->set_content_type('application/json')->set_output(json_encode($ret));
        }
    }

    public function delete_image($id = null, $catalog_id = null)
    {

        if (is_null($id) OR is_null($catalog_id)) {
            redirect('admin/catalog/');
        }


        $catalog_image = $this->Catalog_model->get_image(array('id' => $id, 'catalog_id' => $catalog_id));

        if (count($catalog_image) == 0) {

            $this->session->set_flashdata('success', 'Foto tidak ditemukan');
            redirect('admin/catalog/view/'.$catalog_id);
            return false;

        }

        $ret = $this->Catalog_model->delete_image($id);

        $this->Activity_log_model->add(
            array(
                'log_date' => date('Y-m-d H:i:s'),
                'user_id' => $this->session->userdata('user_id_admin'),
                'log_module' => 'Foto Ruangan',
                'log_action' => 'Hapus',
                'log_info' => 'ID:' . $id . ';'
            )
        );

        
        $this->session->set_flashdata('success', 'Hapus foto ruangan berhasil');
        redirect('admin/catalog/view/'.$catalog_id);
    }

    function check_category_name($name) {        
        if ($this->input->post('category_id')) {
            $id = $this->input->post('category_id');
        } else {
            $id = '';
        }

        $result = $this->Catalog_model->check_unique_category_name($id, $name);

        if($result == 0) {
            $response = TRUE;
        } else {
            $this->form_validation->set_message('check_category_name', 'Category name must be unique');
            $response = FALSE;
        }
        return $response;
    }

}

/* End of file catalog.php */
/* Location: ./application/controllers/admin/catalog.php */
