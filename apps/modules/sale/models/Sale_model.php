<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
* Sale Model Class
 *
 * @package     GROOT
 * @subpackage  Models
 * @category    Models
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */

class Sale_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	var $table = 'sale';

    // Get From Databases
	function get($data = array())
	{
		if(isset($data['id']))
		{
			$this->db->where('sale.sale_id', $data['id']);
		}

		if(isset($data['user_id']))
		{
			$this->db->where('sale.user_id', $data['user_id']);
		}

		if(isset($data['max_id']))
		{
			$this->db->select_max('sale_id');
		}

		if(isset($data['sale_inv_num']))
		{
			$this->db->where('sale.sale_inv_num', $data['sale_inv_num']);
		}

		if(isset($data['date_start']) AND isset($data['date_end']))
		{
			$this->db->where('sale_date', $data['date_start']);
			$this->db->or_where('sale_date', $data['date_end']);
		}

		if(isset($data['limit']))
		{
			if(!isset($data['offset']))
			{
				$data['offset'] = NULL;
			}

			$this->db->limit($data['limit'], $data['offset']);
		}

		if(isset($data['order_by']))
		{
			$this->db->order_by($data['order_by'], 'desc');
		}
		else
		{
			$this->db->order_by('sale_id', 'desc');
		}

		if (isset($data['status'])) {
			$this->db->where('sale.sale_status_sale_status_id', $data['status']);
		}

		$this->db->select('sale.sale_id, sale.sale_inv_num, sale.sale_date, sale.customer_customer_id, sale.sale_total_price, sale.sale_province,
			sale.sale_kabupaten, sale.shipping_shipping_id, sale.sale_status_sale_status_id,
			sale.user_user_id, sale.sale_created_date, sale.sale_last_update, sale.sale_shipping_address, sale.sale_transfer_image, sale.sale_transfer_name,
			sale.sale_transfer_date, sale.sale_tracking_id, sale_courier, sale_courier_service, sale.sale_postal_code, sale_ongkir,sale.sale_recipient_name, sale.sale_recipient_phone');
		
		$this->db->select('customer.customer_id, customer.customer_full_name, customer.customer_email');
		$this->db->select('sale_status.sale_status_id, sale_status.sale_status_name');
		$this->db->select('shipping.shipping_name');

		$this->db->join('customer', 'customer.customer_id = sale.customer_customer_id', 'left');
		$this->db->join('sale_status', 'sale_status.sale_status_id = sale.sale_status_sale_status_id', 'left');
		
		$this->db->join('shipping', 'shipping.shipping_id = sale.shipping_shipping_id', 'left');
		$this->db->join('user', 'user.user_id = sale.user_user_id', 'left');
		$res = $this->db->get('sale');

		if(isset($data['id']) OR isset($data['sale_inv_num']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}

	public function get_sale($params = array())
	{
		if (isset($params['id'])) {
			$this->db->where('sale_id', $params['id']);
		}

		if (isset($params['customer_id'])) {
			$this->db->where('customer_customer_id', $params['customer_id']);
		}

		if(isset($params['limit']))
		{
			if(!isset($params['offset']))
			{
				$params['offset'] = NULL;
			}

			$this->db->limit($params['limit'], $params['offset']);
		}

		if (isset($params['status'])) {
			$this->db->where('sale.sale_status_sale_status_id', $params['status']);
		}

		$this->db->select('sale.sale_id, sale.sale_inv_num, sale.sale_date, sale.customer_customer_id, sale.sale_total_price, sale.sale_province,
			sale.sale_kabupaten, sale.sale_courier, sale.sale_status_sale_status_id,
			sale.user_user_id, sale.sale_created_date, sale.sale_last_update, sale.sale_shipping_address, sale.sale_recipient_name,
			sale.sale_recipient_name, sale.sale_recipient_phone, sale.sale_postal_code, sale.sale_courier_service, sale_ongkir, sale.sale_tracking_id, sale.sale_transfer_bank');
		$this->db->select('customer.customer_id, customer.customer_full_name, customer.customer_email');
		$this->db->select('sale_status.sale_status_id, sale_status.sale_status_name');

		$this->db->join('customer', 'customer.customer_id = sale.customer_customer_id', 'left');
		$this->db->join('sale_status', 'sale_status.sale_status_id = sale.sale_status_sale_status_id', 'left');
		
		$this->db->order_by('sale.sale_id', 'desc');

		$ret = $this->db->get('sale');

		if (isset($params['id'])) {
			return $ret->row_array();
		}else{
			return $ret->result_array();
		}
	}

    // Add and update to database
	function add($data = array()) {

		if (isset($data['sale_id'])) {
			$this->db->set('sale_id', $data['sale_id']);
		}

		if(isset($data['sale_date'])) {
			$this->db->set('sale_date', $data['sale_date']);
		}

		if(isset($data['sale_inv_num'])) {
			$this->db->set('sale_inv_num', $data['sale_inv_num']);
		}

		if(isset($data['customer_id'])) {
			$this->db->set('customer_customer_id', $data['customer_id']);
		}

		if(isset($data['sale_total_price'])) {
			$this->db->set('sale_total_price', $data['sale_total_price']);
		}

		if(isset($data['increase_total_price'])) {
			$this->db->set('sale_total_price', 'sale_total_price +'.$data['increase_total_price'], FALSE);
		}

		if(isset($data['sale_created_date'])) {
			$this->db->set('sale_created_date', $data['sale_created_date']);
		}

		if(isset($data['sale_last_update'])) {
			$this->db->set('sale_last_update', $data['sale_last_update']);
		}

		if(isset($data['payment_id'])) {
			$this->db->set('payment_payment_id', $data['payment_id']);
		}

		if(isset($data['shipping_id'])) {
			$this->db->set('shipping_shipping_id', $data['shipping_id']);
		}

		if(isset($data['sale_status_id'])) {
			$this->db->set('sale_status_sale_status_id', $data['sale_status_id']);
		}

		if(isset($data['user_id'])) {
			$this->db->set('user_user_id', $data['user_id']);
		}

		if (isset($data['tracking_id'])) {
			$this->db->set('sale_tracking_id', $data['tracking_id']);
		}

		if (isset($data['courier'])) {
			$this->db->set('sale_courier', $data['courier']);
		}

		if (isset($data['province'])) {
			$this->db->set('sale_province', $data['province']);
		}

		if (isset($data['kabupaten'])) {
			$this->db->set('sale_kabupaten', $data['kabupaten']);
		}

		if (isset($data['kecamatan_id'])) {
			$this->db->set('kecamatan_kecamatan_id', $data['kecamatan_id']);
		}

		if (isset($data['shipping_address'])) {
			$this->db->set('sale_shipping_address', $data['shipping_address']);
		}

		if (isset($data['transfer_date'])) {
			$this->db->set('sale_transfer_date', $data['transfer_date']);
		}

		if (isset($data['transfer_name'])) {
			$this->db->set('sale_transfer_name', $data['transfer_name']);
		}

		if (isset($data['transfer_to'])) {
			$this->db->set('sale_transfer_bank', $data['transfer_to']);
		}

		if (isset($data['transfer_file'])) {
			$this->db->set('sale_transfer_image', $data['transfer_file']);
		}

		if (isset($data['recipient_name'])) {
			$this->db->set('sale_recipient_name', $data['recipient_name']);
		}

		if (isset($data['recipient_phone'])) {
			$this->db->set('sale_recipient_phone', $data['recipient_phone']);
		}

		if (isset($data['courier'])) {
			$this->db->set('sale_courier', $data['courier']);
		}

		if (isset($data['service'])) {
			$this->db->set('sale_courier_service', $data['service']);
		}

		if (isset($data['ongkir'])) {
			$this->db->set('sale_ongkir', $data['ongkir']);
		}

		if (isset($data['postal_code'])) {
			$this->db->set('sale_postal_code', $data['postal_code']);
		}

		if (isset($data['sale_id'])) {
			$this->db->where('sale_id', $data['sale_id']);
			$this->db->update('sale');
			$id = $data['sale_id'];
		} else {
			$this->db->insert('sale');
			$id = $this->db->insert_id();
		}

		return $id;
	}

    // Delete to database
	function delete($id) {
		$this->db->where('sale_id', $id);
		$this->db->delete('sale');
	}

    // Get From Databases
	function get_sale_item($data = array())
	{
		if(isset($data['sale_id']))
		{
			$this->db->where('sale_sale_id', $data['sale_id']);
		}

		if(isset($data['catalog_id']))
		{
			$this->db->where('catalog_catalog_id', $data['catalog_id']);
		}

		if(isset($data['sale_count']))
		{
			$this->db->where('sale_count', $data['sale_count']);
		}

		if(isset($data['sale_price']))
		{
			$this->db->where('sale_price', $data['sale_price']);
		}

		if(isset($data['limit']))
		{
			if(!isset($data['offset']))
			{
				$data['offset'] = NULL;
			}

			$this->db->limit($data['limit'], $data['offset']);
		}

		if(isset($data['order_by']))
		{
			$this->db->order_by($data['order_by'], 'desc');
		}
		else
		{
			$this->db->order_by('sale_item_id', 'desc');
		}

		$this->db->select('sale_item_id, sale_sale_id, catalog_catalog_id, sale_count, sale_price, 
			catalog_name, sale_item.sale_total_price, catalog.catalog_weight');
		$this->db->join('sale', 'sale.sale_id = sale_item.sale_sale_id');
		$this->db->join('catalog', 'catalog.catalog_id = sale_item.catalog_catalog_id');
		$res = $this->db->get('sale_item');

		if(isset($data['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}

    // Add and update to database
	function add_sale_item($data = array()) {

		if(isset($data['item_id'])) {
			$this->db->set('sale_item_id', $data['item_id']);
		}

		if(isset($data['sale_id'])) {
			$this->db->set('sale_sale_id', $data['sale_id']);
		}

		if(isset($data['catalog_id'])) {
			$this->db->set('catalog_catalog_id', $data['catalog_id']);
		}

		if(isset($data['sale_count'])) {
			$this->db->set('sale_count', $data['sale_count']);
		}

		if(isset($data['sale_price'])) {
			$this->db->set('sale_price', $data['sale_price']);
		}

		if(isset($data['sale_total_price'])) {
			$this->db->set('sale_total_price', $data['sale_total_price']);
		}

		if (isset($data['item_id'])) {
			$this->db->where('sale_item_id', $data['sale_item_id']);
			$this->db->update('sale_item');
			$id = $data['item_id'];
		} else {
			$this->db->insert('sale_item');
			$id = $this->db->insert_id();
		}

		$status = $this->db->affected_rows();
		return ($status == 0) ? FALSE : $id;
	}

    // Get From Databases
	function get_payment($data = array())
	{
		if(isset($data['id']))
		{
			$this->db->where('payment_id', $data['id']);
		}

		if(isset($data['limit']))
		{
			if(!isset($data['offset']))
			{
				$data['offset'] = NULL;
			}

			$this->db->limit($data['limit'], $data['offset']);
		}

		if(isset($data['order_by']))
		{
			$this->db->order_by($data['order_by'], 'desc');
		}
		else
		{
			$this->db->order_by('payment_id', 'desc');
		}

		$this->db->select('payment_id, payment_name');
		$res = $this->db->get('payment');

		if(isset($data['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}

    // Get From Databases
	function get_shipping($data = array())
	{
		if(isset($data['id']))
		{
			$this->db->where('shipping_id', $data['id']);
		}

		if(isset($data['limit']))
		{
			if(!isset($data['offset']))
			{
				$data['offset'] = NULL;
			}

			$this->db->limit($data['limit'], $data['offset']);
		}

		if(isset($data['order_by']))
		{
			$this->db->order_by($data['order_by'], 'desc');
		}
		else
		{
			$this->db->order_by('shipping_id', 'desc');
		}

		$this->db->select('shipping_id, shipping_name');
		$res = $this->db->get('shipping');

		if(isset($data['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}

    // Get From Databases
	function get_sale_status($data = array())
	{
		if(isset($data['id']))
		{
			$this->db->where('sale_status_id', $data['id']);
		}

		if(isset($data['limit']))
		{
			if(!isset($data['offset']))
			{
				$data['offset'] = NULL;
			}

			$this->db->limit($data['limit'], $data['offset']);
		}

		if(isset($data['order_by']))
		{
			$this->db->order_by($data['order_by'], 'desc');
		}
		else
		{
			$this->db->order_by('sale_status_id', 'desc');
		}

		$this->db->select('sale_status_id, sale_status_name');
		$res = $this->db->get('sale_status');

		if(isset($data['id']))
		{
			return $res->row_array();
		}
		else
		{
			return $res->result_array();
		}
	}

}
