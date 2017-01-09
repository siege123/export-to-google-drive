<?php
    include_once '/home/codeninja/Desktop/cj.com/vendor/autoload.php';

    //create client for authentication
    //first make sure to create a web application credentials on your google account
    //to enable the API's you'll be using
    //download the client_secret.json file and place it on your project
        
    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/users/saveTo';
    $client = new Google_Client();
    $client->setAuthConfig('/home/codeninja/Desktop/cj.com/client_secret.json');
    $client->setRedirectUri($redirect_uri);
    $client->addScope("https://www.googleapis.com/auth/drive");
    $service = new Google_Service_Drive($client);
    $client->setIncludeGrantedScopes(true);
    
    //if the authentication is a success
    if (isset($_REQUEST['code'])) {
      $token = $client->fetchAccessTokenWithAuthCode($_REQUEST['code']); //create access token from the auth code
      $client->setAccessToken($token);
      // store in the session also
      $_SESSION['upload_token'] = $token;
      // redirect back to the example
      header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    }
    
    // set the access token as part of the client
    if (!empty($_SESSION['upload_token'])) {                //if the access token has been saved / not yet expired
      $client->setAccessToken($_SESSION['upload_token']);   
      if ($client->isAccessTokenExpired()) {
        unset($_SESSION['upload_token']);
      }
    }else{
        $authUrl = $client->createAuthUrl();
    }

    //if the user will upload a file and the access token has been registered correctly
    //the access token will be used to call the sevice API's you'll be using
    //this uses a local data to upload to google drive
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $client->getAccessToken()) {
        $file = new Google_Service_Drive_DriveFile();
        $file->setName('test');
        $file->setMimeType('application/vnd.ms-excel');
        $file->setDescription('test document');
        
        
      try {
        $data = file_get_contents('/home/codeninja/Desktop/cj.com/accountInfo.xls');

        $createdFile = $service->files->create($file, array(
          'data' => $data,
          'mimeType' => 'application/vnd.ms-excel',
        ));
        
    } catch (Exception $e) {
        print "An error occurred: " . $e->getMessage();
      } 
    }
?>
<html>
    <head>
        <style>
            body {
                background: #2c3338;
                color: #606468;
                font: 87.5%/1.5em 'Open Sans', sans-serif;
                margin: 0;
            }
            .box {
                margin: 50px auto;
                width: 320px;
            }
        </style>
    </head>
    <body>
        
    <div class="box">
    <?php
        echo '<button>';
        echo anchor('http://www.cj.com/users/generateExcel/dl', 'Download Excel');
        echo '</button>';
        
        echo '</br>'; echo '</br>';
        
        echo '<button>';
        echo anchor('http://www.cj.com/users/generateExcel/read', 'Read Excel');
        echo '</button>';
        
        echo '</br>';echo '</br>';
        
        if (isset($authUrl)): 
            echo '<button>';
            echo anchor($authUrl,'Create Permission');
            echo '</button>';
            
            echo '</br>';echo '</br>';
            
        elseif ($_SERVER['REQUEST_METHOD'] == 'POST'):
            
            echo 'Uploaded File Successfully'; echo '</br>';
            
        else: ?>

        <form method="POST">
            <input type="submit" value="Save to Google Drive" />
        </form>
    <?php endif;
        echo '<button>';
        echo anchor('http://www.cj.com/users', 'Back');
        echo '</button>';
        echo 'wtf';
        ?>
        
    </div>
    </body>
</html>
