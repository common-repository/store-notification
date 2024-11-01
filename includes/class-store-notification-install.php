<?php
/**
 * Store_Notification install setup
 *
 * @package Store_Notification
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

/**
 * Main Store_Notification_Install Class.
 *
 * @class Store_Notification
 */
final class Store_Notification_Install
{

    public static function install()
    {
        $store_notification_version = get_option('store_notification_plugin_version');

        if (empty($store_notification_version)) {
            self::install_content_and_options();
            //self::add_cap();
        } else {
            update_option('store_notification_plugin_version', STORE_NOTIFICATION_VERSION);
        }

    }

    private static function install_content_and_options()
    {
        $pages = array(

            array(

            ),
        );

        foreach ($pages as $page) {

            $page_id = wp_insert_post($page);


        }

        $options = array(); // Default Options goes here

        foreach ($options as $option_key => $option_value) {

            update_option($option_key, $option_value);
        }

    }


    public static function init()
    {

    }


}

Store_Notification_Install::init();