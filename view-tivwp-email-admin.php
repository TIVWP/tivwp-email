<?php
/**
 * File: view-tivwp-email-admin.php
 *
 * @package TIVWP-Email
 */

/**
 * View: Email Test admin page
 * *
 * There are variables defined in the calling function.
 *
 * @see     TIVWP_Email::menu_callback__email_test()
 * The 'globals' below tell PHPStorm that everything is fine, and there is no need to warn about undefined vars.
 * @global string    $to
 * @global string    $subject
 * @global string    $body
 * @global stdClass  $config
 * *
 * PHPStorm does not know the type of $this, unless we tell it:
 * @type TIVWP_Email $this
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<div class="wrap">

	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<hr />
	<h2><?php esc_html_e( 'We are ready to send a test email using a standard wp_mail() call:', 'tivwp-email' ); ?></h2>
	<table class="wp-list-table widefat">
		<tbody>
		<tr>
			<th><?php esc_html_e( 'Recipient (admin email):', 'tivwp-email' ); ?></th>
			<td><?php echo esc_html( $to ); ?></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Recipient overwrite:', 'tivwp-email' ); ?></th>
			<td><?php /** @noinspection ElvisOperatorCanBeUsedInspection */
				echo esc_html( $this->get_mail_to() ? $this->get_mail_to() : __( 'Not specified', 'tivwp-email' ) ); ?></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Subject:', 'tivwp-email' ); ?></th>
			<td><?php echo esc_html( $subject ); ?></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Body:', 'tivwp-email' ); ?></th>
			<td><?php echo esc_html( $body ); ?></td>
		</tr>
		<tr>
			<th style="vertical-align: top"><?php esc_html_e( 'Configuration:', 'tivwp-email' ); ?></th>
			<td>
					<pre><?php
						$_config_display                = $this->_config;
						$_config_display->SMTP_PASSWORD = str_repeat( '*', strlen( $_config_display->SMTP_PASSWORD ) );
						/** @noinspection ForgottenDebugOutputInspection */
						print_r( $_config_display );
						unset( $_config_display );
						?></pre>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Host name:', 'tivwp-email' ); ?></th>
			<td>
				<?php
				/**
				 * For the explanation of the end-line comments, see
				 * https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/406
				 */
				if ( isset( $_SERVER['HTTP_HOST'] ) ) { // Input var okay.
					echo esc_html( wp_unslash( $_SERVER['HTTP_HOST'] ) ); // Input var okay; sanitization okay.
				}
				?>
			</td>
		</tr>
		</tbody>
	</table>
	<p><?php esc_html_e( 'Please click the button below to send a test email:', 'tivwp-email' ); ?></p>

	<?php
	/**
	 * We are on the page /wp-admin/tools.php?page=tivwp-email-test.
	 * There are global variables in the core that help us make the correct FORM action.
	 *
	 * @global string $pagenow     That's the "/wp-admin/tools.php" part of the URL.
	 * @global string $plugin_page This is the "tivwp-email-test" part.
	 */
	global $pagenow, $plugin_page;
	?>
	<form action="<?php echo esc_attr( $pagenow ); ?>">
		<input type="hidden" name="page" id="page" value="<?php echo esc_attr( $plugin_page ); ?>" />
		<?php
		/**
		 * The submit button's value serves as a cache buster
		 */
		?>
		<button class="button-primary" type="submit" name="send_email" id="send_email" value="<?php echo esc_attr( time() ); ?>">
			<?php
			/**
			 * About `XSS okay` comment.
			 *
			 * @link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/wiki/Whitelisting-code-which-flags-errors
			 */
			echo $this->_icon_email; // WPCS: XSS okay.
			?>
			<?php esc_html_e( 'Send Test Email', 'tivwp-email' ); ?>
		</button>
	</form>

</div>
