<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shopping_cart extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('catalog/Catalog_model');
		$this->load->model('brand/Brand_model');
		$this->load->model('posting/Posting_model');
		$this->load->library('Zebra_Mptt');
		$this->mptt = new Zebra_Mptt();
	}

	public function index()
	{
		if ($this->input->post()) {
			$this->update_cart();
		}
		if ($this->input->get('id', TRUE) != '' AND $this->input->get('count', TRUE) == 0) {
			$this->delete_item($this->input->get('id', TRUE));
			redirect('shopping_cart');
		}

		$data['popular_post'] = $this->Posting_model->get_random_post(array('limit' => 2, 'status' => 1));
		$data['catalogCategory'] = $this->Catalog_model->get_category(array('limit' => 5));
		$data['catalogBrand'] = $this->Brand_model->get(array('limit' => 5));
		$data['title'] = 'Shopping Cart';
		$data['page'] = 'shopping_cart';
		$data['widget'] = 'widget/category-brand';
		$this->load->view('layout', $data);
	}

	function update_cart($id = null)
	{

		unset($_POST['update_cart']);
		$content = $this->input->post();
		
		foreach ($content as $key) {
			
			$info = array(
				'rowid' => $key['rowid'],
				'qty'   => $key['qty']
				);

			$this->cart->update($info);
		}
	}

	function delete_item($id = null)
	{

		$info = array(
			'rowid' => $id,
			'qty'   => 0
			);

		$this->cart->update($info);
		
	}

}

/* End of file Shopping_cart.php */
/* Location: .//Applications/MAMP/htdocs/jatayu/storeapp/modules/shopping_cart/controllers/Shopping_cart.php */