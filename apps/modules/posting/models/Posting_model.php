<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
* Posting Model Class
 *
 * @package     GROOT
 * @subpackage  Models
 * @category    Models
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */

class Posting_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	var $table = 'posting';

    // Get From Databases
	function get($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('posting.posting_id', $params['id']);
		}
		if(isset($params['category_id']))
		{
			$this->db->where('posting_category_posting_category_id', $params['category_id']);
		}
		if(isset($params['user_id']))
		{
			$this->db->where('posting.user_id', $params['user_id']);
		}

		if(isset($params['posting_title']))
		{
			$this->db->like('posting_title', $params['posting_title']);
		}

		if(isset($params['date_start']) AND isset($params['date_end']))
		{
			$this->db->where('posting_created_date', $params['date_start']);
			$this->db->or_where('posting_created_date', $params['date_end']);
		}

		if (isset($params['status_publish'])) {
			$this->db->where('posting.posting_publish_status', $params['status_publish']);
		}

		if(isset($params['limit']))
		{
			if(!isset($params['offset']))
			{
				$params['offset'] = NULL;
			}

			$this->db->limit($params['limit'], $params['offset']);
		}

		if(isset($params['order_by']))
		{
			$this->db->order_by($params['order_by'], 'desc');
		}
		else
		{
			$this->db->order_by('posting_last_update', 'desc');
		}

		$this->db->select('posting_id, posting_title, posting_short_desc, posting_desc, posting_image,
			posting_category_posting_category_id, posting_created_date, posting_last_update
			user_user_id, posting.posting_publish_status, user_name, posting_category_name, posting.posting_viewer');
		$this->db->join('posting_category', 'posting_category.posting_category_id = posting_category_posting_category_id', 'left');
		$this->db->join('user', 'user.user_id = posting.user_user_id');
		$res = $this->db->get('posting');

		if(isset($params['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}

	public function get_random_post($params = array())
	{
		if (isset($params['id'])) {
			$this->db->where('posting.posting_id', $params['id']);
		}

		if (isset($params['status_publish'])) {
			$this->db->where('posting.posting_publish_status', $params['status_publish']);
		}

		if (isset($params['order_by'])) {
			$this->db->order_by($params['order_by'], 'desc');
		} else {
			$this->db->order_by('rand()');
		}

		if (isset($params['limit'])) {
			if (!isset($params['offset'])) {
				$params['offset'] = NULL;
			}

			$this->db->limit($params['limit'], $params['offset']);
		}

		$this->db->select('posting_id, posting_title, posting_short_desc, posting_desc, posting_image,
			posting_category_posting_category_id, posting_created_date, posting_last_update
			user_user_id, posting.posting_publish_status, user_name, posting_category_name');
		$this->db->join('posting_category', 'posting_category.posting_category_id = posting_category_posting_category_id', 'left');
		$this->db->join('user', 'user.user_id = posting.user_user_id');
		$res = $this->db->get('posting');

		if (isset($params['id'])) {
			return $res->row_array();
		} else {
			return $res->result_array();
		}
	}

    // Add and update to database
	function add($data = array()) {

		if(isset($data['posting_id'])) {
			$this->db->set('posting_id', $data['posting_id']);
		}

		if(isset($data['posting_title'])) {
			$this->db->set('posting_title', $data['posting_title']);
		}

		if(isset($data['posting_short_desc'])) {
			$this->db->set('posting_short_desc', $data['posting_short_desc']);
		}

		if(isset($data['posting_desc'])) {
			$this->db->set('posting_desc', $data['posting_desc']);
		}

		if(isset($data['posting_image'])) {
			$this->db->set('posting_image', $data['posting_image']);
		}

		if(isset($data['posting_created_date'])) {
			$this->db->set('posting_created_date', $data['posting_created_date']);
		}

		if(isset($data['posting_last_update'])) {
			$this->db->set('posting_last_update', $data['posting_last_update']);
		}

		if(isset($data['posting_is_published'])) {
			$this->db->set('posting_publish_status', $data['posting_is_published']);
		}		

		if(isset($data['user_id'])) {
			$this->db->set('user_user_id', $data['user_id']);
		}

		if(isset($data['category_id'])) {
			$this->db->set('posting_category_posting_category_id', $data['category_id']);
		}

		if (isset($data['posting_id'])) {
			$this->db->where('posting_id', $data['posting_id']);
			$this->db->update('posting');
			$id = $data['posting_id'];
		} else {
			$this->db->insert('posting');
			$id = $this->db->insert_id();
		}

		$status = $this->db->affected_rows();
		return ($status == 0) ? FALSE : $id;
	}

    // Delete to database
	function delete($id) {
		$this->db->where('posting_id', $id);
		$this->db->delete('posting');
	}

    // Get category from database
	function get_category($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('posting_category_id', $params['id']);
		}

		if(isset($params['limit']))
		{
			if(!isset($params['offset']))
			{
				$params['offset'] = NULL;
			}

			$this->db->limit($params['limit'], $params['offset']);
		}
		if(isset($params['order_by']))
		{
			$this->db->order_by($params['order_by'], 'desc');
		}
		else
		{
			$this->db->order_by('posting_category_id', 'desc');
		}

		$this->db->select('posting_category_id, posting_category_name, posting_category_created_date,
			posting_category_last_update, user_user_id');
		$res = $this->db->get('posting_category');

		if(isset($params['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}

    // Add and Update category to database
	function add_category($data = array()) {
		if(isset($data['category_id'])) {
			$this->db->set('posting_category_id', $data['category_id']);
		}

		if(isset($data['category_name'])) {
			$this->db->set('posting_category_name', $data['category_name']);
		}

		if(isset($data['category_created_date'])) {
			$this->db->set('posting_category_created_date', $data['category_created_date']);
		}

		if(isset($data['category_last_update'])) {
			$this->db->set('posting_category_last_update', $data['category_last_update']);
		}

		if(isset($data['user_id'])) {
			$this->db->set('user_user_id', $data['user_id']);
		}

		if (isset($data['category_id'])) {
			$this->db->where('posting_category_id', $data['category_id']);
			$this->db->update('posting_category');
			$id = $data['category_id'];
		} else {
			$this->db->insert('posting_category');
			$id = $this->db->insert_id();
		}

		$status = $this->db->affected_rows();
		return ($status == 0) ? FALSE : $id;
	}

    // Delete category to database
	function delete_category($id) {
		$this->db->where('posting_category_id', $id);
		$this->db->delete('posting_category');
	}

    // Set Default category
	function set_default_category($id,$params) {
		$this->db->where('posting_category_posting_category_id', $id);
		$this->db->update('posting', $params);
	}

	public function increment_viewer($id = null)
	{
		if (!is_null($id)) {
			$this->db->where('posting.posting_id', $id);
			$this->db->set('posting.posting_viewer', 'posting_viewer + 1', false);
			$this->db->update('posting');
		}
	}

}
