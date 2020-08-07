<?php 
include('../includes/loader_ajax.php');
if((!empty($_FILES["pro-pic"])) && ($_FILES['pro-pic']['error'] == 0)) {
  //Check if the file is JPEG image and it's size is less than 350Kb
$fileType = $_FILES['pro-pic']['type'];
$filesize = $_FILES['pro-pic']['size'];
$fileError = $_FILES['pro-pic']['error'];
  $filename = basename($_FILES['pro-pic']['name']);
  $ext = substr($filename, strrpos($filename, '.') + 1);
  if (($ext == "jpg" || $ext == "png" || $ext == "jpeg") && ($_FILES["pro-pic"]["type"] == "image/jpeg" || $_FILES["pro-pic"]["type"] == "image/png" || $_FILES["pro-pic"]["type"] == "image/jpeg") && ($_FILES["pro-pic"]["size"] < 350000)) {
    //Determine the path to which we want to save this file
$extb = strtolower(pathinfo($_FILES['pro-pic']['name'], PATHINFO_EXTENSION));
$newFileName = microtime(true).'.'.$extb;
      $tmpImageFolder = dirname(__DIR__).'/uploads/profile-pics/'.$newFileName;
      //Check if the file with the same name is already exists on the server
      if (!file_exists($tmpImageFolder)) {
        //Attempt to move the uploaded file to it's new place

        if ((move_uploaded_file($_FILES['pro-pic']['tmp_name'],$tmpImageFolder))) {

$id = (int)NULL;
$fkUserId = $_POST['editClient'];

$type = $fileType;
$size = $filesize;
$createdDate = strftime("%Y-%m-%d %H:%M:%S", time());
$image =  json_encode($newFileName);
$filename = str_replace('"', "", $image);

$picture = new profilePicture();
$profilePicAlreadyExists=$picture->findByfkUserId($fkUserId);
		foreach($profilePicAlreadyExists as $record)
		{
			
		$profilePicAlreadyExistsId	= $record->id;
		}
if(isset($profilePicAlreadyExistsId)){
$sql = "UPDATE profile_pics SET filename='$filename', size='$size', type='$type' WHERE id='$profilePicAlreadyExistsId'";
		} else{
$sql = "INSERT INTO profile_pics (id, fkUserId,filename, type, size,createdDate) VALUES('$id', '$fkUserId', '$filename', '$type', '$size', '$createdDate')";
}
if ($connect->query($sql) === true) {
	echo 'ok';
} else{
	echo $connect->error;
}
        } else {
           echo "Error: A problem occurred during file upload!";
        }
      } else {
         echo "Error: File ".$_FILES["pro-pic"]["name"]." already exists";
      }
  } else {
     echo "Error: Only .jpg, .png images are accepted for upload";
  }
} else {
 echo "Error: No file uploaded";
}