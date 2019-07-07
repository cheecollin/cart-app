var allTestFiles = [];
for (var file in window.__karma__.files) {
  if (file.indexOf('/tests/specs/') >= 0) {
      allTestFiles.push(file);
  }
}

require.config({
    // Karma serves files under /base, which is the basePath from your config
    // file
    baseUrl : '/base/app',
    
    // example of using a couple of path translations (paths), to allow us to
    // refer to different library dependencies, without using relative paths
    paths : {
        'angular-mocks' : 'lib/angular-mocks/angular-mocks',
        'jquery' : 'lib/jquery/dist/jquery',
        'bootstrap' : 'lib/bootstrap/dist/js/bootstrap',
        'angular' : 'lib/angular/angular',
        'ng-route' : 'lib/angular-route/angular-route',
        'ng-sanitize' : 'lib/angular-sanitize/angular-sanitize',
        'ui-bootstrap' : 'lib/angular-bootstrap/ui-bootstrap-tpls',
        'app' : '../tests/app'
    },
    
    // example of using a shim, to load non AMD libraries (such as underscore)
    shim : {
        'bootstrap' : {
            deps : [ 'jquery' ]
        },
        'angular' : {
            exports : 'angular'
        },
        'angular-mocks' : {
            deps : [ 'angular' ]
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
    
    // dynamically load all test files
    deps : allTestFiles,
    
    // we have to kickoff jasmine, as it is asynchronous
    callback : window.__karma__.start
});