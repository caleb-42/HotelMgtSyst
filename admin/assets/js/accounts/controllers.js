accountsApp.controller("accounts", ["$rootScope", "$scope", 'jsonPost', '$filter',  function ($rootScope, $scope, jsonPost, $filter) {
    $scope.tabnav = {
        navs: {
            Expenses: {
                name: 'Expenses',
                options: {
                    rightbar: false
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
                jsonfunc: jsonPost.data("../php1/restaurant_bar/admin/list_sessions.php", {})
            }
        },
        subclass: {

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

    
    $scope.users = {
        jslist:{},
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/accounts/admin/list_users.php", {})
            }
        },
        addUser: function (jsonprod) {
            console.log("new user", jsonprod);

            jsonPost.data("../php1/accounts/admin/add_user.php", {
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
            jsonPost.data("../php1/accounts/admin/edit_user.php", {
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
            jsonPost.data("../php1/accounts/admin/del_user.php", {
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
                jsonfunc: jsonPost.data("../php1/accounts/admin/list_sessions.php", {})
            }
        }
    }
    
}]);


