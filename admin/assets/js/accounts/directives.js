accountsApp.directive('expenselist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/accounts/listTemplates.php?list=expenses',

        scope: false,

        link: function (scope, element, attrs) {
            scope.expenses.jslist = {
                createList: function (param) {
                    listdetails = scope.expenses.itemlist(param);
                    jsonlist = listdetails.jsonfunc;
                    jsonlist.then(function (result) {
                        console.log(result);
                        scope.expenses.jslist.values = param.script == "list_expenses" ? result : result.expense_payments_array;
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
            scope.expenses.jslist.createList({
                script : 'list_expenses',
                data : {}
            });
        }
    };
}]);

accountsApp.directive('accountsuserlist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/accounts/listTemplates.php?list=users',

        scope: false,

        link: function (scope, element, attrs) {
            scope.users.jslist = {
                createList: function () {
                    listdetails = scope.users.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    jsonlist.then(function (result) {
                        console.log(result);
                        scope.users.jslist.values = result;
                        scope.users.jslist.selected = null;
                    });
                    scope.users.listhddata = [
                        {
                            name: "Name",
                            width: "col-6",
                        },
                        {
                            name: "Role",
                            width: "col-6",
                        }
                    ];
                },
                select: function (index, id) {
                    scope.users.jslist.selected = id;
                    scope.users.jslist.selectedObj = scope.users.jslist.newItemArray[index];
                    console.log(scope.users.jslist.newItemArray[index]);
                    scope.sessions.jslist.createList();
                },
                toggleOut : function(){
                    $(".listcont").fadeOut(200);
                },
                toggleIn : function(){
                    $(".listcont").delay(500).fadeIn(200);
                }
            }
            scope.users.jslist.createList();
        }
    };
}]);

accountsApp.directive('accountssessionlist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/accounts/listTemplates.php?list=sessions',

        scope: false,

        link: function (scope, element, attrs) {
            scope.sessions.jslist = {
                createList: function () {
                    if(!scope.users.jslist.selected){
                        return;
                    }
                    listdetails = scope.sessions.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    resultfiltered = [];

                    jsonlist.then(function (result) {
                        if (!result) {
                            return 0;
                        }
                        console.log(result);
                        result.forEach(function (element) {
                            if (element.user_name == scope.users.jslist.selectedObj.user_name && element.role == scope.users.jslist.selectedObj.role) {
                                resultfiltered.push(element);
                                console.log(element);
                            }else{
                                return;
                            }
                        });
                        scope.sessions.jslist.values = resultfiltered;
                        //scope.users.jslist.selected = null;
                    });
                    scope.sessions.listhddata = [
                        {
                            name: "Logged On",
                            width: "col-6",
                        },
                        {
                            name: "Logged Off",
                            width: "col-6",
                        }
                    ];
                }
            }
            scope.sessions.jslist.createList();
        }
    };
}]);


accountsApp.directive('debtlist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/accounts/listTemplates.php?list=debts',

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

accountsApp.directive('history', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/accounts/listTemplates.php?list=frontdesk',

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
