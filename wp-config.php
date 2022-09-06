<?php /* BEGIN KINSTA DEVELOPMENT ENVIRONMENT */ ?>
<?php if ( !defined('KINSTA_DEV_ENV') ) { define('KINSTA_DEV_ENV', true); /* Kinsta development - don't remove this line */ } ?>
<?php if ( !defined('JETPACK_STAGING_MODE') ) { define('JETPACK_STAGING_MODE', true); /* Kinsta development - don't remove this line */ } ?>
<?php /* END KINSTA DEVELOPMENT ENVIRONMENT */ ?>
<?php
session_start();?>
<?php
// define('WP_CACHE', true);
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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */
 
 define( 'WP_AUTO_UPDATE_CORE', false );

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "srp" );

/** MySQL database username */
define( 'DB_USER', "root" );

/** MySQL database password */
define( 'DB_PASSWORD', "" );

/** MySQL hostname */
define( 'DB_HOST', "localhost" );

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
define( 'AUTH_KEY',         '9lfwusccubpmeorxjpahzfu5qd71y5jvj5ijwqrggufg4tpke5mhek7tftdqu14u' );
define( 'SECURE_AUTH_KEY',  'ffzj5whd3qejxly8bl5o1x9l2rlnnro6ivl8t2m68dnrqpyeardumuc820nvyoua' );
define( 'LOGGED_IN_KEY',    'mcgilj5tcymnbswozssxgobo17pk6scyvlrppil4gib1exvpcenl8rigk9hrj8p6' );
define( 'NONCE_KEY',        'oga1mhsf65ipadiny0zbrtacghsickjypzy4y3oi6tctjrxgh6uqmjyakysrizqn' );
define( 'AUTH_SALT',        'szke4mqzsrthspszxcywsepn47acl1jnyl6bio2g7ytfribwvqpfkqm4cvuqyviu' );
define( 'SECURE_AUTH_SALT', 'daktaknhvekpxii9tscpizq0pwwwmnof1mpnorrp3meg5d9clypmiz0oj9o2imdf' );
define( 'LOGGED_IN_SALT',   'mmb4qiyn5qouonknel3nuzwpqrwklmv6rtk26mgjnk1on5v6bdaihekn8116njzp' );
define( 'NONCE_SALT',       ' ' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wphs_';
if (! defined('WP_DEBUG') ) { define( 'WP_DEBUG', false ); } // line added by the MyKinsta

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */

define( 'WP_AUTO_UPDATE_CORE', false );

////Paypal Sandbox
//define( 'PAYPAL_CLIENT_ID', 'AbtJAWLWBAlAZtHVyDy9SqtEPnhoV47GPbni1Pbe3ZSvCA1PaLyQnGbjK0KohTTI-3ljEcDlf4CMpIPb' );
//define( 'PAYPAL_CLIENT_SECRET', 'EOfXgG0I8SQmWx79sy1BO9QnAKZqPWjEEHi5GkHIJhuHELPQR3CXcV4H0R2b9ABfxyMbON4CaHeVAeLq' );

////Paypal Live
define( 'PAYPAL_CLIENT_ID', 'AWS1CO8YikeZmVtmfF-MVG8TTEvgi2QPAQNhKnIB0SLCPihGtqRLmEcCJEWGnGOT3-C7op2tktYl2x4B' );
define( 'PAYPAL_CLIENT_SECRET', 'EOgZft9IiwW7mxzegKMsGFrWqU1gNwgiYKU29YrlsMIvegg6JrwUrwkSi_X90ESKSzotej1xEPEhhJAr' );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
