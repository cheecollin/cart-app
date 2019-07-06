define([ 'app' ], function (app) {
    
    app.component('spinner', {
        bindings : {
            loading : '<'
        },
        templateUrl : 'components/spinner/spinner.tpl.html',
        controller : [ function SpinnerController() {
            
        } ]
    
    });
    
});
