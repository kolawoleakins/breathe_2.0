<?php

$from = 'Breathe Web App <hello@breathe.africa.com>';


$sendTo = 'Breathe Africa <hello@breathe.africa.com>'; 

$subject = 'New message from Deski';

$fields = array('Fname' => 'First Name', 'Lname' => 'Last Name', 'email' => 'Email', 'message' => 'Message'); 

$okMessage = 'Contact form successfully submitted. Thank you, We will get back to you soon!';

$errorMessage = 'There was an error while submitting the form. Please try again later';


// turn this off by error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);

try
{

    if(count($_POST) == 0) throw new \Exception('Form is empty');
            
    $emailText = "You have a new message from Breathe Web App\n=============================\n";

    foreach ($_POST as $key => $value) {
        // $fields array, include it in the email 
        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    // the necessary headers for the email.
    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    // Send email
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}


// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
// else just display the message
else {
    echo $responseArray['message'];
}

//simple as that by Kolawole Akinsumbo