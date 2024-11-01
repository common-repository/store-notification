<?php
/**
 * Store_Notification Autoloader.
 *
 * @package Store_Notification/Classes
 * @version 1.0.0
 */

defined('ABSPATH') || exit;

/**
 * Autoloader class.
 */
class Store_Notification_Autoloader
{

    /**
     * Path to the includes directory.
     *
     * @var string
     */
    private $include_path = '';

    /**
     * The Constructor.
     */
    public function __construct()
    {
        if (function_exists('__autoload')) {
            spl_autoload_register('__autoload');
        }

        spl_autoload_register(array($this, 'autoload'));

        $this->include_path = untrailingslashit(plugin_dir_path(STORE_NOTIFICATION_FILE)) . '/includes/';
    }

    /**
     * Take a class name and turn it into a file name.
     *
     * @param  string $class Class name.
     * @return string
     */
    private function get_file_name_from_class($class)
    {
        return 'class-' . str_replace('_', '-', $class) . '.php';
    }

    /**
     * Include a class file.
     *
     * @param  string $path File path.
     * @return bool Successful or not.
     */
    private function load_file($path)
    {
        if ($path && is_readable($path)) {
            include_once $path;
            return true;
        }
        return false;
    }

    /**
     * Auto-load Store_Notification classes on demand to reduce memory consumption.
     *
     * @param string $class Class name.
     */
    public function autoload($class)
    {

        $class = strtolower($class);


        if (0 !== strpos($class, 'store_notification_')) {
            return;
        }

        $file = $this->get_file_name_from_class($class);

        $path = '';

        if (0 === strpos($class, 'store_notification_shortcode')) {
            $path = $this->include_path . 'shortcodes/';
        } elseif (0 === strpos($class, 'store_notification_metabox')) {
            $path = $this->include_path . 'meta-boxes/';
        } elseif (0 === strpos($class, 'store_notification_taxonomy')) {
            $path = $this->include_path . 'taxonomy/';
        } elseif (0 === strpos($class, 'store_notification_custom_post_type')) {
            $path = $this->include_path . 'custom-post-type/';
        } elseif (0 === strpos($class, 'store_notification_admin')) {
            $path = $this->include_path . 'admin/';
        } elseif (0 === strpos($class, 'store_notification_customizer_control')) {
            $path = $this->include_path . 'customizer/control/';
        } elseif (0 === strpos($class, 'store_notification_helper')) {
            $path = $this->include_path . 'helper/';
        }

        if (empty($path) || !$this->load_file($path . $file)) {
            $this->load_file($this->include_path . $file);
        }
    }
}

new Store_Notification_Autoloader();
