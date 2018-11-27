define([
    'jquery'
], function ($) {
    'use_strict';

    return function () {
        $.validator.addMethod(
            'mobileUA',
            function (mobile_ua) {
                return mobile_ua.substring(0, 3) == '+38' && mobile_ua.match(/([+]?\d{1,2}[.-\s]?)?(\d{3}[.-]?){2}\d{4}/g) && mobile_ua.match(/^[-+]?[0-9]+$/);
            },
            $.mage.__('Please specify a valid mobile number')
        );
    }
});
