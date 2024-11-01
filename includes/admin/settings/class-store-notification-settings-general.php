<?php
/**
 * Store_Notification Miscellaneous Settings
 *
 * @package Store_Notification/Admin
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if (class_exists('Store_Notification_Settings_General', false)) {
    return new Store_Notification_Settings_General();
}

/**
 * Store_Notification_Settings_General.
 */
class Store_Notification_Settings_General extends Store_Notification_Admin_Settings_Base
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->id = 'general';
        $this->label = __('General', 'store-notification');

        parent::__construct();
    }

    /**
     * Get sections.
     *
     * @return array
     */
    public function get_sections()
    {
        $sections = array(
            'general' => __('General', 'store-notification'),
            'texts' => __('Texts', 'store-notification'),
        );

        return apply_filters('store_notification_get_sections_' . $this->id, $sections);
    }

    /**
     * Get settings array.
     *
     * @param string $current_section Current section name.
     * @return array
     */
    public function get_settings($current_section = '')
    {
        if ('texts' === $current_section) {
            $settings = apply_filters(
                'store_notification_settings_general_texts',
                array(array(
                    'title' => __('Text Settings', 'store-notification'),
                    'type' => 'title',
                    'desc' => '',
                    'id' => 'store_notification_texts_options',
                ), array(
                    'title' => __('Promo Text', 'store-notification'),
                    'desc' => __('Promo text to show detail on notification.', 'store-notification'),
                    'id' => 'promo_text',
                    'type' => 'text',
                    'default' => __('This is promo text, please update from Settings>>Store Notification>>Texts Tab.', 'store-notification'),
                ), array(
                    'title' => __('Promo Code', 'store-notification'),
                    'desc' => __('Promo Code.', 'store-notification'),
                    'id' => 'promo_code',
                    'type' => 'text',
                ), array(
                    'title' => __('Day Text', 'store-notification'),
                    'desc' => __('Text for Day Symbol.', 'store-notification'),
                    'id' => 'day_text',
                    'type' => 'text',
                    'default' => 'D',
                ), array(
                    'title' => __('Hour Text', 'store-notification'),
                    'desc' => __('Text for Hour Symbol.', 'store-notification'),
                    'id' => 'hour_text',
                    'type' => 'text',
                    'default' => 'H',
                ), array(
                    'title' => __('Minutes Text', 'store-notification'),
                    'desc' => __('Text for Minutes Symbol.', 'store-notification'),
                    'id' => 'minute_text',
                    'type' => 'text',
                    'default' => 'M',
                ), array(
                    'title' => __('Second Text', 'store-notification'),
                    'desc' => __('Text for Seconds Symbol.', 'store-notification'),
                    'id' => 'second_text',
                    'type' => 'text',
                    'default' => 'S',
                ), array(
                    'type' => 'sectionend',
                    'id' => 'store_notification_texts_options',
                ),

                )
            );

        } else {


            $settings = apply_filters(
                'store_notification_settings_general_general',
                array(
                    array(
                        'title' => __('General Settings', 'store-notification'),
                        'type' => 'title',
                        'desc' => '',
                        'id' => 'store_notification_general_options',
                    ),

                    array(
                        'title' => __('Container Class', 'store-notification'),
                        'desc' => __('Change Container Class, If needed', 'store-notification'),
                        'id' => 'container_class',
                        'type' => 'text',
                    ),
                    array(
                        'title' => __('Notice End Date', 'store-notification'),
                        'desc' => __('Pick ending date of this notice', 'store-notification'),
                        'id' => 'notice_end_date',
                        'type' => 'datetime',
                    ),
                    array(
                        'title' => __('Notification position', 'store-notification'),
                        'desc' => __('Choose either bottom or top position', 'store-notification'),
                        'id' => 'notice_position',
                        'type' => 'select',
                        'options' => array(
                            'top-normal' => __('Top of the page (normal)', 'store-notification'),
                            'top-fixed' => __('Top of the page (fixed)', 'store-notification'),
                            'bottom-normal' => __('Bottom of the page (normal)', 'store-notification'),
                            'bottom-fixed' => __('Bottom of the page (fixed)', 'store-notification')
                        ),
                        'default' => 'top-fixed'
                    ),
                    array(
                        'title' => __('Notification Background Color', 'store-notification'),
                        'desc' => __('Background color for notification bar', 'store-notification'),
                        'id' => 'notification_bar_background',
                        'type' => 'color',
                        'default' => '#424242',
                    ),
                    array(
                        'title' => __('Time Block Background Color', 'store-notification'),
                        'desc' => __('Background Color for Time Block', 'store-notification'),
                        'id' => 'time_block_background',
                        'type' => 'color',
                        'default' => '#ea4335',
                    ),
                    array(
                        'title' => __('Show close button', 'store-notification'),
                        'desc' => __('Show close button', 'store-notification'),
                        'id' => 'show_close_button',
                        'type' => 'checkbox',
                    ),
                    array(
                        'type' => 'sectionend',
                        'id' => 'store_notification_general_options',
                    )

                )

            );
        }

        return apply_filters('store_notification_get_settings_' . $this->id, $settings, $current_section);
    }
}

return new Store_Notification_Settings_General();
