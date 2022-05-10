<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sliders_admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_admin')) {
            redirect('admin/auth/login');
        }

        $this->load->model(array('Sliders_model'));
    }

    public function index()
    {
        $this->load->library('pagination');

        $config['base_url']             = current_url();
        $config['total_rows']           = count($this->Sliders_model->get());
        $config['per_page']             = 10;
        $config['page_query_string']    = true;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);

        $params['limit']  = 10;
        $params['offset'] = $this->input->get('page');
        $data['sliders']  = $this->Sliders_model->get($params);

        $data['page']  = 'sliders';
        $data['title'] = 'Slider';
        $this->load->view('admin/layout/main', $data);
    }

    public function view($id = null)
    {
        if (is_null($id)) {
            $this->session->set_flashdata('failed', 'Data tidak ditemukan');
            redirect('admin/sliders');
        }

        $sliders = $this->Sliders_model->get(array('id' => $id));
        if (count($sliders) == 0) {
            $this->session->set_flashdata('failed', 'Data tidak ditemukan');
            redirect('admin/sliders');
        }

        $data['sliders'] = $sliders;
        $data['page']    = 'view_sliders';
        $data['title']   = 'Detail Slider';
        $this->load->view('admin/layout/main', $data);
    }

    public function add($id = null)
    {
        $data['operation'] = is_null($id) ? 'Tambah' : 'Edit';

        if (!is_null($id)) {
            $sliders = $this->Sliders_model->get(array('id' => $id));
            if (count($sliders) == 0) {
                $this->session->set_flashdata('failed', 'Data tidak ditemukan');
                redirect('admin/sliders');
            }
            $data['slider'] = $sliders;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('inputCaption', 'Caption', 'trim|required|xss_clean');
        if (is_null($id) && isset($_FILES['inputFile']) && $_FILES['inputFile']['name'] == '') {
            $this->form_validation->set_rules('inputFile', 'Photo', 'trim|required|xss_clean');
        }
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        if ($this->form_validation->run()) {
            
            $params['id']      = $id;
            $params['caption'] = $this->input->post('inputCaption');
            if (isset($_FILES['inputFile']) && $_FILES['inputFile']['name'] != '') {
                $params['photo']   = $this->do_upload('inputFile');
            }
            $ret = $this->Sliders_model->add($params);
            $this->session->set_flashdata('success', $data['operation'] . ' Slider Berhasil');
            redirect('admin/sliders');

        }

        $data['page']  = 'add_sliders';
        $data['title'] = $data['operation'] . ' Slider';
        $this->load->view('admin/layout/main', $data);
    }

    public function do_upload($field = 'inputFile')
    {
        $config['upload_path'] = './uploads/sliders/';
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true);
        }

        $config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPG|JPEG|PNG';
        
        $this->load->library('upload', $config);
        $error = false;
        if ( ! $this->upload->do_upload($field)){
            $data = $this->upload->display_errors();
            $error = true;
        }
        else{
            $data = $this->upload->data();
        }

        return $error ? null : $data['file_name'];
    }

    public function delete($id = null)
    {
        if (is_null($id)) {
            $this->session->set_flashdata('failed', 'Data tidak ditemukan');
            redirect('admin/sliders');
        }

        if ($this->input->post('inputDelete')) {

            $sliders = $this->Sliders_model->get(array('id' => $id));
            if (count($sliders) == 0) {
                $this->session->set_flashdata('failed', 'Data tidak ditemukan');
                redirect('admin/sliders');
            }

            $this->Sliders_model->delete($id);

            $this->session->set_flashdata('success', 'Berhasil menghapus data');
            redirect('admin/sliders');
        }

    }
}

/* End of file Reservasi.php */
/* Location: .//var/www/html/projects/slidersruangan/apps/modules/sliders/controllers/Reservasi.php */
