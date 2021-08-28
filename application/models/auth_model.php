<?php if(!defined('BASEPATH')) exit('Hacking Attempt: Out now...!');


class auth_model extends CI_Model{
  function __construct(){
    parent::__construct();
  }

function auth($formdata){
  if(empty($formdata['email'] || $formdata['password'])){
     echo  'preencha todoss os campos';
    return;
    }
    $formdata['password'] = md5($formdata['password']);
    $this->db->where('email',$formdata['email']);
    $this->db->where('password',$formdata['password']);
    $response = $this->db->get('users')->result_array();
    unset($response[0]['PASSWORD']);
    
    return  $response;
  
  }

}