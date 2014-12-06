<?php

/**

 * The base configurations of the WordPress.

 *

 * This file has the following configurations: MySQL settings, Table Prefix,

 * Secret Keys, WordPress Language, and ABSPATH. You can find more information

 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing

 * wp-config.php} Codex page. You can get the MySQL settings from your web host.

 *

 * This file is used by the wp-config.php creation script during the

 * installation. You don't have to use the web site, you can just copy this file

 * to "wp-config.php" and fill in the values.

 *

 * @package WordPress

 */


// ** MySQL settings - You can get this info from your web host ** //

/** The name of the database for WordPress */

define('DB_NAME', 'idea_app');


/** MySQL database username */

define('DB_USER', 'idea_app');


/** MySQL database password */

define('DB_PASSWORD', '674jtg9^u90');


/** MySQL hostname */

define('DB_HOST', 'localhost');


/** Database Charset to use in creating database tables. */

define('DB_CHARSET', 'utf8');


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

define('AUTH_KEY',         'jb--+xj-d8G2zu[B1|_e~M^YS9+[<ox7N}Oe.Ngd-Pa@_+$+=w7[ZCZxZ=n GCNM');

define('SECURE_AUTH_KEY',  'vzNW?nhX^kp5YU M,3r%UTl|DC5g`kt5;0B_KMC]Z1-1gD[qjI-!sGT*.UZDf1B|');

define('LOGGED_IN_KEY',    'Ai~mvZ2JAaoDy%|$IeOdgX?g-l6B3{;oB*rhIy+_WvwWz:+mgr;~=|oN3Fjuw-be');

define('NONCE_KEY',        '=mWUHq>uVrx6f:NsKlWGbK#L@NSxGakoeKn|Xbnp,yMmWdI>^*=PvErhO;kqtp#C');

define('AUTH_SALT',        '<qu{o$p~q^^u#H5vc@J Y{PP*lBwLYMr9hY!Y#UuqPI& I8y6 VCf_~ffX<-#+Vb');

define('SECURE_AUTH_SALT', '7Tl25J>}mZXMS)iiIGjb@/b6LMtN H-*&L.N;]51etuHvQeDQ(]NBwFGIS#q{o,o');

define('LOGGED_IN_SALT',   'Wn  *rW4}/V|8_5zt20hnWFma5X#A)];2o8tN--TaFck..kC$/8z#}*qHm2LW~$d');

define('NONCE_SALT',       '>}&{?j-e{`$k,a}Yf__+tXiPuU~g%u~4/2|.Ik}C[V@S.NZ[b5)g-$n_EbJ{[6-n');


/**#@-*/


/**

 * WordPress Database Table prefix.

 *

 * You can have multiple installations in one database if you give each a unique

 * prefix. Only numbers, letters, and underscores please!

 */

$table_prefix  = 'wp_';


/**

 * For developers: WordPress debugging mode.

 *

 * Change this to true to enable the display of notices during development.

 * It is strongly recommended that plugin and theme developers use WP_DEBUG

 * in their development environments.

 */

define('WP_DEBUG', false);


/* That's all, stop editing! Happy blogging. */


/** Absolute path to the WordPress directory. */

if ( !defined('ABSPATH') )

	define('ABSPATH', dirname(__FILE__) . '/');


/** Sets up WordPress vars and included files. */

require_once(ABSPATH . 'wp-settings.php');

define('FS_METHOD','direct');

