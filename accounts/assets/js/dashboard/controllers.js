dashApp.controller("dashboard", ["$rootScope", "$scope", 'jsonPost', '$filter', '$timeout', 'jsonGet', function ($rootScope, $scope, jsonPost, $filter, $timeout, jsonGet) {

    $rootScope.$on('guestselect', function(evt,param){
        console.log($scope.guest.getRoomBooking(param.guest_id));
        $scope.booking.itemlist(param.guest_id).jsonfunc.then(function(result){
            $scope.booking.rooms = result ? result : [];
            console.log(result);
        });
    });

    $rootScope.$on('roomselect', function(evt,param){
        $scope.rooms.getGuest(param.current_guest_id);
        /* console.log($scope.guest.getGuestBooking(param.room_id)); */
        /* $scope.booking.itemlist(param.guest_id).jsonfunc.then(function(result){
            $scope.booking.rooms = result ? result : [];
            console.log(result);
        }); */
    });

    $scope.tabnav = {
        navs: {
            /* Overview: {
                name: 'Overview',
                options: {
                    rightbar: false
                }
            }, */
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
            }
        },
        selected: {
            name: 'Expenses',
            options: {
                rightbar: false
            }
        },
        selectNav: function (navname) {
            $scope.tabnav.selected = $scope.tabnav.navs[navname];
        }
    };
    $scope.expenses = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/accounts/list_expenses.php", {})
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
        updateExpenses: function (jsonguest) {
            jsonguest.id = $scope.guest.jslist.selected;
            console.log("new product", jsonguest);
            jsonPost.data("../php1/front_desk/admin/edit_guest.php", {
                update_guest: $filter('json')(jsonguest)
            }).then(function (response) {
                $scope.guest.jslist.toggleOut();
                console.log(response);
                res = $rootScope.settings.modal.msgprompt(response);
                res ? $scope.guest.jslist.createList() : null;
                $scope.guest.itemlist().jsonfunc.then(function(response){
                    $scope.guest.jslist.selectedObj =  $filter('filterObj')(response,$scope.guest.jslist.selected, ['guest_id']);
                    $scope.guest.jslist.selected = $scope.guest.jslist.selectedObj.guest_id;
                    console.log($scope.guest.jslist.selectedObj);
                });
                $scope.guest.jslist.toggleIn();
            });
        },
        deleteExpenses: function () {
            jsonexp = {};
            jsonexp.expenses = [$scope.expenses.jslist.selectedObj];
            console.log("new expenses", jsonexp);
            jsonPost.data("../php1/accounts/admin/del_expense.php", {
                del_expense: $filter('json')(jsonexp)
            }).then(function (response) {
                $scope.expenses.jslist.toggleOut();
                console.log(response);
                $scope.expenses.jslist.createList();
                $scope.expenses.jslist.selectedObj = {};
                $scope.expenses.jslist.selected = null;
                $scope.expenses.jslist.toggleIn();
            });
        }
    };

    $scope.debts = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/accounts/list_debts.php", {})
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

}]);
