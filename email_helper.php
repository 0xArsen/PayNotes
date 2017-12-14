<?php 
error_reporting( E_ALL );
$recipient = $_GET['requester_email'];
$
$AWSAccessKeyId = "";
$AWSSecretAccessKeyId = "";

// Replace path_to_sdk_inclusion with the path to the SDK as described in 
// http://docs.aws.amazon.com/aws-sdk-php/v2/guide/quick-start.html
define('REQUIRED_FILE','/Applications/MAMP/htdocs/vendor/autoload.php'); 
                                                  
// Replace sender@example.com with your "From" address. 
// This address must be verified with Amazon SES.
define('SENDER', 'aa4202@nyu.edu');           

// Replace recipient@example.com with a "To" address. If your account 
// is still in the sandbox, this address must be verified.
define('RECIPIENT', 'msk610@nyu.edu');    

// Replace us-west-2 with the AWS region you're using for Amazon SES.
define('REGION','us-east-1'); 

define('SUBJECT','PayNotes: Your notes are available for access.');
define('BODY','Dear _USer_ ,\n Another user has accepted your request.\n We will inform you when your notes have been uploaded.');

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
     echo("Email sent! Message ID: $messageId"."\n");

} catch (Exception $e) {
     echo("The email was not sent. Error message: ");
     echo($e->getMessage()."\n");
}

?>
