<?php
/**
 * Plugin Name: TIVWP-EMAIL
 * Plugin URI: https://github.com/TIVWP/tivwp-email
 * Description: Configure email settings (SMTP, etc.)
 * Version: 14.04.30
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

if ( ! empty( $GLOBALS['TIVWP']['EMAIL'] ) ) {
	require_once 'class-tivwp-email.php';
	$oTIVWP_Email = new TIVWP_Email( $GLOBALS['TIVWP']['EMAIL'] );
	unset( $GLOBALS['TIVWP']['EMAIL'] );

	if ( $oTIVWP_Email->get_smtp_enabled() ) {
		/**
		 * @see TIVWP_Email::filter__phpmailer_init__setup_smtp()
		 */
		add_filter( 'phpmailer_init',
			array(
				$oTIVWP_Email,
				'filter__phpmailer_init__setup_smtp'
			)
			, 10, 1
		);
	}

	if ( $oTIVWP_Email->get_mail_to() ) {
		/**
		 * @see TIVWP_Email::filter__wp_mail__force_mail_to()
		 */
		add_filter( 'wp_mail',
			array(
				$oTIVWP_Email,
				'filter__wp_mail__force_mail_to'
			)
			, 10, 1
		);
	}
}

# --- EOF