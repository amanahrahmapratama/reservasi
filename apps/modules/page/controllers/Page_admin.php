<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/** 
* Page controllers class
 *
 * @package     GROOT
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */

class Page_admin extends CI_Controller {

    public function __construct() {
        parent::__construct(TRUE);
        if ($this->session->userdata('logged_admin') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model('Page_model');
        $this->load->model('activity_log/Activity_log_model');
        $this->load->library('upload');
    }
    
    // Page view in list
    public function index($offset = NULL) {
        $this->load->library('pagination');
        $data['pages'] = $this->Page_model->get(array('limit' => 10, 'offset' => $offset));
        $config['base_url'] = site_url('admin/page/index');
        $config['total_rows'] = $this->db->count_all('page');
        $this->pagination->initialize($config);
        $data['title'] = 'Halaman';
        $data['page'] = 'page/page_list';
        $this->load->view('admin/layout/main', $data);
    }

    function view($id = NULL) {
        if ($this->Page_model->get(array('id' => $id)) == NULL) {
            redirect('admin/page');
        }
        $data['pages'] = $this->Page_model->get(array('id' => $id));
        $data['title'] = 'Detail page';
        $data['page'] = 'page/page_view';
        $this->load->view('admin/layout/main', $data);
    }

    // Add Page and Update
    public function add($id = NULL) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('page_name', 'Title', 'required');
        $this->form_validation->set_rules('page_content', 'Content', 'required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {
            if (!empty($_FILES['inputGambar']['name'])) {
                $params['page_image'] = $this->do_upload();
            } elseif ($this->input->post('inputGambarExisting')) {
                $params['page_image'] = $this->input->post('inputGambarExisting');
            } else {
                if ($this->input->post('page_id')) {
                    $params['page_image'] = $this->input->post('inputGambarCurrent');
                } else {
                    $params['page_image'] = '';
                }
            }

            if ($this->input->post('page_id')) {
                $params['page_id'] = $this->input->post('page_id');
            } else {
                $params['page_created_date'] = date('Y-m-d H:i:s');
            }

            $params['page_id'] = $id;
            $params['page_last_update'] = date('Y-m-d H:i:s');
            $params['user_id'] = $this->session->userdata('user_id_admin');
            $params['page_name'] = $this->input->post('page_name');
            $params['page_content'] = $this->input->post('page_content');
            $params['page_short_desc'] = $this->input->post('page_short_desc');
            $params['page_is_published'] = $this->input->post('page_is_published');
            $status = $this->Page_model->add($params);

                // activity log
            $this->Activity_log_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id_admin'),
                    'log_module' => 'Halaman',
                    'log_action' => $data['operation'],
                    'log_info' => 'ID:null;Title:' . $params['page_name']
                )
            );

            $this->session->set_flashdata('success', $data['operation'] . ' halaman berhasil');
            redirect('admin/page');
        } else {
            if ($this->input->post('user_id')) {
                redirect('admin/page/edit/' . $this->input->post('page_id'));
            }

            if (!is_null($id)) {
                $data['pages'] = $this->Page_model->get(array('id' => $id));
            }

            $data['widgets'] = ['widgets/tinymce'];
            $data['title'] = $data['operation'] . ' Halaman';
            $data['page'] = 'page/page_add';
            $this->load->view('admin/layout/main', $data);
        }
    }

    // Delete Page
    public function delete($id = NULL) {
        if ($_POST) {
            $this->Page_model->delete($this->input->post('del_id'));
                // activity log
            $this->Activity_log_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id_admin'),
                    'log_module' => 'Page',
                    'log_action' => 'Hapus',
                    'log_info' => 'ID:' . $this->input->post('del_id') . ';Title:' . $this->input->post('del_name')
                )
            );
            $this->session->set_flashdata('success', 'Hapus halaman berhasil');
            redirect('admin/page');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/page/edit/' . $id);
        }
    }

    public function tree($id=NULL) {
        $this->load->library('Zebra_mptt');
        $this->mptt = new Zebra_Mptt();
        if ($_POST) {
                // Add menu
            if (!empty($_POST['inputJudul'])) {
                $id = $this->mptt->add($this->input->post('inputParent'), $this->input->post('inputJudul'));
                $param['id'] = $id;
                $param['url'] = $this->input->post('inputURL');
                $this->Page_model->update_menu($param);
                $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

                    // activity log
                $this->Activity_log_model->add(
                    array(
                        'log_date' => date('Y-m-d H:i:s'),
                        'user_id' => $this->session->userdata('user_id_admin'),
                        'log_module' => 'Page Tree',
                        'log_action' => $data['operation'],
                        'log_info' => 'ID:' . $id . ';Title:' .$this->input->post('inputJudul')
                    )
                );

                $this->session->set_flashdata('success', 'Add tree node berhasil');
                redirect('admin/page/tree');
            }

            $new_tree = json_decode($_POST['page_tree'], TRUE);

            foreach ($new_tree as $key => $tree) {
                $parent = 0;
                $position = $key + 1;
                $this->mptt->move($tree['id'], $parent, $position);

                if (isset($tree['children'])) {
                    foreach ($tree['children'] as $ckey => $child) {
                        $parent = $tree['id'];
                        $position = $ckey + 1;
                        $this->mptt->move($child['id'], $parent, $position);

                        if (isset($child['children'])) {
                            foreach ($child['children'] as $gckey => $grandchild) {
                                $parent = $child['id'];
                                $position = $gckey + 1;
                                $this->mptt->move($grandchild['id'], $parent, $position);
                            }
                        }
                    }
                }
            }

            $this->session->set_flashdata('success', 'Sunting tree berhasil');
            redirect('admin/page/tree');
        }
        $data['title'] = 'Page Tree';
        $data['page'] = 'page/page_tree';
        $data['tree'] = $this->mptt->get_tree();
        $data['pages'] = $this->Page_model->get(array('id' => $id));
        $this->load->view('admin/layout/main', $data);

    }

    public function remove_node($id = NULL) {
        $this->load->library('G_mptt');
        $this->mptt = new Zebra_Mptt();
        $tree = $this->mptt->get_path($id);
        $this->mptt->delete($id);

            // activity log
        $this->Activity_log_model->add(
            array(
                'log_date' => date('Y-m-d H:i:s'),
                'user_id' => $this->session->userdata('user_id_admin'),
                'log_module' => 'Page Tree',
                'log_action' => 'Hapus Page Tree',
                'log_info' => 'ID:' . $id . ';Title:' . $tree[$id]['title']
            )
        );

        $this->session->set_flashdata('success', 'Hapus tree node berhasil');
        redirect('admin/page/tree');
    }

}

/* End of file page.php */
/* Location: ./application/controllers/page.php */
