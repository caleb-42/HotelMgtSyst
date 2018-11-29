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
                            width: "col-3",
                        },
                        {
                            name: "Description",
                            width: "col-2",
                        },
                        {
                            name: "Cost",
                            width: "col-2",
                        },
                        {
                            name: "Amount Paid",
                            width: "col-2",
                        },
                        {
                            name: "Balance",
                            width: "col-3",
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

app.directive('debtlist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/dashboard/listTemplates.php?list=debts',

        scope: false,

        link: function (scope, element, attrs) {
            scope.debts.jslist = {
                createList: function () {
                    listdetails = scope.debts.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    jsonlist.then(function (result) {
                        console.log(result);
                        scope.debts.jslist.values = result.debts_array;
                    });
                    scope.debts.listhddata = [
                        {
                            name: "Name",
                            width: "col-3",
                        },
                        {
                            name: "Description",
                            width: "col-2",
                        },
                        {
                            name: "Cost",
                            width: "col-2",
                        },
                        {
                            name: "Amount Paid",
                            width: "col-2",
                        },
                        {
                            name: "Balance",
                            width: "col-3",
                        }
                    ];
                },
                select: function (index, id) {
                    console.log(id);
                    scope.debts.jslist.selected = id;
                    scope.debts.jslist.selectedObj = scope.debts.jslist.newItemArray[index];
                    console.log(scope.debts.jslist.newItemArray[index]);
                    $rootScope.$emit('debtselect', scope.debts.jslist.selectedObj)
                },
                toggleOut : function(){
                    $(".listcont").fadeOut(200);
                },
                toggleIn : function(){
                    $(".listcont").delay(500).fadeIn(200);
                },
                gender : 'male'
            }
            scope.debts.jslist.createList();
        }
    };
}]);




