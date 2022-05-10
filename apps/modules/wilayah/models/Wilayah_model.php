<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wilayah_model extends CI_Model {

	public function get_province($params = array())
	{
		if (isset($params['id'])) {
			$this->db->where('province_id', $params['id']);
		}

		if(isset($params['limit']))
		{
			if(!isset($params['offset']))
			{
				$params['offset'] = NULL;
			}

			$this->db->limit($params['limit'], $params['offset']);
		}

		$ret = $this->db->get('province');
		
		if (isset($params['id'])) {
			return $ret->row_array();
		}else{
			return $ret->result_array();
		}
	}	

	public function get_kabupaten($params = array())
	{
		if (isset($params['province_id'])) {
			$this->db->where('province_province_id', $params['province_id']);
		}
		
		if (isset($params['id'])) {
			$this->db->where('kabupaten_id', $params['id']);
		}

		if(isset($params['limit']))
		{
			if(!isset($params['offset']))
			{
				$params['offset'] = NULL;
			}

			$this->db->limit($params['limit'], $params['offset']);
		}

		$ret = $this->db->get('kabupaten');
		
		if (isset($params['id'])) {
			return $ret->row_array();
		}else{
			return $ret->result_array();
		}
	}

	public function get_kecamatan($params = array())
	{
		if (isset($params['kabupaten_id'])) {
			$this->db->where('kabupaten_kabupaten_id', $params['kabupaten_id']);
		}
		
		if (isset($params['id'])) {
			$this->db->where('kecamatan_id', $params['id']);
		}

		if(isset($params['limit']))
		{
			if(!isset($params['offset']))
			{
				$params['offset'] = NULL;
			}

			$this->db->limit($params['limit'], $params['offset']);
		}

		$ret = $this->db->get('kecamatan');
		
		if (isset($params['id'])) {
			return $ret->row_array();
		}else{
			return $ret->result_array();
		}
	}

}

/* End of file Wilayah_model.php */
/* Location: .//Applications/MAMP/htdocs/jatayu/storeapp/modules/wilayah/models/Wilayah_model.php */