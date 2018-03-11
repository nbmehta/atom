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
define('DB_NAME', 'atom');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'kV`QE.o`? ,3FE5OzrY#B;@~(}ypjIqM;feZy9v~>[wS|=uE@Z>`Q8u}Jw3|OON(');
define('SECURE_AUTH_KEY',  '2A#oaVUxT?+kV=e3pZHM6!yOfl-QvI/pD/?lF9GKJT>D-?):ET5afs>% %CSDC67');
define('LOGGED_IN_KEY',    'r8(+B+7MM|tMHJP)/G!eB,Zsl37fE]ksiS`av(o!<LCSyDQ&0I6RnPkNhxu}-.ph');
define('NONCE_KEY',        '2rEAmO{0n.W;;^-fVAeH!WA]oAJ|k[,-X8&WD,)Hc #.Y&+b`g@A|Yt$&`<;MITF');
define('AUTH_SALT',        '>)jM*aovGz6z6l$4Qr/BsU.D$EW8gZQ!nW]j?e9!:ETH4a_:{b@KQDBg30gc/Mf4');
define('SECURE_AUTH_SALT', '55Vx{kZt`{ rL>wOA.fgf}M0JLnBzxSqz_DF3ivTZQc0/m4(D#OOoQ] e`|^Vf5e');
define('LOGGED_IN_SALT',   'v7G9CYR$WL?At%2-HxbB;128YmbtX/>.xIKL53-:;(anNV,FZ;Ju/~!Uv)K8FSD5');
define('NONCE_SALT',       '+t^J.2pX._MDgn=Ual}g)r$$A/Cb^-[fms,%nZ+Ss|C:yaE@K~41t#DPXT,x|y!_');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
