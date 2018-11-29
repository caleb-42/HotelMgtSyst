app.directive('history', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/revenue/listTemplates.php?list=frontdesk',

        scope: {
            listhddata: "=",
            itemlist : "&",
            evt : "=",
        },

        link: function (scope, element, attrs) {
            scope.jslist = {
                createList: function (param) {
                    console.log(scope.list);
                    listdetails = scope.itemlist({range:param});
                    jsonlist = listdetails.jsonfunc;
                    scope.jslist.values = [];
                    jsonlist.then(function (result) {
                        if (!result) {
                            return 0;
                        }
                        console.log(result);
                        scope.jslist.values = result.revenues_array;
                    });
                },
                /* select: function (index, id) {
                    scope.jslist.selected = id;
                    scope.jslist.selectedObj = scope.jslist.newItemArray[index];
                    console.log(scope.jslist.selectedObj);
                    
                } */
            }
            $rootScope.$on(attrs.evt,function(evt, param){
                console.log(param);
                scope.list = param.table;
                scope.jslist.createList(param);
            });
            scope.list = attrs.list;
            scope.jslist.createList({
                script: attrs.script ,
                data : {table : attrs.list}
            });
            
        }
    };
}]);
