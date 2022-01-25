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
define('DB_NAME', 'd80044_reg');

/** MySQL database username */
define('DB_USER', 'a80044_reg');

/** MySQL database password */
define('DB_PASSWORD', 'vPTMJAa4');

/** MySQL hostname */
define('DB_HOST', 'wm68.wedos.net');

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
define('AUTH_KEY',         '-/eG,S]2W2Z00+RqV>F!We|sk~Y3iiIRf;IFwIw2F.)nc)].(_P`2`7<Po/`=(mL');
define('SECURE_AUTH_KEY',  'f9bSqpKD{Yj$20Cb2?sa:xPK_Otu+H+6&P?}x!}:r1~1]Ys$N{T6FKAcN39*zUHy');
define('LOGGED_IN_KEY',    '(&zXCufaCh#saMfHUaohiMrj=4yEl`-BP)Oh?>b{sIZ&?y{4cuXzMz[n<_jcT.fk');
define('NONCE_KEY',        'pD`z:/IfC:hi,8nY)asI?y!fbo%@[~j.T|P<z?8Pp>5<er{g>~kLC;R/8!<Z BOr');
define('AUTH_SALT',        'g)<F:f9)T_y?;|nW3vv&6;iu7*kieo[4wh`S^M@9.zu6 g<6}mT:l(v |zLUTKNr');
define('SECURE_AUTH_SALT', 'I}H$G<aXmiudhP181;qdacS:|1m)g/r;UCx.eV/vPqqS.uFF>}GXu,H=vapOWG=T');
define('LOGGED_IN_SALT',   'dvvAeOgjiM?(y@2oH<9flZw+o)Q_;{mVMPn~GjSYoJyLQ*n}?XSft;<_N(/WBo9|');
define('NONCE_SALT',       'yi^oZU0H0Fq:~uCQJ-~xh0Oe/;]lQ1@nwaTIDg7X2$.O=xE6.0$kW(`l`J%#h~.w');

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
