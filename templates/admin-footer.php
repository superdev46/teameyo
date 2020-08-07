<?php 
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Admin Footer //////////////////////////
*/
$dash_settings = settings::findById(1);
$url = $dash_settings->url;
?>
    <!--[if lt IE 9]>
    <script src="assets/plugins/respond.min.js"></script>  
    <![endif]-->  
    <script src="<?php echo $url; ?>assets/js/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
$.base_url = "<?php echo $url; ?>";

</script>
    <script src="<?php echo $url; ?>assets/js/bootstrap.js" type="text/javascript"></script>
    <script src="<?php echo $url; ?>assets/js/jquery-ui.min.js" type="text/javascript"></script>
<?php 
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$actual_link = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$actual_link = strtok($actual_link,'?');
$trash_page = "{$url}admin/trash.php";
$client_page = "{$url}admin/clients.php";
$staff_page = "{$url}admin/staff.php";
$setting_page = "{$url}admin/email-setting.php";
$admin_page = "{$url}admin/index.php";
$staffb_page = "{$url}client/index.php";
$clientb_page = "{$url}staff/index.php";

if($actual_link != $trash_page && $actual_link != $client_page && $actual_link != $staff_page && $actual_link != $setting_page && $actual_link != $admin_page && $actual_link != $staffb_page && $actual_link != $clientb_page){ ?>
	 <script src="<?php echo $url; ?>assets/js/semantic.min.js" type="text/javascript"></script>
<?php }?>
   <script src="<?php echo $url; ?>assets/js/jquery.nicescroll.min.js" type="text/javascript"></script>
    <script src="<?php echo $url; ?>assets/js/client.js" type="text/javascript"></script>
    <script src="<?php echo $url; ?>assets/js/general.js?var=<?php echo rand();?>" type="text/javascript"></script>
    <!-- <script src="../assets/js/canvasjs.min.js" type="text/javascript"></script> -->
<!-- include summernote css/js -->
<link href="<?php echo $url; ?>assets/css/summernote-bs4.css" rel="stylesheet">
<script src="<?php echo $url; ?>assets/js/summernote-bs4.js"></script>
    <!-- END CORE PLUGINS -->
<script>
$(document).ready(function() {
$('#editor, .editor').summernote({
		disableDragAndDrop: true,
		dialogsFade: true,
		height: 250,
		emptyPara: '',
		toolbar: [['style', ['style']],
		['font', ['bold', 'underline', 'clear']],
		['fontname', ['fontname']],
		['height', ['height']],
		['color', ['color']],
		['para', ['ul', 'ol', 'paragraph']],
		['table', ['table']],
		['insert', ['link']],
		['view', ['fullscreen', 'codeview', 'help']]
		]
		});
});
</script>
</body>
<!-- END BODY -->
</html>