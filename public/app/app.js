define([ 'angular', 'routes', 'ng-route', 'ng-sanitize', 'ui-bootstrap' ], function (angular, routes) {
    
    var app = angular.module('JobAdsCheckout', [ 'ngRoute', 'ngSanitize', 'ui.bootstrap' ]);
    
    app.config([ '$routeProvider', '$compileProvider', '$provide', '$httpProvider', function ($routeProvider, $compileProvider, $provide, $httpProvider) {
        
        // Provider-based component for registering component after angular
        // bootstrap
        app.component = function (name, component) {
            $compileProvider.component(name, component);
            return (this);
        };
        
        app.factory = function (name, factory) {
            $provide.factory(name, factory);
            return (this);
        };
        
        app.service = function (name, service) {
            $provide.service(name, service);
            return (this);
        };
        
        angular.forEach(routes, function (route) {
            
            $routeProvider.when(route.path, {
                template : '<' + route.component + ' ng-show="!loading"></' + route.component + '>',
                resolve : {
                    loadComponent : [ '$q', function ($q) {
                        var deferred = $q.defer();
                        
                        var component = 'components/' + route.component + '/' + route.component + '.component';
                        
                        require([ component ], function () {
                            deferred.resolve(true);
                        });
                        
                        return deferred.promise;
                        
                    } ]
                }
            });
        });
        
        // Cache busting for view templates
        $httpProvider.interceptors.push([ function () {
            return {
                'request' : function (conf) {
                    
                    var templates_pattern = /^components\/(.*)\.tpl\.html/g;
                    
                    if (templates_pattern.test(conf.url)) {
                        conf.url = conf.url + '?t=' + config.version;
                    }
                    
                    return conf;
                }
            }
        } ]);
    } ])

    app.run([ '$rootScope', '$timeout', function ($rootScope, $timeout) {
        
        $rootScope.loading = true;
        
        $rootScope.config = config;
        
        $rootScope.$on('$routeChangeStart', function () {
            $rootScope.loading = true;
        });
        
        $rootScope.$on('$routeChangeSuccess', function () {
            $timeout(function () {
                $rootScope.loading = false;
            }, 50);
        });
    } ]);
    
    // Add method for angular bootstraping
    app.init = function () {
        
        // load all shared scripts before bootstrap.
        require([ 'bootstrap', 'shared/services', 'shared/directives', 'shared/filters', 'components/header/header.component', 'components/spinner/spinner.component' ],
                function () {
                    angular.bootstrap(document, [ 'JobAdsCheckout' ]);
                });
        
    };
    
    return app;
});
