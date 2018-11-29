restaurantApp.directive('productlist', ['$rootScope', '$filter', function ($rootScope, $filter) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/restaurant/listTemplates.php?list=stock',

        scope: false,

        link: function (scope, element, attrs) {
            var jslistObj;
            scope.productstock.jslist = {
                createList: function () {
                    listdetails = scope.productstock.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    jsonlist.then(function (result) {
                        console.log(result);
                        scope.productstock.jslist.values = result;
                        scope.productstock.jslist.selected = null;
                    });
                    scope.productstock.listhddata = [
                        {
                            name: "Name",
                            width: "col-2",
                        },
                        {
                            name: "Stock",
                            width: "col-1",
                        },
                        {
                            name: "Price",
                            width: "col-1",
                        },
                        {
                            name: "Description",
                            width: "col-2",
                        },
                        {
                            name: "Category",
                            width: "col-2",
                        },
                        {
                            name: "Type",
                            width: "col-2",
                        },
                        {
                            name: "Shelf Item",
                            width: "col-2",
                        },
                    ];
                    /* if(scope.productstock.jslist.selected){
                        scope.productstock.jslist.selectedObj = $filter('filter')(scope.productstock.jslist.values, {id : scope.productstock.jslist.selected}, true);
                        
                        console.log(scope.productstock.jslist.selectedObj);
                    } */
                },
                select: function (index, id) {
                    scope.productstock.jslist.selected = id;
                    scope.productstock.jslist.selectedObj = scope.productstock.jslist.newItemArray[index];
                    scope.details.discount.selected_discount = 'item';
                    console.log(scope.productstock.jslist.selectedObj);
                },
                toggleOut: function () {
                    $(".listcont").fadeOut(200);
                },
                toggleIn: function () {
                    $(".listcont").delay(500).fadeIn(200);
                },
                shelfitem : 'yes'
            }
            scope.productstock.jslist.createList();
        }
    };
}]);

restaurantApp.directive('discountlist', ['$rootScope', '$filter', function ($rootScope, $filter) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/restaurant/listTemplates.php?list=discount',
        scope: false,

        link: function (scope, element, attrs) {
            var jslistObj;
            scope.details.discount.jslist = {
                createList: function () {
                    listdetails = scope.details.discount.itemlist(scope.details.discount.selected_discount);

                    jsonlist = listdetails.jsonfunc;

                    resultfiltered = [];

                    jsonlist.then(function (result) {
                        if (!result) {
                            return 0;
                        }
                        console.log(result);
                        result.forEach(function (element) {
                            if (scope.details.discount.selected_discount == "total" && element.discount_item == "all") {
                                resultfiltered.push(element);
                                console.log(element);
                            } else if (scope.details.discount.selected_discount == "item" && scope.productstock.jslist.selectedObj) {
                                if (element.discount_item == scope.productstock.jslist.selectedObj.item) {
                                    resultfiltered.push(element)
                                    console.log(element);
                                }
                            }else{
                                return 0;
                            }
                        });
                        scope.details.discount.jslist.values = resultfiltered;
                        scope.details.discount.jslist.selected = null;
                    });
                },
                select: function (index, id) {
                    scope.details.discount.jslist.selected = id;
                    scope.details.discount.jslist.selectedObj = scope.details.discount.jslist.values[index];
                    console.log(scope.details.discount.jslist.selectedObj);
                },
                toggleOut: function () {
                    $(".discntfade").fadeOut(200);
                },
                toggleIn: function () {
                    $(".discntfade").delay(500).fadeIn(200);
                }
            }
            scope.details.discount.jslist.createList();
        }
    };
}]);

restaurantApp.directive('customerslist', ['$rootScope', '$filter', function ($rootScope, $filter) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/restaurant/listTemplates.php?list=customers',

        scope: false,

        link: function (scope, element, attrs) {
            scope.customers.jslist = {
                createList: function () {
                    listdetails = scope.customers.itemlist();
                    jsonlist = listdetails.jsonfunc;

                    jsonlist.then(function (result) {
                        if (!result) {
                            return 0;
                        }
                        console.log(result);
                        scope.customers.jslist.values = result;
                        scope.customers.jslist.selected = null;
                    });
                    scope.customers.listhddata = [
                        {
                            name: "Cust ID",
                            width: "col-2",
                        },
                        {
                            name: "Name",
                            width: "col-2",
                        },
                        {
                            name: "Phone",
                            width: "col-2",
                        },
                        {
                            name: "Address",
                            width: "col-2",
                        },
                        {
                            name: "Gender",
                            width: "col-1",
                        },
                        {
                            name: "Oustanding Bal",
                            width: "col-3",
                        }
                    ];
                },
                select: function (index, id) {
                    if($filter('limitTo')(id, 3) == 'LOD'){
                        //return;
                    }
                    scope.customers.jslist.selected = id;
                    scope.customers.jslist.selectedObj = scope.customers.jslist.newItemArray[index];
                    console.log(scope.customers.jslist.selectedObj);
                    $rootScope.$emit('custselect', {customer_ref : id, obj: scope.customers.jslist.selectedObj});
                    //scope.palistsales.jslist.createList(params);
                },
                toggleOut: function () {
                    $(".listcont").fadeOut(200);
                },
                toggleIn: function () {
                    $(".listcont").delay(500).fadeIn(200);
                },
            }
            scope.customers.jslist.createList();
            $rootScope.$on('createcustomerlist', function(evt, params){
                scope.customers.jslist.createList();
            });
        }
    };
}]);

restaurantApp.directive('saleshistorylist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/restaurant/listTemplates.php?list=sales',

        scope: false,

        link: function (scope, element, attrs) {
            scope.salesHistory.jslist = {
                createList: function () {
                    listdetails = scope.salesHistory.itemlist();
                    jsonlist = listdetails.jsonfunc;

                    jsonlist.then(function (result) {
                        if (!result) {
                            return 0;
                        }
                        console.log(result);
                        scope.salesHistory.jslist.values = result;
                    });
                    scope.salesHistory.listhddata = [
                        {
                            name: "Tranx Ref",
                            width: "col-1",
                        },
                        {
                            name: "Method",
                            width: "col-2",
                        },
                        {
                            name: "Items",
                            width: "col-1",
                        },
                        {
                            name: "Cost",
                            width: "col-1",
                        },
                        {
                            name: "Discnt Cost",
                            width: "col-1",
                        },
                        {
                            name: "Tranx Discnt",
                            width: "col-1",
                        },
                        {
                            name: "Deposited",
                            width: "col-2",
                        },
                        {
                            name: "Balance",
                            width: "col-1",
                        },
                        {
                            name: "Status",
                            width: "col-2",
                        }
                    ];
                },
                select: function (index, id) {
                    scope.salesHistory.jslist.selected = id;
                    scope.salesHistory.jslist.selectedObj = scope.salesHistory.jslist.newItemArray[index];
                    console.log(scope.salesHistory.jslist.selectedObj);
                    $rootScope.$emit('tranxselect', {sales_ref : id, obj: scope.salesHistory.jslist.selectedObj});
                }
            }
            scope.salesHistory.jslist.createList();
        }
    };
}]);

restaurantApp.directive('stockhistorylist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/restaurant/listTemplates.php?list=stocks',

        scope: false,

        link: function (scope, element, attrs) {
            scope.stockHistory.jslist = {
                createList: function () {
                    listdetails = scope.stockHistory.itemlist();
                    jsonlist = listdetails.jsonfunc;

                    jsonlist.then(function (result) {
                        if (!result) {
                            return 0;
                        }
                        console.log(result);
                        scope.stockHistory.jslist.values = result;
                    });
                    scope.stockHistory.listhddata = [
                        {
                            name: "Tranx Ref",
                            width: "col-2",
                        },
                        {
                            name: "Item",
                            width: "col-1",
                        },
                        {
                            name: "Previous Stock",
                            width: "col-2",
                        },
                        {
                            name: "Quantity",
                            width: "col-1",
                        },
                        {
                            name: "New Stock",
                            width: "col-2",
                        },
                        {
                            name: "Category",
                            width: "col-2",
                        },
                        {
                            name: "Tranx Date",
                            width: "col-2",
                        }
                    ];
                }
            }
            scope.stockHistory.jslist.createList();
        }
    };
}]);

restaurantApp.directive('listsale', ['$rootScope', '$filter', function ($rootScope, $filter) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/restaurant/listTemplates.php?list=tranxsales',

        scope: false,

        link: function (scope, element, attrs) {
            scope.listsales.jslist = {
                createList: function (params) {
                    listdetails = scope.listsales.itemlist(params);
                    jsonlist = listdetails.jsonfunc;

                    jsonlist.then(function (result) {
                        /* if (!result) {
                            return 0;
                        } */
                        console.log(result);
                        scope.listsales.jslist.values = result;
                    });
                    scope.listsales.listhddata = [
                        {
                            name: "Item",
                            width: "col-3 f-13",
                        },
                        {
                            name: "Qty",
                            width: "col-1 f-13",
                        },
                        {
                            name: "Unit Cost",
                            width: "col-2 f-13",
                        },
                        {
                            name: "Cost",
                            width: "col-2 f-13",
                        },
                        {
                            name: "Discnt Amt",
                            width: "col-2 f-13",
                        },
                        {
                            name: "Discnt %",
                            width: "col-1 f-13",
                        }
                    ];
                }
            };
            //scope.listsales.jslist.createList({sales_ref : 0});
            $rootScope.$on('tranxselect' , function(evt, params){
                //console.log('sssss');
                scope.listsales.jslist.createList(params);
                scope.listsales.jslist.tranx = params.obj;
                scope.listsales.jslist.active = true;
            });
        }
    };
}]);

restaurantApp.directive('restaurantuserlist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/restaurant/listTemplates.php?list=users',

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

restaurantApp.directive('restaurantsessionlist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/restaurant/listTemplates.php?list=sessions',

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
                            name: "Username",
                            width: "col-4",
                        },
                        {
                            name: "Logged On Time",
                            width: "col-4",
                        },
                        {
                            name: "Logged Off Time",
                            width: "col-4",
                        }
                    ];
                }
            }
            scope.sessions.jslist.createList();
        }
    };
}]);
