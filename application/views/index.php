<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Crud Boladao</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
  <link href='./styles/global.css' rel='stylesheet'>
  <link href='./styles/shared.css' rel='stylesheet'>
</head>
<body>
    <div class='container center h-100vh'>
        <div class='border rounded  w-50 center h-75'>

            <form action="index/auth" method='post' class='genral-form w-75 '>
          
              <label for="">E-mail</label>
                <input  class='form-control m-3' type="email" name='email' value='igorr@gmail'>
              
                <label for="">Senha</label>
                <input class='form-control m-3' type="password" name='password' value='123'>
   
                  <button type='submit' class='btn btn-primary w-100 m-2 p-2'>Entrar</button>
                
                  <a href="<?php ?>register"  class='btn btn-secondary w-100 p-2'>Criar conta</a>
              </form>
        </div>
    </div>
</body>
</html>