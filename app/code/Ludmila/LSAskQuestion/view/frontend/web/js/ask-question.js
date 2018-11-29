define([
    'jquery',
    'ludmila_validationAlert',
    'Magento_Ui/js/modal/alert',
    'mage/cookies',
    'mage/translate',
    'jquery/ui'
], function ($, validationAlert, alert) {
    'use strict';

    $.widget('ludmila.askQuestion', {
        options: {
            cookieName: 'ludmila_question_was_sent'
        },

        /** @inheritdoc */
        _create: function () {
            $(this.element).submit(this.submitForm.bind(this));
            $('body').on('ludmila_ask_question_clear_cookie', this.clearCookie.bind(this));


        },

        /**
         * Validate request and submit the form if able
         */
        submitForm: function () {
            if (!this.validateForm()) {
                validationAlert();

                return;
            }
            if ($.mage.cookies.get(this.options.cookieName)) {
                alert({
                    title: $.mage.__('Warning'),
                    content: $.mage.__('Wait for 2 minutes and try again.')
                });

                return;
            }

            this.ajaxSubmit();
        },

        /**
         * Submit request via AJAX. Add form key to the post data.
         */
        ajaxSubmit: function () {
            var formData = new FormData($(this.element).get(0));

            formData.append('form_key', $.mage.cookies.get('form_key'));

            formData.append('ludmila_question_was_sent', $.mage.cookies.get(this.options.cookieName));

            formData.append('isAjax', 1);

            $.ajax({
                url: $(this.element).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                dataType: 'json',
                context: this,

                /** @inheritdoc */
                beforeSend: function () {
                    $('body').trigger('processStart');
                },

                /** @inheritdoc */
                success: function (response) {
                    $('body').trigger('processStop');
                    alert({
                        title: $.mage.__(response.status),
                        content: $.mage.__(response.message)
                    });

                    if (response.status === 'Success') {
                        // Prevent from sending requests too often

                        var timeInterval = new Date(new Date().getTime() + 120 * 1000);

                        // console.log(timeInterval);
                        // $.mage.cookies.set(this.options.cookieName, true);
                        // console.log($.mage.cookies.get(this.options.cookieName));

                        $.mage.cookies.set(this.options.cookieName, 1, {expires: timeInterval});

                    }
                },

                /** @inheritdoc */
                error: function () {
                    $('body').trigger('processStop');
                    alert({
                        title: $.mage.__('Error'),
                        content: $.mage.__('Your question can not be sent right now. Please, contact us directly via email or phone to get your answer.')
                    });
                }
            });
        },

        /**
         * Validate request form
         */
        validateForm: function () {
            return $(this.element).validation().valid();
        },

        /**
         * Clear that `ludmila_ask_question_clear_cookie` cookie
         * when the event `ludmila_ask_question_clear_cookie` is triggered
         */
        clearCookie: function () {
            $.mage.cookies.clear(this.options.cookieName);
        }
    });

    return $.ludmila.askQuestion;
});