<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'THshop' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '7NW_(eeP@v&uIx|[JP4$6R}W4^;yaqpu25LSRfYXI)v=C}|T<;LsQ8ZCfV!q]ach' );
define( 'SECURE_AUTH_KEY',  'PLu(pLgJV3:o`ch!<a%*MU[Gl3!Izz{bfJiY_B;zotROFZ|Z-}NS:!2o0SF9^bu+' );
define( 'LOGGED_IN_KEY',    ':I]E63jtU;x;g>QD33d?4f<53y5_tyvMz_|{>[g4Ck%^)_B$Hc8}Efdlio2Yy)h-' );
define( 'NONCE_KEY',        '&UZOupTzgrUY^gRM~QR+~_67{n~ )LL3aTC$#<&+vO>]q5lT#;y)|^O7hEiJZ(AF' );
define( 'AUTH_SALT',        'r<![~rrmU@~nnf^w-5PHx[y_p=RjNE^oi7(fy73vt(CUG vSuYyIxrd&By<1.1:=' );
define( 'SECURE_AUTH_SALT', 'hSg}wXSQ!|<,~s._y&%{;Tr@{F,dga?2CajDX@=`qXWW0d;Kjo%>r@xOX0^9vXeb' );
define( 'LOGGED_IN_SALT',   'fLb;(y|9A=w/d`%)5BwLm}:oG<o$>e}z+<^tS/DKEvA udhRR4C(F(M#yKhsy_Yi' );
define( 'NONCE_SALT',       '#~OI}GcPM]86ZoXZVtM2nS?ym|8aNH5wW2he:)m|DVvBnAx/t%7Z|P8`-30QjXb%' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
