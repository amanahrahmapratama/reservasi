<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
* Purchase Model Class
 *
 * @package     GROOT
 * @subpackage  Models
 * @category    Models
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */

class Purchase_model extends CI_Model 
{

    function __construct() 
    {
        parent::__construct();
    }

    var $table = 'purchase';
    
    // Get From Databases
    function get($params = array())
    {
        if(isset($params['id']))
        {
            $this->db->where('purchase.purchase_id', $params['id']);
        }
        if(isset($params['user_id']))
        {
            $this->db->where('purchase.user_id', $params['user_id']);
        }
        
        if(isset($params['date_start']) AND isset($params['date_end']))
        {
            $this->db->where('purchase_date', $params['date_start']);
            $this->db->or_where('purchase_date', $params['date_end']);
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
            $this->db->order_by('purchase_last_update', 'desc');
        }

        $this->db->select('purchase_id, purchase_date, supplier_supplier_id, supplier.supplier_name,
           purchase_total_price, purchase_created_date, 
           purchase_last_update, purchase.user_user_id, user.user_name');
        $this->db->join('user', 'user.user_id = purchase.user_user_id');
        $this->db->join('supplier', 'supplier.supplier_id = purchase.supplier_supplier_id');
        $res = $this->db->get('purchase');

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

       if(isset($data['purchase_id'])) {
        $this->db->set('purchase_id', $data['purchase_id']);
    }

    if(isset($data['purchase_date'])) {
        $this->db->set('purchase_date', $data['purchase_date']);
    }

    if(isset($data['supplier_id'])) {
        $this->db->set('supplier_supplier_id', $data['supplier_id']);
    }

    if(isset($data['purchase_total_price'])) {
        $this->db->set('purchase_total_price', $data['purchase_total_price']);
    }

    if(isset($data['increase_total_price'])) {
        $this->db->set('purchase_total_price', 'purchase_total_price +'.$data['increase_total_price'], FALSE);
    }

    if(isset($data['decrease_total_price'])) {
            $this->db->set('purchase_total_price', 'purchase_total_price -'.$data['decrease_total_price'], FALSE);
        }

    if(isset($data['purchase_created_date'])) {
        $this->db->set('purchase_created_date', $data['purchase_created_date']);
    }

    if(isset($data['purchase_last_update'])) {
        $this->db->set('purchase_last_update', $data['purchase_last_update']);
    }

    if(isset($data['user_id'])) {
        $this->db->set('user_user_id', $data['user_id']);
    }

    if (isset($data['purchase_id'])) {
        $this->db->where('purchase_id', $data['purchase_id']);
        $this->db->update('purchase');
        $id = $data['purchase_id'];
    } else {
        $this->db->insert('purchase');
        $id = $this->db->insert_id();
    }

    $status = $this->db->affected_rows();
    return ($status == 0) ? FALSE : $id;
}

    // Delete to database
function delete($id) {
    $this->db->where('purchase_id', $id);
    $this->db->delete('purchase');
}

    // Add and update to database
function add_purchase_item($data = array()) {

    if(isset($data['item_id'])) {
        $this->db->set('item_id', $data['item_id']);
    }

    if(isset($data['purchase_id'])) {
        $this->db->set('purchase_purchase_id', $data['purchase_id']);
    }

    if(isset($data['catalog_id'])) {
        $this->db->set('catalog_catalog_id', $data['catalog_id']);
    }

    if(isset($data['item_count'])) {
        $this->db->set('item_count', $data['item_count']);
    }

    if(isset($data['item_price'])) {
        $this->db->set('item_price', $data['item_price']);
    }

    if(isset($data['item_total_price'])) {
        $this->db->set('item_total_price', $data['item_total_price']);
    }

    if (isset($data['item_id'])) {
        $this->db->where('item_id', $data['item_id']);
        $this->db->update('purchase_item');
        $id = $data['item_id'];
    } else {
        $this->db->insert('purchase_item');
        $id = $this->db->insert_id();
    }

    $status = $this->db->affected_rows();
    return ($status == 0) ? FALSE : $id;
}

function get_purchase_item($params = array())
{
    if(isset($params['item_id']))
    {
        $this->db->where('purchase_purchase_id', $params['item_id']);
    }

    if(isset($params['catalog_id']))
    {
        $this->db->where('catalog_catalog_id', $params['catalog_id']);
    }

    if(isset($params['item_count']))
    {
        $this->db->where('item_count', $params['item_count']);
    }

    if(isset($params['item_price']))
    {
        $this->db->where('item_price', $params['item_price']);
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
        $this->db->order_by('item_id', 'desc');
    }

    $this->db->select('item_id, purchase_purchase_id, catalog_catalog_id, item_count, item_price, 
        catalog_name, purchase_item.item_total_price');
    $this->db->join('purchase', 'purchase.purchase_id = purchase_item.purchase_purchase_id');
    $this->db->join('catalog', 'catalog.catalog_id = purchase_item.catalog_catalog_id');
    $res = $this->db->get('purchase_item');

    if(isset($params['id']))
    {
        return $res->row_array();
    }
    else
    {
        return $res->result_array();
    }
}
}