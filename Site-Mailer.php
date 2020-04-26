<?php
//*************************************************************
// Server Settings
//*************************************************************
//ini_set( "display_errors", 1 );

ini_set("SMTP","ssl:smtp.gmail.com" );

//error_reporting(E_ALL|E_STRICT|E_NOTICE);
date_default_timezone_set( "UTC" );

//*************************************************************
// Include Config / Functions
//*************************************************************
include_once( "Site-Config.php"    );
include_once( "Site-Functions.php" );

//*************************************************************
// Contact Form Field Values
//*************************************************************
$Form_Name    = $_POST['Name'];
$Form_EMail   = $_POST['EMail'];
$Form_Phone   = $_POST['Phone'];
$Form_Offer   = $_POST['Offer'];
$Form_Message = $_POST['Message'];
$Form_Captcha = $_POST['g-recaptcha-response'];

//*************************************************************
// Field Validation
//*************************************************************
	if ( REQUIRED_NAME    && '' == $Form_Name    ) Message( "Error", "Please enter your name." );
elseif ( REQUIRED_EMAIL   && '' == $Form_EMail   ) Message( "Error", "Please enter your e-mail address." );
elseif ( REQUIRED_PHONE   && '' == $Form_Phone   ) Message( "Error", "Please enter your phone number." );
elseif ( REQUIRED_OFFER   && '' == $Form_Offer   ) Message( "Error", "Please enter an offer / bid." );
elseif ( REQUIRED_MESSAGE && '' == $Form_Message ) Message( "Error", "Please enter a message." );

//*************************************************************
// ReCAPTCHA Validation
//*************************************************************
if ( CAPTCHA_ENABLED )
{
	if ( '' === $Form_Captcha )
		Message( "Error", "CAPTCHA Test Failed" );
	else
	{
		$Recaptcha_URL = "https://www.google.com/recaptcha/api/siteverify";
		$Recaptcha = array(
			"secret"   => CAPTCHA_KEY_PRIVATE,
			"response" => $Form_Captcha,
			"remoteip" => $_SERVER['REMOTE_ADDR']
		);
	
		$Res = Get_CURL_Data( $Recaptcha_URL, $Recaptcha );
		$Res = json_decode( $Res );
	
		if ( "false" === $Res->success )
			Message( "Error", "CAPTCHA Test Failed" );
	}
}

//*************************************************************
// FUNCT >> Get CURL Data
// PARAM >> String | URL
// PARAM >> Array  | Data
// NOTES >> Get reCAPTCHA data from remote server.
//*************************************************************
function Get_CURL_Data( $URL, $Data )
{
	$Str = '';
	foreach ( $Data as $key=>$value ) { $Str .= $key . "=" . $value . "&"; }
	rtrim( $Str, "&" );

	$CURL = curl_init();
	curl_setopt( $CURL, CURLOPT_URL, $URL );
	curl_setopt( $CURL, CURLOPT_RETURNTRANSFER, TRUE );
	curl_setopt( $CURL, CURLOPT_TIMEOUT, 30 );
	curl_setopt( $CURL, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16" );
	curl_setopt( $CURL, CURLOPT_SSL_VERIFYPEER, FALSE );
	curl_setopt( $CURL, CURLOPT_POST, count( $Data ) );
	curl_setopt( $CURL, CURLOPT_POSTFIELDS, $Str );
	$CURL_Data = curl_exec( $CURL );	
	curl_close( $CURL );
	return $CURL_Data;
}

//*************************************************************
// Setup E-Mail
//*************************************************************
$Headers  = "MIME-Version: 1.0\n";
$Headers .= "From: $Form_Name <$Form_EMail>\n";
$Headers .= "Content-Type: text/plain; charset=iso-8859-1";

$Message  = "Domain: " . $_SERVER['SERVER_NAME'] . "\n\n";
$Message .= "- - - - -\n\n";
$Message .= "Name: $Form_Name\n\n";
$Message .= "Email Address: $Form_EMail\n\n";
$Message .= "Phone Number: $Form_Phone\n\n";
$Message .= "Offer / Bid: $Form_Offer\n\n";
$Message .= "Message:\n";
$Message .= wordwrap( $Form_Message, 70, "\n" );

mail( FORM_EMAIL, FORM_SUBJECT, $Message, $Headers );

Message( "Success", "Message Sent! We will reply as soon as we can." );
?>