<div class="borders">
<div class="container-fluid">
<div class="row row-eq-height cont-box-wrap">
    <div class="col-lg-3 col-md-4 listWrapper">
		 <?php 
		 $project_id = $_GET['project_id'];
		 $alldata =Projects::findByProjectId($project_id);
		  $users_count =user::findBySql("select * from users where accountStatus = '3'");
		 if($_SESSION['chat_contatcs_accountStatus']==1){ 
		if($project_id){ ?>
			 <div class="main-title">
			 <h5><?php echo $lang['Project Title']; ?></h5>
			 <h3><?php echo $alldata->project_title; ?></h3>
			 </div>
			 <div class="assign-stf">
			 <h3><?php echo $lang['Assigned Team / Client']; ?></h3>
			 </div>
 <div id="tabs-control" style="display: none !important;" class="bg-gray strong border-top border-bottom text-center">
		<div class="container">
		<div class="row contact-con">
        	<div class="padding-none"><a href="#" id="tab-chats" class="tab border-right active-tab">
            	<div id="loadingDiv-chats"></div>
            	<span class="glyphicon glyphicon-envelope"></span><?php echo $lang['Recent Chats']; ?></a>
            </div>
            <div class="padding-none"><a href="#" id="tab-contacts" class="tab">
            	<div id="loadingDiv-contacts"></div>
            	<span class="glyphicon glyphicon-user"></span> <?php echo $lang['Staff']; ?> (<?php echo count($users_count); ?>)</a>
            </div>
         </div>
         </div>
        </div>
			 <?php 
		} else { ?>
        <div class="innerBox" id="contacts-search">
            <form autocomplete="off" class="form-inline margin-none">
                <div class="input-group input-group-sm">
                    <input class="form-control" id="contacts-search-input" placeholder="<?php echo $lang['Search Staff']; ?>" type="text">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-xs pull-right"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
                </div>
            </form>
        </div>
        <div id="tabs-control" class="bg-gray strong border-top border-bottom text-center">
		<div class="container">
		<div class="row contact-con">
        	<div class="padding-none"><a href="#" id="tab-chats" class="tab border-right active-tab">
            	<div id="loadingDiv-chats"></div>
            	<span class="glyphicon glyphicon-envelope"></span><?php echo $lang['Recent Chats']; ?></a>
            </div>
            <div class="padding-none"><a href="#" id="tab-contacts" class="tab">
            	<div id="loadingDiv-contacts"></div>
            	<span class="glyphicon glyphicon-user"></span> <?php echo $lang['Staff']; ?> (<?php echo count($users_count); ?>)</a>
            </div>
         </div>
         </div>
        </div>
		<?php }
		} else { ?>
<?php if($project_id){ ?>
			 <div class="main-title">
			 <h5><?php echo $lang['Project Title']; ?></h5>
			 <h3><?php echo $alldata->project_title; ?></h3>
			 </div>
			 <div class="assign-stf">
			 <?php if($_SESSION['chat_contatcs_accountStatus']==3){ ?>
			 <h3><?php echo $lang['Assigned Team / Staff']; ?></h3>
			 <?php } else {?>
			 <h3><?php echo $lang['Assigned Team']; ?></h3>
			 <?php }?>
			 </div>
		 <div id="tabs-control" class="bg-gray strong border-top border-bottom text-center" style="display: none;">
			 <?php 
		} else { ?>
        <div class="innerBox" id="contacts-search">
            <form autocomplete="off" class="form-inline margin-none">
                <div class="input-group input-group-sm">
                    <input class="form-control" id="contacts-search-input" placeholder="Search Staff" type="text">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-xs pull-right"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
                </div>
            </form>
        </div>
		<div id="tabs-control" class="bg-gray strong border-top border-bottom text-center">
		<?php } ?>
		<div class="container">
		<div class="row contact-con">
        	<div class="padding-none"><a href="#" id="tab-chats" class="tab border-right active-tab">
            	<div id="loadingDiv-chats"></div>
            	<span class="glyphicon glyphicon-envelope"></span><?php echo $lang['Recent Chats']; ?></a>
            </div>
            <div class="padding-none"><a href="#" id="tab-contacts" class="tab">
            	<div id="loadingDiv-contacts"></div>
                <?php ?>
            	<span class="glyphicon glyphicon-user"></span> <?php echo $lang['Staff']; ?> (<?php echo count($users_count); ?>)</a>
            </div>
         </div>
         </div>
        </div>
		<?php }?>
		<div class="clearfix"></div>
        <?php 	
			$init_load = true;
			$chat_tab = false;
				include('chat_list.php'); 
		?>
    </div>

    <div class="col-lg-9 col-md-8 messageWrapper">
	<div class="mobilearr"><i class="fa fa-arrow-left" aria-hidden="true"></i></div>
        <div id="loadingDiv"></div>
        <div id="errorDiv"></div>
        <div id="text-messages-request">
            <div class="welcomebox">
			<img src="<?php echo $url; ?>/images/welcome.jpg" />
			<h3><?php echo $lang['Team is ready to work with you!']; ?></h3> 
			<p><?php echo $lang['Read your messages by selecting a contact on the left']; ?></p> 
			</div>
        </div>
    </div>
</div>
</div>

</div>