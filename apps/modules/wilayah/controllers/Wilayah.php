<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wilayah extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Wilayah_model'));
	}

	public function index()
	{
		$this->output->set_content_type('application/json')->set_output(json_encode(array()));
	}


	public function getProvince()
	{
		
	}

	public function getKabupatenJson()
	{

		$params = array();
		if ($this->input->post('province_id', TRUE)) {
			$params['province_id'] = $this->input->post('province_id', TRUE);
		}

		$ret = $this->Wilayah_model->get_kabupaten($params);

		$this->output->set_content_type('application/json')->set_output(json_encode($ret));
	}

	public function getKecamatanJson()
	{

		$params = array();
		if ($this->input->post('kabupaten_id', TRUE)) {
			$params['kabupaten_id'] = $this->input->post('kabupaten_id', TRUE);
		}

		$ret = $this->Wilayah_model->get_kecamatan($params);

		$this->output->set_content_type('application/json')->set_output(json_encode($ret));
	}


}

/* End of file Wilayah.php */
/* Location: .//Applications/MAMP/htdocs/jatayu/storeapp/modules/wilayah/controllers/Wilayah.php */