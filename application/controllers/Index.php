<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {
	function __construct(){
		parent::__construct();
			$this->load->model('auth_model');
		 	$this->load->library('form_validation');
	}
	public function index(){
		$this->load->view('index');
	}
	public function auth(){
		$this->load->helper('url');   
		
		if(!empty($_POST) ){
      $form_data = $_POST;
			$response = $this->auth_model->auth($form_data);

			if($response){

		 		$this->session->set_userdata('logged_user', $response);
				redirect(base_url().'dashboard');			
			}else{
				redirect(base_url());
			}
		}	
	}
}
