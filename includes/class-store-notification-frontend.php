<?php
/**
 * Store_Notification frontend setup
 *
 * @package Store_Notification
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

/**
 * Main Store_Notification_Frontend Class.
 *
 * @class Store_Notification
 */
final class Store_Notification_Frontend
{

    /**
     * The single instance of the class.
     *
     * @var Store_Notification_Frontend
     * @since 1.0.0
     */
    protected static $_instance = null;


    /**
     * Main Store_Notification_Frontend Instance.
     *
     * Ensures only one instance of Store_Notification_Frontend is loaded or can be loaded.
     *
     * @since 1.0.0
     * @static
     * @return Store_Notification_Frontend - Main instance.
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
        do_action('store_notification_frontend_loaded');
    }

    /**
     * Hook into actions and filters.
     *
     * @since 1.0.0
     */
    private function init_hooks()
    {
        add_action('wp_footer', array($this, 'notice'));


    }


    /**
     * Include required core files used in frontend.
     */
    public function includes()
    {
        include_once STORE_NOTIFICATION_ABSPATH . 'includes/class-store-notification-assets.php';


    }

    function notice()
    {
        $current_date_time = current_time('mysql', 1);

        list($today_year, $today_month, $today_day, $hour, $minute, $second) = preg_split('([^0-9])', $current_date_time);

        $end_date = $today_year . '-' . $today_month . '-' . $today_day;

        $notice_end_date = store_notification_get_option('notice_end_date', $end_date);

        $notice_end_date = !$this->is_valid_date($notice_end_date) ? $end_date : $notice_end_date;

        $notice_end_date_time = $notice_end_date . ' ' . '23:59:59';

        /*$current_date_time = '2012-12-12 23:59:59';
        $notice_end_date_time = '2014-12-12 23:59:58';*/

        $formatted_current_date = new DateTime($current_date_time);
        $formatted_end_date = $formatted_current_date->diff(new DateTime($notice_end_date_time));

        $container_class = store_notification_get_option('container_class');

        $promo_text = store_notification_get_option('promo_text', __('This is promo text, please update from Settings>>Store Notification>>Texts Tab.', 'store-notification'));

        $promo_code = store_notification_get_option('promo_code');


        store_notification_get_template('tmpl-notice.php', array(
                'notice' => array(
                    'container_class' => $container_class,
                    'days' => $formatted_end_date->days,
                    'h' => $formatted_end_date->h,
                    'i' => $formatted_end_date->i,
                    's' => $formatted_end_date->s,
                    'end_date_time' => $notice_end_date_time,
                    'promo_text' => $promo_text,
                    'promo_code' => $promo_code,
                    'day_text' => store_notification_get_option('day_text', 'D'),
                    'hour_text' => store_notification_get_option('hour_text', 'H'),
                    'minute_text' => store_notification_get_option('minute_text', 'M'),
                    'second_text' => store_notification_get_option('second_text', 'S'),
                    'notice_position' => store_notification_get_option('notice_position', 'top-fixed'),
                    'notification_bar_background' => store_notification_get_option('notification_bar_background', '#424242'),
                    'time_block_background' => store_notification_get_option('time_block_background', '#ea4335'),
                    'show_close_button' => store_notification_get_option('show_close_button', 'no'),

                )
            )
        );
    }

    public function is_valid_date($str)
    {
        if (is_numeric($str) || preg_match('^[0-9]^', $str)) {
            $stamp = strtotime($str);
            $month = date('m', $stamp);
            $day = date('d', $stamp);
            $year = date('Y', $stamp);
            return checkdate($month, $day, $year);
        }
        return false;
    }


}
