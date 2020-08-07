<?php 
if(isset($_POST['submit'])){
	$dbname = $_POST['dbname'];
	$uname = $_POST['uname'];
	$dbhost = $_POST['dbhost'];
	$dbpass = $_POST['dbpass'];
$connect = mysqli_connect($dbhost , $uname, $dbpass , $dbname);

if (!$connect) {
    echo "Error: Unable to connect to MySQL. <br>" . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . '<br>' . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . '<br>' . PHP_EOL;
    exit;
} else {
	$file = fopen('../includes/config.php', 'w+');
	ftruncate($file, 0);
	 $content = '<?php defined("DB_SERVER") ? null : define("DB_SERVER", "'.$dbhost.'");
defined("DB_NAME")   ? null : define("DB_NAME", "'.$dbname.'");
defined("DB_USER")   ? null : define("DB_USER", "'.$uname.'");
defined("DB_PASS")   ? null : define("DB_PASS", "'.$dbpass.'");
$connect = new mysqli(DB_SERVER , DB_USER, DB_PASS, DB_NAME);
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
} 

$sql = "SELECT * FROM settings";
if ($result=mysqli_query($connect,$sql)){
 while($row = mysqli_fetch_array($result)){
  $main_url = ($row["url"]);
    }
  mysqli_free_result($result);
}
// Global Vars
	$base_url = $main_url;
	$base_root = dirname(__DIR__);
	$perpage = 15;
	$contacts_per_page = 100;';
	 fwrite($file , $content); //Now lets write it in there
    fclose($file ); //Finally close our .txt
$errors = [];

$table1 = "CREATE TABLE friends (
 id int(11) NOT NULL AUTO_INCREMENT,
 user_id int(11) NOT NULL,
 friend int(11) NOT NULL,
 PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

$table2 = "CREATE TABLE messages (
 id int(11) NOT NULL AUTO_INCREMENT,
 message text COLLATE utf8_unicode_ci NOT NULL,
 time int(11) NOT NULL,
 user_id int(11) NOT NULL,
 receiver int(11) NOT NULL,
 storage_a int(11) NOT NULL,
 storage_b int(11) NOT NULL,
 Project_id int(255) NOT NULL,
 status varchar(6) COLLATE utf8_unicode_ci NOT NULL,
 PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

$table3 = "CREATE TABLE settings (
 id int(10) NOT NULL AUTO_INCREMENT,
 url varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 company_name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 syatem_title varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 login_page_title varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 copy_rights varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 system_currency varchar(10) COLLATE utf8_unicode_ci NOT NULL,
 time_zone varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 favicon_image varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 login_page_logo varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 logo varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 mobile_logo varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 stripe_sk varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
 stripe_pk varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
 paypal_email varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
 checkout_id varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
 checkout_pk varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
 system_email varchar(150) COLLATE utf8_unicode_ci NOT NULL,
 forget_email text COLLATE utf8_unicode_ci NOT NULL,
 create_account_email text COLLATE utf8_unicode_ci NOT NULL,
 project_assign_email text COLLATE utf8_unicode_ci NOT NULL,
 assign_staff_email text COLLATE utf8_unicode_ci NOT NULL,
 project_update_email text COLLATE utf8_unicode_ci NOT NULL,
 system_language varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 version varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 purchase_code varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

$table4 = "CREATE TABLE users (
 id int(9) NOT NULL AUTO_INCREMENT,
 Projects_ids varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 password varchar(50) COLLATE utf8_unicode_ci NOT NULL,
 email varchar(50) NOT NULL,
 accountStatus tinyint(1) NOT NULL,
 firstName varchar(50) NOT NULL,
 title varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 address varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 phone varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 website varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 skype_id varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 fb varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 regDate datetime NOT NULL,
 type_status varchar(300) COLLATE utf8_unicode_ci NOT NULL,
 last_seen int(255) NOT NULL,
 session_status varchar(7) COLLATE utf8_unicode_ci NOT NULL,
 status int(10) NOT NULL,
 note text COLLATE utf8_unicode_ci NOT NULL,
 city varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 state varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 zip varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 user_language varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 country varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 PRIMARY KEY (id),
 UNIQUE KEY email (email)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

$table5 = "CREATE TABLE profile_pics (
 id int(11) NOT NULL AUTO_INCREMENT,
 fkUserId int(11) NOT NULL,
 filename varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 type varchar(10) COLLATE utf8_unicode_ci NOT NULL,
 size varchar(10) COLLATE utf8_unicode_ci NOT NULL,
 createdDate datetime NOT NULL,
 PRIMARY KEY (id),
 KEY fkUserId (fkUserId),
 CONSTRAINT profile_pics_ibfk_1 FOREIGN KEY (fkUserId) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

$table6 = "CREATE TABLE projects (
 p_id int(11) NOT NULL AUTO_INCREMENT,
 c_id int(11) NOT NULL,
 s_ids varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 project_title varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 project_desc varchar(1200) COLLATE utf8_unicode_ci NOT NULL,
 budget varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 status varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 archive int(10) NOT NULL,
 trash int(10) NOT NULL,
 start_time date NOT NULL,
 end_time date NOT NULL,
 PRIMARY KEY (p_id),
 KEY c_id (c_id),
 CONSTRAINT fkClientId FOREIGN KEY (c_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

$table7 = "CREATE TABLE milestones (
 id int(255) NOT NULL AUTO_INCREMENT,
 p_id int(255) NOT NULL,
 title varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 deadline date NOT NULL,
 releaseDate date DEFAULT NULL,
 budget varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 status tinyint(4) NOT NULL,
 PRIMARY KEY (id),
 KEY p_id (p_id),
 CONSTRAINT fk_p_id FOREIGN KEY (p_id) REFERENCES projects (p_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

$tables = [$table1, $table2, $table3, $table4, $table5, $table6, $table7];


foreach($tables as $k => $sql){
    $query = mysqli_query($connect, $sql);
	//  echo("Error description: " . mysqli_error($connect)) .'<br>';
    if(!$query)
       $errors[] = 1;
    else
       $errors[] = 0;
}

$allvals = 0;
foreach($errors as $msg) {
	$allvals += $msg;
}
	$serverhost =  $_SERVER['HTTP_HOST'];
if(preg_match('/www/', $serverhost))
{
$hostname = str_replace('www.', '', $serverhost);
}
else
{
$hostname = $serverhost;
}
if($allvals == 0){
include('./notification.php');
header('Location: system.php');

} else{
	echo 'Table Already Exist or Unable to create Table!';
	
}
}
} else{
	
include('../includes/config.php');
if (!$connect) { ?>
<!DOCTYPE html>
<html>
<head>
<title>Teameyo Installation</title>
 <link href='https://fonts.googleapis.com/css?family=Raleway:400,600,500,700' rel='stylesheet' type='text/css'>
 <link href="style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="dbinstall">
<h1>Database Connection Settings</h1>
	<form method="post" action="">
	<input required type="text" placeholder="Host Name" name="dbhost" />
	<input required type="text" placeholder="Database User Name" name="uname" />
	<input required type="text" placeholder="Database Name" name="dbname" />
	<input type="text" placeholder="Database Password" name="dbpass" />
	<input type="submit" value="Next" name="submit" />
	</form>
</div>
</body>
</html>
<?php }
}
?>