app.directive('jslist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/dashboard/listTemplates.php?list=expenses',

        scope: false,

        link: function (scope, element, attrs) {
            scope.expenses.jslist = {
                createList: function () {
                    listdetails = scope.expenses.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    jsonlist.then(function (result) {
                        console.log(result);
                        scope.expenses.jslist.values = result;
                        /* scope.guest.jslist.values.forEach(function(elem){
                            elem.value = elem.guest_name;
                        }); */
                        //scope.guest.jslist.selected = null;
                    });
                    scope.expenses.listhddata = [
                        {
                            name: "Name",
                            width: "col-2",
                        },
                        {
                            name: "Description",
                            width: "col-3",
                        },
                        {
                            name: "Cost",
                            width: "col-2",
                        },
                        {
                            name: "Amount Paid",
                            width: "col-3",
                        },
                        {
                            name: "Balance",
                            width: "col-2",
                        }
                    ];
                },
                select: function (index, id) {
                    console.log(id);
                    scope.expenses.jslist.selected = id;
                    scope.expenses.jslist.selectedObj = scope.expenses.jslist.newItemArray[index];
                    console.log(scope.expenses.jslist.newItemArray[index]);
                    $rootScope.$emit('expenseselect', scope.expenses.jslist.selectedObj)
                },
                toggleOut : function(){
                    $(".listcont").fadeOut(200);
                },
                toggleIn : function(){
                    $(".listcont").delay(500).fadeIn(200);
                },
                gender : 'male'
            }
            scope.expenses.jslist.createList();
        }
    };
}]);

app.directive('revenuelist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/dashboard/listTemplates.php?list=revenue',

        scope: false,

        link: function (scope, element, attrs) {
            scope.revenue.jslist = {
                createList: function () {
                    listdetails = scope.revenue.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    jsonlist.then(function (result) {
                        console.log(result);
                        scope.revenue.jslist.values = result;
                        /* scope.guest.jslist.values.forEach(function(elem){
                            elem.value = elem.guest_name;
                        }); */
                        //scope.guest.jslist.selected = null;
                    });
                    scope.revenue.listhddata = [
                        {
                            name: "Name",
                            width: "col-3",
                        },
                        {
                            name: "Gender",
                            width: "col-2",
                        },
                        {
                            name: "Rooms",
                            width: "col-2",
                        },
                        {
                            name: "Visit Count",
                            width: "col-2",
                        },
                        {
                            name: "Out bal.",
                            width: "col-3",
                        }
                    ];
                },
                select: function (index, id) {
                    console.log(id);
                    scope.revenue.jslist.selected = id;
                    scope.revenue.jslist.selectedObj = scope.revenue.jslist.newItemArray[index];
                    console.log(scope.revenue.jslist.newItemArray[index]);
                    $rootScope.$emit('revenueselect', scope.revenue.jslist.selectedObj)
                },
                toggleOut : function(){
                    $(".listcont").fadeOut(200);
                },
                toggleIn : function(){
                    $(".listcont").delay(500).fadeIn(200);
                },
                gender : 'male'
            }
            scope.revenue.jslist.createList();
        }
    };
}]);

dashApp.directive('accordion', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/dashboard/listTemplates.php?list=accordion',
        scope: false,
        link: function (scope, element, attrs) {
            scope.type = attrs.type;
        }
    };
}]);



