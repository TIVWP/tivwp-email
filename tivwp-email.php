<?php
/**
 * Plugin Name: TIVWP-EMAIL
 * Plugin URI: https://github.com/TIVWP/tivwp-email
 * Description: Configure WordPress email settings (SMTP, MAIL_TO)
 * Text Domain: tivwp-email
 * Domain Path: /languages/
 * Version: 1.0.4
 * Author: TIV.NET
 * Author URI: https://www.tiv.net
 * License: GPL-3.0-or-later
 * License URI: https://spdx.org/licenses/GPL-3.0-or-later.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'TIVWP_EMAIL_VERSION', '1.0.4' );

/**
 * This plugin does nothing unless a special global array is setup in wp-config
 * *
 * Tip: wp-config can (and should) be different on development and production environments.
 * If you'd like to have only a part of wp-config different by server, you can create an additional file
 * and include it in the wp-config, like this:
 * <code>
 * require_once dirname( __FILE__ ) . '/tivwp-settings-local.inc.php';
 * </code>
 *
 * @example
 * <code>
 * $GLOBALS['TIVWP']['EMAIL'] = array(
 *      // Using GMail SMTP
 *      'SMTP_ENABLED'  => true,
 *      'SMTP_HOST'     => 'smtp.gmail.com',
 *      'SMTP_PORT'     => '587',
 *      'SMTP_SECURE'   => 'tls',
 *      'SMTP_AUTH'     => true,
 *      'SMTP_USER'     => 'me@gmail.com',
 *      'SMTP_PASSWORD' => '*****',
 *      // Forcing all email sent to ... (better if not the same as the SMTP_USER)
 *      'MAIL_TO'       => 'me@hotmail.com',
 *      // Prevent SSL certificate verify error on MS Windows.
 *      'SMTP_OPTIONS'  => array(
 *          'ssl' => array(
 *          'verify_peer'       => false,
 *          'verify_peer_name'  => false,
 *          'allow_self_signed' => true,
 *          )
 *      ),
 * );
 * </code>
 */

if ( empty( $GLOBALS['TIVWP']['EMAIL'] ) ) {
	return;
}

/**
 * Load the plugin Controller
 */
require_once dirname( __FILE__ ) . '/class-tivwp-email-controller.php';

/**
 * The Controller starts working when other plugins are loaded.
 */
add_action( 'plugins_loaded', array( 'TIVWP_Email_Controller', 'constructor' ) );
