<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
* Banner Model Class
 *
 * @package     GROOT
 * @subpackage  Models
 * @category    Models
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */

class Banner_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    var $table = 'banner';
    
    // Get From Databases
    function get($params = array())
    {
        if(isset($params['id']))
        {
            $this->db->where('banner.banner_id', $params['id']);
        }
        
        if(isset($params['banner_title']))
        {
            $this->db->like('banner_title', $params['banner_title']);
        }
        
        if(isset($params['date_start']) AND isset($params['date_end']))
        {
            $this->db->where('banner_created_date', $params['date_start']);
            $this->db->or_where('banner_created_date', $params['date_end']);
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
            $this->db->order_by('banner_last_update', 'desc');
        }

        $this->db->select('banner_id, banner_title, banner_desc, banner_image,
            banner_created_date, banner_last_update, banner.user_user_id, user.user_name');
        $this->db->join('user', 'user.user_id = banner.user_user_id');
        $res = $this->db->get('banner');

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
        
         if(isset($data['banner_id'])) {
            $this->db->set('banner_id', $data['banner_id']);
        }
        
         if(isset($data['banner_title'])) {
            $this->db->set('banner_title', $data['banner_title']);
        }
        
         if(isset($data['banner_desc'])) {
            $this->db->set('banner_desc', $data['banner_desc']);
        }
        
         if(isset($data['banner_image'])) {
            $this->db->set('banner_image', $data['banner_image']);
        }
        
         if(isset($data['banner_created_date'])) {
            $this->db->set('banner_created_date', $data['banner_created_date']);
        }
        
         if(isset($data['banner_last_update'])) {
            $this->db->set('banner_last_update', $data['banner_last_update']);
        }
        
         if(isset($data['user_id'])) {
            $this->db->set('user_user_id', $data['user_id']);
        }
        
        if (isset($data['banner_id'])) {
            $this->db->where('banner_id', $data['banner_id']);
            $this->db->update('banner');
            $id = $data['banner_id'];
        } else {
            $this->db->insert('banner');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    
    // Delete to database
    function delete($id) {
        $this->db->where('banner_id', $id);
        $this->db->delete('banner');
    }
    
}
