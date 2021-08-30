<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('register_model');
    $this->load->helper(array('security', 'url', 'form'));
    $this->load->library('form_validation');
  }

  public function index()
  {
    if (isset($_SESSION['logged_user'])) {
      redirect(base_url() . 'dashboard');
    }

      $this->load->view('register');
  }

  public function post(){
    $config =  array(
      array(
        'field' => 'email',
        'label' => 'E-mail',
        'rules' => 'required|valid_email'
      ),
      array(
        'field' => 'password',
        'label' => 'Senha',
        'rules' => 'required'
      )
    );

    if (!empty($_POST['email']) && !empty($_POST['password'])){

      $form_data = $_POST;

      $this->form_validation->set_rules($config);
      $this->form_validation->set_error_delimiters('<p class="alert alert-warning w-50" style="text-align:center">' , '</p>');
      
      if ($this->form_validation->run() == false) {
          $this->load->view('register');
      
      }else{
        $response = $this->register_model->register($form_data);
        if (!isset($response['message'])) {

          $this->session->set_userdata('logged_user', $response);
          redirect(base_url() . 'dashboard');
        
        } else {
          $this->session->set_flashdata('msg', 'already exists');
          $this->load->view('register');
        }
      }      
    }
  }
}
