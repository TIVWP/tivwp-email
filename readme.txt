=== TIVWP Email ===
Contributors: tivnet, tivnetinc
Tags: development, developer, email, smtp, TIVWP
Requires at least: 3.8
Tested up to: 4.7.3
Stable tag: trunk
License: GPL-3.0
License URI: http://www.gnu.org/licenses/gpl.txt

Setup SMTP and force MAIL_TO for development and testing

== Description ==

**TIVWP Email** is a plugin for WordPress developers. Its main features are:

* Configure SMTP Email. Particularly useful on Windows machines.
* MAIL_TO overwriting. Force all email to be sent to one address. Useful on staging environment when you do not want email to be sent to the real users.

The settings are stored in a configuration file (`wp-config.php` or similar), so they are not accidentally copied from development to production.

== Installation ==

You can install this plugin directly from your WordPress dashboard:

1. Go to the *Plugins* menu and click *Add New*.
2. Search for *TIVWP Email*.
3. Click *Install Now* next to the TIVWP Email plugin.
4. Activate the plugin.

Alternatively, see the guide to [Manually Installing Plugins](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

== Frequently Asked Questions ==

= Testing: =

To check the configuration settings, and to send a test email, go to Tools->TIVWP Email in admin.

= Configuration Example: =

`
$GLOBALS['TIVWP']['EMAIL'] = array(
	// Using GMail SMTP
	'SMTP_ENABLED'  => true,
	'SMTP_HOST'     => 'smtp.gmail.com',
	'SMTP_PORT'     => '587',
	'SMTP_SECURE'   => 'tls',
	'SMTP_AUTH'     => true,
	'SMTP_USER'     => 'me@gmail.com',
	'SMTP_PASSWORD' => '*****',
	// Forcing all email sent to ...
	// (better if not the same as the SMTP_USER)
	'MAIL_TO'       => 'me@hotmail.com',
	'SMTP_OPTIONS'  => array(
		'ssl' => array(
			'verify_peer'       => false,
			'verify_peer_name'  => false,
			'allow_self_signed' => true,
		)
	),
);
`

== Screenshots ==

1. Admin interface to test email settings

== Changelog ==

= 1.0.3 =

* Added configuration parameter `SMTP_OPTIONS`.
* Code cleanup using the latest PHP inspections and phpcs.
* Checked with WordPress 4.7.3, the latest versions of [WooCommerce](https://woocommerce.com/) and [WPGlobus](https://wpglobus.com/).

= 1.0.2 =

* Code cleanup using the latest PHP inspections and phpcs.
* Checked with WordPress 4.6.

= 1.0.1 =
* Fix: Start on 'plugins_loaded' instead of 'wp_loaded'. (Contact Form 7, for example, sends emails on 'init')

= 1.0.0 =
* Initial release
