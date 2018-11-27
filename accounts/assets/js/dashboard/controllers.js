dashApp.controller("dashboard", ["$rootScope", "$scope", 'jsonPost', '$filter', '$timeout', function ($rootScope, $scope, jsonPost, $filter, $timeout) {

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
            }/* ,
            Revenue: {
                name: 'Revenue',
                options: {
                    rightbar: {
                        present: true,
                        rightbarclass: 'w-35',
                        primeclass: 'w-65'
                    }
                }
            } */
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
    $scope.booking = {
        itemlist: function (id) {
            return {
                jsonfunc: jsonPost.data("../php1/front_desk/list_bookings_custom.php", {
                    col : 'guest_id',
                    val : id
                })
            }
        },
        select : function(item){
            arr = $scope.booking.selected.find(function(elem, index){
                if(elem.room_id == item.room_id) $scope.booking.selected.splice(index,1);
                return elem.room_id == item.room_id;
            });
            if(!arr) $scope.booking.selected.push({room_id : item.room_id, booking_ref : item.booking_ref});
        },
        selected : []
    }

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
        payExpenses: function (jsonexpense) {
            console.log("new Expense", jsonexpense);
            //return;     
            jsonexpense.expense_ref = $scope.expenses.jslist.selected;
            jsonexpense.date_of_payment = $scope.expenses.jslist.selected;
            jsonPost.data("../php1/accounts/expense_pay.php", {
                payment_details: $filter('json')(jsonexpense)
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
            jsonguest = {};
            jsonguest.guest = [$scope.guest.jslist.selectedObj];
            console.log("new users", jsonguest);
            jsonPost.data("../php1/restaurant_bar/admin/del_user.php", {
                del_users: $filter('json')(jsonguest)
            }).then(function (response) {
                $scope.guest.jslist.toggleOut();
                console.log(response);
                $scope.guest.jslist.createList();
                $scope.guest.jslist.selectedObj = {};
                $scope.guest.jslist.selected = null;
                $scope.guest.jslist.toggleIn();
            });
        }
    };

    $scope.revenue = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/accounts/list_revenues.php", {})
            }
        },
        addExpenses: function (jsonguest) {
            console.log("new Guest", jsonguest);

            jsonPost.data("../php1/front_desk/add_guest.php", {
                checkin_data: $filter('json')(jsonguest)
            }).then(function (response) {
                console.log(response);
                $scope.guest.roomgrid.averagenyt = 0;
                $scope.guest.roomgrid.room_info.rooms = 0;
                $scope.guest.roomgrid.room_info.cost = 0;
                $scope.guest.jslist.toggleOut();
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
            jsonguest = {};
            jsonguest.guest = [$scope.guest.jslist.selectedObj];
            console.log("new users", jsonguest);
            jsonPost.data("../php1/restaurant_bar/admin/del_user.php", {
                del_users: $filter('json')(jsonguest)
            }).then(function (response) {
                $scope.guest.jslist.toggleOut();
                console.log(response);
                $scope.guest.jslist.createList();
                $scope.guest.jslist.selectedObj = {};
                $scope.guest.jslist.selected = null;
                $scope.guest.jslist.toggleIn();
            });
        }
    };

    $scope.rooms = {
        current_guest : {},
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/front_desk/list_rooms.php", {})
            }
        },
        getallrooms: function(){
            $scope.rooms.itemlist().jsonfunc.then(function(result){
                $scope.rooms.allrooms = result;
            });
        },
        getGuest : function(id){
            $scope.guest.itemlist().jsonfunc.then(function(result){
                found = false;
                result.forEach(function(elem){
                    if(id == elem.guest_id){
                        found = true;
                        $scope.rooms.current_guest = elem;
                    }
                })
                $scope.rooms.current_guest = found ? $scope.rooms.current_guest : {};
            })
        },
        

    };
}]);
