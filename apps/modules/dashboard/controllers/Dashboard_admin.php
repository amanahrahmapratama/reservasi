<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Dashboard_admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_admin') == null) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }

        $this->load->model(array('catalog/Catalog_model', 'sale/Sale_model', 'customer/Customer_model', 'posting/Posting_model', 'reservasi/Reservasi_model'));
    }

    // Dashboard View
    public function index()
    {
        $data['countRuangan']       = count($this->Catalog_model->get());
        $data['countReservasi']     = count($this->Reservasi_model->get());
        $data['countCustomer']      = count($this->Customer_model->get());
        $data['latestReservasi']    = $this->Reservasi_model->get(array('limit' => 5));
        $data['latestNewReservasi'] = $this->Reservasi_model->get(array('limit' => 5, 'status_id' => STATUS_NEW));
        $data['latestNews']         = $this->Posting_model->get(array('limit' => 5));
        $data['date']               = $this->buildDate($this->Reservasi_model->get());
        $data['reservasiDayCount']  = $this->countDateReservasi($this->Reservasi_model->get());

        $data['title'] = 'Dashboard';
        $data['page']  = 'dashboard/dashboard';
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
                'title' => $val['reservasi_type'],
                'start' => $val['reservasi_date_start'],
                'end'   => $val['reservasi_date_end'],
                'color' => $color,
            );
        }

        return json_encode($res);
    }

    public function countDateReservasi($reservasi = array())
    {
        $count = 0;
        foreach ($reservasi as $val) {
            $day = date_diff(date_create($val['reservasi_date_start']), date_create($val['reservasi_date_end']));
            $count += $day->d;
        }

        return $count;
    }
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
