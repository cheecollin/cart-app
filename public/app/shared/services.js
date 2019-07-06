define([ 'app', 'swagger' ], function (app, Swagger) {
    
    app.factory('SwaggerClient', [ '$q', function ($q) {
        
        var SwaggerClient = new Swagger('/docs/api-docs.json');
        
        return {
            call : function (operation_id, params, request_body) {
                
                var deferred = $q.defer();
                
                SwaggerClient.then(function (client) {
                    
                    client.execute({
                        operationId : operation_id,
                        parameters : params,
                        requestBody : request_body,
                        requestInterceptor : function (request) {
                            request.headers.Accept = 'application/json';
                            return request;
                        }
                    }).then(function (response) {
                        if (response.headers['content-type'].indexOf('application/json') !== -1) {
                            deferred.resolve(response.obj);
                        } else {
                            deferred.resolve(response.text);
                        }
                    }, function (err) {
                        deferred.reject(err.response.obj);
                    });
                });
                
                return deferred.promise;
            }
        }

    } ]);
});