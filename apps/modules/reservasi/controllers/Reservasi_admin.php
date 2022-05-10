<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reservasi_admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_admin')) {
            redirect('admin/auth/login');
        }

        $this->load->model(array('Reservasi_model', 'catalog/Catalog_model', 'posting/Posting_model', 'user/User_model'));
    }

    public function index()
    {
        $this->load->library('pagination');

        $config['base_url']             = current_url();
        $config['total_rows']           = count($this->Reservasi_model->get());
        $config['per_page']             = 10;
        $config['page_query_string']    = true;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);

        $params['limit']   = 10;
        $params['offset']  = $this->input->get('page');
        $data['reservasi'] = $this->Reservasi_model->get($params);

        $data['page']  = 'reservasi';
        $data['title'] = 'Reservasi Ruangan';
        $this->load->view('admin/layout/main', $data);
    }

    public function view($id = null)
    {
        if (is_null($id)) {
            $this->session->set_flashdata('failed', 'Data tidak ditemukan');
            redirect('admin/reservasi');
        }

        $reservasi = $this->Reservasi_model->get(array('id' => $id));
        if (count($reservasi) == 0) {
            $this->session->set_flashdata('failed', 'Data tidak ditemukan');
            redirect('admin/reservasi');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        if ($this->input->post('inputDisposisi')) {
            $this->form_validation->set_rules('inputStatus', 'Status', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputMessage', 'Status', 'trim|required|xss_clean');
            if ($this->form_validation->run()) {
                $status = $this->input->post('inputStatus');
                if ($status == STATUS_PROCESS) {
                    $params['message']      = nl2br($this->input->post('inputMessage'));
                    $params['reservasi_id'] = $id;
                    $params['user_id']      = $this->session->userdata('user_id_admin');
                    $params['status_id']    = $status;
                    $params['date']         = date('Y-m-d H:i:s');

                    $ret = $this->Reservasi_model->add_log($params);

                    $params['id']          = $id;
                    $params['status_id']   = STATUS_PROCESS;
                    $params['position_id'] = POSITION_KAMUS;
                    $params['updated_at']  = date('Y-m-d H:i:s');

                    $ret = $this->Reservasi_model->add($params);

                    $this->session->set_flashdata('success', 'Berhasil memproses reservasi');
                    redirect(current_url());
                } else {
                    $params['message']      = nl2br($this->input->post('inputMessage'));
                    $params['reservasi_id'] = $id;
                    $params['user_id']      = $this->session->userdata('user_id_admin');
                    $params['status_id']    = $status;
                    $params['date']         = date('Y-m-d H:i:s');

                    $ret = $this->Reservasi_model->add_log($params);

                    $params['id']          = $id;
                    $params['status_id']   = STATUS_REJECTED;
                    $params['position_id'] = POSITION_KASUBAG_FIRST;
                    $params['updated_at']  = date('Y-m-d H:i:s');

                    $ret = $this->Reservasi_model->add($params);

                    $this->session->set_flashdata('success', 'Berhasil memproses reservasi');
                    redirect(current_url());
                }
            }
        } elseif ($this->input->post('inputDisposisiFromKamus')) {
            $this->form_validation->set_rules('inputStatus', 'Status', 'trim|required|xss_clean');
            $this->form_validation->set_rules('inputMessage', 'Status', 'trim|required|xss_clean');
            if ($this->form_validation->run()) {
                $status = $this->input->post('inputStatus');
                if ($status == STATUS_PROCESS) {
                    $params['message']      = nl2br($this->input->post('inputMessage'));
                    $params['reservasi_id'] = $id;
                    $params['user_id']      = $this->session->userdata('user_id_admin');
                    $params['status_id']    = $status;
                    $params['date']         = date('Y-m-d H:i:s');

                    $ret = $this->Reservasi_model->add_log($params);

                    $params['id']          = $id;
                    $params['status_id']   = STATUS_PROCESS;
                    $params['position_id'] = POSITION_KASUBAG_SECOND;
                    $params['updated_at']  = date('Y-m-d H:i:s');

                    $ret = $this->Reservasi_model->add($params);

                    $email['nama'] = $reservasi['customer_full_name'];
                    $email['nama_ruangan'] = $reservasi['catalog_name'];
                    $email['date_start'] = $reservasi['reservasi_date_start'];
                    $email['date_end'] = $reservasi['reservasi_date_end'];
                    $email['type'] = $reservasi['reservasi_type'];
                    $email['estimasi_peserta'] = $reservasi['reservasi_attendance'];

                    $kasubag_resource = $this->User_model->get(array('role_id' => USER_KASUBAG));
                    $kasubag = array();
                    foreach ($kasubag_resource as $key) {
                        $kasubag[] = $key['user_email'];
                    }

                    $this->load->library('sendMail');
                    $this->sendmail->send($kasubag, 'Reservasi Ruangan Museum ' . $email['nama_ruangan'], $email, 'email/disposisi_to_kasubag');

                    $this->session->set_flashdata('success', 'Berhasil memproses reservasi');
                    redirect(current_url());
                } else {
                    $params['message']      = nl2br($this->input->post('inputMessage'));
                    $params['reservasi_id'] = $id;
                    $params['user_id']      = $this->session->userdata('user_id_admin');
                    $params['status_id']    = STATUS_REJECTED;
                    $params['date']         = date('Y-m-d H:i:s');

                    $ret = $this->Reservasi_model->add_log($params);

                    $params['id']          = $id;
                    $params['status_id']   = STATUS_REJECTED;
                    $params['position_id'] = POSITION_KASUBAG_SECOND;
                    $params['updated_at']  = date('Y-m-d H:i:s');

                    $ret = $this->Reservasi_model->add($params);

                    $email['nama'] = $reservasi['customer_full_name'];
                    $email['nama_ruangan'] = $reservasi['catalog_name'];
                    $email['date_start'] = $reservasi['reservasi_date_start'];
                    $email['date_end'] = $reservasi['reservasi_date_end'];
                    $email['type'] = $reservasi['reservasi_type'];
                    $email['estimasi_peserta'] = $reservasi['reservasi_attendance'];

                    $kasubag_resource = $this->User_model->get(array('role_id' => USER_KASUBAG));
                    $kasubag = array();
                    foreach ($kasubag_resource as $key) {
                        $kasubag[] = $key['user_email'];
                    }

                    $this->load->library('sendMail');
                    $this->sendmail->send($kasubag, 'Reservasi Ruangan Museum ' . $email['nama_ruangan'], $email, 'email/disposisi_to_kasubag');

                    $this->session->set_flashdata('success', 'Berhasil memproses reservasi');
                    redirect(current_url());
                }
            }
        } elseif ($this->input->post('inputKabag2')) {
            $this->form_validation->set_rules('inputMessage', 'Status', 'trim|required|xss_clean');
            if ($this->form_validation->run()) {
                $params['message']      = nl2br($this->input->post('inputMessage'));
                $params['reservasi_id'] = $id;
                $params['user_id']      = $this->session->userdata('user_id_admin');
                $params['status_id']    = STATUS_APPROVED;
                $params['date']         = date('Y-m-d H:i:s');

                $ret = $this->Reservasi_model->add_log($params);

                $params['id']            = $id;
                $params['status_id']     = STATUS_APPROVED;
                $params['end_message']   = $params['message'];
                $params['is_complete']   = true;
                $params['response_file'] = $this->do_upload('inputScan', $id);
                $params['updated_at']    = date('Y-m-d H:i:s');

                $ret = $this->Reservasi_model->add($params);

                $this->load->library('sendMail');
                $data['nama']             = $reservasi['customer_full_name'];
                $data['email']            = $reservasi['customer_email'];
                $data['nama_ruangan']     = $reservasi['catalog_name'];
                $data['date_start']       = $reservasi['reservasi_date_start'];
                $data['date_end']         = $reservasi['reservasi_date_end'];
                $data['type']             = $reservasi['reservasi_type'];
                $data['estimasi_peserta'] = $reservasi['reservasi_attendance'];
                $data['alasan']           = $params['end_message'];
                $this->sendmail->send($data['email'], 'Reservasi Ruangan Museum ' . $data['nama_ruangan'], $data, 'email/approved_to_customer');

                $this->session->set_flashdata('success', 'Berhasil memproses reservasi');
                redirect(current_url());
            }
        } elseif ($this->input->post('inputKabagLastStep')) {
            $this->form_validation->set_rules('inputMessage', 'Status', 'trim|required|xss_clean');
            if ($this->form_validation->run()) {
                $params['message']      = nl2br($this->input->post('inputMessage'));
                $params['reservasi_id'] = $id;
                $params['user_id']      = $this->session->userdata('user_id_admin');
                $params['status_id']    = STATUS_REJECTED;
                $params['date']         = date('Y-m-d H:i:s');

                $ret = $this->Reservasi_model->add_log($params);

                $params['id']            = $id;
                $params['status_id']     = STATUS_REJECTED;
                $params['end_message']   = $params['message'];
                $params['is_complete']   = true;
                $params['response_file'] = $this->do_upload('inputScan', $id);
                $params['updated_at']    = date('Y-m-d H:i:s');

                $ret = $this->Reservasi_model->add($params);

                $this->load->library('sendMail');
                $data['nama']             = $reservasi['customer_full_name'];
                $data['email']            = $reservasi['customer_email'];
                $data['nama_ruangan']     = $reservasi['catalog_name'];
                $data['date_start']       = $reservasi['reservasi_date_start'];
                $data['date_end']         = $reservasi['reservasi_date_end'];
                $data['type']             = $reservasi['reservasi_type'];
                $data['estimasi_peserta'] = $reservasi['reservasi_attendance'];
                $data['alasan']           = $params['end_message'];
                $this->sendmail->send($data['email'], 'Reservasi Ruangan Museum ' . $data['nama_ruangan'], $data, 'email/rejected_to_customer');

                $this->session->set_flashdata('success', 'Berhasil memproses reservasi');
                redirect(current_url());
            }
        }

        $data['show_action_kabag_step_1'] = false;

        $data['show_action_kamus'] = false;
        if (
            $reservasi['reservasi_status_status_id'] == STATUS_NEW &&
            ($this->session->userdata('user_role_admin') == USER_KAMUS || $this->session->userdata('user_role_admin') == USER_ADMIN) &&
            $reservasi['reservasi_position_position_id'] == POSITION_KAMUS) {
            $data['show_action_kamus'] = true;
        }

        $data['show_action_kabag_step_2'] = false;
        if (
            $reservasi['reservasi_status_status_id'] == STATUS_PROCESS &&
            ($this->session->userdata('user_role_admin') == USER_KASUBAG || $this->session->userdata('user_role_admin') == USER_ADMIN) &&
            $reservasi['reservasi_position_position_id'] == POSITION_KASUBAG_SECOND) {
            $data['show_action_kabag_step_2'] = true;
        }

        $data['show_action_kabag_last_step'] = false;
        if (
            $reservasi['reservasi_status_status_id'] == STATUS_REJECTED &&
            ($this->session->userdata('user_role_admin') == USER_KASUBAG || $this->session->userdata('user_role_admin') == USER_ADMIN) &&
            !$reservasi['reservasi_is_complete']) {
            $data['show_action_kabag_last_step'] = true;
        }

        $data['logs']      = $this->Reservasi_model->get_log(array('reservasi_id' => $id));
        $data['reservasi'] = $reservasi;
        $data['page']      = 'view_reservasi';
        $data['title']     = 'Reservasi Ruangan';
        $this->load->view('admin/layout/main', $data);
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

    public function add($id = null)
    {
        if (!is_null($id)) {
            $reservasi = $this->Reservasi_model->get(array('id' => $id));
            if (count($reservasi) == 0) {
                $this->session->set_flashdata('failed', 'Data tidak ditemukan');
                redirect('admin/reservasi');
            }
            $data['reservasi'] = $reservasi;
        }

        if ($this->input->post()) {

            $this->load->library('form_validation');
            if (is_null($id)) {
                $this->form_validation->set_rules('inputCustomer', 'Customer', 'required|trim|xss_clean');
            }
            $this->form_validation->set_rules('inputCatalog', 'Ruangan', 'required|trim|xss_clean');
            $this->form_validation->set_rules('inputJenis', 'Jenis Acara', 'required|trim|xss_clean');
            $this->form_validation->set_rules('inputDateStart', 'Tanggal Mulai', 'required|trim|xss_clean');
            $this->form_validation->set_rules('inputDateEnd', 'Tanggal Selesai', 'required|trim|xss_clean');
            $this->form_validation->set_rules('inputAttendance', 'Perkiraan Peserta', 'required|trim|xss_clean');
            $this->form_validation->set_rules('inputOtherRequest', 'Kebutuhan Lainnya', 'trim|xss_clean');
            if (isset($_FILES['inputFile']) && $_FILES['inputFile']['name'] == '') {
                if (is_null($id)) {
                    $this->form_validation->set_rules('inputFile', 'Scan Surat Permoohonan', 'trim|required|xss_clean');
                }
            }else{
                $this->form_validation->set_rules('inputFile', 'Scan Surat Permohonan', 'trim|xss_clean|callback_check_request_file');
            }
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            if ($this->form_validation->run()) {
                $params['id']            = is_null($id) ? null : $id;
                $params['jenis']         = $this->input->post('inputJenis', true);
                $params['date_start']    = $this->input->post('inputDateStart', true);
                $params['date_end']      = $this->input->post('inputDateEnd', true);
                $params['attendance']    = $this->input->post('inputAttendance', true);
                $params['other_request'] = $this->input->post('inputOtherRequest', true);
                $params['customer_id']   = $this->input->post('inputCustomer');
                $params['catalog_id']    = $this->input->post('inputCatalog');
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
                $ret                     = $this->Reservasi_model->add($params);

                $this->session->set_flashdata('success', 'Berhasil submit permohonan pinjam ruangan');
                redirect('admin/reservasi/view/' . $ret);
            }
        }
        $data['catalog'] = $this->Catalog_model->get();

        $data['operation'] = is_null($id) ? 'Tambah' : 'Edit';
        $data['page']      = 'add_reservasi';
        $data['title']     = $data['operation'] . ' Reservasi Ruangan';
        $this->load->view('admin/layout/main', $data);
    }

    public function delete($id = null)
    {
        if (is_null($id)) {
            $this->session->set_flashdata('failed', 'Data tidak ditemukan');
            redirect('admin/reservasi');
        }

        if ($this->input->post('inputDelete')) {

            $reservasi = $this->Reservasi_model->get(array('id' => $id));
            if (count($reservasi) == 0) {
                $this->session->set_flashdata('failed', 'Data tidak ditemukan');
                redirect('admin/reservasi');
            }

            $params['id'] = $id;
            $params['is_deleted'] = true;
            $this->Reservasi_model->add($params);

            $this->session->set_flashdata('success', 'Berhasil menghapus data');
            redirect('admin/reservasi');
        }
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

        $allowedExts  = array("jpeg", "jpg", "png", "JPG", "JPEG", "PNG", "pdf", "PDF");
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
