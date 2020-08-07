var last_time = 0; // <--- New
var new_time = 0; // <--- New
var audio = new Audio($.base_url+'assets/beep/beeps.mp3');
var project_create = {
	project_title: '',
	project_desc: '',
	c_id: '',
	s_ids: '',
	email_notification: 'true',
	prep_service: '0',
	promo_code: '',
	comment: '',
	shipment_optm: 0,
	save_packing: 0
};
var client_name = '';
var staff_names = '';
var items = [];
var bundle_items = [];

function unread_chat(){
var URL = $.base_url + 'message-popup.php';
var old_time = $('.msg-menu ul li:first-child').find('.mbox-info-sec').html();

$.ajax({
		type: "POST",
		url: URL,
		data: {message_page: 'whole_page'},
		cache: false,
		error: function() { $('.msg-menu ul').html('<li>'+$.ajaxError+'</li>'); },
		success: function(html) {
			$('.msg-menu ul').html(html);
		}
	});	
}

function isAlphaNumeric(str) {
  var code, i, len;

  for (i = 0, len = str.length; i < len; i++) {
    code = str.charCodeAt(i);
    if (!(code > 47 && code < 58) && // numeric (0-9)
        !(code > 64 && code < 91) && // upper alpha (A-Z)
        !(code > 96 && code < 123)) { // lower alpha (a-z)
      return false;
    }
  }
  return true;
};

function counter_up(){
var URLB = $.base_url + 'ajax/counter.php';
var oldval = $('.msg-icon-img>span').html();
$.ajax({
		type: "POST",
		url: URLB,
		data: {counter_up: 'update_c'},
		cache: false,
		error: function() { $('.msg-icon-img>span').html($.ajaxError); },
		success: function(html) {
			$('.msg-icon-img>span').html('');
			$('.msg-icon-img>span').html(html);
			if(parseInt(oldval) < parseInt(html)){
				audio.play();
			}
		}
	});	
}
setInterval("unread_chat()", 4000); 
setInterval("counter_up()", 4000); 
$(document).ready(function(){

	$(".language-selecter ul li").click( function(){
		 if(!$(this).hasClass('active')){
		var thisval = $(this).data('value');
		$('.user_language').val(thisval);
		setTimeout( function(){
			$("form.language-form").submit();
		},500);
		 }
		 return false;
	});

/*  --------------------Start Custom Script Files ---------------------------- */
	//step 1
	$("#form_step_1").find(".btn_step_next").click( function(){

		var state = true;

		project_create.project_title = $("input[name='projectTite']").val();
		project_create.c_id = $("select[name='client']").val();
		

		var html = '';

		if(project_create.project_title == ''){
			html += '<p class="alert alert-danger"><i class="fa fa-times"></i> Please insert project title! </p>';
			state = false;
		}

		if(project_create.c_id == ''){
			html += '<p class="alert alert-danger"><i class="fa fa-times"></i> Please select client! </p>';
			state = false;
		}

		if($("select[name='staff[]']").val() == null){
			html += '<p class="alert alert-danger"><i class="fa fa-times"></i> Please select staffs! </p>';
			state = false;
		}else{
			project_create.s_ids = $("select[name='staff[]']").val().join(",");
		}

		if(!state){
			$(".alert-row-group").html(html);
			return ;
		}else{
			$(".alert-row-group").html('');
		}


		if($('.email_notification').hasClass('checked')){
			project_create.email_notification = 'true';
		}else{
			project_create.email_notification = 'false';
		}

		$.ajax({
		    type: "POST",
		   	url: $.base_url + "ajax/get_username.php",
	      	data : {
	      		user_type: 'client',
	      		user_id: project_create.c_id
	      	},
	       	success : function(data) {
	           client_name = data;
	       	}
	    });

	    $.ajax({
		    type: "POST",
		   	url: $.base_url + "ajax/get_username.php",
	      	data : {
	      		user_type: 'staff',
	      		user_id: project_create.s_ids
	      	},
	       	success : function(data) {
	           staff_names = data;
	       	}
	    });


		$(".page_step_form").removeClass("active");
		$("#form_step_2").addClass("active");
		$(".progress").find(".progress-bar-info").css('width', '25%');
		$(".progress-bar-top").text("Shipment Optimization Selection");
		$(".progress").find(".progress-bar-info").text("25% Completed");
	});

	//Step 2
	$("#form_step_2").find(".btn_step_next").click( function(){

		if($(".prep-service.active").attr("role") == '1')
		{
			project_create.prep_service = '1';
		}else if($(".prep-service.active").attr("role") == '2')
		{
			project_create.prep_service = '2';
		}else{
			project_create.prep_service = '0';
		}

		if(project_create.prep_service == '0')
		{
			var html = '';
			html += '<p class="alert alert-danger"><i class="fa fa-times"></i> Please select service ! </p>';
			$(".alert-row-group").html(html);
			return ;
		}

		$(".alert-row-group").html('');

		$(".progress-bar-top").text("List Incoming Unit(s)");
		$(".page_step_form").removeClass("active");
		$("#form_step_3").addClass("active");
		if(userstatus == 1)
		{
			$(".progress").find(".progress-bar-info").css('width', '50%');
			$(".progress").find(".progress-bar-info").text("50% Completed");
		}else if(userstatus == 2)
		{
			$(".progress").find(".progress-bar-info").css('width', '33%');
			$(".progress").find(".progress-bar-info").text("33% Completed");
		}
		
	});

	$("#form_step_2").find(".btn_step_prev").click( function(){
		$(".alert-row-group").html('');
		$(".progress-bar-top").text("Create a Work Order");
		$(".page_step_form").removeClass("active");
		$("#form_step_1").addClass("active");
		$(".progress").find(".progress-bar-info").css('width', '0%');
		$(".progress").find(".progress-bar-info").text("0%");
	});

	//Step 3
	$("#form_step_3").find(".btn_step_next").click( function(){

		items = [];
		if($(".toggle_item").hasClass('checked')){
			$('.marchant-group').each(function(i, obj) {
			    var input_sku = $(obj).find('.input_sku').val();
			    var input_asin = $(obj).find('.input_asin').val();
			    var input_itemname = $(obj).find('.input_itemname').val();
			    var input_qty = $(obj).find('.input_qty').val();

			    var item = {
			    	sku: input_sku,
			    	asin: input_asin,
			    	itemname: input_itemname,
			    	qty: input_qty
				}
				items.push(item);
			});
			if(items.length > 0){
				var final_index = items.length - 1; 
				var item = items[final_index];
				if(item.sku == '' || item.asin == '' || item.itemname == '' || item.qty == '')
				{
					var html = '';
					html = '<p class="alert alert-danger"><i class="fa fa-times"></i> Please fill in all field! </p>';
					$(".alert-row-group").html(html);
					return ;
				}else{
					var html = '';
					if(item.asin.length > 10 || !isAlphaNumeric(item.asin))
					{
						html += '<p class="alert alert-danger"><i class="fa fa-times"></i> ASIN field is not valid! </p>';
						$(".alert-row-group").html(html);
						return ; 
					}

					$(".alert-row-group").html('');
				}
			}
		}

		bundle_items = [];
		if($(".toggle_bundle").hasClass("checked"))
		{
			$('.bundle-group').each(function(i, obj) {
			
			    var input_bundle_sku = $(obj).find('.input_bundle_sku').val();
			    var input_bundle_asin = $(obj).find('.input_bundle_asin').val();
			    var input_bundle_itemname = $(obj).find('.input_bundle_itemname').val();
			    var input_bundle_qty = $(obj).find('.input_bundle_qty').val();
			    var input_bundle_total = $(obj).find('.input_bundle_total').val();

			    var bundle_item = {
			    	bundle_sku: input_bundle_sku,
			    	bundle_asin: input_bundle_asin,
			    	bundle_itemname: input_bundle_itemname,
			    	bundle_qty: input_bundle_qty,
			    	bundle_total: input_bundle_total
				}
				bundle_items.push(bundle_item);
			});
			if(bundle_items.length > 0){
				var f_index = bundle_items.length - 1; 
				var b_item = bundle_items[f_index];
				if(b_item.bundle_sku == '' || b_item.bundle_asin == '' || b_item.bundle_itemname == '' || b_item.bundle_qty == '' || b_item.bundle_total == '')
				{
					var html = '';
					html = '<p class="alert alert-danger"><i class="fa fa-times"></i> Please fill in all field! </p>';
					$(".alert-row-group").html(html);
					return ;
				}else{
					var html = '';
					if(b_item.bundle_asin.length > 10 || !isAlphaNumeric(b_item.bundle_asin))
					{
						html += '<p class="alert alert-danger"><i class="fa fa-times"></i> ASIN field is not valid! </p>';
						$(".alert-row-group").html(html);
						return ; 
					}
					$(".alert-row-group").html('');
				}
			}

		}

		$(".progress-bar-top").text("Select Gopher Extra(s)");
		$(".page_step_form").removeClass("active");
		$("#form_step_4").addClass("active");
		if(userstatus == 1)
		{
			$(".progress").find(".progress-bar-info").css('width', '75%');
			$(".progress").find(".progress-bar-info").text("75% Completed");
		}else if(userstatus == 2)
		{
			$(".progress").find(".progress-bar-info").css('width', '66%');
			$(".progress").find(".progress-bar-info").text("66% Completed");
		}
		
	});

	$("#form_step_3").find(".btn_step_prev").click( function(){
		$(".alert-row-group").html('');
		$(".progress-bar-top").text("Shipment Optimization Selection");
		$(".page_step_form").removeClass("active");
		$("#form_step_2").addClass("active");

		if(userstatus == 1)
		{
			$(".progress").find(".progress-bar-info").css('width', '25%');
			$(".progress").find(".progress-bar-info").text("25% Completed");
		}else if(userstatus == 2)
		{
			$(".progress").find(".progress-bar-info").css('width', '0%');
			$(".progress").find(".progress-bar-info").text("0%");
		}
	});


	$(".toggle_bundle").click(function(){
		if($(this).hasClass('checked'))
		{
			$(".bundle-rows").addClass("show");
		}else{
			$(".bundle-rows").removeClass("show");
		}
	});

	$(".toggle_item").click(function(){
		if($(this).hasClass('checked'))
		{
			$(".marchant-rows").addClass("show");
		}else{
			$(".marchant-rows").removeClass("show");
		}
	});


	//Step 4
	$("#form_step_4").find(".btn_step_next").click( function(){

		project_create.promo_code = $("input[name='promoCode']").val();
		project_create.comment = $("textarea[name='description']").val();

		// if(project_create.promo_code == '')
		// {
		// 	var html = '';
		// 	html = '<p class="alert alert-danger"><i class="fa fa-times"></i> Please insert promo code! </p>';
		// 	$(".alert-row-group").html(html);
		// 	return ;
		// }else{
		// 	$(".alert-row-group").html('');
		// }

		if($(".shipment_optimization").hasClass('checked')){
			project_create.shipment_optm = 1
		}else{
			project_create.shipment_optm = 0
		}

		if($(".save_packing").hasClass("checked")){
			project_create.save_packing = 1;
		}else{
			project_create.save_packing = 0;
		}

		var tb_html = '';
		var total_individual_qty = 0; 

		if(items.length == 0)
		{
			$(".individual_summary_group").css('display', 'none');
		}else{
			$(".individual_summary_group").css('display', 'block');
		}

		for(var i = 0; i < items.length; i++)
		{
			tb_html += '<tr>';
			tb_html += '<td>'+items[i].sku+'</td>';
			tb_html += '<td>'+items[i].asin+'</td>';
			tb_html += '<td>'+items[i].itemname+'</td>';
			tb_html += '<td>'+items[i].qty+'</td>';
			tb_html += '</tr>';

			total_individual_qty += parseInt(items[i].qty);
		}
		$(".summary_skus").text("Total Individual SKUs : " + items.length);
		$(".summary_qty").text("Total Qty : " + total_individual_qty);
		
		$(".summary_tbody").html(tb_html);

		var tb_bundle_html = '';
		var total_bundle_qty = 0;
		var total_bundle_total = 0;

		if(bundle_items.length == 0){
			$(".bundle_summary_group").css('display', 'none');
		}else{
			$(".bundle_summary_group").css('display', 'block');
		}

		for(var i = 0; i < bundle_items.length; i++)
		{
			tb_bundle_html += '<tr>';
			tb_bundle_html += '<td>'+bundle_items[i].bundle_sku+'</td>';
			tb_bundle_html += '<td>'+bundle_items[i].bundle_asin+'</td>';
			tb_bundle_html += '<td>'+bundle_items[i].bundle_itemname+'</td>';
			tb_bundle_html += '<td>'+bundle_items[i].bundle_qty+'</td>';
			tb_bundle_html += '<td>'+bundle_items[i].bundle_total+'</td>';
			tb_bundle_html += '</tr>';

			total_bundle_qty += parseInt(bundle_items[i].bundle_qty);
			total_bundle_total += parseInt(bundle_items[i].bundle_total);
		}
		$(".summary_bundle_tbody").html(tb_bundle_html);
		$(".total_bundle_qty").text("Total Bundled SKUs : " + bundle_items.length);
		$(".total_bundle_total").text("Total Bundles : " + total_bundle_total);

		$(".total_skus").text("Total # of SKUs: " + (items.length + bundle_items.length));
		$(".total_units").text("Total # of Units : " + (total_individual_qty*1 + total_bundle_total*1));

		if(userstatus == 2)
		{
			project_create.project_title = currentdate + " " + 'Shipping Plan - ' + (items.length + bundle_items.length) + ' SKUs - ' + (total_individual_qty*1 + total_bundle_total*1) + ' Items';
		}
		$(".project_title").text(project_create.project_title);


		if(project_create.prep_service == '1'){
			$(".selected_service").text("Prep Service Optimization : SPEED");
		}else if(project_create.prep_service == '2'){
			$(".selected_service").text("Prep Service Optimization : PRICE");
		}else if(project_create.prep_service == '0'){
			$(".selected_service").text("Service : ");
		}

		if(project_create.shipment_optm == 1)
		{
			$(".shipment_optimization_group").css("display", "block");
		}else if(project_create.shipment_optm == 0){
			$(".shipment_optimization_group").css("display", "none");
		}

		if(project_create.save_packing == 1)
		{
			$(".save_packing_group").css("display", "block");
		}else if(project_create.save_packing == 0){
			$(".save_packing_group").css("display", "none");
		}
		
		$(".summary_promocode").text("Promo Code :   " + project_create.promo_code);
		if(project_create.promo_code.trim() == '')
		{
			$(".promocode_group").css('display', 'none');
		}else{
			$(".promocode_group").css('display', 'block');
		}

		$(".summary-prep-service").removeClass("active");
		$(".sm_pre_"+project_create.prep_service).addClass("active");

		if(userstatus == 1)
		{
			$(".summary_client").text("Client: " + client_name);
			$(".summary_staffs").text("Staff: " + staff_names);
		}else if(userstatus == 2)
		{
			project_create.c_id = current_userId;
			$(".summary_client").css("display", "none");
			$(".summary_staffs").css("display", "none");
			$(".summary_client").text("Client: " + current_username);
			$(".summary_staffs").text("Staff: ");
		}

		

		if(project_create.comment.trim() == '')
		{
			$(".comments_group").css('display', 'none');
		}else{
			$(".comments_group").css('display', 'block');
			$(".project_description").val(project_create.comment);
		}

		$(".progress-bar-top").text("Incoming Product(s) Summary");
		$(".page_step_form").removeClass("active");
		$("#form_step_5").addClass("active");
		$(".progress").find(".progress-bar-info").css('width', '100%');
		$(".progress").find(".progress-bar-info").text("100% Completed");
	});

	$("#form_step_4").find(".btn_step_prev").click( function(){
		$(".alert-row-group").html('');
		$(".progress-bar-top").text("List Incoming Unit(s)");
		$(".page_step_form").removeClass("active");
		$("#form_step_3").addClass("active");

		if(userstatus == 1)
		{
			$(".progress").find(".progress-bar-info").css('width', '50%');
			$(".progress").find(".progress-bar-info").text("50% Completed");
		}else if(userstatus == 2)
		{
			$(".progress").find(".progress-bar-info").css('width', '33%');
			$(".progress").find(".progress-bar-info").text("33% Completed");
		}

	});

	//Step 5
	$("#form_step_5").find(".btn_step_prev").click( function(){
		$(".alert-row-group").html('');
		$(".progress-bar-top").text("Select Gopher Extra(s)");
		$(".page_step_form").removeClass("active");
		$("#form_step_4").addClass("active");
		$(".progress").find(".progress-bar-info").css('width', '75%');
		$(".progress").find(".progress-bar-info").text("75% Completed");

		if(userstatus == 1)
		{
			$(".progress").find(".progress-bar-info").css('width', '75%');
			$(".progress").find(".progress-bar-info").text("75% Completed");
		}else if(userstatus == 2)
		{
			$(".progress").find(".progress-bar-info").css('width', '66%');
			$(".progress").find(".progress-bar-info").text("66% Completed");
		}
	});


	// Select Prep Service
	$(".prep-service").click(function(){
		var active_state = false;
		if($(this).hasClass("active"))
		{
			active_state = true;
		}else{
			active_state = false;
		}
		$(".prep-service").removeClass("active");
		if(active_state){
			project_create.prep_service = '0';
		}else{
			var role = $(this).attr('role');
			project_create.prep_service = role;
			$(this).addClass("active");
		}
	});

	//Add project
	$(".btn_add_project").click(function()
	{
		var terms_val = $("input[name='terms']:checked").val();
		if(parseInt(terms_val) != 1){
			var html = '';
			html = '<p class="alert alert-danger"><i class="fa fa-times"></i> You must agree with Consent to Terms & Conditions ! </p>';
			$(".alert-row-group").html(html);
			return ;
		}


		var add_project_url = $.base_url + 'ajax/add_project.php';
		$.ajax({
            type: "POST",
            dataType: 'json',
            url: add_project_url,
            data: {
            	project_create: project_create,
            	items: items,
            	bundle_items: bundle_items
            },
			error: function(err) { 
				console.log(err.responseText);
			},
            success: function(result) {
            	if(result.status == 200)
            	{
            		window.location.href = base_dir + result.msg;
            	}
			}
		});
	});


	//Add project
	$(".btn_update_project").click(function()
	{
		var terms_val = $("input[name='terms']:checked").val();
		if(parseInt(terms_val) != 1){
			var html = '';
			html = '<p class="alert alert-danger"><i class="fa fa-times"></i> You must agree with Consent to Terms & Conditions ! </p>';
			$(".alert-row-group").html(html);
			return ;
		}
		var pro_id = $(this).attr('role');

		var add_project_url = $.base_url + 'ajax/update_project.php';
		$.ajax({
            type: "POST",
            dataType: 'json',
            url: add_project_url,
            data: {
            	pro_id : pro_id,
            	project_create: project_create,
            	items: items,
            	bundle_items: bundle_items
            },
			error: function(err) { 
				console.log(err.responseText);
			},
            success: function(result) {
            	if(result.status == 200)
            	{
            		window.location.href = base_dir + result.msg;
            	}
			}
		});
	});


	$(".terms_content").click(function(){
		var ttt = $("input[name='terms']:checked").val();
		console.log(ttt);
	});


/*  --------------------End Custom Script Files ---------------------------- */


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

	$(".alert-savestn").click( function(){
		alert("System setting cannot be change in demo version");
		return false;
	});
	$(".editprofilebtn").click( function(){
		alert("Profile cannot be edit in demo version");
		return false;
	});

	$("#inputtoggale").click( function(){
		var x = $(".passwordfield").attr("type");
	    if (x === "password") {
	        $(".passwordfield").attr("type", "text");
	    } else {
	        $(".passwordfield").attr("type", "password");
	    }
	});

	var winWidth = $(window).width();
	if(winWidth <= 767){
		$(".mobile-menu i").click( function(){
			$(".sidebar-admin.col-md-3").animate({left:0});
		});
		$(".cross-mobile").click( function(){
			$(".sidebar-admin.col-md-3").animate({left:'-107%'});
		});
		$("#messages-stack-list").on("click", '.prepare-message', function(event) {
			$(".messages-box .messageWrapper").animate({
				right: 0
			});
			$(".messages-box .messageWrapper").removeClass("animatedBox");
		});
		$(".mobilearr").click( function(){
			$(this).parent().animate({
				right: '-100%'
			});
			$(this).parent().addClass("animatedBox");
		});
		$("#text-messages-request").on("click", ".mobilesmenu", function(){

		$(".buttons-cont").fadeToggle("fast");

		});

	} else{
		$(".mobile-menu i").click( function(){
			$(".sidebar-admin.col-md-3").animate({left:0});
		});
		$(".cross-mobile").click( function(){
			$(".sidebar-admin.col-md-3").animate({left:'-30%'});
		});
	}	
	$(".btn-action").click( function(e){e.preventDefault();});
	var client_val = $("select[name=client]").val();
	$('.new_val').val(client_val);
	$("select[name=client]").change(function() {
		$('.new_val').val($(this).val());
	});

	$(".month-drop").change( function(){
		var Month = $(this).val();
		var month_url = $.base_url + 'ajax/monthly_budget.php';
		$.ajax({
            type: "POST",
            url: month_url,
            data: {month: Month},
			error: function() { $('.month-rps').html('<p>'+$.ajaxError+'</p>'); },
            success: function(html) {
				$('.month-rps').html(html);
			}
		});

	});
	// Scroll
	$("ul#messages-stack-list, #text-messages-request, #text-messages, .unread-scroll, .admin-nav-area>ul.list-unstyled, .db-box-wrapadmin").niceScroll({
		cursorcolor: "#2f2e2e",
		cursoropacitymax: 0.6,
		boxzoom: false,
		touchbehavior: true,
		autohidemode: false,
		touchbehavior: false
	});
  $("#protbl-input").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#projects-tbl tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  $("#staff-searchnew").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".col-sm-3.staff").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
	  $(".norecords").hide();
 	if($('.staff:visible').length == 0)
            {
                $(".norecords").show();
            }
    });
  });
$(':checkbox[name=btSelectAll]').click (function () {
	var alltrs = $(this).parent().parent().parent().parent().find('tr');
	$(':checkbox[name=btSelectItem]').prop('checked', this.checked);
 	var checkbox_val = [];
    $.each($("input[name='btSelectItem']:checked"), function(){            
        checkbox_val.push($(this).val());
    });
	var check_fcal = checkbox_val.join(", ");
    console.log("My favourite sports are: " + check_fcal);
	$(".bulk_ids").val(check_fcal);
	if(check_fcal){
		$(".pm-trash").addClass('active');
		$('button[name="bulk_del_proj"]').prop('disabled','');
	} else {
		$(".pm-trash").removeClass('active');
		$('button[name="bulk_del_proj"]').prop('disabled','disabled');
	}
			
});
$(':checkbox[name=btSelectItem]').click( function(){
	var checkbox_val = [];
    $.each($("input[name='btSelectItem']:checked"), function(){            
        checkbox_val.push($(this).val());
    });
	var check_fcal = checkbox_val.join(", ");

	$(".bulk_ids").val(check_fcal);
	if(check_fcal){
		$(".pm-trash").addClass('active');
		$('button[name="bulk_del_proj"]').prop('disabled','');
	} else {
		$(".pm-trash").removeClass('active');
		$('button[name="bulk_del_proj"]').prop('disabled','disabled');
	}
});
$(':checkbox[name=client-checkbox]').click( function(){
var checkbox_val = [];
            $.each($("input[name='client-checkbox']:checked"), function(){            
                checkbox_val.push($(this).val());
            });
			var check_ucal = checkbox_val.join(", ");

			$(".bulk_uids").val(check_ucal);
			if(check_ucal){
				$(".um-trash").addClass('active');
				$('button[name="bulk_del_user"]').prop('disabled','');
			} else {
				$(".um-trash").removeClass('active');
				$('button[name="bulk_del_user"]').prop('disabled','disabled');
			}
});


$(".action-toggle").click( function(){
	$(this).next().toggle();
});
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});
var sampage_count = parseInt($("#projects-tbl tr").length);
var start_val = parseInt($(".resilts-txt span.start_val").html());
var total_count = sampage_count + start_val;
$(".resilts-txt span.end_val").html(total_count);
$(".upload-up").click( function(){
	$(this).parent().parent().find("input").click();
	return false;
});
$(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('input[type="file"]').on('change', function() {
		$(this).parent().find('div.uploaded-img').css('display','block');
		$(this).parent().find('div.uploaded-img').html('');
        imagesPreview(this, $(this).parent().find('div.uploaded-img'));
		$(this).parent().find(".remove-up").css('display','block');
    });
});
$(".remove-up").click( function(){
	$(this).hide();
	$(this).parent().parent().find('div.uploaded-img').hide();
	$(this).parent().parent().find(".uploaded-img").html('');
	$(this).parent().parent().find('input[type="file"]').val('');
	return false;
});
$(".setup-btn").click( function(){
	$(this).parent().parent().parent().find('.payment-fields').toggle();
	return false;
});
/* Image Upload Profile */
$('#imgInpb').change( function(event) {
var tmppath = URL.createObjectURL(event.target.files[0]);
$(".upload-pro-pic .img-uploadwrap img").attr('src',URL.createObjectURL(event.target.files[0]));
});
$('#imgInp').change( function(event) {
var tmppath = URL.createObjectURL(event.target.files[0]);
    $(".upload-pro-pic .img-uploadwrap img").attr('src',URL.createObjectURL(event.target.files[0]));
	$(".upload-pro-pic .img-uploadwrap img").css('opacity','0.4');
var formData = new FormData();
formData.append('pro-pic', $(this)[0].files[0]);
formData.append('editClient', $(this).data('clientid'));
	 uploadFile(formData);
	
});
function uploadFile(formData)
{
   $.ajax({
	   type: "POST",
	   url: $.base_url + "ajax/ajax_profilepic.php",
      data : formData,
       processData: false,  // tell jQuery not to process the data
       contentType: false,  // tell jQuery not to set contentType
       success : function(data) {
           console.log(data);
		   if(data == 'ok'){
		   $(".imageupates").show();
		   $(".imageupatesfail").hide();
		   } else{
			   $(".imageupates").hide();
			    $(".imageupatesfail").show();
			   
		   }
		   $(".upload-pro-pic .img-uploadwrap img").css('opacity','1');
       }
    });
}
/* Image Upload Profile End*/
  $(".collapse").on('shown.bs.collapse', function(){
        $(this).prev().addClass('show');
    });
    $(".collapse").on('hidden.bs.collapse', function(){
        $(this).prev().removeClass('show');
    });

var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!

var yyyy = today.getFullYear();
if (dd < 10) {
  dd = '0' + dd;
} 
if (mm < 10) {
  mm = '0' + mm;
} 
var today = yyyy + '-' + mm + '-' + dd;
 $(".status1").change(function () {
        var thisval = this.value;
		if(thisval == '1'){
        $(".releaseDate").val(today);
		} else{
		$(".releaseDate").val('1970-01-01');	
		}
    });
});
$(document).on("click", function(event){
	if (!$(event.target).is('.action-toggle.show')) {
		$('.toggle-action.in').hide();
	    $('.toggle-action.in').collapse('hide');	    
    }
});


//marchant group
$("body").on('click', ".btn_item_add" ,function()
{
	var m_rows = $(this).parents('.marchant-rows');
	var group_row = $(this).parents(".marchant-group");
	var input_sku = group_row.find('.input_sku').val();
	var input_asin = group_row.find('.input_asin').val();
	var input_itemname = group_row.find('.input_itemname').val();
	var input_qty = group_row.find('.input_qty').val();
	var html = '';
	var status = false;

	if(input_sku == '' || input_asin == '' || input_itemname == '' || input_qty == '')
	{
		html = '<p class="alert alert-danger"><i class="fa fa-times"></i> Please fill in all field! </p>';
		$(".alert-row-group").html(html);
		return ;
	}else{
		$(".alert-row-group").html('');
		html = '';
		if(input_asin.length > 10 || !isAlphaNumeric(input_asin))
		{
			html += '<p class="alert alert-danger"><i class="fa fa-times"></i> ASIN field is not valid! </p>';
			status = true;
		}
		
		if(status)
		{
			$(".alert-row-group").html(html);
			return ; 
		}

	}
	html += '<div class="row marchant-group">';
	html += '<div class="col-md-3"><input type="text" name="" class="form-control input_sku" placeholder="Merchant SKU" required></div>';
	html += '<div class="col-md-3"><input type="text" name="" class="form-control input_asin" placeholder="ASIN" maxlength="10" required></div>';
	html += '<div class="col-md-3"><input type="text" name="" class="form-control input_itemname" placeholder="Unit Name" required></div>';								
	html += '<div class="col-md-3"><input type="number" name="" class="form-control input_qty" placeholder="Qty" required></div>';
	html += '<div class="col-sm-12 btn-manage"><div><a class="btn_item_add"><i class="fa fa-plus"></i></a><a class="btn_marchant_remove"><i class="fa fa-times"></i></a></div></div>';								
	html += '</div>';
	m_rows.append(html);				
});


//bundle group
$("body").on('click', ".btn_bundle_add" ,function()
{
	var m_rows = $(this).parents('.bundle-rows');
	var group_row = $(this).parents(".bundle-group");
	var input_bundle_sku = group_row.find('.input_bundle_sku').val();
	var input_bundle_asin = group_row.find('.input_bundle_asin').val();
	var input_bundle_itemname = group_row.find('.input_bundle_itemname').val();
	var input_bundle_qty = group_row.find('.input_bundle_qty').val();
	var input_bundle_total = group_row.find('.input_bundle_total').val();
	var html = '';
	var status = false;

	if(input_bundle_sku == '' || input_bundle_asin == '' || input_bundle_itemname == '' || input_bundle_qty == '' || input_bundle_total == '')
	{
		html = '<p class="alert alert-danger"><i class="fa fa-times"></i> Please fill in all field! </p>';
		$(".alert-row-group").html(html);
		return ;
	}else{
		$(".alert-row-group").html('');
		console.log(input_bundle_asin);
		html = '';
		if(input_bundle_asin.length > 10 || !isAlphaNumeric(input_bundle_asin))
		{
			html += '<p class="alert alert-danger"><i class="fa fa-times"></i> ASIN field is not valid! </p>';
			status = true;
		}
		
		if(status)
		{
			$(".alert-row-group").html(html);
			return ; 
		}
	}

	html += '<div class="row bundle-group">';
	html += '<div class="col-md-7"><div class="row">';
	html += '<div class="col-md-4"><input type="text" name="" class="form-control input_bundle_sku" placeholder="Merchant SKU" required></div>';
	html += '<div class="col-md-4"><input type="text" name="ASIN" class="form-control input_bundle_asin" placeholder="ASIN" maxlength="10" required></div>';
	html += '<div class="col-md-4"><input type="text" name="" class="form-control input_bundle_itemname" placeholder="Unit Name" required></div>';
	html += '</div></div>';
	html += '<div class="col-md-5"><div class="row">';
	html += '<div class="col-md-6"><input type="number" name="" class="form-control input_bundle_qty" placeholder="Qty in bundle" required></div>';								
	html += '<div class="col-md-6"><input type="number" name="" class="form-control input_bundle_total" placeholder="Total # of bundles" required></div>';
	html += '</div></div>';
	html += '<div class="col-sm-12 btn-manage"><div><a class="btn_bundle_add"><i class="fa fa-plus"></i></a><a class="btn_bundle_remove"><i class="fa fa-times"></i></a></div></div>';								
	html += '</div>';
	m_rows.append(html);							
});

$("body").on('click', ".btn_marchant_remove", function()
{
	var m_row = $(this).parents('.marchant-group');
	m_row.remove();							
});

$("body").on('click', ".btn_bundle_remove", function()
{
	var m_row = $(this).parents('.bundle-group');
	m_row.remove();							
});

$("body").on('keyup', '.input_asin', function(){
	var inputstr = $(this).val();
	if(inputstr.length > 10)
	{
		$(this).val(inputstr.substring(0, 10));
	}

});


$("body").on('keyup', '.input_bundle_asin', function(){
	var inputstr = $(this).val();
	if(inputstr.length > 10)
	{
		$(this).val(inputstr.substring(0, 10));
	}

});