// @var store_notification_params
var StoreNotification = function ($) {
    return {

        init: function () {
            this.cacheDom();
            this.bindEvents();
        },
        cacheDom: function () {
            this.$notification_wrap = $('.mb-notification-wrap');
        },

        bindEvents: function () {

            var notification_wrapper = this.$notification_wrap;
            var end_date = notification_wrapper.attr('data-end-datetime');
            var calcNewYear = setInterval(function () {
                var date_future = new Date(end_date);
                console.log(date_future);
                var date_now = new Date();
                var seconds = Math.floor((date_future - (date_now)) / 1000);
                var minutes = Math.floor(seconds / 60);
                var hours = Math.floor(minutes / 60);
                var days = Math.floor(hours / 24);

                hours = hours - (days * 24);
                minutes = minutes - (days * 24 * 60) - (hours * 60);
                seconds = seconds - (days * 24 * 60 * 60) - (hours * 60 * 60) - (minutes * 60);

                notification_wrapper.find('.date.d').html(days + '<span>' + notification_wrapper.find('.date.d').attr('data-text') + '</span>');
                notification_wrapper.find('.date.h').html(hours + '<span>' + notification_wrapper.find('.date.h').attr('data-text') + '</span>');
                notification_wrapper.find('.date.i').html(minutes + '<span>' + notification_wrapper.find('.date.i').attr('data-text') + '</span>');
                notification_wrapper.find('.date.s').html(seconds + '<span>' + notification_wrapper.find('.date.s').attr('data-text') + '</span>');

            }, 1000);


            this.makeTop();

            this.close();
        },
        makeTop: function () {

            var hasTop = this.$notification_wrap.hasClass('top-normal') || this.$notification_wrap.hasClass('top-fixed');

            var notificationHeight = 0;
            if (hasTop) {

                notificationHeight = this.$notification_wrap.height();

                var notificationTopPosition = 0;

                if ($('body').find('#wpadminbar').length > 0) {

                    notificationTopPosition = $('#wpadminbar').height();
                }

            }

            $('body').prepend('<div class="store-notification-content" style="height:' + notificationHeight + 'px;width:100%; display:block;"></div>');
            this.$notification_wrap.css({
                'top': notificationTopPosition + 'px'
            }).show();
        },
        close: function () {
            var close = this.$notification_wrap.find('.close');
            close.on('click', function () {
                $(this).closest('.mb-notification-wrap').remove();
                $('body').find('.store-notification-content').remove();
            });

        }


    };
}(jQuery);


(function ($) {

    $(document).ready(function () {

        StoreNotification.init();
    });

}(jQuery));