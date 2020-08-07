<?php
$uploads_dir = dirname(__DIR__) . '/user-uploads/';
 $filename = $_POST['tm'] . $_FILES[ 'file' ][ 'name' ];
            $file_name = $_POST['tm'] . $_FILES['file']['name'];
            $file_tmp = $_FILES['file']['tmp_name'];
if ( move_uploaded_file($file_tmp, $uploads_dir . $file_name))
{
    echo $file_name;
}
else
{
    echo 'Error in uploading file ' . $uploads_dir;
} 