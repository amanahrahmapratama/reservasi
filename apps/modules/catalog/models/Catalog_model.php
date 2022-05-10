<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
* Catalog Model Class
 *
 * @package     GROOT
 * @subpackage  Models
 * @category    Models
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */

class Catalog_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	var $table = 'catalog';

    // Get From Databases
	function get($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('catalog.catalog_id', $params['id']);
		}

		if(isset($params['user_id']))
		{
			$this->db->where('catalog.user_id', $params['user_id']);
		}

		if(isset($params['brand_id']))
		{
			$this->db->where('brand_brand_id', $params['brand_id']);
		}

		if(isset($params['catalog_name']))
		{
			$this->db->like('catalog_name', $params['catalog_name']);
		}

		if(isset($params['catalog_url_slug']))
		{
			$this->db->where('catalog_url_slug', $params['catalog_url_slug']);
		}

		if(isset($params['catalog_for_sale']))
		{
			$this->db->where('catalog_for_sale', $params['catalog_for_sale']);
		}

		if(isset($params['date_start']) AND isset($params['date_end']))
		{
			$this->db->where('catalog_created_date', $params['date_start']);
			$this->db->or_where('catalog_created_date', $params['date_end']);
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
			$this->db->order_by('catalog_last_update', 'desc');
		}

		if (isset($params['autocomplete'])) {
			$this->db->select('catalog_id AS id, catalog_name as label');			
		}else{
			$this->db->select('catalog_id, catalog_name');			
		}

		$this->db->select('catalog_desc, catalog_image, catalog_url_slug, catalog_category_slug,
			catalog_created_date, catalog_last_update, catalog.user_user_id, user.user_name, user_full_name');
		// $this->db->join('brand', 'brand.brand_id = catalog.brand_brand_id', 'left');
		$this->db->join('user', 'user.user_id = catalog.user_user_id', 'left');
		$res = $this->db->get('catalog');

		if(isset($params['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}

	public function get_random_catalog($param = array())
	{
		if (isset($param['id'])) {
			$this->db->where('catalog_id', $param['id']);
		}

		if (isset($param['for_sale'])) {
			$this->db->where('catalog_for_sale', $param['for_sale']);
		}

		if (isset($param['order_by'])) {
			$this->db->order_by($param['order_by'], 'desc');
		} else {
			$this->db->order_by('rand()');
		}

		if (isset($param['limit'])) {
			if (!isset($param['offset'])) {
				$param['offset'] = NULL;
			}

			$this->db->limit($param['limit'], $param['offset']);
		}

		$this->db->select('catalog.*');
		$res = $this->db->get('catalog');

		if(isset($param['id'])) {
			return $res->row_array();
		} else {
			return $res->result_array();
		}
	}

    // Add and update to database
	function add($data = array()) {

		if(isset($data['catalog_id'])) {
			$this->db->set('catalog_id', $data['catalog_id']);
		}

		if(isset($data['catalog_name'])) {
			$this->db->set('catalog_name', $data['catalog_name']);
		}

		if(isset($data['catalog_url_slug'])) {
			$this->db->set('catalog_url_slug', $data['catalog_url_slug']);
		}

		if(isset($data['category_slug'])) {
			$this->db->set('catalog_category_slug', $data['category_slug']);
		}

		if(isset($data['catalog_sku'])) {
			$this->db->set('catalog_sku', $data['catalog_sku']);
		}

		if(isset($data['catalog_desc'])) {
			$this->db->set('catalog_desc', $data['catalog_desc']);
		}

		if(isset($data['catalog_image'])) {
			$this->db->set('catalog_image', $data['catalog_image']);
		}

		if(isset($data['catalog_weight'])) {
			$this->db->set('catalog_weight', $data['catalog_weight']);
		}

		if(isset($data['catalog_buying_price'])) {
			$this->db->set('catalog_buying_price', $data['catalog_buying_price']);
		}

		if(isset($data['catalog_selling_price'])) {
			$this->db->set('catalog_selling_price', $data['catalog_selling_price']);
		}

		if(isset($data['catalog_discount'])) {
			$this->db->set('catalog_discount', $data['catalog_discount']);
		}

		if(isset($data['catalog_real_stock'])) {
			$this->db->set('catalog_real_stock', $data['catalog_real_stock']);
		}

		if(isset($data['increase_real_stock'])) {
			$this->db->set('catalog_real_stock', 'catalog_real_stock +'.$data['increase_real_stock'], FALSE);
		}

		if(isset($data['decrease_real_stock'])) {
			$this->db->set('catalog_real_stock', 'catalog_real_stock -'.$data['decrease_real_stock'], FALSE);
		}

		if(isset($data['catalog_virtual_stock'])) {
			$this->db->set('catalog_virtual_stock', $data['catalog_virtual_stock']);
		}

		if(isset($data['increase_virtual_stock'])) {
			$this->db->set('catalog_virtual_stock', 'catalog_virtual_stock +'.$data['increase_virtual_stock'], FALSE);
		}

		if(isset($data['decrease_virtual_stock'])) {
			$this->db->set('catalog_virtual_stock', 'catalog_virtual_stock -'.$data['decrease_virtual_stock'], FALSE);
		}

		if(isset($data['catalog_created_date'])) {
			$this->db->set('catalog_created_date', $data['catalog_created_date']);
		}

		if(isset($data['catalog_last_update'])) {
			$this->db->set('catalog_last_update', $data['catalog_last_update']);
		}

		if(isset($data['catalog_for_sale'])) {
			$this->db->set('catalog_for_sale', $data['catalog_for_sale']);
		}

		if(isset($data['brand_id'])) {
			$this->db->set('brand_brand_id', $data['brand_id']);
		}

		if(isset($data['user_id'])) {
			$this->db->set('user_user_id', $data['user_id']);
		}

		if (isset($data['catalog_id'])) {
			$this->db->where('catalog_id', $data['catalog_id']);
			$this->db->update('catalog');
			$id = $data['catalog_id'];
		} else {
			$this->db->insert('catalog');
			$id = $this->db->insert_id();
		}

		$status = $this->db->affected_rows();
		return $id;
	}

    // Delete to database
	function delete($id) {
		$this->db->where('catalog_id', $id);
		$this->db->delete('catalog');
	}

    // Get category from database
	function get_category($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('catalog_category_id', $params['id']);
		}
		if (isset($params[''])) {
            # code...
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
			$this->db->order_by('catalog_category_id', 'desc');
		}

		$this->db->select('catalog_category_id, catalog_category_name, catalog_category_created_date,
			catalog_category_last_update, user_user_id');

		$res = $this->db->get('catalog_category');

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
			$this->db->set('catalog_category_id', $data['category_id']);
		}

		if(isset($data['category_name'])) {
			$this->db->set('catalog_category_name', $data['category_name']);
		}

		if(isset($data['category_created_date'])) {
			$this->db->set('catalog_category_created_date', $data['category_created_date']);
		}

		if(isset($data['category_last_update'])) {
			$this->db->set('catalog_category_last_update', $data['category_last_update']);
		}

		if (isset($data['category_id'])) {
			$this->db->where('catalog_category_id', $data['category_id']);
			$this->db->update('catalog_category');
			$id = $data['category_id'];
		} else {
			$this->db->insert('catalog_category');
			$id = $this->db->insert_id();
		}

		$status = $this->db->affected_rows();
		return ($status == 0) ? FALSE : $id;
	}

    // Delete category to database
	function delete_category($id) {
		$this->db->where('catalog_category_id', $id);
		$this->db->delete('catalog_category');
	}

    // Get category from database
	function get_has_category($params = array())
	{
		if(isset($params['id']))
		{
			$this->db->where('catalog_has_catalog_category_id', $params['id']);
		}

		if(isset($params['catalog_id']))
		{
			$this->db->where('catalog_id', $params['catalog_id']);
		}

		if(isset($params['catalog_category_id']))
		{
			$this->db->where('catalog_category_id', $params['catalog_category_id']);
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
			$this->db->order_by('catalog_has_catalog_category_id', 'desc');
		}

		$this->db->select('catalog_has_catalog_category.catalog_has_catalog_category_id, catalog_has_catalog_category.catalog_category_id');
		$this->db->select('catalog_category.catalog_category_id, catalog_category.catalog_category_name');
		$this->db->join('catalog_category', 'catalog_category.catalog_category_id = catalog_has_catalog_category.catalog_category_id', 'left');
		$res = $this->db->get('catalog_has_catalog_category');

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
	function add_has_category($data = array()) {
		if(isset($data['catalog_has_catalog_category_id'])) {
			$this->db->set('catalog_has_catalog_category_id', $data['catalog_has_catalog_category_id']);
		}

		if(isset($data['catalog_id'])) {
			$this->db->set('catalog_id', $data['catalog_id']);
		}

		if(isset($data['catalog_category_id'])) {
			$this->db->set('catalog_category_id', $data['catalog_category_id']);
		}

		if (isset($data['catalog_has_catalog_category_id'])) {
			$this->db->where('catalog_has_catalog_category_id', $data['catalog_has_catalog_category_id']);
			$this->db->update('catalog_has_catalog_category');
			$id = $data['catalog_has_catalog_category_id'];
		} else {
			$this->db->insert('catalog_has_catalog_category');
			$id = $this->db->insert_id();
		}

		$status = $this->db->affected_rows();
		return ($status == 0) ? FALSE : $id;
	}

    // Set Default category
	function delete_has_category($id) {
		$this->db->where('catalog_id', $id);
		$this->db->delete('catalog_has_catalog_category');
	}

	public function add_catalog_image($params = array())
	{
		if (isset($params['catalog_id'])) {
			$this->db->set('catalog_catalog_id', $params['catalog_id']);
		}

		if (isset($params['name'])) {
			$this->db->set('catalog_image_path', $params['name']);
		}

		if (isset($params['id'])) {
			$this->db->where('catalog_image_id', $params['id']);
			$this->db->update('catalog_image');
			return $params['id'];
		}else{
			$this->db->insert('catalog_image');
			return $this->db->insert_id();
		}
	}

	public function get_image($params = array())
	{
		if (isset($params['catalog_id'])) {
			$this->db->where('catalog_catalog_id', $params['catalog_id']);
		}

		if (isset($params['id'])) {
			$this->db->where('catalog_image_id', $params['id']);
		}

		$ret = $this->db->get('catalog_image');

		if (isset($params['id'])) {
			return $ret->row_array();
		}else{	
			return $ret->result_array();
		}
	}

	public function delete_image($id = null)
	{
		$ret = false;
		if (!is_null($id)) {
			$this->db->where('catalog_image_id', $id);
			$this->db->delete('catalog_image');
			$ret = true;
		}

		return $ret;
	}

	function check_unique_category_name($id = '', $name) {
        $this->db->where('catalog_category_name', $name);
        if($id) {
            $this->db->where_not_in('catalog_category_id', $id);
        }
        return $this->db->get('catalog_category')->num_rows();
    }

}
