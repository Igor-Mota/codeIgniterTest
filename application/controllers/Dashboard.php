<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
  }
  public function index()
  {
    $this->load->view('navBar');
    $this->load->view('dashboard');
  }

  public function quit()
  {
    $this->session->sess_destroy();
    redirect(base_url());
  }
}
