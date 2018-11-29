revenueApp.controller("revenue", ["$rootScope", "$scope", 'jsonPost', '$filter',  function ($rootScope, $scope, jsonPost, $filter) {
    $scope.tabnav = {
        navs: {
            Transactions: {
                name: 'Transactions',
                options: {
                    rightbar : false
                }
            },
            Payments: {
                name: 'Payments',
                options: {
                    rightbar : false
                }
            }
        },
        selected: {
            name: 'Transactions',
            options: {
                rightbar : false
            }
        },
        selectNav: function (navname) {
            $scope.tabnav.selected = $scope.tabnav.navs[navname];
            /* if(navname == 'Transaction'){
                $scope.initList('list_transactions', {table : 'frontdesk'});
            }else{
                $scope.initList('list_revenues', {table : 'frontdesk'});
            } */
            
        },
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
        tabevt = $filter('lowercase')($scope.tabnav.selected.name) + 'list';
        console.log(tabevt);
        $rootScope.$emit(tabevt, {script: code , data: info})
    };
}]);

revenueApp.controller("transactionhistory", ["$rootScope", "$scope", 'jsonPost', '$filter', function ($rootScope, $scope, jsonPost, $filter) {
    $scope.transaction = {
        itemlist: function (range) {
            console.log(range);
            script = "../php1/accounts/" + range.script + ".php";
            if(range.script == 'list_transactions'){
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
                name: "Ref",
                body: "reservation_ref",
                width: "col-2",
            },
            {
                name: "Total Cost",
                body: "total_cost",
                width: "col-2",
            },
            {
                name: "Deposited",
                body: "deposited",
                width: "col-2",
            },
            {
                name: "Balance",
                body: "balance",
                width: "col-2",
            },
            {
                name: "Status",
                body: "payment_status",
                width: "col-2",
            },
            {
                name: "Method",
                body: "means_of_payment",
                width: "col-2",
            },
            /* {
                name: "Rep",
                width: "col-1",
            } */
        ],
        fetchdate : function (){
            if($scope.transaction.table == "frontdesk"){
                $scope.transaction.listhddata[0].body = 'booking_ref' 
            }else if($scope.transaction.table == "restaurant"){
                $scope.transaction.listhddata[0].body = 'txn_ref' 
            }else if($scope.transaction.table == "reservations"){
                $scope.transaction.listhddata[0].body = 'reservation_ref' 
            }
            if($scope.transaction.fromdate == "" || $scope.transaction.todate == "" || $scope.transaction.fromdate == undefined || $scope.transaction.todate == undefined){
                $scope.initList('list_transactions',{table: $scope.transaction.table});
                return;
            }
            console.log('fff');
            $scope.initList('list_transactions_range',{table: $scope.transaction.table, 
            from_date: $scope.transaction.fromdate,
            to_date: $scope.transaction.todate})
        },
        table : 'frontdesk'
    }
    
     

}]);

revenueApp.controller("paymentshistory", ["$rootScope", "$scope", 'jsonPost', '$filter', function ($rootScope, $scope, jsonPost, $filter) {
    $scope.payment = {
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
                body: "frontdesk_txn",
                width: "col-1",
            },
            {
                name: "Tranx Date",
                body: "txn_date",
                width: "col-2",
            },
            {
                name: "Paid",
                body: "amount_paid",
                width: "col-1",
            },
            {
                name: "Payment Date",
                body: "date_of_payment",
                width: "col-2",
            },
            {
                name: "Balance",
                body: "amount_balance",
                width: "col-1",
            },
            {
                name: "Net Paid",
                body: "net_paid",
                width: "col-2",
            },
            {
                name: "Tranx Worth",
                body: "txn_worth",
                width: "col-2",
            },
            {
                name: "Method",
                body: "means_of_payment",
                width: "col-1",
            },
            /* {
                name: "Rep",
                width: "col-1",
            } */
        ],
        fetchdate : function (){
            if($scope.payment.table == "frontdesk"){
                $scope.payment.listhddata[0].body = 'frontdesk_txn' 
            }else if($scope.payment.table == "restaurant"){
                $scope.payment.listhddata[0].body = 'restaurant_txn' 
            }
            if($scope.payment.fromdate == "" || $scope.payment.todate == "" || $scope.payment.fromdate == undefined || $scope.payment.todate == undefined){
                $scope.initList('list_revenues',{table: $scope.payment.table});
                return;
            }
            $scope.initList('list_revenues_range',{table: $filter('lowercase')($scope.payment.table), 
            from_date: $scope.payment.fromdate,
            to_date: $scope.payment.todate})
        },
        table : 'frontdesk'
    }
}]);


