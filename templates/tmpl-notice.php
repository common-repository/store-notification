<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$blogtime = current_time('mysql', 1);
list($today_year, $today_month, $today_day, $hour, $minute, $second) = preg_split('([^0-9])', $blogtime);
?>
<div class="mb-notification-wrap <?php esc_attr_e($notice['notice_position']); ?>" data-end-datetime="<?php esc_attr_e($notice['end_date_time']); ?>" style="background:<?php echo sanitize_hex_color($notice['notification_bar_background']) ?>">
    <div class="mb-inner">
        <div class="mb-container <?php echo esc_attr($notice['container_class']) ?>">
            <?php echo 'yes' == $notice['show_close_button'] ? '<span class="close">X</span>': ''; ?>

            <div class="mb-notice-date" style="background:<?php echo sanitize_hex_color($notice['time_block_background']) ?>">
                <span class="date d" data-text="<?php echo esc_attr($notice['day_text']) ?>"><?php echo esc_html($notice['days']);?><span><?php echo esc_html($notice['day_text']) ?></span></span>
                <span class="date h" data-text="<?php echo esc_attr($notice['hour_text']) ?>"><?php echo esc_html($notice['h']); ?><span><?php echo esc_html($notice['hour_text']) ?></span></span>
                <span class="date i" data-text="<?php echo esc_attr($notice['minute_text']) ?>"><?php echo esc_html($notice['i']); ?><span><?php echo esc_html($notice['minute_text']) ?></span></span>
                <span class="date s" data-text="<?php echo esc_attr($notice['second_text']) ?>"><?php echo esc_attr($notice['s']); ?><span><?php echo esc_html($notice['second_text']) ?></span></span>
            </div>
            <div class="mb-message">
                <p><?php echo esc_html($notice['promo_text']);
                    if (!empty($notice['promo_code'])) {
                    ?> <span class="coupon-code"><?php echo esc_html($notice['promo_code']); ?></span></p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

