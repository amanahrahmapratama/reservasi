<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_admin extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Setting_model');
		if ($this->session->userdata('logged_admin') == NULL) {
			header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
		}
	}

	public function index()
	{
		$this->general();
	}

	public function general()
	{
		if ($this->input->post()) {
			$this->update_setting();
		}
		$params['category_id'] = SETTING_GENERAL;
		$data['setting'] = $this->Setting_model->get_setting($params);
		$data['title'] = 'General Setting';
		$data['page'] = 'setting/general';
		$this->load->view('admin/layout/main', $data);
	}

	function update_setting()
	{
		$arr = $this->input->post();
		
		foreach ($arr as $key => $value) {
			$params['setting_key'] = $key;
			$params['setting_value'] = $value;
			$this->Setting_model->add($params);
		}
	}

	public function email()
	{
		if ($this->input->post()) {
			$this->update_setting();
		}
		$params['category_id'] = SETTING_EMAIL;
		$data['setting'] = $this->Setting_model->get_setting($params);
		$data['title'] = 'Email Setting';
		$data['page'] = 'setting/email';
		$this->load->view('admin/layout/main', $data);
	}

	public function image()
	{
		if ($_FILES) {
			$this->update_setting_image();
		}
		$params['category_id'] = SETTING_IMAGE;
		$data['setting'] = $this->Setting_model->get_setting($params);
		$data['title'] = 'Image Setting';
		$data['page'] = 'setting/image';
		$this->load->view('admin/layout/main', $data);
	}

	function update_setting_image()
	{
		if (!empty($_FILES['img_favicon']['name'])) {
			$params['setting_key'] = 'img_favicon';
			$params['setting_value'] = $this->do_upload('img_favicon');
			$this->Setting_model->add($params);
		}

		if (!empty($_FILES['img_logo']['name'])) {
			$params['setting_key'] = 'img_logo';
			$params['setting_value'] = $this->do_upload('img_logo');
			$this->Setting_model->add($params);
		}

		if (!empty($_FILES['img_brand']['name'])) {
			$params['setting_key'] = 'img_brand';
			$params['setting_value'] = $this->do_upload('img_brand');
			$this->Setting_model->add($params);
		}
	}

	public function do_upload($name = NULL)
	{
		$this->load->library('upload');

		$config['upload_path'] = FCPATH . 'uploads/meta';

		/* create directory if not exist */
		if (!is_dir($config['upload_path'])) {
			mkdir($config['upload_path'], 0755, TRUE);
		}

		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size'] = '32000';
		$this->upload->initialize($config);
        // $this->load->library('upload', $config);

		if (!$this->upload->do_upload($name)) {
			echo $config['upload_path'];
			echo $this->upload->display_errors('');
			die();
			$this->session->set_flashdata('success', $this->upload->display_errors(''));

			redirect(uri_string());
		}

		$upload_data = $this->upload->data();

		return $upload_data['file_name'];
	}

	public function view()
	{
		$data['setting'] = $this->Setting_model->get();
		$data['page'] = 'setting/general';
		$this->load->view('admin/layout/main', $data);
	}

	public function add($id = NULL)
	{
		if ($id == NULL){
			redirect('admin/setting');
		}
		$this->load->library('user_agent');

		$this->load->library('form_validation');

		$this->form_validation->set_rules('inputKey', 'Key', 'required');
		$this->form_validation->set_rules('inputValue', 'Value', 'required');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
		$data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

		if ($_POST AND $this->form_validation->run() == TRUE) {

			$params['setting_key'] = $this->input->post('inputKey');
			$params['setting_value'] = $this->input->post('inputValue');
			$status = $this->Setting_model->add($params);

			$this->session->set_flashdata('success', $data['operation'] . ' Pengaturan berhasil');
			if ($this->input->post('last_url', TRUE) != '') {
				redirect($this->input->post('last_url', TRUE));
			}else{
				redirect('admin/setting/');
			}

			// redirect($this->agent->referrer());
		} 

		if ($id != null) {
			$data['setting'] = $this->Setting_model->get(array('key' => $id));
		}

		$data['last_url'] = $this->agent->referrer();
		$data['title'] = $data['operation'] . ' Setting';
		$data['page'] = 'setting/add';
		$this->load->view('admin/layout/main', $data);

	}

	public function delete($id = NULL) {
		if ($_POST) {
			$this->Setting_model->delete($this->input->post('del_id'));
            // activity log
			$this->Activity_log_model->add(
				array(
					'log_date' => date('Y-m-d H:i:s'),
					'user_id' => $this->session->userdata('user_id_admin'),
					'log_module' => 'Setting',
					'log_action' => 'Hapus',
					'log_info' => 'ID:' . $this->input->post('del_id') . ';Title:' . $this->input->post('del_name')
				)
			);
			$this->session->set_flashdata('success', 'Hapus pengaturan berhasil');
			redirect('admin/setting');
		} elseif (!$_POST) {
			$this->session->set_flashdata('delete', 'Delete');
			redirect('admin/setting/edit/' . $id);
		}
	}

}

/* End of file Setting_admin.php */
/* Location: .//Applications/XAMPP/xamppfiles/htdocs/jatayu/panelapp/modules/setting/controllers/Setting_admin.php */