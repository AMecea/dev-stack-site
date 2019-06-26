<?php
/**
 * Configuration overrides for WP_ENV === 'development'
 */

use Roots\WPConfig\Config;

Config::define('SAVEQUERIES', true);
Config::define('WP_DEBUG', true);
Config::define('WP_DEBUG_DISPLAY', true);
Config::define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
Config::define('SCRIPT_DEBUG', true);

ini_set('display_errors', 1);

// Enable plugin and theme updates and installation from the admin
Config::define('DISALLOW_FILE_MODS', false);


// deactiveate hashing of password for testing
if ( !function_exists('wp_hash_password') ){
    function wp_hash_password($password) {
        //apply your own hashing structure here
        return $password;
    }
}

if ( !function_exists('wp_check_password') ){
    function wp_check_password($password, $hash, $user_id = '') {
            //check for your hash match
            error_log("Password: $password, hash: $hash, UID: $user_id \n\n");
            return $password == $hash;
	}
}
