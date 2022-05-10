<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Catalog extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('text');
        $this->load->model(array('Catalog_model', 'posting/Posting_model', 'reservasi/Reservasi_model'));
    }

    public function index($offset = null)
    {
        $this->load->library('pagination');
        $this->load->helper('text');
        $data['title']         = 'Rooms';
        $data['popular_post']  = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
        $data['catalog']       = $this->Catalog_model->get();
        $config['uri_segment'] = 3;
        $config['per_page']    = 8;
        $config['base_url']    = site_url('catalog/index');
        $config['total_rows']  = count($this->Catalog_model->get());
        $this->pagination->initialize($config);
        $data['body_color'] = 'background:#f2f2f2;';

        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

        $data['page'] = 'public/catalog_index';
        $this->load->view('layout', $data);
    }

    // public function category($id = NULL, $offset = NULL)
    // {
    //     $this->load->library('pagination');
    //     $data['posting'] = $this->Posting_model->get(array('category_id' => $id, 'status' => 1, 'limit' => 10, 'offset' => $offset));
    //     $data['title'] = 'Posting';
    //     $data['category_name'] = isset($data['posting'][0]) ? $data['posting'][0]['category_name'] : 'Not Found';
    //     $config['uri_segment'] = 4;
    //     $config['per_page'] = 10;
    //     $config['base_url'] = site_url('posting/category/'.$id);
    //     $config['total_rows'] = count($this->Posting_model->get(array('category_id' => $id, 'status' => 1)));
    //     $this->pagination->initialize($config);

    //     $data['page'] = 'public/posting_category';
    //     $this->load->view('layout', $data);
    // }

    public function detail($id = null, $offset = null)
    {
        $data['catalog'] = $this->Catalog_model->get(array('id' => $id));
        if (count($data['catalog']) == 0) {
            redirect('catalog');
        }
        $data['image'] = $this->Catalog_model->get_image(array('catalog_id' => $id));

        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];
        $data['fb_id']       = $setting['fb_id']['setting_value'];

        $date         = $this->buildDate($this->Reservasi_model->get(array('status_id' => STATUS_APPROVED, 'catalog_id' => $id)));
        $data['date'] = $date;

        $data['popular_post']  = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
        $data['catalog_other'] = $this->Catalog_model->get_random_catalog(array('limit' => 4));
        $data['title']         = $data['catalog']['catalog_name'];
        // $data['body_color'] = 'background:#f2f2f2;';
        $data['page'] = 'public/catalog_detail';
        $this->load->view('layout', $data);
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

}
