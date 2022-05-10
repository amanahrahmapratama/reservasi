<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sliders_model extends CI_Model
{

	public function get($params = array())
	{
		if (isset($params['id'])) {
			$this->db->where('slider_id', $params['id']);
		}

		if(isset($params['limit']))
		{
			if(!isset($params['offset']))
			{
				$params['offset'] = NULL;
			}

			$this->db->limit($params['limit'], $params['offset']);
		}

		$this->db->order_by('sliders.slider_id', 'desc');

		$ret = $this->db->get('sliders');

		if (isset($params['id'])) {
			return $ret->row_array();
		}

		return $ret->result_array();
	}

	public function add($params = array())
	{

		if (isset($params['caption'])) {
			$this->db->set('slider_caption', $params['caption']);
		}

		if (isset($params['photo'])) {
			$this->db->set('slider_photo', $params['photo']);
		}

		if (isset($params['id'])) {
			$this->db->where('slider_id', $params['id']);
			$this->db->update('sliders');
			return $params['id'];
		}

		$this->db->insert('sliders');
		return $this->db->insert_id();
	}

	public function delete($id = null)
	{
		if (!is_null($id)) {
			$this->db->where('slider_id', $id)->delete('sliders');
			return $id;
		}
	}

}

/* End of file Reservasi_model.php */
/* Location: .//var/www/html/projects/slidersruangan/apps/modules/sliders/models/Reservasi_model.php */
