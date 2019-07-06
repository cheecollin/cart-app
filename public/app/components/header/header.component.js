define([ 'app' ], function (app) {
    
    app.component('header', {
        templateUrl : 'components/header/header.tpl.html',
        controller : [ function HeaderComponent() {
            
            var ctrl = this;
            
            ctrl.page_title = 'Job Ads Checkout';
            
        } ]
    
    });
    
});
