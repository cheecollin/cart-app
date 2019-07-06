require.config({
    urlArgs : typeof config !== 'undefined' ? 't=' + config.version : null,
    paths : {
        'requirejs' : 'lib/requirejs/require',
        'jquery' : 'lib/jquery/dist/jquery',
        'bootstrap' : 'lib/bootstrap/dist/js/bootstrap',
        'angular' : 'lib/angular/angular',
        'ng-route' : 'lib/angular-route/angular-route',
        'ng-sanitize' : 'lib/angular-sanitize/angular-sanitize',
        'ui-bootstrap' : 'lib/angular-bootstrap/ui-bootstrap-tpls',
        'swagger' : 'lib/swagger-js/browser/index',
    },
    packages : [ {
        name : 'moment',
        location : 'lib/moment',
        main : 'moment'
    } ],
    shim : {
        'bootstrap' : {
            deps : [ 'jquery' ]
        },
        'angular' : {
            exports : 'angular'
        },
        'ng-route' : {
            deps : [ 'angular' ]
        },
        'ng-sanitize' : {
            deps : [ 'angular' ]
        },
        'ui-bootstrap' : {
            deps : [ 'angular' ]
        },
        'swagger' : {
            exports : 'Swagger'
        }
    },
    waitSeconds : 10
});

require([ 'app' ], function (app) {
    app.init();
});