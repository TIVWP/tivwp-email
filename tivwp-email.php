<?php
/**
 * Plugin Name: TIVWP-EMAIL
 * Plugin URI: https://github.com/TIVWP/tivwp-email
 * Description: Configure email settings (SMTP, etc.)
 * Text Domain: tivwp-email
 * Domain Path: /languages/
 * Version: 14.05.01
 * Author: TIV.NET
 * Author URI: http://www.tiv.net
 * Network: false
 * License: GPL2
 */

/*  Copyright 2014 Gregory Karpinsky (tiv.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/*
 * This plugin does nothing unless a special global array is setup in wp-config
 *
 * Tip: wp-config can (and should) be different on development and production environments.
 *
 * Example:
 *
$GLOBALS['TIVWP']['EMAIL'] = array(
	// Using GMail SMTP
	'SMTP_ENABLED'  => true,
	'SMTP_HOST'     => 'smtp.gmail.com',
	'SMTP_PORT'     => '587',
	'SMTP_SECURE'   => 'tls',
	'SMTP_AUTH'     => true,
	'SMTP_USER'     => 'me@gmail.com',
	'SMTP_PASSWORD' => '*****',
	// Forcing all email sent to ... (better if not the same as the SMTP_USER)
	'MAIL_TO'       => 'me@hotmail.com',
);
*/
if ( empty( $GLOBALS['TIVWP']['EMAIL'] ) ) {
	return;
}

/**
 * Load the class, construct the object and destroy the wp-config global (do not need it anymore)
 * @global TIVWP_Email $oTIVWP_Email
 */
require_once 'class-tivwp-email.php';
$oTIVWP_Email = new TIVWP_Email( $GLOBALS['TIVWP']['EMAIL'] );
unset( $GLOBALS['TIVWP']['EMAIL'] );

/**
 * Setup SMTP if defined in config
 * @see TIVWP_Email::filter__phpmailer_init__setup_smtp()
 */
if ( $oTIVWP_Email->get_smtp_enabled() ) {
	add_filter( 'phpmailer_init', array(
		$oTIVWP_Email,
		'filter__phpmailer_init__setup_smtp'
	), 10, 1 );
}

/**
 * Force "To:" if defined in config
 * @see TIVWP_Email::filter__wp_mail__force_mail_to()
 */
if ( $oTIVWP_Email->get_mail_to() ) {
	add_filter( 'wp_mail', array(
		$oTIVWP_Email,
		'filter__wp_mail__force_mail_to'
	), 10, 1 );
}

/**
 * Make an admin page to send test email
 * @see TIVWP_Email::action__admin_menu()
 */
if ( is_admin() ) {
	add_action( 'admin_menu', array(
		$oTIVWP_Email,
		'action__admin_menu'
	) );
}

# --- EOF