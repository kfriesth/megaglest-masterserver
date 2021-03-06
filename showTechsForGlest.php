<?php
//	Copyright (C) 2012 Mark Vejvoda, Titus Tscharntke and Tom Reynolds
//	The MegaGlest Team, under GNU GPL v3.0
// ==============================================================

	define( 'INCLUSION_PERMITTED', true );

	require_once( 'registry.php' );
	require_once( 'config.php' );
	require_once( 'functions.php' );

	define( 'DB_LINK', db_connect() );

        if ( isset( $_GET['glestVersion'] ) ) {
            $glestVersion = (string) clean_str( $_GET['glestVersion'] );
        }
        else {
                $glestVersion = "";
        }

	$techs_in_db = mysqli_query( Registry::$mysqliLink, 'SELECT * FROM glesttechs WHERE disabled=0 ORDER BY techname;' );
	$all_techs = array();
	while ( $tech = mysqli_fetch_array( $techs_in_db ) )
	{
		array_push( $all_techs, $tech );
	}
	unset( $techs_in_db );
	unset( $tech );

	db_disconnect( Registry::$mysqliLink );

	// Representation starts here
	header( 'Content-Type: text/plain; charset=utf-8' );
	foreach( $all_techs as &$tech )
	{
                $itemVersion = 'v' . "${tech['glestversion']}";
                $addItem = false;

                if($glestVersion == '') {
                     if (version_compare("v3.6.0.3",$itemVersion,">=")) {
                        $addItem = true;
                     }
                }
                else if (version_compare($glestVersion,$itemVersion,">=")) {
                        $addItem = true;
                }

                if($addItem == true) {
	                if ( isset( $_GET['version'] )) { $mgversion = $_GET['version']; } else { $mgversion = ''; };
	                if($mgversion == '')
	                {
                    		$outString =
                    			"${tech['techname']}|${tech['factioncount']}|${tech['crc']}|${tech['description']}|${tech['url']}|${tech['imageUrl']}|";
                        }
                        else {
                    		$outString =
                    			"${tech['techname']}|${tech['factioncount']}|${tech['crcnew']}|${tech['description']}|${tech['url']}|${tech['imageUrl']}|";
                        }
            		$outString = $outString . "\n";
            		
            		echo ($outString);
                }
	}
	unset( $all_techs );
	unset( $tech );
?>

