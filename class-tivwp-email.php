<?php
/**
 * File: class-tivwp-email.php
 *
 * @package TIVWP-Email
 */

/**
 * Class TIVWP_Email
 */
class TIVWP_Email {

	/**
	 * Admin area permission.
	 *
	 * @var string
	 */
	const MIN_CAPABILITY = 'activate_plugins';

	/**
	 * Admin area menu slug.
	 *
	 * @var string
	 */
	const MENU_SLUG_EMAIL_TEST = 'tivwp-email';

	/**
	 * Configuration object.
	 *
	 * @var stdClass
	 */
	private $config;

	/**
	 * Icon for admin menu.
	 * The icons in dashicons.css are top-aligned; Aligning to the middle works better with buttons.
	 *
	 * @var string
	 */
	const ICON_EMAIL = '<span class="dashicons dashicons-email" style="vertical-align:middle"></span>';

	/**
	 * Constructor
	 * Initializes the configuration object
	 *
	 * @param array $config The configuration array.
	 */
	public function __construct( array $config = array() ) {
		$this->config = (object) $config;
	}

	/**
	 * Get configuration value SMTP_ENABLED.
	 *
	 * @return bool
	 */
	public function get_smtp_enabled() {
		return ( isset( $this->config->SMTP_ENABLED ) ? $this->config->SMTP_ENABLED : false );
	}

	/**
	 * Get configuration value MAIL_TO.
	 *
	 * @return string
	 */
	public function get_mail_to() {
		return ( isset( $this->config->MAIL_TO ) ? $this->config->MAIL_TO : '' );
	}

	/**
	 * Setup PHPMailer.
	 *
	 * @param \PHPMailer\PHPMailer\PHPMailer $phpmailer The PHPMailer object.
	 */
	public function filter__phpmailer_init__setup_smtp( $phpmailer ) {
		if ( isset( $this->config->SMTP_HOST ) ) {
			$phpmailer->Host = $this->config->SMTP_HOST; // phpcs:ignore WordPress.NamingConventions
		}
		if ( isset( $this->config->SMTP_PORT ) ) {
			$phpmailer->Port = $this->config->SMTP_PORT; // phpcs:ignore WordPress.NamingConventions
		}
		if ( isset( $this->config->SMTP_SECURE ) ) {
			$phpmailer->SMTPSecure = $this->config->SMTP_SECURE; // phpcs:ignore WordPress.NamingConventions
		}
		if ( isset( $this->config->SMTP_AUTH ) ) {
			$phpmailer->SMTPAuth = $this->config->SMTP_AUTH; // phpcs:ignore WordPress.NamingConventions
		}
		if ( isset( $this->config->SMTP_USER ) ) {
			$phpmailer->Username = $this->config->SMTP_USER; // phpcs:ignore WordPress.NamingConventions
		}
		if ( isset( $this->config->SMTP_PASSWORD ) ) {
			$phpmailer->Password = $this->config->SMTP_PASSWORD; // phpcs:ignore WordPress.NamingConventions
		}
		/**
		 * To prevent PHPMailer certificate error.
		 *
		 * @link  http://stackoverflow.com/questions/32694103/phpmailer-openssl-error
		 * @since 1.0.3
		 * @example
		 * 'SMTP_OPTIONS'  => array(
		 * 'ssl' => array(
		 * 'verify_peer'       => false,
		 * 'verify_peer_name'  => false,
		 * 'allow_self_signed' => true,
		 * )
		 * ),
		 */

		if ( isset( $this->config->SMTP_OPTIONS ) ) {
			$phpmailer->SMTPOptions = $this->config->SMTP_OPTIONS; // phpcs:ignore WordPress.NamingConventions
		}
		$phpmailer->isSMTP();
	}

	/**
	 * Override the "To:" setting, so the mail is always sent to one address.
	 * Useful for development and testing.
	 *
	 * @param array $args An array of wp_mail() arguments, including the "to" email, subject, message, headers, and attachments values.
	 *
	 * @return array
	 */
	public function filter__wp_mail__force_mail_to( array $args = array() ) {
		$args['subject'] .= ' - ' . ( is_array( $args['to'] ) ? $args['to'][0] : $args['to'] );

		$args['to'] = $this->get_mail_to();

		return $args;
	}

	/**
	 * Make an admin page to send test email.
	 */
	public function action__admin_menu() {
		add_management_page(
			__( 'TIVWP Email', 'tivwp-email' ),
			self::ICON_EMAIL . ' ' . __( 'TIVWP Email', 'tivwp-email' ),
			self::MIN_CAPABILITY,
			self::MENU_SLUG_EMAIL_TEST,
			array(
				$this,
				'menu_callback__email_test',
			)
		);

	}

	/**
	 * This function is called when the "Email Test" admin menu link is clicked.
	 *
	 * @see action__admin_menu()
	 */
	public function menu_callback__email_test() {

		/**
		 * Send a test email
		 */
		$to      = get_option( 'admin_email' );
		$subject = __( 'Example sent by TIVWP Email', 'tivwp-email' );
		$body    = __( 'If you received this then the email settings are probably correct.', 'tivwp-email' );

		0 && wp_verify_nonce( '' );
		if ( ! empty( $_GET['send_email'] ) ) {

			add_action( 'wp_mail_failed', array( __CLASS__, 'action__wp_mail_failed' ) );

			$rc = wp_mail( $to, $subject, $body );

			if ( $rc ) {
				/**
				 * Display admin notice
				 * Note that the message will be shown below the page title (H2), regardless its place in the code.
				 *
				 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/admin_notices
				 */
				echo '<div class="notice notice-success"><p>';
				esc_html_e( 'Email sent.', 'tivwp-email' );
				echo '</p></div>';
			}

			remove_action( 'wp_mail_failed', array( __CLASS__, 'action__wp_mail_failed' ) );
		}

		/**
		 * Display the page
		 */
		include dirname( __FILE__ ) . '/view-tivwp-email-admin.php';
	}

	/**
	 * Print admin notice if sending failed.
	 *
	 * @param WP_Error $error WP_Error.
	 */
	public static function action__wp_mail_failed( $error ) {
		echo '<div class="notice notice-error"><p>';
		echo esc_html( $error->get_error_message() );
		echo '</p></div>';
	}
}
