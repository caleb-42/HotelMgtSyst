accountsApp.controller("accounts", ["$rootScope", "$scope", 'jsonPost', '$filter',  function ($rootScope, $scope, jsonPost, $filter) {
    $scope.tabnav = {
        navs: {
            Expenses: {
                name: 'Expenses',
                options: {
                    rightbar: false
                }
            },
            Debts: {
                name: 'Debts',
                options: {
                    rightbar: false
                }
            },
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
            },
            Users: {
                name: 'Users',
                options: {
                    rightbar: {
                        present: true,
                        rightbarclass: 'w-30',
                        primeclass: 'w-70'
                    }
                }
            }
        },
        selected: {
            name: 'Expenses',
            options: {
                rightbar : false
            }
        },
        selectNav: function (navname) {
            $scope.tabnav.selected = $scope.tabnav.navs[navname];
        }
    };
    $scope.rightSidebar = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/admin/account_admin/admin/list_sessions.php", {})
            }
        },
        subclass: {

        },
        
    };
    $scope.initList = function(code, info){
        console.log(info.table);
        tabevt = $filter('lowercase')($scope.tabnav.selected.name) + 'list';
        console.log(tabevt);
        $rootScope.$emit(tabevt, {script: code , data: info})
    };
    $scope.transaction = {
        itemlist: function (range) {
            console.log(range);
            script = "../php1/admin/account_admin/" + range.script + ".php";
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

    $scope.payment = {
        itemlist: function (range) {
            script = "../php1/admin/account_admin/" + range.script + ".php";
            console.log(range);
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
    $scope.expenses = {
        itemlist: function (range) {
            console.log(range);
            script = "../php1/admin/account_admin/" + range.script + ".php";
            if(range.script == 'list_expenses'){
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
        addExpenses: function (jsonexpense) {
            console.log("new Expense", jsonexpense);
            //return;     
            jsonPost.data("../php1/accounts/add_expense.php", {
                add_expense: $filter('json')(jsonexpense)
            }).then(function (response) {
                console.log(response);
                $scope.expenses.jslist.toggleOut();
                res = $rootScope.settings.modal.msgprompt(response);
                res ? $scope.expenses.jslist.createList() : null;
                $scope.expenses.itemlist().jsonfunc.then(function(response){
                    $scope.expenses.jslist.selectedObj =  $filter('filterObj')(response,$scope.expenses.jslist.selected, ['expense_ref']);
                    $scope.expenses.jslist.selected = $scope.expenses.jslist.selectedObj.expense_ref;
                    console.log($scope.expenses.jslist.selectedObj);
                });
                $scope.expenses.jslist.toggleIn();
            });
        },
        deleteExpenses: function () {
            jsonexp = {};
            jsonexp.expenses = [$scope.expenses.jslist.selectedObj];
            console.log("new expenses", jsonexp);
            jsonPost.data("../php1/admin/account_admin/admin/del_expense.php", {
                del_expense: $filter('json')(jsonexp)
            }).then(function (response) {
                $scope.expenses.jslist.toggleOut();
                console.log(response);
                $scope.expenses.jslist.createList();
                $scope.expenses.jslist.selectedObj = {};
                $scope.expenses.jslist.selected = null;
                $scope.expenses.jslist.toggleIn();
            });
        },
        fetchdate : function (){
            if($scope.expenses.fromdate == "" || $scope.expenses.todate == "" || $scope.expenses.fromdate == undefined || $scope.expenses.todate == undefined){
                $scope.expenses.jslist.createList({
                    script : 'list_expenses',
                    data : {}
                });
                return;
            }
            $scope.expenses.jslist.createList({
                script : 'list_expense_range',
                data : {
                    from_date: $scope.expenses.fromdate,
                    to_date: $scope.expenses.todate
                }
            });
        }
    };

    $scope.debts = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/admin/account_admin/list_debts.php", {})
            }
        },
        payDebts: function (jsondebts) {    
            jsondebts.expense_ref = $scope.debts.jslist.selected;
            console.log("new Debts", jsondebts);
            ///return; 
            jsonPost.data("../php1/accounts/expense_pay.php", {
                payment_details: $filter('json')(jsondebts)
            }).then(function (response) {
                console.log(response);
                $scope.debts.jslist.toggleOut();
                res = $rootScope.settings.modal.msgprompt(response);
                res ? $scope.debts.jslist.createList() : null;
                $scope.debts.itemlist().jsonfunc.then(function(response){
                    $scope.debts.jslist.selectedObj =  $filter('filterObj')(response.debts_array ,$scope.debts.jslist.selected, ['expense_ref']);
                    $scope.debts.jslist.selected = $scope.debts.jslist.selectedObj.expense_ref;
                    console.log($scope.debts.jslist.selectedObj);
                });
                $scope.debts.jslist.toggleIn();
            });
        }
    };

    $scope.users = {
        jslist:{},
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/admin/account_admin/admin/list_users.php", {})
            }
        },
        addUser: function (jsonprod) {
            console.log("new user", jsonprod);

            jsonPost.data("../php1/admin/account_admin/admin/add_user.php", {
                new_user: $filter('json')(jsonprod)
            }).then(function (response) {
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.users.jslist.createList();
            });
        },
        updateUser: function (jsonuser) {
            jsonuser.id = $scope.users.jslist.selected;
            console.log("new product", jsonuser);
            jsonPost.data("../php1/admin/account_admin/admin/edit_user.php", {
                update_user: $filter('json')(jsonuser)
            }).then(function (response) {
                $scope.users.jslist.toggleOut();
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.users.jslist.createList();
                $scope.users.jslist.toggleIn();
            });
        },
        deleteUser: function () {
            jsonuser = {};
            jsonuser.users = [$scope.users.jslist.selectedObj];
            console.log("new users", jsonuser);
            jsonPost.data("../php1/admin/account_admin/admin/del_user.php", {
                del_users: $filter('json')(jsonuser)
            }).then(function (response) {
                $scope.users.jslist.toggleOut();
                console.log(response);
                $scope.users.jslist.createList();
                $scope.users.jslist.toggleIn();
            });
        }
    };

    $scope.sessions = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/admin/account_admin/admin/list_sessions.php", {})
            }
        }
    }
    
}]);


