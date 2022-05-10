<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SendMail
{
    protected $ci;

    public function send($receiver, $subject, $data, $view) {
        $this->ci =& get_instance();
        $this->ci->load->library('email');
        $this->ci->email->set_newline("\r\n");

        $this->ci->email->from($this->ci->config->item('from'), "Reservasi Ruangan");
        $this->ci->email->to($receiver);
        $this->ci->email->subject($subject);

        $message = $this->ci->load->view($view, $data, TRUE);
        $this->ci->email->message($message);

        if ($this->ci->email->send()) {
            return true;
        } else {
            show_error($this->ci->email->print_debugger());
        }
    }
}