<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
* Brand Model Class
 *
 * @package     GROOT
 * @subpackage  Models
 * @category    Models
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */

class Setting_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	var $table = 'setting';

    // Get From Databases
	function get($params = array())
	{
		if(isset($params['key']))
		{
			$this->db->where('setting.setting_key', $params['key']);
		}
		if(isset($params['value']))
		{
			$this->db->where('setting.setting_value', $params['value']);
		}

		if(isset($params['limit']))
		{
			if(!isset($params['offset']))
			{
				$params['offset'] = NULL;
			}

			$this->db->limit($params['limit'], $params['offset']);
		}

		if (isset($params['category_id'])) {
			$this->db->where('setting_category_setting_category_id', $params['category_id']);
		}

		if(isset($params['order_by']))
		{
			$this->db->order_by($params['order_by'], 'desc');
		}
		else
		{
			$this->db->order_by('setting_value', 'desc');
		}

		$this->db->select('setting_key, setting_value, setting_category_setting_category_id');
		$res = $this->db->get('setting');

		if(isset($params['key']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}

	public function get_setting($params = array())
	{
		$ret = $this->get($params);

		$res_array = array();
		foreach ($ret as $key => $value) {
			$res_array[$value['setting_key']] = array(
				'setting_key' => $value['setting_key'],
				'setting_value' => $value['setting_value']
				);
		}

		return $res_array;
	}

    // Add and update to database
	function add($data = array()) {

		if(isset($data['setting_key'])) {
			$this->db->set('setting_key', $data['setting_key']);
		}

		if(isset($data['setting_value'])) {
			$this->db->set('setting_value', $data['setting_value']);
		}

		if (isset($data['setting_key'])) {
			$this->db->where('setting_key', $data['setting_key']);
			$this->db->update('setting');
			$id = $data['setting_key'];
		} else {
			$this->db->insert('setting');
			$id = $this->db->insert_id();
		}

	}

    // Delete to database
	function delete($id) {
		$this->db->where('setting_key', $id);
		$this->db->delete('setting');
	}

}
