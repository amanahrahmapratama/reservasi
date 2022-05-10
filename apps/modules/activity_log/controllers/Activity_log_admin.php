<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/** 
* Activity log controllers class
 *
 * @package     GROOT
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Sistiandy Syahbana nugraha <sistiandy@artikulpi.com>
 */

class Activity_log_admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_admin') == NULL) redirect('admin/auth/login');
        $this->load->model('Activity_log_model');
        $this->load->model('user/User_model');
        $this->load->helper(array('form', 'url'));
    }

    public function index($offset = NULL)
    {
        $this->load->library('pagination');

        $config['per_page'] = 10;
        $config['base_url'] = base_url('admin/activity_log/index');
        $config['total_rows'] = $this->db->count_all('activity_log');
        $this->pagination->initialize($config);

        $data['data'] = $this->Activity_log_model->get(array('limit' => 10, 'offset' => $offset));
        $data['user'] = $this->User_model->get();
        $data['title'] = 'Log Aktivitas';
        $data['page'] = 'activity_log/list';
        $this->load->view('admin/layout/main', $data);
    }

}

/* End of file log_activity.php */
/* Location: ./application/controllers/log_activity.php */