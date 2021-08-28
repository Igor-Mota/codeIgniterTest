<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('auth_model');
		$this->load->helper('form');   
		 $this->load->library('form_validation');

	}
	public function index(){
		$data =  array(
			'title' => 'Crud bolado',
			'name' => 'user_name'
		);

		$user_profile_account =[
			'data' => 'name'
		];

		$this->load->view('index', $data);

		if(!empty($_POST) ){
      $form_data =   $_POST;

			$response = $this->auth_model->auth($form_data);
			dump($response);
			
		}
	}
}
