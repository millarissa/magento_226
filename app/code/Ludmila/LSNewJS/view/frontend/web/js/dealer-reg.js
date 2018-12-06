define([
        "jquery",
        "Magento_Ui/js/modal/modal"
    ], function ($) {
        var DealerRegPopup = {
            initModal: function (config, element) {
                // $dealerForm = $('.form-create-account').clone();
                $dealerForm = $('#dealer-form-validate');
                $dealerForm.modal();
                $element = $(element);
                $element.click(function () {
                    $dealerForm.modal('openModal');
                    $dealerForm.trigger('contentUpdated');
                });
            }
        };

        return {
            'dealer_reg': DealerRegPopup.initModal
        };
    }
);