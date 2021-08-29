<?php if(!defined('BASEPATH')) exit('Hacking Attempt: Out now...!');

class register_model extends CI_Model{
  function __construct(){
    parent::__construct();
  }
  function register($formdata){
    unset($formdata['check_password']);
    $formdata['password'] = md5($formdata['password']);

      $email = $formdata['email'];
      $sql =  "SELECT * FROM users WHERE email = ?";
      $response  = $this->db->query($sql, $email);

      if($response->num_rows() == 0){
          $this->db->insert('users', $formdata);
          $this->db->where('email',$formdata['email']);
          $response = $this->db->get('users')->result_array();
          unset($response[0]['PASSWORD']);
          return $response;
      }else{
        return $response = ['message' => 'user already exist'];
      }
  }
}