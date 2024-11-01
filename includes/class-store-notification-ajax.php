<?php
defined('ABSPATH') || exit;

class Store_Notification_Ajax
{

    private function admin_ajax_actions()
    {
        $actions = array();

        return $actions;

    }

    private function public_ajax_actions()
    {
        $actions = array(

            'load_more_profile',
        );
        return $actions;
    }

    private function validate_nonce($nonce_action = '', $nonce_value = '')
    {
        $debug_backtrace = debug_backtrace();

        if (@isset($debug_backtrace[1]['function'])) {

            $nonce_action = 'wp_store_notification_' . $debug_backtrace[1]['function'] . '_nonce';

        }
        if (empty($nonce_value)) {
            $nonce_value = isset($_REQUEST['store_notification_nonce']) ? $_REQUEST['store_notification_nonce'] : '';
        }

        return wp_verify_nonce($nonce_value, $nonce_action);

    }

    private function ajax_error()
    {
        return array('message' => __('Something wrong, please try again.', 'store-notification'), 'status' => false);
    }

    public function __construct()
    {
        $admin_actions = $this->admin_ajax_actions();

        $public_ajax_actions = $this->public_ajax_actions();

        $all_ajax_actions = array_unique(array_merge($admin_actions, $public_ajax_actions));

        foreach ($all_ajax_actions as $action) {
            add_action('wp_ajax_store_notification_' . $action, array($this, $action));
            if (isset($public_ajax_actions[$action])) {
                add_action('wp_ajax_nopriv_store_notification_' . $action, array($this, $action));
            }

        }


    }




}

new Store_Notification_Ajax();