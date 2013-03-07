<?php
/*
Plugin Name: xwolf Anti-Censorship Worldday 2013
Plugin URI: http://piratenkleider.xwolf.de/plugins/xwolf-anticensorship-worldday2013
Description: Plugin enables to go dark on the world day against cyber-censorship 2013 
Tags:  Internet Censorship, Worldday 2013
Plugin URI: https://github.com/xwolfde/xwolf-anticensorship-worldday2013
Donate link: https://flattr.com/donation/give/to/xwolf
Version: 1.0
Author: xwolf
Author URI: http://blog.xwolf.de
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/



/**
 * Define Constants 
 */
define("XW_PROTEST_URL", 'http://www.piratenpartei.de/2013/03/10/welttag-gegen-internetzensur-die-feinde-des-internets/');
define("XW_PROTEST_pages", "1");
define("XW_TESTMODE", true);
define("XW_PROTEST_year", '2013');
define("XW_PROTEST_month", '03');
define("XW_PROTEST_day", '12');
define("XW_PROTEST_date", '2013-03-12');
define("XW_PROTEST_timestart",  8);
define("XW_PROTEST_timeend",  20);
define("XW_PROTEST_timezone", null);



function xw_protest_init() {
	$xw_protest_path = plugin_dir_url( __FILE__ );
	 if (xw_protest_checkdate()) {
	    if ( !is_admin() ) { // don't load this if we're in the backend
		
	//	if (((XW_PROTEST_pages == 1) && (is_home() || is_front_page()) ) 
	//	    || (XW_PROTEST_pages == 2)) {    
		    wp_register_style( 'xw_protest_css', $xw_protest_path . 'protest.css' );
		    wp_enqueue_style( 'xw_protest_css' );
		    add_action('wp_footer', 'xw_protest_footercode');
	//	}
	    } 
	 }
 //       load_plugin_textdomain('xw-protest', '', dirname(plugin_basename(__FILE__)) . '/lang' ); 
}
add_action( 'init', 'xw_protest_init' );

function xw_protest_checkdate(){
	if(XW_PROTEST_timezone){
		date_default_timezone_set(XW_PROTEST_timezone);
	}
	$toreturn = false;
	if (XW_TESTMODE) {
	    return true;
	}
	if(date('Y-m-d')==XW_PROTEST_year.'-'.sprintf('%02d',XW_PROTEST_month).'-'.sprintf('%02d',XW_PROTEST_day)){
		if(date('H')>=XW_PROTEST_timestart && date('H')<XW_PROTEST_timeend){
			$toreturn = true;
		}
	}
	return $toreturn;
}


function xw_protest_footercode() {
    $xw_protest_path = plugin_dir_url( __FILE__ );
	echo '<script type="text/javascript">
	/* <![CDATA[ */';
	echo '$(function () {  $(\'body\').append($(
        \'<div id=\"protest\"><div><a href=\"#\" class=\"close\">X</a>\' +
        \'<a class=\"link\" href=\"';
	echo XW_PROTEST_URL;
	echo '\"><img src=\"';
	echo $xw_protest_path.'link.png\" /></a>\' +
        \'</div></div>\'
	));

    $(\'#protest\').css(\'height\', $(window).height());

    $(\'#protest .close\').click(function () {
    	$(\'#protest\').fadeOut();
    	return false;
    });

 $(\'#protest\').fadeIn();
});

$(window).bind(\'resize\', function(){
 	$(\'#protest\').css(\'height\', $(window).height());
});

    ';
    
	echo '/* ]]> */
      </script> ';
}

