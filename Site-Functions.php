<?php
//**********************************************************
//  SITE >> URL
// NOTES >> Return the current page URL.
//**********************************************************
function SITE_URL()
{
	$URL = isset( $_SERVER['HTTPS'] ) ? "https" : "http";
	$URL = $URL . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	return $URL;
}

//**********************************************************
// FUNCT >> Message
// PARAM >> String | Type
// PARAM >> String | Msg
// NOTES >> Generates JSON output and exits.
//**********************************************************
function Message( $Type = "Error", $Msg = '' )
{
	echo '{"type":"' . $Type . '", "message":"' . $Msg . '"}';
	exit; 
}

//**********************************************************
// FUNCT >> Domain Details
// PARAM >> String | Type
// NOTES >> Checks for parameters, returns values.
//**********************************************************
function Domain_Details( $Type = "Name" )
{
	$Domain_Name  = isset( $_GET['name']  ) ? $_GET['name']  : DOMAIN_NAME;
	$Domain_Price = isset( $_GET['price'] ) ? $_GET['price'] : DOMAIN_PRICE;

		if ( "Name"  === $Type ) echo $Domain_Name;
	elseif ( "Price" === $Type ) echo $Domain_Price;
}

//**********************************************************
// FUNCT >> Domain List
// NOTES >> output domain list form text file.
//**********************************************************
function Domain_List()
{
	$File = fopen( DOMAIN_LIST, "r" );
	$i = 1;
	
	if ( $File )
	{
		echo "<div id='Domains-List'><ul>";
	
		while ( FALSE !== ( $Line = fgets( $File ) ) )
		{
			$Line = trim( $Line );
			$Item = $Line;
						
			if ( strpos( $Item, "http" ) <= -1 )
				$Item = "http://" . $Item;
			
			echo "<li><span>$i.</span> <a href='$Item'>$Line</a></li>";
			$i = $i + 1;
		}
		
		echo "</ul></div>";
	}
	else
	{
		echo "<p>
			<i class='fa fa-warning'></i>
			<strong>File Read Error</strong><br />
			There was a problem opening the domain list file.
		</p>";
	}
}
?>