<?php


/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    CF7_Zoho_CMPG
 * @subpackage CF7_Zoho_CMPG/includes
 * @author     Nesho Sabakov <code@neshable.com>
 */
class CF7_Zoho_CMPG_Activator {

	
	public static function activate() {
		add_action('admin_notices', array(__CLASS__, 'mce_error') );
		
	}

	public static function mce_error() {

	  if( !file_exists( WP_PLUGIN_DIR.'/contact-form-7/wp-contact-form-7.php' ) ) {

	    $mce_error_out = '<div id="message" class="error is-dismissible"><p>';
	    $mce_error_out .= __('The Contact Form 7 plugin must be installed for the <b>MailChimp Extension</b> to work. <b><a href="'.admin_url('plugin-install.php?tab=plugin-information&plugin=contact-form-7&from=plugins&TB_iframe=true&width=600&height=550').'" class="thickbox" title="Contact Form 7">Install Contact Form 7  Now.</a></b>', 'mce_error');
	    $mce_error_out .= '</p></div>';
	    echo $mce_error_out;

	  } else if ( !class_exists( 'WPCF7') ) {

	    $mce_error_out = '<div id="message" class="error is-dismissible"><p>';
	    $mce_error_out .= __('The Contact Form 7 is installed, but <strong>you must activate Contact Form 7</strong> below for the <b>MailChimp Extension</b> to work.','mce_error');
	    $mce_error_out .= '</p></div>';
	    echo $mce_error_out;

	  }

	}

}
