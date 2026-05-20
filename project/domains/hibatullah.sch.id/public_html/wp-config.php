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
define( 'DB_NAME', 'hibatullah_wp' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',          'h&)]g]DBI(U8 TQ,xiw/3h0|;S`7C*Ag6H+*nwKaBA%H]!mAi, m<{<1:d$vDh[f' );
define( 'SECURE_AUTH_KEY',   ':~vQ$)31$sb;KSw<pL|V2S)hcs<<k;hz5`Dx:c;g6?y&x}lq_4;~U!60o*xj:)>;' );
define( 'LOGGED_IN_KEY',     'Q*|P_Z Cj4Eg[`ugh,Qd3#bI]5Pd~,+pq(gL](4R[{CO/av_n9Si.xH1U!+we|.f' );
define( 'NONCE_KEY',         '@sGj)IIOJhTpJ*9d`=B&5xhqL0z%w6=eDl!j>0lHBe<<{hUC>>5?XyVR8g+6oM,U' );
define( 'AUTH_SALT',         'fcf38pQE/r#$k]Qu-D.r S@Hc=Aeze}[Gz.GbR=fo?l[x=NtqkP2,PALjNU>:GKE' );
define( 'SECURE_AUTH_SALT',  'J0MuBsA{]PZ 4IOU0p(3JL.0|IQ3=!k@H&r(|)`SPg6?xmFd<b@rE[6ge}hAJSVP' );
define( 'LOGGED_IN_SALT',    '.hMM6`GvYs6wVa:>;@}|Z b6%wY$q~+IUzC<I ?+3HaKyA>IXbQ:Z%15U+^?b2`n' );
define( 'NONCE_SALT',        'u5Mty_X2Ceg%~4-s7 SDY*R91Sgw;*AO]Fp3;u&o=C~w#0X#]])XMBl<#![3|ncd' );
define( 'WP_CACHE_KEY_SALT', 'bVLl%KO{rMA`pF-*?4(ETV@*ck#sx_lg:Nj))@Fs;K*U:y(TkEx/3K>f<gM~yeWe' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );


/* Add any custom values between this line and the "stop editing" line. */



define( 'FS_METHOD', 'direct' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
