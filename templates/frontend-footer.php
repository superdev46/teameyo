
             
    
    <!-- END COPYRIGHT -->

    <!-- Load javascripts at bottom, this will reduce page load time -->
    <!-- BEGIN CORE PLUGINS(REQUIRED FOR ALL PAGES) -->
    <!--[if lt IE 9]>
    <script src="assets/plugins/respond.min.js"></script>  
    <![endif]-->  
    <script src="assets/js/jquery.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
<script>
$(document).ready(function(){
$(".adminlogin").click( function(){
	$(".logemail").val('admin@teameyo.com');
	$(".pass").val('admin12345');
});
$(".clientlogin").click( function(){
	$(".logemail").val('client@teameyo.com');
	$(".pass").val('admin12345');	
});
$(".stafflogin").click( function(){
	$(".logemail").val('staff@teameyo.com');
	$(".pass").val('admin12345');
});
});
</script>
       
    
	
</body>
<!-- END BODY -->
</html>