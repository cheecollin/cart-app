define([ 'app' ], function (app) {
    
    app.component('modal', {
        templateUrl : 'components/modal/modal.tpl.html',
        bindings : {
            resolve : '<',
            close : '&',
        },
        controller : [ function OrderSucessComponent() {
            
            var ctrl = this;
            
            ctrl.dismiss = function () {
                ctrl.close();
            }
        } ]
    
    });
    
});
