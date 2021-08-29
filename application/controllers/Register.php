<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

  function __construct(){
		parent::__construct();
    $this->load->model('register_model');	
	}

	public function index(){
    $data = [
        'let' => 't'
    ];
		$this->load->view('register', $data);
    $this->load->helper('url');   
      
    if(!empty($_POST) ){
      $form_data =   $_POST;

      if($form_data['password'] != $form_data['check_password'] ){
          echo 'as senhas devem ser iguais ';
          return;
        }
       $response = $this->register_model->register($form_data);
        if(!isset($response['message'])){
          $this->session->set_userdata('logged_user', $response);
          redirect(base_url().'dashboard');
        }else{
            $data = [
                'message' => 'quale'
            ];
          dump($response);
        }
    }
  }
}
