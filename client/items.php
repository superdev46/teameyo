<?php 
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Payments page Edit milestone/Create Milestones/Update Milestones  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
$title = "Items | ". $syatem_title;
include("../templates/admin-header.php");

if(!($session->isLoggedIn())){
    redirectTo($url."index.php");
  }
if($_SESSION['accountStatus'] == 1){
  redirectTo($url."admin/edit-profile.php");
}
if($_SESSION['accountStatus'] == 3){
  redirectTo($url."staff/edit-profile.php");
}
//condition check for login

$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array  
$username=$user->firstName;
$email=$user->email;
$account_stat=$user->status;
if(isset($_GET['projectId'])){
   $projectId=$_GET['projectId'];
}
 
if(isset($_GET['projectId']))
{
  $ProjectsLoop =projects::findBySql("select * from projects WHERE p_id= $projectId");
?>

<div class="page-container">
<div class="container-fluid">
<div class="row row-eq-height">
  <?php  include("../templates/sidebar.php"); ?>
  
    <div class="page-content col-lg-9 col-md-12 col-sm-12 col-lg-push-3" style="padding-bottom:0px !important;">
<?php include('../templates/top-header.php'); ?>
         <div class="row">
            <div class="col-md-12 margin-top-10 clients">
<div class="row project-dash">
              <div class="col-lg-6 col-md-6 col-sm-6 mobileleft">
        <div class="pm-heading" style="width:100%;">
          <h2> <?php echo $ProjectsLoop[0]->project_title;?> </h2>
        </div>
        
<?php $items=projects::findBySql("select * from projects WHERE trash=1");?>
        </div> 
                <div class="col-lg-6 col-md-6 col-sm-6 creative-right text-right">
<div class="mobilepromenu">
        <div class="projbtnm"><a data-toggle="modal" data-target="#add-milestone" class="milebtn"><span>+</span></a></div>
        <div class="projmobilem">
        <i class="fa fa-bars" aria-hidden="true"></i>
          <ul>
<li class="cprojectmsg"><form action="../messages.php?project_id=<?php echo $ProjectsLoop[0]->p_id;?>" method="post">
                <input type="hidden" name="user_id" value="<?php echo $ProjectsLoop[0]->c_id;?>" />
                <input type="hidden" name="project_id" value="<?php echo $ProjectsLoop[0]->p_id;?>" />
                <button type="submit" name="chat"><?php echo $lang['view project']; ?></button>
                </form></li>
          </ul>
          </div>
        </div>
        <ul class="deskvisible">
<li class="cprojectmsg"><form action="../messages.php?project_id=<?php echo $ProjectsLoop[0]->p_id;?>" method="post">
                <input type="hidden" name="user_id" value="<?php echo $ProjectsLoop[0]->c_id;?>" />
                <input type="hidden" name="project_id" value="<?php echo $ProjectsLoop[0]->p_id;?>" />
                <button type="submit" name="chat"><?php echo $lang['view project']; ?></button>
                </form></li>
        </ul>
      </div>
      </div>
                <div class="clearfix"></div>
                <?php if(isset($message) && (!empty($message))){echo $message;} ?>

        <div class="row">
          <?php 
                    $items = items::findBySql("select * from project_items where p_id='$projectId'");
          ?>
                  <div class="table-responsive">          
                    <h2>Units Sold Individually</h2>
                      <table class="table table-new table-milestones">
                        <thead>
                          <tr>
                            <th><?php echo $lang['No.']; ?></th>
                            <th class="table-title1">Unit Name</th>
                            <th class="table-due">Qty</th>
                            <th class="text-center"><?php echo $lang['Status']; ?></th>
                            <th class="text-center">Alerts</th>
                            <th class="text-center">Options</th>
                          </tr>
                        </thead>
                        <tbody id="projects-tbl">
            <?php 
              $counter=1;
              if($items == NULL){
                  echo '<tr><td colspan="7">'.$lang['There is no milestones available!'].'</td></tr>';
                }
                          foreach($items  as $item_key => $item){ ?>
                            <?php 
                            ?>
                            <tr class="tr_main">
                                <td>                   
                                  <?php echo $counter; ?>
                                </td>
                                <td class="tbl-ttl">
                                  <span class="icon_item_detail" style="padding-right: 20px"><i class="fa fa-caret-right" aria-hidden="true"></i></span>
                                  <span class="onmobile">Unit Name: </span>
                                  <span> <?php echo $item->name;?> </span> </td>
                                <td><span class="onmobile centera">Qty</span> <?php echo $item->Qty;?></td>
                                <td class="inv-status">
                                  <?php 
                                    if($item->status==0)
                                      { 
                                        echo "<span class='label label-danger'>Awaiting Delivery</span>";
                                      }
                                    else if($item->status==1){
                                        echo "<span class='label label-purple'>Delivered</span>";
                                      }
                                    else if($item->status==2){
                                      echo "<span class='label label-brown'>Prepping</span>";
                                    }
                                    else if($item->status==3){
                                      echo "<span class='label label-green'>Completed</span>";
                                    }
                                    else if($item->status==4){
                                      echo "<span class='label label-orange'>Partially Delivered</span>";
                                    }
                                  ?>
                                </td>

                                <td>
                                <?php 
                                  if($item->alert == 'no') 
                                  {
                                ?>
                                  <a class="btn blue btn_add_alert" item_id="<?php echo $item->id ?>" role="item" >No Alerts</a>
                                <?php
                                  }else{
                                    ?>
                                    <a class="btn btn-danger btn_add_alert" item_id="<?php echo $item->id ?>" role="item" ><?php echo $item->alert ?></a>
                                    <?php
                                  }
                                ?>
                                </td>

                                <td class="extra-height">
                                  <span class="onmobile centera"><?php echo $lang['Options']; ?></span>
                                  <div class="action-toggle" data-toggle="collapse" data-target="#client-menu<?php echo $recentProject->p_id;?>"><?php echo $lang['Options']; ?><i class="fa fa-caret-down"></i></div>
                                    <div id="client-menu<?php echo $recentProject->p_id;?>" class="toggle-action item_toggle collapse">
                                      <ul>
                                        <li>
                                            <button type="button" class="btn_add_qty" item_id="<?php echo $item->id ?>" role="item"> Receive Partial Units </button>
                                        </li>
                                        <li>
                                            <button type="button" class="btn_all_qty" item_id="<?php echo $item->id ?>" role="item"> Receive All Units </button>
                                        </li>
                                        <li>
                                          <button type="button" class="btn_begin_prepping" item_id="<?php echo $item->id ?>" role="item"> Begin Prepping All Units </button>
                                        </li>
                                        <li>
                                          <button type="button" class="btn_mark_completed" item_id="<?php echo $item->id ?>" role="item"> Mark Project Completed </button>
                                        </li>
                                      </ul>
                                    </div>
                                  </td>
                            </tr>
                            <tr class="tr_detail">
                              <td colspan="6">
                                <table class="table-item-detail">
                                  <thead>
                                    <tr>
                                      <th>Status</th>
                                      <th>Qty</th>
                                      <th>Date</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                      $item_id = $item->id;
                                      $item_delivery_list = itemsdelivery::findBySql("select * from items_delivery where item_id='$item_id'");
                                      $total_delivered_qty = 0;
                                      foreach ($item_delivery_list as $d_key => $item_delivery) {
                                        $total_delivered_qty += $item_delivery->qty;
                                    ?>
                                      <tr>
                                        <td>Deilvered</td>
                                        <td><?php echo $item_delivery->qty ?></td>
                                        <td>
                                          <?php 
                                            $date = new DateTime($item_delivery->delivery_date);
                                            $d_mon = (int)$date->format('m');
                                            $d_day = (int)$date->format('d');
                                            $d_year = $date->format('y');
                                            echo $d_mon . "|" . $d_day . "|" . $d_year;
                                          ?>  
                                        </td>
                                      </tr>
                                    <?php
                                      }

                                      $remain_delivery_qty = $item->Qty - $total_delivered_qty;
                                    ?>

                                      <tr>
                                        <td>Awaiting Deilvery</td>
                                        <td colspan="2"><?php echo $remain_delivery_qty ?></td>
                                      </tr>

                                  </tbody>
                                </table>
                              </td>
                            </tr>
                            <input type="hidden" id="item_name_<?php echo $item->id ?>" value="<?php echo $item->name ?>">
                            <input type="hidden" id="item_remain_<?php echo $item->id ?>" value="<?php echo $remain_delivery_qty ?>">
                          <?php 
                $counter++; 
                }
              ?>
                      </tbody>
                      </table>
                  </div>

                  <?php 
                    $bundleitems = bundleitems::findBySql("select * from project_bundleitems where p_id='$projectId'");
          ?>
                  <div class="table-responsive">          
                    <h2>Units Sold as Bundles or Multipacks</h2>
                      <table class="table table-new table-milestones">
                        <thead>
                          <tr>
                            <th><?php echo $lang['No.']; ?></th>
                            <th class="table-title1">Unit Name</th>
                            <th class="table-due">Qty</th>
                            <th class="text-center"><?php echo $lang['Status']; ?></th>
                            <th class="text-center">Alerts</th>
                            <th class="text-center"> Options </th>
                          </tr>
                        </thead>
                        <tbody id="projects-tbl">
            <?php 
              $counter=1;
              if($bundleitems == NULL){
                  echo '<tr><td colspan="7">'.$lang['There is no milestones available!'].'</td></tr>';
                }
                          foreach($bundleitems as $bundleitem){
                          ?>
                            <tr class="tr_main">
                                <td><?php echo $counter; ?></td>
                                <td class="tbl-ttl">
                                  <span class="icon_item_detail" style="padding-right: 20px"><i class="fa fa-caret-right" aria-hidden="true"></i></span>
                                  <span class="onmobile">Unit Name: </span>
                                  <span><?php echo $bundleitem->name;?></span></td>
                                <td><span class="onmobile centera">Qty</span> <?php echo $bundleitem->bundle_qty;?></td>
                                <td class="inv-status">

                                  <?php 
                                    if($bundleitem->status==0)
                                      { 
                                        echo "<span class='label label-danger'>Awaiting Delivery</span>";
                                      }
                                    else if($bundleitem->status==1){
                                        echo "<span class='label label-purple'>Delivered</span>";
                                      }
                                    else if($bundleitem->status==2){
                                      echo "<span class='label label-brown'>Prepping</span>";
                                    }
                                    else if($bundleitem->status==3){
                                      echo "<span class='label label-green'>Completed</span>";
                                    }
                                    else if($bundleitem->status==4){
                                      echo "<span class='label label-orange'>Partially Delivered</span>";
                                    }
                                  ?>
                                </td>
                                <td>
                                 <?php 
                                  if($bundleitem->alert == 'no') 
                                  {
                                ?>
                                  <a class="btn blue btn_add_alert" item_id="<?php echo $bundleitem->id ?>" role="bundleitem" >No Alerts</a>
                                <?php
                                  }else{
                                    ?>
                                    <a class="btn btn-danger btn_add_alert" item_id="<?php echo $bundleitem->id ?>" role="bundleitem" ><?php echo $bundleitem->alert ?></a>
                                    <?php
                                  }
                                ?>
                                </td>

                                <td class="extra-height">
                                  <span class="onmobile centera"><?php echo $lang['Options']; ?></span>
                                  <div class="action-toggle" data-toggle="collapse" data-target="#client-menu<?php echo $recentProject->p_id;?>"><?php echo $lang['Options']; ?><i class="fa fa-caret-down"></i></div>
                                  <div id="client-menu<?php echo $recentProject->p_id;?>" class="toggle-action item_toggle collapse">
                                    <ul>
                                      <li>
                                          <button type="button" class="btn_add_qty" item_id="<?php echo $bundleitem->id ?>" role="bundleitem"> Receive Partial Units </button>
                                      </li>
                                      <li>
                                          <button type="button" class="btn_all_qty" item_id="<?php echo $bundleitem->id ?>" role="bundleitem"> Receive All Units </button>
                                      </li>
                                      <li>
                                        <button type="button" class="btn_begin_prepping" item_id="<?php echo $bundleitem->id ?>" role="bundleitem"> Begin Prepping All Units </button>
                                      </li>
                                      <li>
                                        <button type="button" class="btn_mark_completed" item_id="<?php echo $bundleitem->id ?>" role="bundleitem"> Mark Project Completed </button>
                                      </li>
                                    </ul>
                                  </div>
                                </td>
                            </tr>
                            <tr class="tr_detail">
                              <td colspan="5">
                                <table class="table-item-detail">
                                  <thead>
                                    <tr>
                                      <th>Status</th>
                                      <th>Qty</th>
                                      <th>Date</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                      $bundleitem_id = $bundleitem->id;
                                      $bundle_item_delivery_list = bundleitemsdelivery::findBySql("select * from bundleitems_delivery where bundleitem_id='$bundleitem_id'");
                                      $total_delivered_qty = 0;
                                      foreach ($bundle_item_delivery_list as $d_key => $bundle_item_delivery) {
                                        $total_delivered_qty += $bundle_item_delivery->qty;
                                    ?>
                                      <tr>
                                        <td>Deilvered</td>
                                        <td><?php echo $bundle_item_delivery->qty ?></td>
                                        <td>
                                          <?php 
                                            $date = new DateTime($bundle_item_delivery->delivery_date);
                                            $d_mon = (int)$date->format('m');
                                            $d_day = (int)$date->format('d');
                                            $d_year = $date->format('y');
                                            echo $d_mon . "|" . $d_day . "|" . $d_year;
                                          ?>    
                                        </td>
                                      </tr>
                                    <?php
                                      }

                                      $remain_delivery_qty = $bundleitem->bundle_qty - $total_delivered_qty;
                                    ?>

                                      <tr>
                                        <td>Awaiting Deilvery</td>
                                        <td colspan="2"><?php echo $remain_delivery_qty ?></td>
                                      </tr>

                                  </tbody>
                                </table>
                              </td>
                            </tr>
                            <input type="hidden" id="bundleitem_name_<?php echo $bundleitem->id ?>" value="<?php echo $bundleitem->name ?>">
                            <input type="hidden" id="bundleitem_remain_<?php echo $bundleitem->id ?>" value="<?php echo $remain_delivery_qty ?>">
                          <?php 
                             $counter++;  
                            }
                          ?>
                      </tbody>
                      </table>
                  </div>

              </div>
            </div>
        </div><!-- row -->
    </div>
  <div class="clearfix"></div>

<a data-toggle="modal" data-target="#add_qty" id="link_add_qty" style="display: none;"> Add new milestone <span>+</span></a>
<!-- Modal -->
<div id="add_qty" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" id="btn_close_qty_modal" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title modal-left" id="add_qty_title"> Add Qty </h4>
        </div>
        <div class="modal-body">
          <form method="post" class="add_qty_form" action="#" enctype="multipart/form-data">
                <div class="form-group">
                      <div class="col-sm-12">
                          <div class="field-label"><label for="">Add Qty</label></div>
                        <input type="number" name="qty" class="form-control item_input_qty" required>
                      </div>
                      <div class="clearfix"></div>
                  </div>
          <div class="form-group">
                      <div class="col-sm-12">
                      <input type="hidden" name="item_id" class="modal_item_id" />
                      <input type="hidden" name="role" class="item_role">
                      <input type="hidden" name="status" class="item_status">
                      <input type="button" name="add-milestone" value="Add" class="btn btn-primary float-right submit_add_qty"/>
            </div>
          </div>
                <div class="clearfix"></div> 
              </form>
          </div> 
      </div>
    </div>
</div> 

<a data-toggle="modal" data-target="#confirm_add_qty" id="link_confirm_modal" style="display: none;"> Add new milestone <span>+</span></a>
<!-- Modal -->
<div id="confirm_add_qty" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" id="btn_close_qty_modal" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title modal-left" id=""> Recieved Qty Confirmation </h4>
        </div>
        <div class="modal-body">
          <form method="post" class="add_qty_form" action="#" enctype="multipart/form-data">
                <div class="form-group">
                      <div class="col-sm-12">
                          <div class="field-label"><label for="">Received Qty</label></div>
                        <input type="number" name="qty" class="form-control item_confirm_qty" disabled="true">
                      </div>
                      <div class="clearfix"></div>
                  </div>
          <div class="form-group">
                      <div class="col-sm-12">
                      <input type="button" name="add-milestone" value="Add" class="btn btn-primary float-right submit_confirm_qty"/>
            </div>
          </div>
                <div class="clearfix"></div> 
              </form>
          </div> 
      </div>
    </div>
</div> 

<a data-toggle="modal" data-target="#confirm_begin_prepping" id="prepping_confirm_modal" style="display: none;"> Add new milestone <span>+</span></a>
<!-- Modal -->
<div id="confirm_begin_prepping" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" id="btn_close_qty_modal" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title modal-left" id=""> Begin Prepping All Units Confirmation </h4>
        </div>
        <div class="modal-body">
          <form method="post" class="add_qty_form" action="#" enctype="multipart/form-data">
            <div class="form-group">
                <div class="col-sm-12">
                    <p style="font-size: 18px;">
                      Are you sure to confirm to begin prepping all units?
                    </p>
                </div>
                <div class="clearfix"></div>
            </div>
          <div class="form-group">
                      <div class="col-sm-12">
                      <input type="button" name="add-milestone" value="Yes" class="btn btn-primary float-right submit_confirm_qty"/>
            </div>
          </div>
                <div class="clearfix"></div> 
              </form>
          </div> 
      </div>
    </div>
</div> 

<a data-toggle="modal" data-target="#confirm_completing_project" id="completing_confirm_modal" style="display: none;"> Add new milestone <span>+</span></a>
<!-- Modal -->
<div id="confirm_completing_project" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" id="btn_close_qty_modal" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title modal-left" id=""> Mark Project Completed Confirmation </h4>
        </div>
        <div class="modal-body">
          <form method="post" class="add_qty_form" action="#" enctype="multipart/form-data">
            <div class="form-group">
                <div class="col-sm-12">
                    <p style="font-size: 18px;">
                      Are you sure to confirm to mark project completed?
                    </p>
                </div>
                <div class="clearfix"></div>
            </div>
          <div class="form-group">
                      <div class="col-sm-12">
                      <input type="button" name="add-milestone" value="Yes" class="btn btn-primary float-right submit_confirm_qty"/>
            </div>
          </div>
                <div class="clearfix"></div> 
              </form>
          </div> 
      </div>
    </div>
</div> 

<a data-toggle="modal" data-target="#confirm_alert_project" id="alert_confirm_modal" style="display: none;"> Add new milestone <span>+</span></a>
<!-- Modal -->
<div id="confirm_alert_project" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" id="btn_close_qty_modal" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title modal-left" id=""> Alert </h4>
        </div>
        <div class="modal-body">
          <form method="post" class="add_qty_form" action="#" enctype="multipart/form-data">
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="field-label"><label for="">Please input alert content</label></div>
                    <input type="text" class="form-control alert_content">
                </div>
                <div class="clearfix"></div>
            </div>
          <div class="form-group">
                      <div class="col-sm-12">
                        <input type="hidden" class="alert_item_id">
                        <input type="hidden" name="" class="alert_item_role">
                      <input type="button" name="add-milestone" value="Yes" class="btn btn-primary float-right submit_item_alert"/>
            </div>
          </div>
                <div class="clearfix"></div> 
              </form>
          </div> 
      </div>
    </div>
</div> 

    
</div> 
</div> 
</div> 



<?php 
  }
?>      


<?php  include("../templates/admin-footer-payment.php"); 
?>
  <script type="text/javascript">
    var current_url = window.location.href;
     $(document).ready(function(){
        $(".icon_item_detail").click(function(){
          var main_tr = $(this).parents(".tr_main");
          var tr_detail = $(main_tr).next();
          if($(this).hasClass("detail")){
            $(this).removeClass("detail");
            $(this).html('<i class="fa fa-caret-right" aria-hidden="true">');
            tr_detail.slideUp();

          }else{
            $(this).addClass("detail");
            $(this).html('<i class="fa fa-caret-down" aria-hidden="true">');
            tr_detail.slideDown();
          }
      });

        $(".btn_add_qty").click(function(){
          var role = $(this).attr('role');
          if(role == 'item')
          {
            var item_id = $(this).attr('item_id');
            var item_name = $("#item_name_"+item_id).val();
            var item_remain_qty = $("#item_remain_"+item_id).val();
          }else if(role == 'bundleitem')
          {
            var item_id = $(this).attr('item_id');
            var item_name = $("#bundleitem_name_"+item_id).val();
            var item_remain_qty = $("#bundleitem_remain_"+item_id).val();
          }
          $("#add_qty_title").text(item_name);
          $(".item_input_qty").val(item_remain_qty);
          $(".modal_item_id").val(item_id);
          $(".item_role").val(role);
          $(".item_status").val('adding');
          $("#link_add_qty").trigger("click");
        });




        $(".submit_add_qty").click(function(){

          $("#btn_close_qty_modal").trigger("click");
          var input_qty = $(".item_input_qty").val();
          $(".item_confirm_qty").val(input_qty);
          $("#link_confirm_modal").trigger("click");

        });

        $(".submit_confirm_qty").click(function(){
          var base_dir = '<?php echo dirname($_SERVER["REQUEST_URI"]) ?>';
          var addform = $(".add_qty_form");
          $.ajax({
            type: "POST",
            url: $.base_url + 'ajax/add_delivery.php',
            data: addform.serialize(),
            error: function(err) {
              console.log(err);
            },
            success: function(data) {
              if(data*1 > 0)
              {
                window.location.replace(current_url);
              }
            }
          });  
        });

        $(".btn_all_qty").click(function(){
          var role = $(this).attr('role');
          if(role == 'item')
          {
            var item_id = $(this).attr('item_id');
            var item_name = $("#item_name_"+item_id).val();
            item_remain_qty = $("#item_remain_"+item_id).val();
          }else if(role == 'bundleitem')
          {
            var item_id = $(this).attr('item_id');
            var item_name = $("#bundleitem_name_"+item_id).val();
            item_remain_qty = $("#bundleitem_remain_"+item_id).val();
          }
          $("#add_qty_title").text(item_name);
          $(".item_input_qty").val(item_remain_qty);
          $(".modal_item_id").val(item_id);
          $(".item_role").val(role);
          $(".item_status").val('adding');
          $(".item_confirm_qty").val(item_remain_qty);
          $("#link_confirm_modal").trigger("click");
        });

        $(".btn_begin_prepping").click(function(){
          var role = $(this).attr('role');
          if(role == 'item')
          {
            var item_id = $(this).attr('item_id');
            var item_name = $("#item_name_"+item_id).val();
            item_remain_qty = $("#item_remain_"+item_id).val();
          }else if(role == 'bundleitem')
          {
            var item_id = $(this).attr('item_id');
            var item_name = $("#bundleitem_name_"+item_id).val();
            item_remain_qty = $("#bundleitem_remain_"+item_id).val();
          }

          $("#add_qty_title").text(item_name);
          $(".item_input_qty").val(item_remain_qty);
          $(".modal_item_id").val(item_id);
          $(".item_role").val(role);
          $(".item_status").val('prepping');

          $("#prepping_confirm_modal").trigger('click');
        });

        $(".btn_mark_completed").click(function(){
          var role = $(this).attr('role');
          if(role == 'item')
          {
            var item_id = $(this).attr('item_id');
            var item_name = $("#item_name_"+item_id).val();
            item_remain_qty = $("#item_remain_"+item_id).val();
          }else if(role == 'bundleitem')
          {
            var item_id = $(this).attr('item_id');
            var item_name = $("#bundleitem_name_"+item_id).val();
            item_remain_qty = $("#bundleitem_remain_"+item_id).val();
          }

          $("#add_qty_title").text(item_name);
          $(".item_input_qty").val(item_remain_qty);
          $(".modal_item_id").val(item_id);
          $(".item_role").val(role);
          $(".item_status").val('completed');
          $("#prepping_confirm_modal").trigger('click');
        });

        $(".btn_add_alert").click(function(){
          var item_id = $(this).attr('item_id');
          var role = $(this).attr('role');
          $(".alert_item_id").val(item_id);
          $(".alert_item_role").val(role);
          $("#alert_confirm_modal").trigger('click');
        });

        $(".submit_item_alert").click(function(){
          var base_dir = '<?php echo dirname($_SERVER["REQUEST_URI"]) ?>';
          var addform = $(".add_qty_form");
          $.ajax({
            type: "POST",
            url: $.base_url + 'ajax/add_delivery.php',
            data: {
              status: "add_alert",
              alert_content: $(".alert_content").val(),
              item_id: $(".alert_item_id").val(),
              role: $(".alert_item_role").val(),
              qty: 0
            },
            error: function(err) {
              console.log(err);
            },
            success: function(data) {
              console.log(data);
              if(data*1 > 0)
              {
                window.location.replace(current_url);
              }
            }
          });  
        });

      });

  </script>
<?php
$message = "";
?>