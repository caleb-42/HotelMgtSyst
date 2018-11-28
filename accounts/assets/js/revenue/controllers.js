revenueApp.controller("revenue", ["$rootScope", "$scope", 'jsonPost', '$filter',  function ($rootScope, $scope, jsonPost, $filter) {
    $scope.tabnav = {
        navs: {
            Frontdesk: {
                name: 'Frontdesk',
                options: {
                    rightbar : false
                }
            },
            Restaurant: {
                name: 'Restaurant',
                options: {
                    rightbar : false
                }
            }
        },
        selected: {
            name: 'Frontdesk',
            options: {
                rightbar : false
            }
        },
        selectNav: function (navname) {
            $scope.tabnav.selected = $scope.tabnav.navs[navname];
            $scope.initList('list_revenues', {table : $filter('lowercase')(navname)});
        }
    };
    $scope.rightSidebar = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/restaurant_bar/admin/list_sessions.php", {})
            }
        },
        subclass: {

        }
    };
    $scope.initList = function(code, info){
        console.log(info.table);
        tabevt = info.table + 'list';
        $rootScope.$emit(tabevt, {script: code , data: info})
    };
    
    
}]);

revenueApp.controller("frontdeskhistory", ["$rootScope", "$scope", 'jsonPost', '$filter', function ($rootScope, $scope, jsonPost, $filter) {
    $scope.frontdesk = {
        evt : 'frontdesklist',
        itemlist: function (range) {
            console.log(range);
            script = "../php1/accounts/" + range.script + ".php";
            if(range.script == 'list_revenues'){
                return {
                    jsonfunc: jsonPost.data(script, range.data)
                }
            }else{
                return {
                    jsonfunc: jsonPost.data(script, {
                        range_details: $filter('json')(range.data)
                    })
                }
            }
            
        },
        listhddata : [
            {
                name: "Tranx ID",
                width: "col-1",
            },
            {
                name: "Tranx Date",
                width: "col-2",
            },
            {
                name: "Paid",
                width: "col-1",
            },
            {
                name: "Payment Date",
                width: "col-2",
            },
            {
                name: "Balance",
                width: "col-1",
            },
            {
                name: "Net Paid",
                width: "col-2",
            },
            {
                name: "Tranx Worth",
                width: "col-2",
            },
            {
                name: "Method",
                width: "col-1",
            },
            /* {
                name: "Rep",
                width: "col-1",
            } */
        ],
        fetchdate : function (){
            if($scope.frontdesk.fromdate == "" || $scope.frontdesk.todate == "" || $scope.frontdesk.fromdate == undefined || $scope.frontdesk.todate == undefined){
                $scope.initList('list_revenues',{table: $filter('lowercase')($scope.tabnav.selected.name)});
                return;
            }
            console.log('fff');
            $scope.initList('list_revenues_range',{table: $filter('lowercase')($scope.tabnav.selected.name), 
            from_date: $scope.frontdesk.fromdate,
            to_date: $scope.frontdesk.todate})
        }
    }

}]);

revenueApp.controller("restauranthistory", ["$rootScope", "$scope", 'jsonPost', '$filter', function ($rootScope, $scope, jsonPost, $filter) {
    $scope.restaurant = {
        evt : 'restaurantlist',
        itemlist: function (range) {
            console.log(range);
            script = "../php1/accounts/" + range.script + ".php";
            if(range.script == 'list_revenues'){
                return {
                    jsonfunc: jsonPost.data(script, range.data)
                }
            }else{
                return {
                    jsonfunc: jsonPost.data(script, {
                        range_details: $filter('json')(range.data)
                    })
                }
            }
        },
        listhddata : [
            {
                name: "Tranx ID",
                width: "col-1",
            },
            {
                name: "Tranx Date",
                width: "col-2",
            },
            {
                name: "Paid",
                width: "col-1",
            },
            {
                name: "Payment Date",
                width: "col-2",
            },
            {
                name: "Balance",
                width: "col-1",
            },
            {
                name: "Net Paid",
                width: "col-2",
            },
            {
                name: "Tranx Worth",
                width: "col-2",
            },
            {
                name: "Method",
                width: "col-1",
            },
            /* {
                name: "Rep",
                width: "col-1",
            } */
        ],
        fetchdate : function (){
            if($scope.restaurant.fromdate == "" || $scope.restaurant.todate == ""){
                return;
            }
            $scope.initList('list_revenues_range',{table: $filter('lowercase')($scope.tabnav.selected.name), 
            from_date: $scope.restaurant.fromdate,
            to_date: $scope.restaurant.todate})
        }
    }

}]);


