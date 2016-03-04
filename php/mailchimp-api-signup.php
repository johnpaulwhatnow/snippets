<?php 

if(!empty($_POST)){
require_once('Mailchimp/src/Mailchimp.php');

//config for MC API
$mailchimp_account_api = '';
$mailchimp_list_id = '';

	$email = array('email'=>$_POST['email']);
	//optional first and last name
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];

	$mailchimp = new Mailchimp($mailchimp_account_api); 

	//$list = $mailchimp->lists->interestGroupings($mailchimp_list_id);

	//message
	$message = null;

	$merge_array =array(

			'FNAME'=>$first_name,
			'LNAME'=>$last_name,
		);
	try {
	//subscribe($id, $email, $merge_vars=null, $email_type='html', $double_optin=true, $update_existing=false, $replace_interests=true, $send_welcome=false) 
		$result = $mailchimp->lists->subscribe($mailchimp_list_id, $email, null, 'html', false, $update_existing=true, $replace_interests=true, $send_welcome=false);

	} catch (Mailchimp_Error $e) {
		if ($e->getMessage()) {
			$message = $e->getMessage();
			$message_type = ' fail';
		} else {
			$message = 'An unknown error occurred';
			$message_type = ' fail';

		}
	}
	
	$response = array();
	
	//var_dump($result);

	if ( empty($message)   ){
		$response['status'] = 1;
		$response['message'] = 'Thank you for signing up!'; 
	} else{
		$response['status'] = 0;
		$response['message'] = $message; 	
	}
	
	header('Content-Type: application/json');
	echo json_encode($response);
	exit();

}//end post


?>