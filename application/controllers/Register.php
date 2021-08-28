<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

  function __construct(){
		parent::__construct();
    $this->load->model('register_model');
		
	}

	public function index(){
      $data = [
          'title' => 'crud bolado'

      ];
		$this->load->view('register', $data);
      
    if(!empty($_POST) ){
      $form_data =   $_POST;

      if($form_data['password'] != $form_data['check_password'] ){
          echo 'as senhas devem ser iguais ';
      
          return;
        }
        $this->register_model->register($form_data);
        
    }
  }
}
