app.factory('List', function(){
    return {
        createNew: function(a,b,c){
            return new List(a,b,c);
        }
    }
});

app.factory('jsonGet', ['$http', function($http){
    return {
        data: function(rest,json){
            var req = $http(
                {
                    method: "get",
                    url: rest,
                    data: $.param(json),
                    headers : {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function(result){
                return result.data;
            });
            return req;
        }
    }
}]);
app.factory('jsonPost', ['$http', function($http){
    return {
        data: function(rest, json){
            var req = $http(
                {
                    method: "post",
                    url: rest,
                    data: $.param(json),
                    headers : {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function(result){
                return result.data;
            });
            return req;
        }
    }
}]);
