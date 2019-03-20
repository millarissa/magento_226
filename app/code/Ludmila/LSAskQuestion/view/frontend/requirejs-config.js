var config = {
    map: {
        '*': {
            ludmila_askQuestion: 'Ludmila_LSAskQuestion/js/ask-question',
            ludmila_validationAlert: 'Ludmila_LSAskQuestion/js/validation-alert',
            // overriding default cookie component
            'jquery/jquery.cookie': 'Ludmila_LSAskQuestion/js/jquery/jquery.cookie'
        }
    },

    config: {
        mixins: {
            'mage/validation': {
                'Ludmila_LSAskQuestion/js/validation/validation-phone-mixin': true
            }
        }
    }
};