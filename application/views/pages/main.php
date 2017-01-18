<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
  
      <link rel="stylesheet" href="/css/style.css"/>
  
</head>

<body>
    <head>
        <title>Login</title>

        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,700">

    </head>
    
    <div id="login">
        <form name='form-login' action=<?php dirname(__DIR__)?>"/login/validate" method="POST">
        <span class="fontawesome-user"></span>
          <input type="text" name="name" placeholder="Username">
       
        <span class="fontawesome-lock"></span>
          <input type="password" name="pass" placeholder="Password">
        
          
        <input type="submit" value="Login">

</form>
  
  
</body>
</html>
