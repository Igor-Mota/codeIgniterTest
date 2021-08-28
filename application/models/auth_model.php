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
    $sql = "SELECT * FROM users WHERE email = ?";
    $response = $this->db->query($sql, $formdata['email'])->result_array();
    dump($response);
    return  $response;
  
  }

}