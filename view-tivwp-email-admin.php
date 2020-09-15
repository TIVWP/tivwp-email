<?php
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
	<hr/>
	<h2><?php esc_html_e( 'We are ready to send a test email using a standard wp_mail() call:', 'tivwp-email' ); ?></h2>
	<table class="wp-list-table widefat">
		<tbody>
		<tr>
			<th><?php esc_html_e( 'Recipient (admin email):', 'tivwp-email' ); ?></th>
			<td><?php echo esc_html( $to ); ?></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Recipient overwrite:', 'tivwp-email' ); ?></th>
			<td><?php echo esc_html( $this->get_mail_to() ? $this->get_mail_to() : __( 'Not specified', 'tivwp-email' ) ); ?></td>
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
					<pre>
						<?php
						$config_display                = $this->config;
						$config_display->SMTP_PASSWORD = str_repeat( '*', strlen( $config_display->SMTP_PASSWORD ) ); // phpcs:ignore WordPress.NamingConventions

						$fn = 'print_r';
						$fn( $config_display );
						unset( $config_display );
						?>
					</pre>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Host name:', 'tivwp-email' ); ?></th>
			<td>
				<?php
				if ( isset( $_SERVER['HTTP_HOST'] ) ) {
					echo esc_html( wp_unslash( $_SERVER['HTTP_HOST'] ) );
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
		<input type="hidden" name="page" id="page" value="<?php echo esc_attr( $plugin_page ); ?>"/>
		<?php
		/**
		 * The submit button's value serves as a cache buster
		 */
		?>
		<button class="button-primary" type="submit" name="send_email" id="send_email"
				value="<?php echo esc_attr( time() ); ?>">
			<?php
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo TIVWP_Email::ICON_EMAIL;
			esc_html_e( 'Send Test Email', 'tivwp-email' );
			?>
		</button>
	</form>
</div>
