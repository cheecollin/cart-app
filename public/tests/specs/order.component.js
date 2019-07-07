define([ 'angular-mocks', '../../app/components/order/order.component' ], function () {
    
    describe('order component', function () {
        
        var controller = null;
        
        var mockSwaggerClient = {
            call : jasmine.createSpy('SwaggerClient.call')
        };
        
        var mockModal = {
            open : jasmine.createSpy('$uibModal.open')
        };
        
        beforeEach(module('JobAdsCheckout'));
        
        beforeEach(inject(function ($componentController, $q, $rootScope) {
            
            mockSwaggerClient.call.and.callFake(function (method_name) {
                var data = {};
                
                switch (method_name) {
                    case 'getJobAds':
                        data = [ {
                            "id" : 1,
                            "name" : "classic",
                            "description" : "Classic Ad",
                            "price" : "269.99"
                        }, {
                            "id" : 2,
                            "name" : "standout",
                            "description" : "Standout Ad",
                            "price" : "322.99"
                        } ];
                        break;
                    case 'getCustomers':
                        data = [ {
                            "id" : 1,
                            "name" : "Unilever"
                        }, {
                            "id" : 2,
                            "name" : "Apple"
                        }, {
                            "id" : 3,
                            "name" : "Nike"
                        } ];
                        break;
                }
                
                return $q.when(data);
            });
            
            controller = $componentController('order', {
                SwaggerClient : mockSwaggerClient,
                $uibModal : mockModal
            });
            
            $rootScope.$apply();
        }));
        
        describe('increaseQty', function () {
            it('should increase the input quantity of a job ad', function () {
                
                controller.inputs = {
                    quantity : {
                        1 : 1
                    }
                };
                
                controller.increaseQty(1);
                
                expect(controller.inputs.quantity[1]).toEqual(2);
            });
            
            it('should call calculateTotalPrice function', function () {
                
                spyOn(controller, 'calculateTotalPrice');
                
                controller.inputs = {
                    quantity : {
                        1 : 1
                    }
                };
                
                controller.increaseQty(1);
                
                expect(controller.calculateTotalPrice).toHaveBeenCalled();
            });
        });
        
        describe('decreaseQty', function () {
            
            it('should decrease the input quantity of a job ad', function () {
                
                controller.inputs = {
                    quantity : {
                        1 : 5
                    }
                };
                
                controller.decreaseQty(1);
                
                expect(controller.inputs.quantity[1]).toEqual(4);
            });
            
            it('should reset quanity to 0 if user inputed quantity is less than 0', function () {
                
                controller.inputs = {
                    quantity : {
                        1 : -10
                    }
                };
                
                controller.price_summary = {
                    job_ads : {
                        1 : {
                            price : 0,
                            discount : 0
                        }
                    }
                };
                
                controller.decreaseQty(1);
                
                expect(controller.inputs.quantity[1]).toEqual(0);
            });
            
            it('should reset to price summary if user inputed quantity is 0 or less', function () {
                
                controller.inputs = {
                    quantity : {
                        1 : 1
                    }
                };
                
                controller.price_summary = {
                    job_ads : {
                        1 : {
                            price : 300.00,
                            discount : 20.10
                        }
                    }
                };
                
                controller.decreaseQty(1);
                
                expect(controller.price_summary.job_ads[1].price).toEqual(0);
                expect(controller.price_summary.job_ads[1].discount).toEqual(0);
            });
            
            it('should call calculateTotalPrice function', function () {
                
                spyOn(controller, 'calculateTotalPrice');
                
                controller.inputs = {
                    quantity : {
                        1 : 1
                    }
                };
                
                controller.price_summary = {
                    job_ads : {
                        1 : {
                            price : 0,
                            discount : 0
                        }
                    }
                };
                controller.decreaseQty(1);
                
                expect(controller.calculateTotalPrice).toHaveBeenCalled();
            });
        });
        
        describe('calculateTotalPrice', function () {
            
            it('should call to API with proper payload', inject(function ($timeout) {
                
                var payload = {
                    customer_id : 6,
                    job_ads : [ {
                        job_ad_id : 3,
                        quantity : 10
                    }, {
                        job_ad_id : 4,
                        quantity : 1
                    } ]
                };
                
                mockSwaggerClient.call.calls.reset();
                
                controller.inputs = {
                    customer_id : 6,
                    quantity : {
                        3 : 10,
                        4 : 1
                    }
                };
                
                controller.calculateTotalPrice();
                
                $timeout.flush();
                
                expect(mockSwaggerClient.call).toHaveBeenCalledWith('calculateTotalPrice', {}, payload);
            }));
        });
        
        describe('checkout', function () {
            
            beforeEach(inject(function($q){
                mockModal.open.and.callFake(function(){
                   return {
                       result :$q.when({})
                   };
                });
            }));
            
            it('should shown modal on sucessfull checkout', inject(function ($rootScope) {
                controller.checkout();
                $rootScope.$apply();
                expect(mockModal.open).toHaveBeenCalled();
            }));
            
            it('should reset the UI to initial state', inject(function ($rootScope) {
                
                controller.inputs = {
                        customer_id : 3,
                        quantity : {
                            1 : 10,
                            2 : 1
                        }
                    };
                
                controller.checkout();
                $rootScope.$apply();
                
                expect(controller.inputs).toEqual({
                    customer_id : 5,
                    quantity : { 1: 0, 2: 0 }
                });
                
                expect(controller.price_summary).toEqual({
                    total_price : 0,
                    job_ads : {}
                });
                
            }));
        });
        
    });
});