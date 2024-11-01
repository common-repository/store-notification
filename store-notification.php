<?php
/**
 * Plugin Name:       Store Notification
 * Plugin URI:        https://wordpress.org/plugins/store-notification/
 * Description:       Easily show discount notification on your eCommerce shop. This plugins help you to show notification with end time ( day, hour, minute, second) on your WordPress store. Mainly this plugin is suitable for your online eCommerce store.
 * Version:           1.0.0
 * Author:            Mantrabrain
 * Author URI:        https://mantrabrain.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       store-notification
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define STORE_NOTIFICATION_PLUGIN_FILE.
if (!defined('STORE_NOTIFICATION_FILE')) {
    define('STORE_NOTIFICATION_FILE', __FILE__);
}

// Define STORE_NOTIFICATION_VERSION.
if (!defined('STORE_NOTIFICATION_VERSION')) {
    define('STORE_NOTIFICATION_VERSION', '1.0.0');
}

// Define STORE_NOTIFICATION_PLUGIN_URI.
if (!defined('STORE_NOTIFICATION_PLUGIN_URI')) {
    define('STORE_NOTIFICATION_PLUGIN_URI', plugins_url('', STORE_NOTIFICATION_FILE));
}

// Define STORE_NOTIFICATION_PLUGIN_DIR.
if (!defined('STORE_NOTIFICATION_PLUGIN_DIR')) {
    define('STORE_NOTIFICATION_PLUGIN_DIR', plugin_dir_path(STORE_NOTIFICATION_FILE));
}


// Include the main Store_Notification class.
if (!class_exists('Store_Notification')) {
    include_once dirname(__FILE__) . '/includes/class-store-notification.php';
}


/**
 * Main instance of Store_Notification.
 *
 * Returns the main instance of Store_Notification to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return Store_Notification
 */
function mb_store_notification()
{
    return Store_Notification::instance();
}

// Global for backwards compatibility.
$GLOBALS['store-notification-instance'] = mb_store_notification();
