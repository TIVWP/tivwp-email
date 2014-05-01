<?php

/**
 * Class TIVWP_Email
 */
class TIVWP_Email {

	const MIN_CAPABILITY       = 'activate_plugins';
	const MENU_SLUG_EMAIL_TEST = 'tivwp-email-test';

	/** @var object $_config */
	private $_config;

	/**
	 * Constructor
	 * Initializes the configuration object
	 * @param array $config
	 */
	function __construct( $config = array() ) {
		$this->_config = (object) $config;
	}

	/**
	 * Get configuration value SMTP_ENABLED
	 * @return bool
	 */
	public function get_smtp_enabled() {
		return ( isset( $this->_config->SMTP_ENABLED ) ? $this->_config->SMTP_ENABLED : false );
	}

	/**
	 * Get configuration value MAIL_TO
	 * @return string
	 */
	public function get_mail_to() {
		return ( isset( $this->_config->MAIL_TO ) ? $this->_config->MAIL_TO : '' );
	}

	/**
	 * Setup PHPMailer
	 * @param PHPMailer $phpmailer
	 */
	public function filter__phpmailer_init__setup_smtp( PHPMailer $phpmailer ) {

		if ( isset( $this->_config->SMTP_HOST ) ) {
			$phpmailer->Host = $this->_config->SMTP_HOST;
		}
		if ( isset( $this->_config->SMTP_PORT ) ) {
			$phpmailer->Port = $this->_config->SMTP_PORT;
		}
		if ( isset( $this->_config->SMTP_SECURE ) ) {
			$phpmailer->SMTPSecure = $this->_config->SMTP_SECURE;
		}
		if ( isset( $this->_config->SMTP_AUTH ) ) {
			$phpmailer->SMTPAuth = $this->_config->SMTP_AUTH;
		}
		if ( isset( $this->_config->SMTP_USER ) ) {
			$phpmailer->Username = $this->_config->SMTP_USER;
		}
		if ( isset( $this->_config->SMTP_PASSWORD ) ) {
			$phpmailer->Password = $this->_config->SMTP_PASSWORD;
		}
		$phpmailer->IsSMTP();
	}

	/**
	 * Override the "To:" setting, so the mail is always sent to one address
	 * Useful for development and testing
	 * For the filter parameters
	 * @see wp_mail()
	 * @param array $ARGS
	 * @return array
	 */
	public function filter__wp_mail__force_mail_to( $ARGS = array() ) {
		$ARGS['subject'] .= ' - ' . $ARGS['to'];
		$ARGS['to'] = $this->get_mail_to();
		return $ARGS;
	}

	/**
	 * Make an admin page to send test email
	 * @see menu_callback__email_test()
	 */
	public function action__admin_menu() {
		add_management_page(
			__( 'TIVWP Email Test', 'tivwp-email' ),
			__( 'TIVWP Email Test', 'tivwp-email' ),
			self::MIN_CAPABILITY,
			self::MENU_SLUG_EMAIL_TEST,
			array(
				$this,
				'menu_callback__email_test'
			)
		);

	}

	/**
	 * This function is called when the "Email Test" admin menu link is clicked
	 * @see action__admin_menu()
	 */
	public function menu_callback__email_test() {

		/**
		 * Send a test email
		 */
		$to      = get_option( 'admin_email' );
		$subject = __( 'Example sent by TIVWP Email', 'tivwp-email' );

		$body = __( 'If you received this then the email settings are probably correct.', 'tivwp-email' );

		wp_mail( $to, $subject, $body );

		/**
		 * Clone configuration object to hide the password before printing configuration
		 * (Without cloning, the actual configuration would change)
		 */
		$config                = clone( $this->_config );
		$config->SMTP_PASSWORD = str_repeat( '*', strlen( $config->SMTP_PASSWORD ) );

		/**
		 * Display the page
		 */
		include 'view-admin-email-test.inc.php';
	}

} // class

# --- EOF