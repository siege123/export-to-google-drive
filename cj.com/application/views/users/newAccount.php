<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <h1>Create New Account</h1>
    <link rel="stylesheet" href="/css/style.css"/>
</head>
    <body>
        <div id="login">
            <form action="save/" method="POST" style="color: wheat">
                Name: &nbsp;&nbsp;&nbsp;<input type="text" name="name" style="padding-right: 10px"> <br><br>
                Address: <input type="text" name="address" style="padding-right: 6px"> <br><br>
            <input type="submit" value="Submit">
            
        </form>
    </body>
</html>