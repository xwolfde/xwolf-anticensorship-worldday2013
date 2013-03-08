<?php
/*
Plugin Name: Notice for the world day against cyber censorship 2013
Plugin URI: http://piratenkleider.xwolf.de/plugins/anticensorship-worldday2013
Description: Simple Plugin which enables a dark colored notice for the world day against cyber-censorship 2013 (between hours: 8 - 20). Read nore on:  http://www.reporter-ohne-grenzen.de. Plugin was made by the Pirate Party Germany to use in wordpress related sites. 
Tags:  Internet Censorship, Worldday 2013, cyber censorship
Plugin URI: https://github.com/xwolfde/xwolf-anticensorship-worldday2013
Version: 1.0.1
Author: xwolf
Author URI: http://blog.xwolf.de
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/



/**
 * Define Constants 
 */
define("XW_PROTEST_URL", 'http://www.piratenpartei.de/2013/03/07/welttag-gegen-internetzensur-2013/');
define("XW_PROTEST_IMAGE", 'protest.png');
define("XW_PROTEST_ALTTEXT", 'Welttag gegen Internetzensur - 12.03. International Blackour Day');
define("XW_PROTEST_LONGTEXT", 'Wir zeigen uns solidarisch mit allen durch Überwachung und Zensur eingeschränkten Journalisten und Aktivisten weltweit. Die Organisationen Reporter ohne Grenzen und die Piratenpartei rufen am Welttag gegen Internetzensur zu Protesten auf. ');
define("XW_PROTEST_MORE", 'Weitere Informationen bei <a href="http://www.reporter-ohne-grenzen.de/">Reporter ohne Grenzen</a>. <a href="http://wiki.piratenpartei.de/Welttag-gegen-Internetzensur-2013">Informationen, sowie Plugins und Banner</a> zur Teilnahme finden sich auf dem Wiki der Piratenpartei Deutschland.');

define("XW_PROTEST_usecookie", true);
define("XW_PROTEST_cookiename", 'seen_worldday2013');

define("XW_TESTMODE", false);
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
	    if ( xw_see_check() ) { 				
		    wp_register_style( 'xw_protest_css', $xw_protest_path . 'protest.css' );
		    wp_enqueue_style( 'xw_protest_css' );
		    add_action('wp_footer', 'xw_protest_footercode');
                    if ( XW_PROTEST_usecookie )
				setcookie( XW_PROTEST_cookiename, 1, 0, '/' );
		
	    } 
	 }
 //       load_plugin_textdomain('xw-protest', '', dirname(plugin_basename(__FILE__)) . '/lang' ); 
}
add_action( 'init', 'xw_protest_init' );


function xw_see_check() {
    
    if (is_admin()) {
        return false;
    }    
    if (XW_TESTMODE) {
	    return true;
	}
    if ( isset( $_COOKIE ) && array_key_exists( XW_PROTEST_cookiename, $_COOKIE ) && (XW_PROTEST_usecookie) ) {		
		return false;
     }

    return true;
}
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
	echo '\"><img width=\"400\" height=\"300\" src=\"';
	echo $xw_protest_path.XW_PROTEST_IMAGE.'\"';
        if (XW_PROTEST_ALTTEXT) { echo ' alt=\"'.XW_PROTEST_ALTTEXT.'\"'; }
        if (XW_PROTEST_LONGTEXT) { echo ' longdesc=\"'.XW_PROTEST_LONGTEXT.'\"'; }
        echo '></a>\' + ';
        if (XW_PROTEST_MORE) { echo '\'<p class=\"more\">'.XW_PROTEST_MORE.'</p>\' + '; } 
            
        echo '\'</div>';
        echo '</div>\' )); ';
        echo '

    $(\'#protest\').css(\'height\', $(window).height());

    $(\'#protest .close\').click(function () {
    	$(\'#protest\').fadeOut();
    	return false;
    });
    if ($(window).width() >= 600) {
	$(\'#protest\').fadeIn();
    }
});

$(window).bind(\'resize\', function(){
 	$(\'#protest\').css(\'height\', $(window).height());
});

    ';
    
	echo '/* ]]> */
      </script> ';
}

/**
 * Install or update plugin
 */
function xw_protest_install() {
    /* Nothing yet */

}
/**
 * deactivate plugin
 */
function xw_protest_uninstall() {
    /* Nothing yet */
    
}

register_activation_hook(__FILE__, 'xw_progressbar_install');
register_deactivation_hook(__FILE__, 'xw_progressbar_uninstall');