<?php
/**
 * View: Email Test admin page
 * @package tivwp-email
 * These variables are defined in the calling function
 * @see     TIVWP_Email::menu_callback__email_test()
 * @global $to
 * @global $subject
 * @global $body
 * @global $config
 */
?>
<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<hr/>
	<h3><?php esc_html_e( 'Trying to send a test email using a standard wp_mail() call:', 'tivwp-email' ); ?></h3>
	<table class="wp-list-table widefat">
		<tbody>
		<tr>
			<th><?php esc_html_e( 'Recipient (admin email):', 'tivwp-email' ); ?></th>
			<td><?php echo $to; ?></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Subject:', 'tivwp-email' ); ?></th>
			<td><?php echo $subject; ?></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Body:', 'tivwp-email' ); ?></th>
			<td><?php echo $body; ?></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Configuration:', 'tivwp-email' ); ?></th>
			<td>
				<pre><?php var_dump( (array) $config ); ?></pre>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Host name:', 'tivwp-email' ); ?></th>
			<td><?php echo $_SERVER['HTTP_HOST']; ?></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'IP address:', 'tivwp-email' ); ?></th>
			<td><?php echo $_SERVER['REMOTE_ADDR']; ?></td>
		</tr>
		</tbody>
	</table>
	<?php wp_mail( $to, $subject, $body ); ?>
</div>
