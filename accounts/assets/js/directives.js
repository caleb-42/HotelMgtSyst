app.directive('modalentry', ['$rootScope', 'jsonPost', '$filter', function ($rootScope, jsonPost, $filter) {
    return {
        restrict: 'A',
        //template: modalTemplate,
        templateUrl: './assets/js/modals.html',
        scope: false,
        link: function (scope, element, attrs) {

            $.fn.serializeObject = function () {
                var formData = {};
                var formArray = this.serializeArray();

                for (var i = 0, n = formArray.length; i < n; ++i)
                    formData[formArray[i].name] = formArray[i].value;

                return formData;
            };
            loadJson2Form = function (json, cont) {
                for (var key in json) {
                    if (key != "$$hashKey"){
                        $(cont + " input[name = " + key + "]").val(json[key]);
                        $(cont + " textarea[name = " + key + "]").val(json[key]);
                    }
                }
            }
            $('.modal').on("shown.bs.modal", function () {
                if ($rootScope.settings.modal.name == "Update Room") {
                    console.log(scope.rooms);
                    loadJson2Form(scope.rooms.jslist.selectedObj, '.inpRead');
                } else if ($rootScope.settings.modal.name == "Update User") {
                    console.log(scope.users);
                    loadJson2Form(scope.users.jslist.selectedObj, '.inpRead');
                } else if ($rootScope.settings.modal.name == "Update Guest") {
                    console.log(scope.users);
                    loadJson2Form(scope.guest.jslist.selectedObj, '.inpRead');
                } else if ($rootScope.settings.modal.name == "Update Reservation") {
                    console.log(scope.reservation);
                    loadJson2Form(scope.reservation.jslist.selectedObj, '.inpRead');
                } else if ($rootScope.settings.modal.name == "Update Single Reservation") {
                    console.log(scope.resvtn);
                    loadJson2Form(scope.resvtn.jslist.selectedObj, '.inpRead');
                } else if ($rootScope.settings.modal.name == "Update Unconfirmed Reservation") {
                    console.log(scope.rooms.reservations.temp_reservation.reservation_list);
                    loadJson2Form(scope.rooms.reservations.temp_reservation.selectedObj, '.inpRead');
                } else if ($rootScope.settings.modal.name == "Update Confirmed Reservation") {
                    console.log(scope.rooms.reservations.confirmed_reservation.reservation_list);
                    loadJson2Form(scope.rooms.reservations.confirmed_reservation.selectedObj, '.inpRead');
                }
            });
            addUser = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".addUserForm").serializeObject();
                console.log(scope.users);
                scope.users.addUser(jsonForm);
            };
            addExpenses = function () {
                $rootScope.settings.modal.adding = true;
                jsonForm = $(".addExpensesForm").serializeObject();
                scope.expenses.addExpenses(jsonForm);
            };
            payDebts = function () {
                $rootScope.settings.modal.adding = true;
                jsonForm = $(".payDebtsForm").serializeObject();
                scope.debts.payDebts(jsonForm);
            };
            updateUser = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".updateUserForm").serializeObject();
                scope.users.updateUser(jsonForm);
            };
            $rootScope.settings.modal.close = function () {
                $(".report").fadeIn(100, function () {
                    $(".report").delay(1500).fadeOut(100, function () {
                        $(".modal .close").trigger("click");
                        $rootScope.settings.modal.msg = "";
                    });
                });
            }
            $rootScope.settings.modal.fademsg = function () {
                console.log('dvs');
                $(".report").fadeIn(50, function () {
                    $('.report').delay(3500).fadeOut(10);
                });
            };
            $('.modal').on('hidden.bs.modal', function () {
                $rootScope.settings.modal.msg = '';
                $rootScope.settings.modal.active = "";
                $rootScope.settings.AutoComplete.obj = {};
                $(".modal .clearinput").val("");
                reset();
            });
            $('.modal .close').on('click', function () {
                $rootScope.settings.modal.msg = '';
                $rootScope.settings.modal.active = "";
                $rootScope.settings.AutoComplete.obj = {};
                $(".modal .clearinput").val("");
                reset();
            });
            function reset(){
                if(scope.expenses){
                    scope.expenses.jslist.cost = 0;
                    scope.expenses.jslist.paid = 0;
                }
                
            }
        }
    }
}]);
/* app.directive('modalentry', ['$rootScope', 'jsonPost', function ($rootScope, jsonPost, $filter) {
    return {
        restrict: 'A',
        template : '',
        scope: {
            
        },
        link: function (scope, element, attrs) {

        }

    }
}]); */