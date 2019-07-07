define([ 'angular-mocks', '../../app/components/spinner/spinner.component' ], function () {
    
    describe('spinner component', function () {
        
        beforeEach(function () {
            module('JobAdsCheckout');
            module('templates');
        });
        
        it('should be shown during loading', inject(function ($rootScope, $compile) {
            scope = $rootScope.$new();
            
            scope.loading = true;
            
            var element = angular.element('<spinner loading="loading"></spinner>');
            
            element = $compile(element)(scope);
            scope.$digest();
            
            expect(angular.element(element[0].querySelector('.spinner')).hasClass('ng-hide')).toBe(false);
        }));
        
        it('should be hidden when not loading', inject(function ($rootScope, $compile) {
            scope = $rootScope.$new();
            
            scope.loading = false;
            
            var element = angular.element('<spinner loading="loading"></spinner>');
            
            element = $compile(element)(scope);
            scope.$digest();
            
            expect(angular.element(element[0].querySelector('.spinner')).hasClass('ng-hide')).toBe(true);
        }));
    });
    
});