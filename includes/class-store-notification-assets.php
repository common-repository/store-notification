<?php
if (!class_exists('Store_Notification_Assets')) {
    class Store_Notification_Assets
    {
        function __construct()
        {
            add_action('wp_enqueue_scripts', array($this, 'scripts'));

        }

        public function scripts($hook)
        {


            // Other Register and Enqueue
            wp_register_style('store-notification-style', STORE_NOTIFICATION_PLUGIN_URI . '/assets/css/store-notification.css', false, STORE_NOTIFICATION_VERSION);
            wp_enqueue_style('store-notification-style');


            wp_register_script('store-notification-script', STORE_NOTIFICATION_PLUGIN_URI . '/assets/js/store-notification.js', array('jquery'), STORE_NOTIFICATION_VERSION);
            wp_enqueue_script('store-notification-script');

            $store_notification_params = array(

                'ajax_url' => admin_url('admin-ajax.php'),
                'load_more_profile_params' => array(
                    'load_more_profile_action' => 'store_notification_load_more_profile',
                    'load_more_profile_nonce' => wp_create_nonce('wp_store_notification_load_more_profile_nonce')
                )
            );

            wp_localize_script('store-notification-script', 'store_notification_params', $store_notification_params);
        }

    }

}
return new Store_Notification_Assets();