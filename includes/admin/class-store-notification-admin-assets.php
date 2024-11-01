<?php
if (!class_exists('Store_Notification_Admin_Assets')) {
    class Store_Notification_Admin_Assets
    {
        function __construct()
        {
            add_action('admin_enqueue_scripts', array($this, 'load_admin_scripts'));

        }

        public function load_admin_scripts($hook)
        {
            wp_enqueue_style('wp-color-picker');

            wp_enqueue_script('wp-color-picker');


            wp_register_style('jquery-ui', 'http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css');


            // Other Register and Enqueue
            wp_register_style('store-notification-admin-style', STORE_NOTIFICATION_PLUGIN_URI . '/assets/admin/css/admin-style.css', array('jquery-ui'), STORE_NOTIFICATION_VERSION);
            wp_enqueue_style('store-notification-admin-style');


            wp_register_script('store-notification-admin-script', STORE_NOTIFICATION_PLUGIN_URI . '/assets/admin/js/admin-script.js', array('jquery-ui-datepicker'), STORE_NOTIFICATION_VERSION);
            wp_enqueue_script('store-notification-admin-script');

        }


    }

}
return new Store_Notification_Admin_Assets();