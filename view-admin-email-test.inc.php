<?php
/**
 * View: Email Test admin page
 * @package tivwp-email
 * *
 * There are variables defined in the calling function,
 * @see     TIVWP_Email::menu_callback__email_test()
 * The 'globals' below tell PHPStorm that everything is fine, and there is no need to warn about undefined vars.
 * @global           $to
 * @global           $subject
 * @global           $body
 * @global           $config
 * *
 * PHPStorm does not know the type of $this, unless we tell it:
 * @type TIVWP_Email $this
 */
?>
<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<hr/>
	<h3><?php esc_html_e( 'We are ready to send a test email using a standard wp_mail() call:', 'tivwp-email' ); ?></h3>
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
			<th><?php esc_html_e( 'Configuration:', 'tivwp-email' ); ?></th>
			<td>
				<pre><?php var_dump( (array) $config ); ?></pre>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Host name:', 'tivwp-email' ); ?></th>
			<td><?php echo esc_html( $_SERVER['HTTP_HOST'] ); ?></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'IP address:', 'tivwp-email' ); ?></th>
			<td><?php echo esc_html( $_SERVER['REMOTE_ADDR'] ); ?></td>
		</tr>
		</tbody>
	</table>
	<p><?php esc_html_e( 'Please click the button below to send a test email:', 'tivwp-email' ); ?></p>

	<?php
	/**
	 * We are on the page /wp-admin/tools.php?page=tivwp-email-test
	 * There are global variables in the core that help us make the correct FORM action
	 * @global string $pagenow     That's the "/wp-admin/tools.php" part of the URL
	 * @global string $plugin_page This is the "tivwp-email-test" part
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
		<button class="button-primary" type="submit" name="send_email" id="send_email" value="<?php echo time(); ?>">
			<?php esc_html_e( 'Send Test Email', 'tivwp-email' ); ?>
		</button>
	</form>

</div>
