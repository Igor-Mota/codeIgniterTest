<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Crud Boladao</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

  <link href='<?php echo base_url()."styles/global.css" ?>' rel='stylesheet'>
  <link href='<?php echo base_url()."styles/shared.css" ?>' rel='stylesheet'>
</head>

<body>
  <div class='container  h-100vh'>
    <div class='column'>
     <?php  echo validation_errors();?>
      <?php
         if(isset($_SESSION) && isset($_SESSION['msg']) && $_SESSION['msg'] == 'already exists'){ 
         
              echo '<p class="alert alert-warning w-50" style="text-align:center" id="exist"> Este usuario ja existe</p>';
     
             $this->session->set_flashdata('msg', ''); 
          } ?>
      <div class='border rounded  w-50  h-75 center'>

        <?php echo form_open(base_url().'register/post', 'class="genral-form w-75 "') ?>
      <!-- <form action="register" method='post' class='genral-form w-75 '> -->
          <label for="email">E-mail</label>
         <!--  -->
          <input class='form-control m-3' type="email" name='email' value='igor@gmail'>
      
          <label for="">Senha</label>
          <input class='form-control m-3' type="password" name='password' value='123'>
          <label for="">Confirmar senha</label>
          <input class='form-control m-3' type="password" name='check_password' value='123'>
          <button type='submit' class='btn btn-primary w-100 m-2 p-2'>Cadastrar</button>
          <a href="/" class='btn btn-secondary w-100 p-2'>Fazer login</a>
       <!--  </form> -->
        <?php echo form_close() ?>
      </div>
    </div>
  </div>
  <script>
  </script>
</body>
        
<script>
  setTimeout(() =>{
    if(document.querySelector('#exist')){
      document.querySelector('#exist').style.display = 'none'
    }
  },2000)
</script>
</html>