<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
* 
*/
class Contact_model extends CI_Model
{
	public function get($param = array())
	{
		if (isset($param['id'])) {
			$this->db->where('contact_id', $param['id']);
		}

		if (isset($param['limit'])) {

            if(!isset($param['offset'])) {
                $param['offset'] = NULL;
            }

            $this->db->limit($param['limit'], $param['offset']);
        }

        if (isset($param['order_by'])) {
            $this->db->order_by($param['order_by'], 'desc');
        } else {
            $this->db->order_by('contact_id', 'desc');
        }

		$this->db->select('contact_id, contact_name, contact_email, contact_subject, contact_message, contact_created_at, contact_updated_at');

		$res = $this->db->get('contact');

		if (isset($param['id'])) {
			return $res->row_array();
		} else {
			return $res->result_array();
		}
	}

	public function add($param = array())
	{
		if (isset($param['contact_name'])) {
			$this->db->set('contact_name', $param['contact_name']);
		}

		if (isset($param['contact_email'])) {
			$this->db->set('contact_email', $param['contact_email']);
		}

		if (isset($param['contact_subject'])) {
			$this->db->set('contact_subject', $param['contact_subject']);
		}

		if (isset($param['contact_message'])) {
			$this->db->set('contact_message', $param['contact_message']);
		}

		if (isset($param['contact_created_at'])) {
			$this->db->set('contact_created_at', $param['contact_created_at']);
		}

		if (isset($param['contact_updated_at'])) {
			$this->db->set('contact_updated_at', $param['contact_updated_at']);
		}

		if (isset($param['contact_id'])) {
			$this->db->where('contact_id', $param['id']);
			$this->db->update('contact');
			$id = $param['contact_id'];
		} else {
			$this->db->insert('contact');
			$id = $this->db->insert_id();
		}
		
		$status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
	}

	public function delete($id)
	{
		$this->db->where('contact_id', $id);
        $this->db->delete('contact');
	}
}