<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Calendar_admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_admin')) {
            redirect('admin/auth/login');
        }

        $this->load->model(array('reservasi/Reservasi_model'));
    }

    public function index()
    {
        $date         = $this->buildDate($this->Reservasi_model->get());
        $data['date'] = $date;

        $data['page']  = 'calendar';
        $data['title'] = 'Kalender Reservasi Ruangan';
        $this->load->view('admin/layout/main', $data);
    }

    public function buildDate($reservasi = array())
    {
        $res = array();

        foreach ($reservasi as $val) {
            $color = "#BC2E00";
            if ($val['reservasi_status_status_id'] == STATUS_NEW) {
                $color = "#649DDD";
            } elseif ($val['reservasi_status_status_id'] == STATUS_PROCESS) {
                $color = "#4A4297";
            } elseif ($val['reservasi_status_status_id'] == STATUS_APPROVED) {
                $color = "#51D045";
            }

            $res[] = array(
                'id'    => $val['reservasi_id'],
                'title' => $val['catalog_name'],
                'start' => $val['reservasi_date_start'],
                'end'   => $val['reservasi_date_end'],
                'color' => $color,
            );
        }

        return json_encode($res);
    }

}

/* End of file Calendar_admin.php */
/* Location: .//var/www/html/projects/reservasiruangan/apps/modules/calendar/controllers/Calendar_admin.php */
