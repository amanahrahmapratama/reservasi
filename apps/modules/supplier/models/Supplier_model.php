<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
* Supplier Model Class
 *
 * @package     GROOT
 * @subpackage  Models
 * @category    Models
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */

class Supplier_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    var $table = 'supplier';
    
    // Get From Databases
    function get($params = array())
    {
        if(isset($params['id']))
        {
            $this->db->where('supplier.supplier_id', $params['id']);
        }
        if(isset($params['user_id']))
        {
            $this->db->where('supplier.user_id', $params['user_id']);
        }
        
        if(isset($params['supplier_name']))
        {
            $this->db->like('supplier_name', $params['supplier_name']);
        }
        
        if(isset($params['date_start']) AND isset($params['date_end']))
        {
            $this->db->where('supplier_created_date', $params['date_start']);
            $this->db->or_where('supplier_created_date', $params['date_end']);
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
            $this->db->order_by('supplier_last_update', 'desc');
        }

        $this->db->select('supplier_id, supplier_name, supplier_email, supplier_phone, supplier_address,
                         supplier_created_date, supplier_last_update, supplier.user_user_id, user.user_name');
        $this->db->join('user', 'user.user_id = supplier.user_user_id');
        $res = $this->db->get('supplier');

        if(isset($params['id']))
        {
            return $res->row_array();
        }
        else
        {
            return $res->result_array();
        }
    }

    // Add and update to database
    function add($data = array()) {
        
         if(isset($data['supplier_id'])) {
            $this->db->set('supplier_id', $data['supplier_id']);
        }
        
         if(isset($data['supplier_name'])) {
            $this->db->set('supplier_name', $data['supplier_name']);
        }
        
         if(isset($data['supplier_email'])) {
            $this->db->set('supplier_email', $data['supplier_email']);
        }
        
         if(isset($data['supplier_phone'])) {
            $this->db->set('supplier_phone', $data['supplier_phone']);
        }
        
         if(isset($data['supplier_address'])) {
            $this->db->set('supplier_address', $data['supplier_address']);
        }
        
         if(isset($data['supplier_created_date'])) {
            $this->db->set('supplier_created_date', $data['supplier_created_date']);
        }
        
         if(isset($data['supplier_last_update'])) {
            $this->db->set('supplier_last_update', $data['supplier_last_update']);
        }
        
         if(isset($data['user_id'])) {
            $this->db->set('user_user_id', $data['user_id']);
        }
        
        if (isset($data['supplier_id'])) {
            $this->db->where('supplier_id', $data['supplier_id']);
            $this->db->update('supplier');
            $id = $data['supplier_id'];
        } else {
            $this->db->insert('supplier');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    
    // Delete to database
    function delete($id) {
        $this->db->where('supplier_id', $id);
        $this->db->delete('supplier');
    }
    
}
