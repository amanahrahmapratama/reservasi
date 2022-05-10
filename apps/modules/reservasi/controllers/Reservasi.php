<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reservasi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_customer')) {
			redirect('auth/login');
		}

		$this->load->model(array('Reservasi_model', 'catalog/Catalog_model', 'posting/Posting_model', 'user/User_model'));
	}

	public function index($id)
	{
		$data['catalog'] = $this->Catalog_model->get(array('id' => $id));
		if (count($data['catalog']) == 0) {
			redirect('catalog');
		}

		if ($this->input->post()) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('inputJenis', 'Jenis Kegiatan', 'trim|required|xss_clean');
			$this->form_validation->set_rules('inputDateStart', 'Tanggal Mulai', 'trim|required|xss_clean');
			$this->form_validation->set_rules('inputDateEnd', 'Tanggal Selesai', 'trim|required|xss_clean');
			$this->form_validation->set_rules('inputAttendance', 'Perkiraan Jumlah Peserta', 'trim|required|xss_clean');
			$this->form_validation->set_rules('inputOtherRequest', 'Kebutuhan Lainnya', 'trim|xss_clean');

			if ($_FILES['inputFile']['name'] == '') {
				$this->form_validation->set_rules('inputFile', 'Scan Surat Permohonan', 'trim|required|xss_clean');
			} else {
				$this->form_validation->set_rules('inputFile', 'Scan Surat Permohonan', 'trim|xss_clean|callback_check_request_file');
			}

			if ($_FILES['inputProposal']['name'] == '') {
				$this->form_validation->set_rules('inputProposal', 'Scan Proposal', 'trim|required|xss_clean');
			} else {
				$this->form_validation->set_rules('inputProposal', 'Scan Proposal', 'trim|xss_clean|callback_check_proposal_file');
			}
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

			if ($this->form_validation->run()) {
				$params['jenis']         = $this->input->post('inputJenis', true);
				$params['date_start']    = $this->input->post('inputDateStart', true);
				$params['date_end']      = $this->input->post('inputDateEnd', true);
				$params['attendance']    = $this->input->post('inputAttendance', true);
				$params['other_request'] = $this->input->post('inputOtherRequest', true);
				$params['customer_id']   = $this->session->userdata('user_id_customer');
				$params['catalog_id']    = $id;
				$params['status_id']     = STATUS_NEW;
				$params['position_id']   = POSITION_KAMUS;
				$params['created_at']    = date('Y-m-d H:i:s');
				$params['updated_at']    = date('Y-m-d H:i:s');

				$ret                     = $this->Reservasi_model->add($params);
				$params['id']            = $ret;
				if ($_FILES['inputFile']['name'] != '') {
					$params['request_file']  = $this->do_upload('inputFile', $ret);
				}
				if ($_FILES['inputProposal']['name'] != '') {
					$params['proposal_file'] = $this->do_upload('inputProposal', $ret);
				}

				$ret = $this->Reservasi_model->add($params);

				$this->load->library('sendMail');

				$catalog = $data['catalog'];

				$data['nama']             = $this->session->userdata('user_full_name_customer');
				$data['email']            = $this->session->userdata('user_email_customer');
				$data['nama_ruangan']     = $catalog['catalog_name'];
				$data['date_start']       = $params['date_start'];
				$data['date_end']         = $params['date_end'];
				$data['type']             = $params['jenis'];
				$data['estimasi_peserta'] = $params['attendance'];

				$tanggal = 'Tanggal ' . pretty_date($params['date_start'], ' d F Y', false) . ' s.d ' . pretty_date($params['date_start'], ' d F Y', false);
				$this->sendmail->send($data['email'], 'Reservasi Ruangan Museum ' . $tanggal, $data, 'email/new_reservasi_to_customer');

				$admin    = $this->User_model->get();
				$adminArr = array();
				foreach ($admin as $key) {
					$adminArr[] = $key['user_email'];
				}

				if (count($adminArr) > 0) {
					$this->sendmail->send($adminArr, 'Reservasi Ruangan Museum ' . $tanggal, $data, 'email/new_reservasi_to_admin');
				}

				$this->session->set_flashdata('success', 'Berhasil submit permohonan pinjam ruangan');
				redirect('user/reservasi/view/' . $ret);
			}
		}

		$setting                  = $this->setting->general();
		$data['app_name']         = $setting['app_name']['setting_value'];
		$data['shareToFacebook']  = $setting['socmed_fb']['setting_value'];
		$data['shareToTwitter']   = $setting['socmed_twitter']['setting_value'];
		$data['shareToInstagram'] = $setting['socmed_instagram']['setting_value'];

		$imageSetting        = $this->setting->image();
		$data['img_favicon'] = $imageSetting['img_favicon']['setting_value'];
		$data['img_logo']    = $imageSetting['img_logo']['setting_value'];
		$data['fb_id']       = $setting['fb_id']['setting_value'];

		$data['popular_post']  = $this->Posting_model->get_random_post(array('limit' => 2, 'status_publish' => 1));
		$data['catalog_other'] = $this->Catalog_model->get_random_catalog(array('limit' => 4));
		$data['title']         = $data['catalog']['catalog_name'];
		$data['body_color']    = 'background:#f2f2f2;';

		$data['page']  = 'public/reservasi';
		$data['title'] = 'Reservasi Ruangan';
		$this->load->view('layout', $data);
	}

	public function do_upload($field = 'inputFile', $id = null)
	{
		$config['upload_path'] = './uploads/reservasi/' . $id . '/';
		if (!is_dir($config['upload_path'])) {
			mkdir($config['upload_path'], 0755, true);
		}
		$config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG|pdf|PDF|doc|DOC|docx|DOCX';

		$this->load->library('upload', $config);
		$this->upload->do_upload($field);

		$data = $this->upload->data();

		return $data['file_name'];
	}

	public function check_request_file()
	{
		$allowed = $this->check_image_extension('inputFile');
		if (!$allowed) {
			$this->form_validation->set_message('check_request_file', 'The file extension that you uploaded is not allowed');
			return false;
		}

		return true;
	}

	public function check_proposal_file()
	{
		$allowed = $this->check_image_extension('inputProposal');
		if (!$allowed) {
			$this->form_validation->set_message('check_proposal_file', 'The file extension that you uploaded is not allowed');
			return false;
		}

		return true;
	}

	public function check_image_extension($field)
	{
		$allowed = true;

		$allowedExts  = array("jpeg", "jpg", "png", "JPG", "JPEG", "PNG", "pdf", "PDF", "doc", "DOC", "docx", "DOCX");
		$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG);
		$extension    = pathinfo($_FILES[$field]["name"], PATHINFO_EXTENSION);
		$detectedType = exif_imagetype($_FILES[$field]['tmp_name']);
		$type         = $_FILES[$field]['type'];

		if (!in_array($extension, $allowedExts)) {
			$allowed = false;
		}

		return $allowed;
	}

}

/* End of file Reservasi.php */
/* Location: .//var/www/html/projects/reservasiruangan/apps/modules/reservasi/controllers/Reservasi.php */
