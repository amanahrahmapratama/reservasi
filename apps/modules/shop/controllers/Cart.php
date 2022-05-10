<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('cart');
        $this->load->library('Zebra_Mptt');
        $this->mptt = new Zebra_Mptt();
    }

	public function add() 
	{
		$data['catalog'] = $this->Catalog_model->get(); 
		$this->cart->insert($data);
		
	}

	public function remove()
	{
		$this->cart->update();
	}

}

/* End of file shop.php */
/* Location: ./application/controllers/shop.php */