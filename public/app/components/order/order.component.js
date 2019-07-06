define([ 'angular', 'app', 'components/modal/modal.component' ], function (angular, app) {
    
    app.component('order', {
        templateUrl : 'components/order/order.tpl.html',
        controller : [ '$rootScope', '$timeout', '$uibModal', 'SwaggerClient', function OrderComponent($rootScope, $timeout, $uibModal, SwaggerClient) {
            
            var ctrl = this;
            
            var initPriceSummary = function () {
                
                ctrl.price_summary = {
                    total_price : 0,
                    job_ads : {}
                };
            }

            var init = function () {
                
                ctrl.inputs = {
                    customer_id : 5,
                    quantity : {}
                };
                
                // load customers data
                SwaggerClient.call('getCustomers').then(function (data) {
                    ctrl.customers = data;
                });
                
                // load job ads data
                SwaggerClient.call('getJobAds').then(function (data) {
                    
                    // init selected quantity for job ads
                    angular.forEach(data, function (job_ad) {
                        ctrl.inputs.quantity[job_ad.id] = 0;
                    });
                    
                    ctrl.job_ads = data;
                });
                
                initPriceSummary();
            }

            ctrl.increaseQty = function (id) {
                ctrl.inputs.quantity[id] += 1;
                ctrl.calculateTotalPrice();
            }

            ctrl.decreaseQty = function (id) {
                
                if (ctrl.inputs.quantity[id] >= 0) {
                    ctrl.inputs.quantity[id] -= 1;
                } else {
                    ctrl.inputs.quantity[id] = 0;
                }
                
                if (ctrl.inputs.quantity[id] <= 0) {
                    ctrl.price_summary.job_ads[id].price = 0;
                    ctrl.price_summary.job_ads[id].discount = 0;
                }
                
                ctrl.calculateTotalPrice();
            }

            var calculate_promise;
            
            var processInputs = function (user_inputs) {
                
                var inputs = {
                    customer_id : user_inputs.customer_id,
                    job_ads : []
                };
                
                angular.forEach(user_inputs.quantity, function (qty, job_ad_id) {
                    if (qty > 0) {
                        inputs.job_ads.push({
                            job_ad_id : parseInt(job_ad_id),
                            quantity : parseInt(qty)
                        });
                    }
                });
                
                return inputs;
            }

            ctrl.calculateTotalPrice = function () {
                
                ctrl.calculating = true;
                
                if (typeof calculate_promise !== 'undefined') {
                    $timeout.cancel(calculate_promise);
                }
                
                // set timeout to prevent continuous firing when user inputting
                calculate_promise = $timeout(function () {
                    
                    var inputs = processInputs(ctrl.inputs);
                    
                    SwaggerClient.call('calculateTotalPrice', {}, inputs).then(function (data) {
                        
                        initPriceSummary();
                        
                        angular.forEach(data.job_ads, function (job_ad) {
                            ctrl.price_summary.job_ads[job_ad.job_ad_id] = {
                                price : job_ad.price,
                                discount : job_ad.discount
                            }
                        });
                        
                        ctrl.price_summary.total_price = data.total_price;
                        
                        ctrl.calculating = false;
                    });
                    
                }, 800);
            }

            ctrl.checkout = function () {
                $rootScope.loading = true;
                
                var inputs = processInputs(ctrl.inputs);
                
                SwaggerClient.call('createOrder', {}, inputs).then(function () {
                    
                    $rootScope.loading = false;
                    
                    $uibModal.open({
                        animation : true,
                        component : 'modal',
                        resolve : {
                            title : function () {
                                return 'Checkout Complete';
                            },
                            message : function () {
                                return 'Order Checkout Sucessfully';
                            }
                        }
                    }).result.then(function () {
                        init();
                    });
                }, function () {
                    $rootScope.loading = false;
                });
                
            }

            init();
        } ]
    
    });
    
});
