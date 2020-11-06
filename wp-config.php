<?php
define('WP_ROCKET_CF_API_KEY', 'e30dbc461d10077d899227d3819d150f9cb3d');
define( 'WP_ROCKET_CF_API_KEY_HIDDEN', true );
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
// define( 'DB_NAME', 'mmtenders' );
// define( 'DB_NAME', 'inzkdy93_tender' );
define( 'DB_NAME', 'tender' );
/** MySQL database username */
// define( 'DB_USER', 'inzkdy93_tender' );
define( 'DB_USER', 'root' );
// define( 'DB_USER', 'root' );
/** MySQL database password */
// define( 'DB_PASSWORD', 'fortender123!' );
define( 'DB_PASSWORD', '' );
/** MySQL hostname */
define( 'DB_HOST', 'localhost' );
/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );
 
/** The Database Collate type. Don't change this if in doubt. */
// define( 'DB_COLLATE', 'utf8_general_ci' );
define( 'DB_COLLATE', 'utf8mb4_general_ci' );
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'iV+L,X>VRKf1)!CDx,uu%QVutOB[5 {e}G}j<[#u;Dpv0F7sjngcyK!?/FcrLpu[' );
define( 'SECURE_AUTH_KEY',  'AQwA) caM=n[bk}#Tsx%P->ctZe[/p)P(pCtzG[wXj(;TkR:En-tM-iEmH!:e~Nh' );
define( 'LOGGED_IN_KEY',    '|[-4tjdCui.J54th*0eJTuNAqt2DL0fV-(vF*TMM%FZGlMhX,^=9DLJ5yg(e;HEm' );
define( 'NONCE_KEY',        '/a[[|AhT9j?ucn@u)mAQH-KE+yDosc/+b#-kWnGNoKx8Z;c7zl.5gF7_= 8RIgU%' );
define( 'AUTH_SALT',        '%m$)Qa[ghYuA]F@czgmeK|8FaSChlo[T&o_^Cr  Nic!y%0^!?bvDzF{o2m/i.gc' );
define( 'SECURE_AUTH_SALT', ':cbXMq%!u=f{HffO+I|`]D4P0(?Fpc(<}&jN ?ELaF&rwbvW6bEO}+%IDcDW$1WK' );
define( 'LOGGED_IN_SALT',   ',Fq|fNV1aR~cKHgls6Ku9$Tuy-w|i.LxLV(t+(6fNIayF+j`ooiIj%..D)WSh+~:' );
define( 'NONCE_SALT',       's;bn2!<n[NIagxv$AC8/Q9Vp|z3`QJT}`P_gKw)ye!56W#df]Gm!>0SQu?v-Tz9<' );
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
set_time_limit(6000);
define( 'WP_MEMORY_LIMIT', '256M' );
define( 'WP_AUTO_UPDATE_CORE', false );
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}
/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );