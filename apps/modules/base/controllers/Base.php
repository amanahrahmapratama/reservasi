<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Base extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('posting/Posting_model');
        $this->load->model('catalog/Catalog_model');
        $this->load->model('brand/Brand_model');
        $this->load->model('banner/Banner_model');
        $this->load->model('setting/Setting_model');
        $this->load->model('sale/Sale_model');
        $this->load->model('contact/Contact_model');
        $this->load->model('sliders/Sliders_model');
        $this->load->model('page/Page_model');
        $this->load->library('recaptcha');
    }

    public function index()
    {
        $data['show_banner']     = $this->Setting_model->get(array('key' => 'show_banner'));
        $data['banner']          = $this->Banner_model->get(array('limit' => 5));
        $data['catalogCategory'] = $this->Catalog_model->get_category(array('limit' => 5));
        // $data['catalogBrand'] = $this->Brand_model->get(array('limit' => 5));
        $data['catalog']       = $this->Catalog_model->get(array('limit' => 3));
        $data['category']      = $this->Posting_model->get_category();
        $data['posting']       = $this->Posting_model->get(array('limit' => 5, 'status_publish' => 1));
        $data['random_post']   = $this->Posting_model->get_random_post(array('limit' => 3, 'status_publish' => 1));
        $data['option_post']   = $this->Posting_model->get_random_post(array('limit' => 3, 'status_publish' => 1));
        $data['featured_post'] = $this->Posting_model->get_random_post(array('limit' => 1, 'status_publish' => 1));
        $data['popular_post']  = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
        $data['popularNews']   = $this->Posting_model->get_random_post(array('limit' => 3, 'status_publish' => 1));
        $data['sliders']       = $this->Sliders_model->get();

        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

        $data['title'] = 'Home';
        $data['page']  = 'main';
        $this->load->view('layout', $data);
    }

    public function search()
    {
        $input                    = $this->input->get('q', true);
        $search                   = urldecode($input);
        $params['posting_title']  = $search;
        $params['status_publish'] = 1;

        $query_string = $this->input->server('QUERY_STRING', true);

        $config['base_url']             = site_url('search?' . $query_string);
        $config['total_rows']           = count($this->Posting_model->get($params));
        $config['per_page']             = 4;
        $config['page_query_string']    = true;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);

        $offset = $this->input->get('page', true);
        $this->load->helper('text');

        $params['limit']  = 4;
        $params['offset'] = $offset;
        $data['posting']  = $this->Posting_model->get($params);

        $data['posting_other'] = $this->Posting_model->get_random_post(array('limit' => 4, 'status_publish' => 1));
        $data['category']      = $this->Posting_model->get_category();
        $data['popular_post']  = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));

        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

        $data['title'] = 'Pencarian kata: ' . $search;
        $data['page']  = 'search';
        $this->load->view('layout', $data);
    }

    public function about()
    {
        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

        $data['popular_post'] = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
        $data['popularNews']  = $this->Posting_model->get_random_post(array('limit' => 3, 'status_publish' => 1));
        $data['category']     = $this->Posting_model->get_category();
        $data['title']        = 'Tentang';
        $data['page']         = 'about';
        $this->load->view('layout', $data);
    }

    public function contact()
    {
        $this->form_validation->set_rules('contact_name', 'Nama', 'required');
        $this->form_validation->set_rules('contact_email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('contact_message', 'Pesan', 'required');
        $this->form_validation->set_rules('g-recaptcha-response', '<strong>Captcha</strong>', 'callback_getResponseCaptcha');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');

        if ($_POST && $this->form_validation->run() == true) {
            $param['contact_name']       = $this->input->post('contact_name');
            $param['contact_email']      = $this->input->post('contact_email');
            $param['contact_subject']    = $this->input->post('contact_subject');
            $param['contact_message']    = $this->input->post('contact_message');
            $param['contact_created_at'] = date('Y-m-d H:i:s');
            $param['contact_updated_at'] = date('Y-m-d H:i:s');

            $this->Contact_model->add($param);

            $this->email->set_mailtype('html');
            $this->email->from($param['contact_email'], $param['contact_name']);
            $this->email->to($this->config->item('email_admin'));
            $this->email->subject($param['contact_subject']);
            $mail_body = $this->load->view('email/email_contact', array('param' => $param), true);
            $this->email->message($mail_body);
            $this->email->send();

            $this->session->set_flashdata('send_success', 'Pesan anda telah berhasil dikirim');
            redirect(current_url());
        }

        $data = array('recaptcha_html' => $this->recaptcha->render());

        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

        $data['popular_post'] = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
        $data['title']        = 'Kontak';
        $data['page']         = 'contact';
        $this->load->view('layout', $data);
    }

    public function work()
    {
        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

        $data['popular_post'] = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
        $data['title']        = 'Cara Kerja';
        $data['page']         = 'work';
        $this->load->view('layout', $data);
    }

    public function faq()
    {
        $setting                  = $this->setting->general();
        $data['app_name']         = $setting['app_name']['setting_value'];
        $data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
        $data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
        $data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

        $imageSetting        = $this->setting->image();
        $data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
        $data['img_logo']    = $imageSetting['img_logo']['setting_value'];

        $data['posting_other'] = $this->Posting_model->get_random_post(array('limit' => 4, 'status_publish' => 1));
        $data['popular_post']  = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
        $data['category'] = $this->Posting_model->get_category();
        $data['title']         = 'FAQ';

        $data['faq'] = $this->Page_model->get(array('id' => PAGE_FAQ));

        $data['page'] = 'faq';
        $this->load->view('layout', $data);
    }

    public function portal()
    {
        $data['title'] = 'Portal';
        $this->load->view('portal', $data);
    }

    public function add_to_cart_json()
    {
        $result = array();
        if ($this->input->post()) {
            $res = $this->Catalog_model->get(array('id' => $this->input->post('catalog_id', true)));

            $info = array(
                'id'      => $res['catalog_id'],
                'qty'     => 1,
                'price'   => $res['catalog_selling_price'],
                'name'    => $res['catalog_name'],
                'options' => array(
                    'stock'  => $res['catalog_virtual_stock'],
                    'weight' => $res['catalog_weight'],
                ),
            );

            $this->cart->insert($info);

            $redirect_url = site_url('user/cart/view');
            $this->session->set_flashdata('success', 'Berhasil tambah barang ke keranjang belanja');
            $result = array(
                'success'      => true,
                'redirect_url' => $redirect_url,
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function get_csrf_token()
    {
        $data = array(
            'csrf_token' => $this->security->get_csrf_hash(),
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function getResponseCaptcha($str)
    {
        $response = $this->recaptcha->verifyResponse($str);

        if ($response['success']) {
            return true;
        } else {
            $this->form_validation->set_message('getResponseCaptcha', '%s is required.');
            return false;
        }
    }
}
