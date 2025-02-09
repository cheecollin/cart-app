define([ 'app' ], function (app) {
    
    // sharable directive goes here
    
    app.directive('compile', [ '$compile', '$timeout', function ($compile, $timeout) {
        return {
            restrict : 'A',
            link : function (scope, elem, attrs) {
                $timeout(function () {
                    $compile(elem.contents())(scope);
                });
            }
        };
    } ]);
});