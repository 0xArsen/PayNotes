<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
<title>Confirmation</title>
<style>
body{
text-align: center;
}
h2{
margin-top:12%;
}
</style>
</head>

<?php 
include 'include.php';
error_reporting( E_ALL );
require_once "dropbox-sdk/lib/Dropbox/autoload.php";
use \Dropbox as dbx;
try{
$dbxClient = new dbx\Client("fI2UaAqQ3nAAAAAAAAAAjUbJObmrd4ldNkZ1i_11JZhAmKoz8zbs9aVmzVmGPfv6", "PHP-Example/1.0");
$accountInfo = $dbxClient->getAccountInfo();

}catch (Exception $e) {
 echo "drop box error try again";
}


$ID = $_GET['ID'];
$helper = $_GET['helper_email'];
$recipient = $_GET['requester_email'];
$course_name = $_GET['course_name'];
$paypal_link = $_POST['paypal_link'];
//Email Types:
// 1 : Request Accepted
// 2 : Request Processed
$e_type = $_GET['e_type'];
if($e_type == 1){
	$body = "Dear student, a helper has accepted your request. We will inform you when your notes are available for viewing. The note ID is " . $ID . " .";	
	$subject = "PayNotes: Request Accepted for " . $course_name . ".";
	$insert_q = "UPDATE maintable SET helper_email= '$helper' WHERE ID = $ID ";
	//echo $insert_q;
	$result_q= mysqli_query($conn, $insert_q) or die('Query failed: ' . mysqli_error($conn));
	$helper_subject = "PayNotes: Your request ID.";
	$helper_body = "Dear Helper, the ID for your task is " . $ID . ". Please upload your notes at arsenakishev.com/upload_file.php ";

}
else{
$ID = $_POST['ID'];
$paypal_link = $_POST['paypal_link'];
$file = $_FILES['fileToUpload']['tmp_name'];
 $filename = $_FILES['fileToUpload']['name'];
$f = fopen($file, "rb");
   $result = $dbxClient->uploadFile("/".$filename, dbx\WriteMode::add(), $f);
fclose($f);
$fff = $dbxClient->createShareableLink($result['path']);
		$body = "Dear Student, your helper has uploaded the notes  This is the paypal account of your helper " . $paypal_link . "  The link to the content is " . $fff . ". ";
		$subject = "PayNotes: Request Processes for Note ID:  " . $ID . "."; 

}
$AWSAccessKeyId = "AKIAIFTTM2RYDEAUQLIA";
$AWSSecretAccessKeyId = "kI5rLkruxhzJZlmTDTK42HVo1AN+n6ZtoHRKc7bZ";

// Replace path_to_sdk_inclusion with the path to the SDK as described in 
// http://docs.aws.amazon.com/aws-sdk-php/v2/guide/quick-start.html
define('REQUIRED_FILE','/var/www/html/vendor/autoload.php'); 
                                                  
// Replace sender@example.com with your "From" address. 
// This address must be verified with Amazon SES.
define('SENDER', 'paynotesapp@gmail.com');           

// Replace recipient@example.com with a "To" address. If your account 
// is still in the sandbox, this address must be verified.
$recipient = "arsenakishev@nyu.edu";
$helper = "msk610@nyu.edu";
$recipient_array = array( $recipient, $helper);
define('RECIPIENT', $recipient_array);    

// Replace us-west-2 with the AWS region you're using for Amazon SES.
define('REGION','us-east-1'); 

define('SUBJECT', $subject);
define('BODY',$body);

require 'vendor/autoload.php';

use Aws\Ses\SesClient;

$client = SesClient::factory(array(
    'version'=> 'latest',     
    'region' => REGION,
    'credentials' => array(
        'key'    => 'AKIAIFTTM2RYDEAUQLIA',
        'secret' => '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')
));

$request = array();
$request['Source'] = SENDER;
$request['Destination']['ToAddresses'] = $recipient_array;
$request['Message']['Subject']['Data'] = SUBJECT;
$request['Message']['Body']['Text']['Data'] = BODY;

try {
     $result = $client->sendEmail($request);
     $messageId = $result->get('MessageId');
     echo("<h2 class='alert alert-success'>Email sent! Happy note taking :)</h2>");

} catch (Exception $e) {
     echo("<h2 class='alert alert-danger'>The email was not sent. Try again :( </h2>");
     echo($e->getMessage()."\n");
}

//From here starts the other part to email the helper
//
//
//
//
//
/*
define('REQUIRED_FILE','/var/www/html/vendor/autoload.php'); 
                                                  
// Replace sender@example.com with your "From" address. 
// This address must be verified with Amazon SES.
define('SENDER', 'paynotesapp@gmail.com');           

// Replace recipient@example.com with a "To" address. If your account 
// is still in the sandbox, this address must be verified.
define('RECIPIENT', $helper);    

// Replace us-west-2 with the AWS region you're using for Amazon SES.
define('REGION','us-east-1'); 

define('SUBJECT', $helper_subject);
define('BODY',$helper_body);

require 'vendor/autoload.php';

use Aws\Ses\SesClient;

$client = SesClient::factory(array(
    'version'=> 'latest',     
    'region' => REGION,
    'credentials' => array(
        'key'    => 'AKIAIFTTM2RYDEAUQLIA',
        'secret' => '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')
));

$request = array();
$request['Source'] = SENDER;
$request['Destination']['ToAddresses'] = array(RECIPIENT);
$request['Message']['Subject']['Data'] = SUBJECT;
$request['Message']['Body']['Text']['Data'] = BODY;

try {
     $result = $client->sendEmail($request);
     $messageId = $result->get('MessageId');
     echo("<h2>Email sent! Happy note taking :)</h2>");

} catch (Exception $e) {
     echo("<h2>The email was not sent. Try again :( </h2>");
    // echo($e->getMessage()."\n");
}



*/

?>
<a class="btn btn-success" href="/">Return Home</a>
