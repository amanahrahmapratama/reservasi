<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
 * User Model Class
 *
 * @package     GROOT
 * @subpackage  Models
 * @category    Models
 * @author      Sistiandy Syahbana nugraha <sistiandy@artikulpi.com>
 */

class User_model extends CI_Model
{
    var $table = 'user';
    
    function get($params = array())
    {
        $this->db->select('user.user_id, user_name, user_password, user_full_name, user_phone, user_address,
            user_email, user_created_date, user_last_update, user_role_role_id, user_role.role_name, user_deleted');
        
        if(isset($params['id'])) {
            $this->db->where('user.user_id', $params['id']);
        }

        if(isset($params['user_id'])) {
            $this->db->where('user.user_id', $params['user_id']);
        }

        if(isset($params['name'])) {
            $this->db->like('user_name', $params['name']);
        }

        if(isset($params['password'])) {
            $this->db->where('user_password', $params['password']);
        }
        
        if(isset($params['date'])) {
            $this->db->where('user_created_date', $params['date']);
        }
        
        if(isset($params['status'])) {
            $this->db->where('user_deleted', $params['status']);
        }
        
        if(isset($params['role_id'])) {
            $this->db->where('user_role_role_id', $params['role_id']);
        }

        if(isset($params['limit'])) {
            if(!isset($params['offset']))
            {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        if(isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('user_last_update', 'desc');
        }

        $this->db->join('user_role', 'user_role.role_id = user.user_role_role_id', 'left');
        $res = $this->db->get('user');

        if(isset($params['id']) OR isset($params['name'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }
    
    function get_role($params = array())
    {
        $this->db->select('user_role.role_id, role_name'); 
        
        if(isset($params['id'])) {
            $this->db->where('user_role.role_id', $params['id']);
        }

        if(isset($params['role_id'])) {
            $this->db->where('user_role.role_id', $params['role_id']);
        }
        
        if(isset($params['limit'])) {
            if(!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        if(isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('user_role.role_id', 'desc');
        }
        
        $res = $this->db->get('user_role');

        if(isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    function add($data = array())
    { 
        if(isset($data['user_id'])) {
            $this->db->set('user_id', $data['user_id']);
        }
    
        if(isset($data['user_name'])) {
            $this->db->set('user_name', $data['user_name']);
        }
    
        if(isset($data['user_password'])) {
            $this->db->set('user_password', $data['user_password']);
        }
    
        if(isset($data['user_full_name'])) {
            $this->db->set('user_full_name', $data['user_full_name']);
        }
    
        if(isset($data['user_email'])) {
            $this->db->set('user_email', $data['user_email']);
        }
    
        if(isset($data['user_phone'])) {
            $this->db->set('user_phone', $data['user_phone']);
        }
    
        if(isset($data['user_address'])) {
            $this->db->set('user_address', $data['user_address']);
        }
    
        if(isset($data['user_created_date'])) {
            $this->db->set('user_created_date', $data['user_created_date']);
        }
    
        if(isset($data['user_last_update'])) {
            $this->db->set('user_last_update', $data['user_last_update']);
        }
    
        if(isset($data['user_role_role_id'])) {
            $this->db->set('user_role_role_id', $data['user_role_role_id']);
        }
    
        if(isset($data['user_deleted'])) {
            $this->db->set('user_deleted', $data['user_deleted']);
        }
    
        if (isset($data['user_id'])) {
            $this->db->where('user_id', $data['user_id']);
            $this->db->update('user');
            $id = $data['user_id'];
        } else {
            $this->db->insert('user');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    function add_role($data = array())
    {
        if(isset($data['role_id'])) {
            $this->db->set('role_id', $data['role_id']);
        }

        if(isset($data['role_name'])) {
            $this->db->set('role_name', $data['role_name']);
        }

        if (isset($data['role_id'])) {
            $this->db->where('role_id', $data['role_id']);
            $this->db->update('user_role');
            $id = $data['role_id'];
        } else {
            $this->db->insert('user_role');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    function delete($id)
    {
        $this->db->set('user_deleted', 1);
        $this->db->where('user_id', $id);
        $this->db->update('user');
    }

    function delete_role($id)
    {
        $this->db->where('role_id', $id);
        $this->db->delete('user_role');
    }

    function change_password($id, $params)
    {
        $this->db->where('user_id', $id);
        $this->db->update('user', $params);   
    }

    function check_login($username, $pass)
    {
        $this->db->select('user_password');
        $this->db->where('user_name', $username);
        $this->db->where('user_deleted', FALSE);
        $res = $this->db->get('user');
        $user = $res->row_array();

        if (password_verify($pass, $user['user_password'])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_by_username($username)
    {
        $this->db->select('user.user_id, user_name, user_full_name, user_phone, user_address,
            user_email, user_created_date, user_last_update, user_role_role_id,
            user_role.role_name, user_deleted');
        $this->db->where('user_name', $username);
        $this->db->where('user_deleted', FALSE);
        $this->db->join('user_role', 'user_role.role_id = user.user_role_role_id', 'left');

        $res = $this->db->get('user');
        return $res->row_array();
    }

}
