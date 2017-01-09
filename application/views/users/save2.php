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
            
            if(isset($accessToken)){
                echo 'Your Files are now uploading...';
                sleep(5);
                redirect('upload_to_drive/uploadFile/' . $data);
            }else{
                
                $data = array(
                    'name'          =>  'nameOfFile',
                    'maxlegth'      =>  '10',
                    'placeholder'   =>  'Insert Filename Here',
                    'style'         =>  'color: black'
                 );
                
                echo "</br>"; echo "</br>";
                echo form_open('upload_to_drive/auth');
                echo form_label('Filename: ', 'name');
                echo form_input($data);
                echo "</br>"; echo "</br>";
                echo form_submit('upload', 'Upload to Google Drive');
                echo form_close();
            }
        ?>
    </div>
    </body>
</html>
