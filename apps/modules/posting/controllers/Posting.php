<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posting extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('text');
        $this->load->model('Posting_model');
    }

    public function index($offset = NULL)
    {
        $this->load->library('pagination');
        $this->load->helper('text');
        $data['title'] = 'Daftar Berita';
        $params = array(
            'limit' => 4, 
            'offset' => $offset, 
            'status_publish' => 1,
            'posting_title' => $this->input->get('q', true)
        );
        $data['posting'] = $this->Posting_model->get($params);
        $data['posting_other'] = $this->Posting_model->get_random_post(array('limit' => 4, 'status_publish' => 1));
        $data['popular_post'] = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
        $data['category'] = $this->Posting_model->get_category();
        $config['uri_segment']= 3;
        $config['per_page'] = 4;
        $config['base_url'] = site_url('posting/index');
        $config['total_rows'] = count($this->Posting_model->get(array( 'status_publish' => 1)));
        $this->pagination->initialize($config);
        $data['body_color'] = 'background:#f2f2f2;';

        $setting = $this->setting->general();
        $data['app_name'] = $setting['app_name']['setting_value'];
        $data['shareToFacebook'] = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter'] = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo'] = $imageSetting['img_logo']['setting_value'];
        
        $data['page'] = 'public/posting_index';
        $this->load->view('layout', $data);
    }

    public function category($id = NULL, $offset = NULL)
    {
        $this->load->library('pagination');
        $data['posting'] = $this->Posting_model->get(array('category_id' => $id, 'status_publish' => 1, 'limit' => 4, 'offset' => $offset));
        $data['posting_other'] = $this->Posting_model->get_random_post(array('limit' => 4, 'status_publish' => 1));
        $data['popular_post'] = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
        $data['category'] = $this->Posting_model->get_category();
        $data['category_name'] = isset($data['posting'][0]) ? $data['posting'][0]['posting_category_name'] : 'Not Found';
        $data['title'] = 'Posting Kategori '.$data['category_name'];
        $config['uri_segment'] = 4;
        $config['per_page'] = 4;
        $config['base_url'] = site_url('posting/category/'.$id);
        $config['total_rows'] = count($this->Posting_model->get(array('category_id' => $id, 'status_publish' => 1)));
        $this->pagination->initialize($config);

        $setting = $this->setting->general();
        $data['app_name'] = $setting['app_name']['setting_value'];
        $data['shareToFacebook'] = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter'] = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo'] = $imageSetting['img_logo']['setting_value'];

        $data['page'] = 'public/posting_category';
        $this->load->view('layout', $data);
    }

    public function detail($id = NULL, $name = '', $offset=NULL)
    {
        $data['posting'] = $this->Posting_model->get(array('id' => $id));
        if (count($data['posting']) == 0) {
            redirect('posting');
        }

        $this->Posting_model->increment_viewer($id);
        
        $setting = $this->setting->general();
        $data['app_name'] = $setting['app_name']['setting_value'];
        $data['shareToFacebook'] = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter'] = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo'] = $imageSetting['img_logo']['setting_value'];
        $data['fb_id'] = $setting['fb_id']['setting_value'];
        
        $data['popular_post'] = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
        $data['posting_other'] = $this->Posting_model->get_random_post(array('limit' => 4, 'status_publish' => 1));
        $data['relatedPost'] = $this->Posting_model->get_random_post(array('limit' => 5, 'status_publish' => 1));
        $data['category'] = $this->Posting_model->get_category();
        $data['main'] = 'posting_detail';
        $data['title'] = $data['posting']['posting_title'];
        $data['body_color'] = 'background:#f2f2f2;';
        $data['page'] = 'public/posting_detail';
        $this->load->view('layout', $data);
    }

}
