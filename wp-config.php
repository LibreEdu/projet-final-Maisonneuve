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
define( 'DB_NAME', 'vino' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '7IY=~YMWhm!~RgD53M#G>$f]MEHe<!LaAA?t(C4N>gW6EDn!o1t&ZCO.fWoQgJx>' );
define( 'SECURE_AUTH_KEY',  'D F<B}S)KCv#}3:zJ|!}S~g;3Z8 )wj03L[`i?=h%#cr,*@*vZ)dhc&xbx.Ld0KR' );
define( 'LOGGED_IN_KEY',    ':RJ81G-}(jJn}kw*I!G>k$-MEs.}amfX/{YV[jk:H74%CE44ICtx!o_ur83I0;Cv' );
define( 'NONCE_KEY',        'TCQEI2_lZ1 &3C|7JOgQr0():QQHN)vXm~AyWE;bhR=0@,1B!F;uD]L,ub_D+t>q' );
define( 'AUTH_SALT',        '{g!O$msq;Gti}[q>(L8_vJ(B>l533-e~!z{/gv)n{&Va A}_sVsU3x*xH:}<~Gqc' );
define( 'SECURE_AUTH_SALT', 'pypp)Sy3;mg<{AE@}IAD4E5nk3PPX^Q7Q^0}0AY^s(K4r6nbr7:IK&81Rvr|*(;<' );
define( 'LOGGED_IN_SALT',   '$yR)ws!=><%STifzq7sp3c`t&3E=l*kCT^xas)~b]>+he,w~Z+s2]&ndkW}H7o>A' );
define( 'NONCE_SALT',       '{A}UuF4R:rCn.j1?Quf UQUvE(V=Zx<fy!cKu+`O}+f#l`w9>;w| 0;S1h2Rq;`U' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
