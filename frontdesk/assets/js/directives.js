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
            confirmReservation = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".ConfirmReservationForm").serializeObject();
                scope.reservation.confirm(jsonForm);
            }
            claimReservation = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".ClaimReservationForm").serializeObject();
                jsonForm.guest_type_gender = scope.reservation.guest_type_gender;
                scope.reservation.claim(jsonForm);
            }
            updateRoom = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".updateRoomForm").serializeObject();
                console.log(scope.rooms.jslist.new_room_category);
                jsonForm.new_room_category = scope.rooms.jslist.new_room_category ? scope.rooms.jslist.new_room_category : "";
                scope.rooms.updateRoom(jsonForm);
            };
            addRoom = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".addRoomForm").serializeObject();
                //console.log();
                jsonForm.room_category = scope.rooms.jslist.room_category;
                scope.rooms.addRoom(jsonForm);
            };
            addUser = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".addUserForm").serializeObject();
                console.log(scope.users);
                scope.users.addUser(jsonForm);
            };
            addGuest = function () {
                $rootScope.settings.modal.adding = true;
                jsonForm = $(".addGuestForm").serializeObject();
                jsonForm.room_outstanding = 0;
                jsonForm.total_cost = scope.guest.roomgrid.room_info.cost;
                jsonForm.guest_type_gender = scope.guest.guest_type_gender;
                jsonForm.total_rooms_booked = scope.guest.roomgrid.room_info.rooms;
                jsonForm.balance = scope.guest.roomgrid.room_info.cost - jsonForm.deposited;
                jsonForm.frontdesk_rep = $rootScope.settings.user;
                jsonForm.rooms = [];
                arryy = Object.values(scope.guest.roomgrid.room_details.rooms);
                arryy.forEach(function (rm) {
                    if (rm.arr) {
                        rm.arr.forEach(function (elem) {
                            if (elem.selected == true) {
                                elem.room_total_cost = (parseInt(elem.no_of_nights) * parseInt(elem.room_rate));
                                jsonForm.rooms.push(elem);
                            }
                        });
                    }
                });
                console.log(jsonForm);
                scope.guest.addGuest(jsonForm);
            };
            updateGuest = function () {
                $rootScope.settings.modal.adding = true;
                jsonForm = $(".updateGuestForm").serializeObject();
                jsonForm.new_guest_type_gender = scope.guest.guest_type_gender ? scope.guest.guest_type_gender : jsonForm.guest_type_gender;
                console.log(jsonForm);
                scope.guest.updateGuest(jsonForm);
            };
            updateReservation = function () {
                $rootScope.settings.modal.adding = true;
                jsonForm = $(".UpdateReservationForm").serializeObject();
                console.log(jsonForm);
                scope.reservation.updateReservation(jsonForm);
            };
            updateResvtn = function () {
                $rootScope.settings.modal.adding = true;
                jsonForm = $(".UpdateResvtnForm").serializeObject();

                console.log(jsonForm);
                switch($rootScope.settings.modal.name){
                    case "Update Single Reservation":
                        scope.resvtn.updateResvtn(jsonForm);
                    break;
                    case "Update Unconfirmed Reservation":
                        scope.rooms.reservations.temp_reservation.updateResvtn(jsonForm);
                    break;
                    case "Update Confirmed Reservation":
                        scope.rooms.reservations.confirmed_reservation.updateResvtn(jsonForm);
                    break;
                }
                
            };
            checkIn = function () {
                $rootScope.settings.modal.adding = true;
                jsonForm = $(".CheckInForm").serializeObject();
                jsonForm.room_outstanding = 0;
                jsonForm.total_cost = scope.guest.roomgrid.room_info.cost;
                jsonForm.total_rooms_booked = scope.guest.roomgrid.room_info.rooms;
                jsonForm.balance = scope.guest.roomgrid.room_info.cost - jsonForm.deposited;
                jsonForm.frontdesk_rep = $rootScope.settings.user;
                jsonForm.rooms = [];
                arryy = Object.values(scope.guest.roomgrid.room_details.rooms);
                arryy.forEach(function (rm) {
                    if (rm.arr) {
                        rm.arr.forEach(function (elem) {
                            if (elem.selected == true) {
                                elem.room_total_cost = (parseInt(elem.no_of_nights) * parseInt(elem.room_rate));
                                jsonForm.rooms.push(elem);
                            }
                        });
                    }
                });
                console.log(jsonForm);
                scope.guest.checkIn(jsonForm);
            };
            addReservation = function () {
                $rootScope.settings.modal.adding = true;
                jsonForm = $(".addReservationForm").serializeObject();
                scope.guest.jslist.values = scope.guest.jslist.values ? scope.guest.jslist.values : [];
                arr = scope.guest.jslist.values.find(function (elem) {
                    if ((elem.guest_name == jsonForm.guest_name) && (elem.guest_id == $rootScope.settings.AutoComplete.obj.guest_id)) {
                        jsonForm.guest_id = elem.guest_id;
                    }
                    return (elem.guest_name == jsonForm.guest_name) && (elem.guest_id == $rootScope.settings.AutoComplete.obj.guest_id);
                });

                if (!arr) {
                    jsonForm.guest_id = "";
                }
                jsonForm.amount_paid = 0;
                jsonForm.total_cost = scope.reservation.roomgrid.room_info.cost;
                jsonForm.total_rooms_booked = scope.reservation.roomgrid.room_info.rooms;
                jsonForm.frontdesk_rep = $rootScope.settings.user;
                jsonForm.rooms = [];
                arryy = Object.values(scope.reservation.roomgrid.room_details.rooms);
                arryy.forEach(function (rm) {
                    if (rm.arr) {
                        rm.arr.forEach(function (elem) {
                            if (elem.selected == true) {
                                elem.room_total_cost = (parseInt(elem.no_of_nights) * parseInt(elem.room_rate));
                                jsonForm.rooms.push(elem);
                            }
                        });
                    }
                });
                console.log(jsonForm);
                scope.reservation.addReservation(jsonForm);
            };
            checkOut = function () {
                scope.guest.checkOut();
            };
            updateUser = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".updateUserForm").serializeObject();
                scope.users.updateUser(jsonForm);
            };
            payBalance = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".PayBalanceForm").serializeObject();
                console.log(jsonForm, parseInt(jsonForm.amount_paid));
                if (parseInt(jsonForm.amount_paid) < 1 || jsonForm.amount_paid == '') {
                    $rootScope.settings.modal.msgprompt(['ERROR', 'FILL AMOUNT PAID WITH A VALUE']);
                    //console.log($rootScope.settings.modal.msg);
                    $rootScope.$apply();
                    return;
                }
                scope.guest.payBalance(jsonForm);
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
                if(scope.reservation && scope.guest){
                    scope.reservation.roomgrid.activated = false;
                    scope.guest.roomgrid.activated = false;
                    scope.guest.roomgrid.averagenyt = 0;
                    scope.guest.roomgrid.nytdate = $filter('intervalGetDate')(0,$rootScope.settings.date);
                    scope.reservation.roomgrid.averagenyt = 0;
                    scope.reservation.roomgrid.nytstartdate = $filter('intervalGetDate')(0,$rootScope.settings.date);
                    scope.reservation.roomgrid.nytdate = $filter('intervalGetDate')(0,$rootScope.settings.date);
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