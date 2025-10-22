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
define( 'DB_NAME', 'u3302710_wp874' );

/** Database username */
define( 'DB_USER', 'u3302710_wp874' );

/** Database password */
define( 'DB_PASSWORD', 'Sp6T36B-5@' );

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
define( 'AUTH_KEY',         'dbw59kcfn1nld2vdaf2h7jouumwz8qbtj3mfruphd8a8bodg8ejcusgyjyzxzr0c' );
define( 'SECURE_AUTH_KEY',  '0mp5fakesf7vnzzuaqzgnwk1ixi54j2syaub1lcgdx4rzztzk21t8ky8tgjd9ha9' );
define( 'LOGGED_IN_KEY',    'vbgrmecab10gm8ywbhobe21icprrxtkz81aobxzbk5cg38702xmawreamczviygt' );
define( 'NONCE_KEY',        '3j3d5oxx2vmao3q7ttc8cmxmpbpbwjurxv38skm1wbgb7re8hj5oxny2h0a80s5g' );
define( 'AUTH_SALT',        '3gbqtc0hguca95i1q7zuj4utnsj7br5xtcanzogt2km1udpbfotuihiyutwtuyn0' );
define( 'SECURE_AUTH_SALT', '2rutzt0qevl5ygmjjikpmjw5ovvvbtlxj0mmwme27zk0hht6nq0rsh5lsmmixjdy' );
define( 'LOGGED_IN_SALT',   '7zpyr58dmkqidtvwvhtdmfl5f1wnkwtnf8ogwfoal3lf79dwq5xkcmobfidrqtgz' );
define( 'NONCE_SALT',       'pqvemqqruthiv3tldhym6mdiahkemy6pfcjy7ayynycsjvo4dbytcpmuo0atgjqx' );

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
