<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          ':m4e|?{_wUSB-h [,4V<,zKsr-AD{p8<53]yMyrQU^k},y}{_7 N-IU$%Jqx(lI~' );
define( 'SECURE_AUTH_KEY',   'RYN_h*2;yLWgEk)m+Rw5bsRP%V9M%ho(^N?T[6Lq @x&ra;F- 77,y9Ho8#X:o$E' );
define( 'LOGGED_IN_KEY',     'gX{-XC5sPiUw%o3Myw.]8}LrAy18A[&)+;[h]x%P/WlEPiC,g9)WXXsdJo;mpk{m' );
define( 'NONCE_KEY',         'eZ+J:/M*C7$4[EOV^_tof{3.@S_LT:w !w-$z4(7pKD Z?(2GUfG!Ls}-IM%>b`:' );
define( 'AUTH_SALT',         'q xTFOViq+HJs[<, |GrCH>*CWalmvA6gq[b]o>WP#C,aVd3)V8tB|d/*cw{<dlI' );
define( 'SECURE_AUTH_SALT',  '>e1|21)U/p6_|P5|K?Wm/J2AttG>f$Ifg@Xkf4!5cDoG`wMB/dnvOy-=GoU>QoU]' );
define( 'LOGGED_IN_SALT',    'CGklhW[pZfDcf>x/hO%x>(^.bkf[b/$^9 >e_&/u|RnFTm_Px$e:xIyi)pKJ=c/I' );
define( 'NONCE_SALT',        'g# Qnv~CQp-j2/^/6iOCY.QN,X0G#j|z:yx8?tY5y(Z4cN-fo/)VIO&+4R<PPAXe' );
define( 'WP_CACHE_KEY_SALT', 'r:R0 }44qolN=F~L+8aJ9s@np/9;0Ua<(P$as247;O6x}x_>YV0SeejSpYwLO}jP' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
