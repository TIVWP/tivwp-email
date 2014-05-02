<?php

/**
 * Plugin Controller
 * @package tivwp-email
 */
class TIVWP_Email_Controller {

	/**
	 * Everything happens here.
	 */
	public static function action__wp_loaded() {

		/**
		 * Load the Model
		 */
		require_once dirname( __FILE__ ) . '/class-tivwp-email.php';

		/**
		 * Construct the Model object.
		 * Note: we already checked the existence of the global configuration in the main plugin file
		 */
		$model = new TIVWP_Email( $GLOBALS['TIVWP']['EMAIL'] );

		/**
		 * Destroy the global config (do not need it anymore).
		 */
		unset( $GLOBALS['TIVWP']['EMAIL'] );

		/**
		 * Setup SMTP if defined in config
		 * @see TIVWP_Email::filter__phpmailer_init__setup_smtp()
		 */
		if ( $model->get_smtp_enabled() ) {
			add_filter( 'phpmailer_init', array(
				$model,
				'filter__phpmailer_init__setup_smtp'
			), 10, 1 );
		}

		/**
		 * Force "To:" if defined in config
		 * @see TIVWP_Email::filter__wp_mail__force_mail_to()
		 */
		if ( $model->get_mail_to() ) {
			add_filter( 'wp_mail', array(
				$model,
				'filter__wp_mail__force_mail_to'
			), 10, 1 );
		}

		/**
		 * Make an admin page to send test email
		 * @see TIVWP_Email::action__admin_menu()
		 */
		if ( is_admin() ) {
			add_action( 'admin_menu', array(
				$model,
				'action__admin_menu'
			) );
		}

	}

} // class

# --- EOF