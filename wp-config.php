<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'perfect_pickem_db');

/** MySQL database username */
define('DB_USER', 'pickem_user');

/** MySQL database password */
define('DB_PASSWORD', 'Pickem#1');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'dG3Za4Cv9aZslxBvTmgCv7SgJu8KcKUMNZidBMBSRZQgaw4MFJNP11poilezceir');
define('SECURE_AUTH_KEY',  'MOthTKXUO6gJC1cRRaE2JDPenprjJT9HPbvYTrkk73Tpaq2vVNj4cYpvfJzC3IIa');
define('LOGGED_IN_KEY',    '6GhuCEH2f5fy71YE2pdj8D4qMsaxTQjZgNpQ9Cw3EAZuaMSi6ul8XVVagDJwslES');
define('NONCE_KEY',        'WgUGvNl2wFBoV16abt1xXhTS7heFZNw0YRFYwF4zLG42bycfxuZTKtbBrgRWjlFC');
define('AUTH_SALT',        'JtdwdOPH6naonuF4oW7BoWL0zh6Xn2jFKAPZHUBN0cwSnTgCbGyDhf2z6KCRkxuB');
define('SECURE_AUTH_SALT', '6oQiMvUm9JHMRdI3gRQPuHSyZ3MxQv1USB3mzfNhmoYmCcMF0GQQSpkQNFPChzB6');
define('LOGGED_IN_SALT',   '6PYycal0Q4IVVxh1OWfs0KbL3HhboK3CBFMFZDDPOu0QgKTfKmZ2GOdIWy805MqE');
define('NONCE_SALT',       'zcj25YRtKPakRzDufbWnIYX7LVLR3zolkJwsxeGa9X5SBymHmtftryQLWKx8fCbY');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
