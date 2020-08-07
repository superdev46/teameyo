<?php
/*
////////////// Teameyo Project Management System  //////////////////////
//////////////////// Download Invoice Page  //////////////////////////
*/
ob_start();
include("../includes/lib-initialize.php");
require_once('../includes/TCPDF/tcpdf.php');
$edit_id1=$_POST['milestone_id'];

function fetch_data($edit_id1){
	$dash_settings = settings::findById(1);
	$company_namea = $dash_settings->company_name;
	$system_currency = $dash_settings->system_currency;
	$url = $dash_settings->url;	
$logo_check = $dash_settings->logo;
if($logo_check){
	$logo = $logo_check;
}else{
	$logo = 'client-side-logo.png';
}
$company_name = $dash_settings->company_name;
	$sc_arr = explode(",",$system_currency);
	$currency_symbol = $sc_arr[1];
	$currency = $sc_arr[0];
$latestMile1=milestone::findByMilestoneId($edit_id1);
$latestProj1=projects::findByProjectId($latestMile1->p_id);
$latestUser1=user::findById($latestProj1->c_id);	  
$adminUser1=user::findById(1);
$firstName = $latestUser1->firstName;
$address = $latestUser1->address;
$deadline = $latestMile1->deadline;
$InvoiceNo = $latestMile1->p_id . $latestMile1->id;
global $lang;
if($latestMile1->status == 0){
$statusa = '<font color="#ff0000">'.$lang['Unpaid'].'</font>'; 
} else {
$statusa ='<font color="#00c82a">'.$lang['Paid'].'</font>';
}
$adminAddress = $adminUser1->address;
$project_title = $latestProj1->project_title;
$miletitle = $latestMile1->title;
$mileBudget = $currency_symbol.$latestMile1->budget;
$imapePath = '../images/users/'.$logo;

$output = '';
$output   .=  '<style>
                .bordercss{
border-bottom:#e7e7e7 1px solid;
                }
                </style>';
$output .= '<table><tr><td><br><br>';
$output .= '<img src="'.$imapePath.'"/>';
$output .= '</td><td align="right"><br><br><font size="30"><b>'.$lang['INVOICE'].'</b></font></td></tr><tr><td colspan="2"><br><br></td></tr><tr><td><font color="#5fbaff">'.$lang['BILL FROM:'].' </font><br>';
$output .= '<b>'.$firstName . '</b><br>';
$output .= $address;
$output .= '</td><td align="right">'.$lang['Due Date'].':';
$output .= $deadline . '<br>';
$output .= $lang['Invoice No'].':';
$output .= $InvoiceNo . '<br>';
$output .= $lang['Status'].':';
$output .= $statusa . '<br>';
$output .= '</td></tr>';
$output .= '<tr><td colspan="2">&nbsp;<br></td></tr>';
$output .= '<tr><td><font color="#5fbaff">'.$lang['TO:'].'</font>';
$output .= '<br><b>' . $company_namea . '</b><br>';
$output .= $adminAddress . '<br>';
$output .= '</td><td></td></tr>';
$output .= '<tr><td colspan="2">&nbsp;<br></td></tr>';
$output .= '<tr><td colspan="2"><b>'.$lang['Project'].': </b>';
$output .= $project_title;
$output .= '</td></tr>';
$output .= '<tr><td colspan="2">&nbsp;<br></td></tr>';
$output .= '<tr><td>Milestone Name</td><td align="right">'.$lang['Total'].'</td></tr>';
$output .= '<tr><td colspan="2"><div class="bordercss"></div></td></tr>';
$output .= '<tr><td colspan="2"><br><br></td></tr>';
$output .= '<tr><td>';
$output .= '<font size="20"><b>' . $miletitle . '</b></font>';
$output .= '</td><td align="right">';
$output .= '<font size="20"><b>'. $mileBudget . '</b></font>';
$output .= '</td></tr>';
$output .= '<tr><td colspan="2"><br></td></tr>';
$output .= '<tr><td colspan="2"><div class="bordercss"></div></td></tr>';
$output .= '<tr><td colspan="2"><br><br></td></tr>';
$output .= '<tr><td colspan="2" align="right"><font size="20"><b>'.$lang['SUBTOTAL:'].'</b></font> <font color="#5fbaff" size="20"><b>';
$output .= $mileBudget;
$output .= '</b></font></td></tr>';
$output .= '<tr><td colspan="2"><br><br><br><br><br><br><br><br></td></tr>';
$output .= '<tr><td><font color="#5fbaff">'.$lang['Note'].'</font><br><font size="10">'.$lang['Thank you for business with us. We feel great to help in you digital services.'].'</font></td><td align="right"><font color="#5fbaff">'.$company_name.'</font><br><font size="10">';
$output .= $adminAddress;
$output .= '</font><br><a href="'.$url.'">'.$url.'</a></td></tr>';
$output .= '</table>';

return $output;
}
$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
 $obj_pdf->SetCreator(PDF_CREATOR);  
      $obj_pdf->SetTitle("Invoice");  
      $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
      $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
      $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
      $obj_pdf->SetDefaultMonospacedFont('helvetica');  
      $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
      $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
      $obj_pdf->setPrintHeader(false);  
      $obj_pdf->setPrintFooter(false);  
      $obj_pdf->SetAutoPageBreak(TRUE, 10);  
      $obj_pdf->SetFont('helvetica', '', 12);  
      $obj_pdf->AddPage();
	  $obj_pdf->setJPEGQuality(75);
	  $obj_pdf->setImageScale(1.53);

$content = '';
$content .= fetch_data($edit_id1);

$obj_pdf->writeHTML($content);
$obj_pdf->Output('invoice.pdf', 'I');
?>