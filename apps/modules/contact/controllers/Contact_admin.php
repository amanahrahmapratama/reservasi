<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
* 
*/
class Contact_admin extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('logged_admin') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }

        $this->load->model('Contact_model');
	}

	public function index($offset = NULL)
	{
		$param['limit'] = 10;
		$param['offset'] = $offset;
		$data['contact'] = $this->Contact_model->get($param);

		$config['base_url'] = site_url('admin/contact/index');
		$config['total_rows'] = count($this->Contact_model->get());
		$this->pagination->initialize($config);

		$data['title'] = 'Daftar Kontak';
		$data['page'] = 'contact/contact_list';
		$this->load->view('admin/layout/main', $data);
	}

	public function view($id = NULL)
	{
		if ($this->Contact_model->get(array('id' => $id)) == NULL) {
            redirect('admin/contact');
        }

        $data['contact'] = $this->Contact_model->get(array('id' => $id));
        $data['title'] = 'Detail Kontak';
        $data['page'] = 'contact/contact_view';
        $this->load->view('admin/layout/main', $data);
	}

	public function delete()
	{
		if ($_POST) {
			$this->Contact_model->delete($this->input->post('id'));
			$this->session->set_flashdata('success', 'Hapus kontak berhasil');
			redirect('admin/contact');
		}
	}
}
