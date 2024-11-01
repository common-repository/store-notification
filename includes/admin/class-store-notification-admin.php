<?php
/**
 * Store_Notification admin setup
 *
 * @package Store_Notification
 * @since   1.0.0
 */

defined('ABSPATH') || exit;


/**
 * Main Store_Notification_Admin Class.
 *
 * @class Store_Notification
 */
final class Store_Notification_Admin
{

    /**
     * The single instance of the class.
     *
     * @var Store_Notification_Admin
     * @since 1.0.0
     */
    protected static $_instance = null;


    /**
     * Main Store_Notification_Admin Instance.
     *
     * Ensures only one instance of Store_Notification_Admin is loaded or can be loaded.
     *
     * @since 1.0.0
     * @static
     * @return Store_Notification_Admin - Main instance.
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    /**
     * Store_Notification Constructor.
     */
    public function __construct()
    {

        $this->includes();
        $this->init_hooks();
    }

    /**
     * Hook into actions and filters.
     *
     * @since 1.0.0
     */
    private function init_hooks()
    {

        add_action('admin_menu', array($this, 'admin_menu'));

        add_filter('plugin_action_links_' . plugin_basename(STORE_NOTIFICATION_FILE), array($this, 'settings_link'), 10, 2);


    }

    function settings_link($links, $file)
    {
        $settings_link = '<a href="' . admin_url('admin.php?page=store-notification&tab=general&section=general') . '">' . __('Settings', 'store-notification') . '</a>';

        array_unshift($links, $settings_link);

        return $links;
    }


    public function admin_menu()
    {
        $cap = current_user_can('manage_options') ? 'manage_options' : 'manage_options';

        $settings_page = add_submenu_page(
            'options-general.php',
            __('Store Notification', 'store-notification'),
            __('Store Notification', 'store-notification'),
            $cap,
            'store-notification',
            array($this, 'setting_page')
        );

        add_action('load-' . $settings_page, array($this, 'settings_page_init'));

    }

    public function setting_page()
    {

        Store_Notification_Admin_Settings::output();


    }

    public function settings_page_init()
    {

        global $current_tab, $current_section;

        // Include settings pages.
        Store_Notification_Admin_Settings::get_settings_pages();

        // Get current tab/section.
        $current_tab = empty($_GET['tab']) ? 'general' : sanitize_title(wp_unslash($_GET['tab'])); // WPCS: input var okay, CSRF ok.
        $current_section = empty($_REQUEST['section']) ? '' : sanitize_title(wp_unslash($_REQUEST['section'])); // WPCS: input var okay, CSRF ok.

        if ($current_tab == 'general' && $current_section == '') {
            $current_section = 'general';
        }


        // Save settings if data has been posted.
        if ('' !== $current_section && apply_filters("store_notification_save_settings_{$current_tab}_{$current_section}", !empty($_POST['save']))) { // WPCS: input var okay, CSRF ok.

            Store_Notification_Admin_Settings::save();
        } elseif ('' === $current_section && apply_filters("store_notification_save_settings_{$current_tab}", !empty($_POST['save']))) { // WPCS: input var okay, CSRF ok.
            Store_Notification_Admin_Settings::save();
        }

        // Add any posted messages.
        if (!empty($_GET['store_notification_error'])) { // WPCS: input var okay, CSRF ok.
            Store_Notification_Admin_Settings::add_error(wp_kses_post(wp_unslash($_GET['store_notification_error']))); // WPCS: input var okay, CSRF ok.
        }

        if (!empty($_GET['store_notification_message'])) { // WPCS: input var okay, CSRF ok.
            Store_Notification_Admin_Settings::add_message(wp_kses_post(wp_unslash($_GET['store_notification_message']))); // WPCS: input var okay, CSRF ok.
        }

        do_action('store_notification_settings_page_init');


    }


    /**
     * Include required core files used in admin.
     */
    public function includes()
    {

        include_once STORE_NOTIFICATION_ABSPATH . 'includes/admin/class-store-notification-admin-assets.php';

    }


}
