<?php
/**
 * File: tivwp-email.php
 *
 * @package TIVWP-Email
 */

/**
 * Plugin Name: TIVWP-EMAIL
 * Plugin URI: https://github.com/TIVWP/tivwp-email
 * Description: Configure email settings (SMTP, etc.)
 * Text Domain: tivwp-email
 * Domain Path: /languages/
 * Version: 1.0.3
 * Author: TIV.NET
 * Author URI: http://www.tiv.net
 * Network: false
 * License: GPL2
 */

/**
 * Copyright 2014-16 Gregory Karpinsky (tiv.net)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

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
 *
 * @see TIVWP_Email_Controller::constructor
 */
add_action( 'plugins_loaded', 'TIVWP_Email_Controller::constructor' );

/*EOF*/
