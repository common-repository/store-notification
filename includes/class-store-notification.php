<?php
/**
 * Store_Notification setup
 *
 * @package Store_Notification
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

/**
 * Main Store_Notification Class.
 *
 * @class Store_Notification
 */
final class Store_Notification
{

    /**
     * Store_Notification version.
     *
     * @var string
     */
    public $version = STORE_NOTIFICATION_VERSION;

    /**
     * The single instance of the class.
     *
     * @var Store_Notification
     * @since 1.0.0
     */
    protected static $_instance = null;


    /**
     * Main Store_Notification Instance.
     *
     * Ensures only one instance of Store_Notification is loaded or can be loaded.
     *
     * @since 1.0.0
     * @static
     * @see mb_aec_addons()
     * @return Store_Notification - Main instance.
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Cloning is forbidden.
     *
     * @since 1.0.0
     */
    public function __clone()
    {
        _doing_it_wrong(__FUNCTION__, __('Cloning is forbidden.', 'store-notification'), '1.0.0');
    }

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 1.0.0
     */
    public function __wakeup()
    {
        _doing_it_wrong(__FUNCTION__, __('Unserializing instances of this class is forbidden.', 'store-notification'), '1.0.0');
    }

    /**
     * Auto-load in-accessible properties on demand.
     *
     * @param mixed $key Key name.
     * @return mixed
     */
    public function __get($key)
    {
        if (in_array($key, array(''), true)) {
            return $this->$key();
        }
    }

    /**
     * Store_Notification Constructor.
     */
    public function __construct()
    {
        $this->define_constants();
        $this->includes();
        $this->init_hooks();
        do_action('store_notification_loaded');
    }

    /**
     * Hook into actions and filters.
     *
     * @since 1.0.0
     */
    private function init_hooks()
    {

        register_activation_hook(STORE_NOTIFICATION_FILE, array('Store_Notification_Install', 'install'));

        add_action('init', array($this, 'init'), 0);
        add_action('init', array($this, 'global_option'), 0);


    }

    /**
     * Define Store_Notification Constants.
     */
    private function define_constants()
    {

        $this->define('STORE_NOTIFICATION_ABSPATH', dirname(STORE_NOTIFICATION_FILE) . '/');
        $this->define('STORE_NOTIFICATION_BASENAME', plugin_basename(STORE_NOTIFICATION_FILE));
    }

    /**
     * Define constant if not already set.
     *
     * @param string $name Constant name.
     * @param string|bool $value Constant value.
     */
    private function define($name, $value)
    {
        if (!defined($name)) {
            define($name, $value);
        }
    }

    /**
     * What type of request is this?
     *
     * @param  string $type admin, ajax, cron or frontend.
     * @return bool
     */
    private function is_request($type)
    {
        switch ($type) {
            case 'admin':
                return is_admin();
            case 'ajax':
                return defined('DOING_AJAX');
            case 'cron':
                return defined('DOING_CRON');
            case 'frontend':
                return (!is_admin() || defined('DOING_AJAX')) && !defined('DOING_CRON') && !defined('REST_REQUEST');
        }
    }

    /**
     * Include required core files used in admin and on the frontend.
     */
    public function includes()
    {

        /**
         * Class autoloader.
         */
        include_once STORE_NOTIFICATION_ABSPATH . 'includes/class-store-notification-autoloader.php';
        include_once STORE_NOTIFICATION_ABSPATH . 'includes/functions.php';
        include_once STORE_NOTIFICATION_ABSPATH . 'includes/class-store-notification-ajax.php';


        if ($this->is_request('admin')) {
            Store_Notification_Admin::instance();
        }

        if ($this->is_request('frontend')) {
            Store_Notification_Frontend::instance();
        }

    }

    public function global_option()
    {
        global $store_notification_global_options;

        $store_notification_global_options = store_notification_get_option('store_notification_options', array(), true);
    }

    /**
     * Init Store_Notification when WordPress Initialises.
     */
    public function init()
    {
        // Before init action.
        do_action('before_store_notification_init');


        // Set up localisation.
        $this->load_plugin_textdomain();


        // Init action.
        do_action('store_notification_init');
    }

    /**
     * Load Localisation files.
     *
     * Note: the first-loaded translation file overrides any following ones if the same translation is present.
     *
     * Locales found in:
     *      - WP_LANG_DIR/store-notification/store-notification-LOCALE.mo
     *      - WP_LANG_DIR/plugins/store-notification-LOCALE.mo
     */
    public function load_plugin_textdomain()
    {
        $locale = is_admin() && function_exists('get_user_locale') ? get_user_locale() : get_locale();
        $locale = apply_filters('plugin_locale', $locale, 'store-notification');
        unload_textdomain('store-notification');
        load_textdomain('store-notification', WP_LANG_DIR . '/store-notification/store-notification-' . $locale . '.mo');
        load_plugin_textdomain('store-notification', false, plugin_basename(dirname(STORE_NOTIFICATION_FILE)) . '/i18n/languages');
    }

    /**
     * Ensure theme and server variable compatibility and setup image sizes.
     */
    public function setup_environment()
    {

        $this->define('STORE_NOTIFICATION_TEMPLATE_PATH', $this->template_path());

    }

    /**
     * Get the plugin url.
     *
     * @return string
     */
    public function plugin_url()
    {
        return untrailingslashit(plugins_url('/', STORE_NOTIFICATION_FILE));
    }

    /**
     * Get the plugin path.
     *
     * @return string
     */
    public function plugin_path()
    {
        return untrailingslashit(plugin_dir_path(STORE_NOTIFICATION_FILE));
    }

    /**
     * Get the template path.
     *
     * @return string
     */
    public function template_path()
    {
        return apply_filters('store_notification_template_path', 'store-notification/');
    }

    /**
     * Get the template path.
     *
     * @return string
     */
    public function plugin_template_path()
    {
        return apply_filters('store_notification_plugin_template_path', $this->plugin_path() . '/templates/');
    }

    /**
     * Get Ajax URL.
     *
     * @return string
     */
    public function ajax_url()
    {
        return admin_url('admin-ajax.php', 'relative');
    }


}
