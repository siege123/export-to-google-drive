<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?><!DOCTYPE html>
<html lang="en">
<head>
    <title>Accounts</title>

    <link rel="stylesheet" href="/css/style.css"/>

</head>
<body>
    
    <div id="login">
    <table cellpadding="10" border="1" style="color:wheat; background-color: gray;" > 
        
        <tr>
            <td>
                Name:
            </td>
            <td>
                Address:
            </td>
            <td colspan="2" style="text-align: center">Action</td>
        </tr>
        
        <?php
        foreach ($accounts as $account) {
        ?>
        <tr>
            <td><?=$account['name'];?></td>
            <td><?=$account['address'];?></td>
            <td><a href="/users/delete/<?=$account['id'];?>">Delete</a></td>
            <td>
                <a href="/users/info/<?=$account['id'];?>/<?=$account['name']?>/<?=$account['address'];?>">Edit</a>
            </td>
        </tr>
        <?php
        }
        ?>
        
    </table>
        <br/><a href="/users/create" ><button>Create Account</button></a><br/>
        <br/><a href="/users/saveTo"><button>Download Excel</button></a><br/>        
        <br/><a href="/login/"><button>Log out</button></a>
        
    
</body>
</html>

