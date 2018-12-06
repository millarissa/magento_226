var config = {
    map: {
        '*': {
            ludmila_askQuestion: 'Ludmila_LSAskQuestion/js/ask-question',
            ludmila_validationAlert: 'Ludmila_LSAskQuestion/js/validation-alert',
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