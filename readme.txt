=== TIVWP Email ===
Contributors: tivnet
Tags: development, developer, email, smtp
Requires at least: 3.8
Tested up to: 3.9
Stable tag: trunk
License: GPLv2
License URI: https://github.com/TIVWP/tivwp-email/blob/master/LICENSE

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
);
`

= Testing: =

To check the configuration settings, and to send a test email, go to Tools->TIVWP Email in admin.

== Screenshots ==

1. Admin interface to test email settings

== Changelog ==

= 14.05.02 =
* Initial release