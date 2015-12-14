<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'partyexk_transportfree');

/** MySQL database username */
define('DB_USER', 'partyexk_nisarg');

/** MySQL database password */
define('DB_PASSWORD', 'Tfree2015');

/** MySQL hostname */
define('DB_HOST', '103.21.58.121');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '56H-D&*qm?}b(L>#]M5v7.!)H:f$jMC5 `[AN.i7x:|?}~W*]e~ EGo!Lw5!*+5`');
define('SECURE_AUTH_KEY',  '|R*$g2km,1!_XigmVCXng(M-A3PoeQBl[kjukWPm:KPdL+<uImJrDd;5d7K~)amv');
define('LOGGED_IN_KEY',    'Bz[]0Pv+2!XHoVXLE+n]|il5673#]7Og,{Z4k*~xjun.1g03-uuft?cgWq!XF6_:');
define('NONCE_KEY',        'M+0LG-v@7+a$W2k6/=F+78.G.=+Iy@5?03Dc*n*cnJ(kqJ1N!#k9&$qB/9!ly_Z)');
define('AUTH_SALT',        'Gi~#qe+jeS?0iwvzW`xo#?Yo|,|%kr(nYTO=hTkiXae#_~24#8E/cf99sF-P+BM2');
define('SECURE_AUTH_SALT', 'b4KV/#^slnFj9!{}/rJ(`j$T0}rs%<B=?H+gWinF  0[c_F+}cNi>]+9,Mr;b&Cv');
define('LOGGED_IN_SALT',   '~$+a@>D-Vj]}s/`fy;]9)H<[ENu-L8=TJfxT!?XY2it{$ihZsoJr,6DgxJ5FF<H`');
define('NONCE_SALT',       ']yr+E :.1n)gbj|@_`8hB6{mC=:mG7X4r0PTn2%gG>=X0*q%k]nM%6gd$989ik9g');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'tf_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
