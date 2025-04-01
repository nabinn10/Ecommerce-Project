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
define( 'DB_NAME', 'ecommerce5' );

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
define( 'AUTH_KEY',         'iJ{JILggz@?-*|G,3`#]k-N&ZOHZ9`s:_V;@=Tc&0mM4g8Vr]P=[J;f5eyN4FcD|' );
define( 'SECURE_AUTH_KEY',  '2a5{&FZ^(bx:7xQtfE*5fKyF=6tR@5i8w]wZASry!( d|*_BLM|i,u+ih^Uc:6o>' );
define( 'LOGGED_IN_KEY',    'zxf})&/.]u)UC8wgvYF5PYA*}Ze[K$^#haBO~c|Tc W~%`WgO h[fS1;=0s<h8H1' );
define( 'NONCE_KEY',        'M@]%*M.es-${ToYgtZG@5T]DEV+).P#<k>c)|7VLkO{d6B>V@{,Z*y{;o FK& kV' );
define( 'AUTH_SALT',        'Q8f*u}Gp7(,!y-Y&W >J;Tudy)g |kp*&Gt,X_4ko@uq}O{]>dZCO.BmQ)qh``Xy' );
define( 'SECURE_AUTH_SALT', 'v)v{!z>X906YO]Y54-9=`Z2f*E-+6]w,B;I~qj`p^<!=dk^VrR #H2`zJHO6 xTE' );
define( 'LOGGED_IN_SALT',   'Gm]5n;[IUlLN( :(ER<s^GY)!UvD%K|8h/yR#6n_!JRUfEZM^YfflbG}FgYb0&6w' );
define( 'NONCE_SALT',       '4jz^_FY|f.i<GzjJ*6s/)KRu F%pNV<Tpm%gW]xP)G+Ymf]+d<%8ag!.}69:0Kl?' );

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
