<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');

class Settings extends DatabaseObject {
	
	protected static $tblName="settings";
	protected static $tblFields = array('url', 'company_name', 'syatem_title', 'login_page_title', 'copy_rights', 'system_currency', 'time_zone', 'favicon_image', 'login_page_logo', 'logo', 'mobile_logo', 'stripe_sk', 'stripe_pk', 'paypal_email', 'checkout_id', 'checkout_pk','system_email', 'forget_email', 'create_account_email', 'project_assign_email', 'assign_staff_email', 'project_update_email', 'system_language', 'version', 'purchase_code');
	
	public $url;
	public $company_name;
	public $syatem_title;
	public $login_page_title;
	public $copy_rights;
	public $system_currency;
	public $time_zone;
	public $favicon_image;
	public $login_page_logo;
	public $logo;
	public $mobile_logo;
	public $stripe_sk;
	public $stripe_pk;
	public $paypal_email;
	public $checkout_id;
	public $checkout_pk;
	public $system_email;
	public $forget_email;
	public $create_account_email;
	public $project_assign_email;
	public $assign_staff_email;
	public $project_update_email;
	public $system_language;
	public $version;
	public $purchase_code;
	
	public $message=NULL;	
	
	
public static function findById($useId="") {
    global $database;
		$sql  = "SELECT * FROM settings ";
		$sql .= "WHERE id = '{$useId}' ";
		$sql .= "LIMIT 1";
		$result_array = self::findBySql($sql);  // $result_array is an object
		
		return !empty($result_array) ? array_shift($result_array) : false;
			
	}
public $currency_symbols = array(
	'AUD,$' => 'AUD($)',
	'CAD,$;' => 'CAD($)',
	'GBP,£' => 'GBP(£)',
	'NZD,$' => 'NZD($)',
	'EUR,€' => 'EUR(€)',
	'USD,$' => 'USD($)',
	
);

}
?>