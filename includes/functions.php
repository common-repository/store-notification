<?php
defined('ABSPATH') || exit;
global $store_notification_global_options;
// Load Helpers
if (!function_exists('store_notification_get_option')) {

    function store_notification_get_option($option_key = '', $default = '', $is_all_option = false)
    {

        $option_value_array = $store_notification_options = get_option('store_notification_options', array());

        if ($is_all_option) {
            return $option_value_array;
        }

        if (isset($option_value_array[$option_key])) {

            return $option_value_array[$option_key];
        }
        return $default;
    }

}

if (!function_exists('store_notification_update_option')) {

    function store_notification_update_option($update_options = array(), $is_all_option = false)
    {
        $option_value_array = $store_notification_options = get_option('store_notification_options', array());

        foreach ($update_options as $name => $value) {

            $option_value_array [$name] = $value;
        }

        
        update_option('store_notification_options', $option_value_array);


    }

}


if (!function_exists('store_notification_get_template')) {

    function store_notification_get_template($template_name, $args = array(), $template_path = '', $default_path = '')
    {
        $cache_key = sanitize_key(implode('-', array('template', $template_name, $template_path, $default_path)));
        $template = (string)wp_cache_get($cache_key, 'store-notification');

        if (!$template) {
            $template = store_notification_locate_template($template_name, $template_path, $default_path);
            wp_cache_set($cache_key, $template, 'store-notification');
        }
        // Allow 3rd party plugin filter template file from their plugin.
        $filter_template = apply_filters('store_notification_get_template', $template, $template_name, $args, $template_path, $default_path);

        if ($filter_template !== $template) {
            if (!file_exists($filter_template)) {
                /* translators: %s template */
                _doing_it_wrong(__FUNCTION__, sprintf(__('%s does not exist.', 'store-notification'), '<code>' . $template . '</code>'), '1.0.1');
                return;
            }
            $template = $filter_template;
        }

        $action_args = array(
            'template_name' => $template_name,
            'template_path' => $template_path,
            'located' => $template,
            'args' => $args,
        );

        if (!empty($args) && is_array($args)) {
            if (isset($args['action_args'])) {
                _doing_it_wrong(
                    __FUNCTION__,
                    __('action_args should not be overwritten when calling store_notification_get_template.', 'store-notification'),
                    '1.0.0'
                );
                unset($args['action_args']);
            }
            extract($args); // @codingStandardsIgnoreLine
        }

        do_action('store_notification_before_template_part', $action_args['template_name'], $action_args['template_path'], $action_args['located'], $action_args['args']);

        include $action_args['located'];

        do_action('store_notification_after_template_part', $action_args['template_name'], $action_args['template_path'], $action_args['located'], $action_args['args']);
    }
}

if (!function_exists('store_notification_locate_template')) {
    function store_notification_locate_template($template_name, $template_path = '', $default_path = '')
    {
        if (!$template_path) {
            $template_path = mb_store_notification()->template_path();
        }

        if (!$default_path) {
            $default_path = mb_store_notification()->plugin_template_path();
        }

        // Look within passed path within the theme - this is priority.
        $template = locate_template(
            array(
                trailingslashit($template_path) . $template_name,
                $template_name,
            )
        );

        // Get default template/.
        if (!$template) {
            $template = $default_path . $template_name;
        }
        // Return what we found.
        return apply_filters('store_notification_locate_template', $template, $template_name, $template_path);
    }
}

if (!function_exists('store_notification_get_template_part')) {

    function store_notification_get_template_part($slug, $name = '')
    {
        $path = "{$slug}.php";

        if ('' !== $name) {

            $path = "{$slug}-{$name}.php";
        }
        $template = store_notification_locate_template($path, false, false);

        require $template;

    }

}
