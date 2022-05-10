<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reservasi_model extends CI_Model
{

	public function get($params = array())
	{
		if (isset($params['id'])) {
			$this->db->where('reservasi_id', $params['id']);
		}

		if (isset($params['customer_id'])) {
			$this->db->where('customer_customer_id', $params['customer_id']);
		}

		if (isset($params['status_id'])) {
			$this->db->where('reservasi.reservasi_status_status_id', $params['status_id']);
		}

		if (isset($params['catalog_id'])) {
			$this->db->where('reservasi.catalog_catalog_id', $params['catalog_id']);
		}

		if(isset($params['limit']))
		{
			if(!isset($params['offset']))
			{
				$params['offset'] = NULL;
			}

			$this->db->limit($params['limit'], $params['offset']);
		}

		$this->db->where('reservasi.reservasi_is_deleted', false);

		$this->db->select('reservasi.*, reservasi_status.*, catalog.*, customer.*, reservasi_position.*');

		$this->db->join('reservasi_status', 'reservasi_status.status_id = reservasi.reservasi_status_status_id', 'left');
		$this->db->join('catalog', 'catalog.catalog_id = reservasi.catalog_catalog_id', 'left');
		$this->db->join('customer', 'customer.customer_id = reservasi.customer_customer_id', 'left');
		$this->db->join('reservasi_position', 'reservasi_position.position_id = reservasi.reservasi_position_position_id', 'left');

		$this->db->order_by('reservasi.reservasi_id', 'desc');

		$ret = $this->db->get('reservasi');

		if (isset($params['id'])) {
			return $ret->row_array();
		}

		return $ret->result_array();
	}

	public function add($params = array())
	{
		if (isset($params['jenis'])) {
			$this->db->set('reservasi_type', $params['jenis']);
		}

		if (isset($params['date_start'])) {
			$this->db->set('reservasi_date_start', $params['date_start']);
		}

		if (isset($params['date_end'])) {
			$this->db->set('reservasi_date_end', $params['date_end']);
		}

		if (isset($params['attendance'])) {
			$this->db->set('reservasi_attendance', $params['attendance']);
		}

		if (isset($params['other_request'])) {
			$this->db->set('reservasi_other_request', $params['other_request']);
		}

		if (isset($params['request_file'])) {
			$this->db->set('reservasi_request_file', $params['request_file']);
		}

		if (isset($params['proposal_file'])) {
			$this->db->set('reservasi_proposal_file', $params['proposal_file']);
		}

		if (isset($params['customer_id'])) {
			$this->db->set('customer_customer_id', $params['customer_id']);
		}

		if (isset($params['catalog_id'])) {
			$this->db->set('catalog_catalog_id', $params['catalog_id']);
		}

		if (isset($params['status_id'])) {
			$this->db->set('reservasi_status_status_id', $params['status_id']);
		}

		if (isset($params['position_id'])) {
			$this->db->set('reservasi_position_position_id', $params['position_id']);
		}

		if (isset($params['end_message'])) {
			$this->db->set('reservasi_end_message', $params['end_message']);
		}

		if (isset($params['is_complete'])) {
			$this->db->set('reservasi_is_complete', $params['is_complete']);
		}

		if (isset($params['response_file'])) {
			$this->db->set('reservasi_response_file', $params['response_file']);
		}

		if (isset($params['is_deleted'])) {
			$this->db->set('reservasi_is_deleted', $params['is_deleted']);
		}

		if (isset($params['created_at'])) {
			$this->db->set('reservasi_created_at', $params['created_at']);
		}

		if (isset($params['updated_at'])) {
			$this->db->set('reservasi_updated_at', $params['updated_at']);
		}

		if (isset($params['id'])) {
			$this->db->where('reservasi_id', $params['id']);
			$this->db->update('reservasi');
			return $params['id'];
		}

		$this->db->insert('reservasi');
		return $this->db->insert_id();
	}

	public function add_log($params = array())
	{
		if (isset($params['message'])) {
			$this->db->set('log_message', $params['message']);
		}

		if (isset($params['reservasi_id'])) {
			$this->db->set('reservasi_reservasi_id', $params['reservasi_id']);
		}

		if (isset($params['user_id'])) {
			$this->db->set('from_user_id', $params['user_id']);
		}

		if (isset($params['status_id'])) {
			$this->db->set('reservasi_status_status_id', $params['status_id']);
		}

		if (isset($params['date'])) {
			$this->db->set('log_date', $params['date']);
		}

		if (isset($params['id'])) {
			$this->db->where('log_id', $params['id']);
			$this->db->update('reservasi_log');
			return $params['id'];
		}

		$this->db->insert('reservasi_log');
		return $this->db->insert_id();
	}

	public function get_log($params = array())
	{
		if (isset($params['id'])) {
			$this->db->where('log_id', $params['id']);
		}

		if (isset($params['reservasi_id'])) {
			$this->db->where('reservasi_reservasi_id', $params['reservasi_id']);
		}

		$this->db->select('reservasi_log.*, user.*, reservasi_status.*');

		$this->db->join('user', 'user.user_id = reservasi_log.from_user_id', 'left');
		$this->db->join('reservasi_status', 'reservasi_status.status_id = reservasi_log.reservasi_status_status_id', 'left');
		$this->db->order_by('reservasi_log.log_id', 'asc');

		$ret = $this->db->get('reservasi_log');

		if (isset($params['id'])) {
			return $ret->row_array();
		}

		return $ret->result_array();
	}

}

/* End of file Reservasi_model.php */
/* Location: .//var/www/html/projects/reservasiruangan/apps/modules/reservasi/models/Reservasi_model.php */
