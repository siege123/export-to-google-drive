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
      <form name='form-login' action="/login/validate" method="POST">
          <span class="fontawesome-user" style="color:red;"></span>
        <input type="text" name="name" placeholder="Incorrect Username">
       
        <span class="fontawesome-lock" style="color:red;"></span>
          <input type="password" name="pass" placeholder="Incorrect Password">
        
        <input type="submit" value="Login">

</form>
  
  
</body>
</html>
