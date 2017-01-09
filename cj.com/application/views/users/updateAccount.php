<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <h1>Update Account</h1>
    
</head>
    <body>
       
        <form action="/users/update" method="POST">
            <input type="hidden" name="id" value="<?=$id?>">
            
            Name: &nbsp;&nbsp;&nbsp;<input type="text" name="name" value="<?=$name?>"> <br><br>
            
            Address: <input type="text" name="address" value="<?=$address;?>"> <br><br>
            
            <input type="submit" value="Submit">
        
        </form>
    </body>
</html>