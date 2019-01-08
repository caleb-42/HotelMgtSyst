dashApp.directive('dashmodalentry', ['$rootScope', 'jsonPost', '$filter', function ($rootScope, jsonPost, $filter) {
    return {
        restrict: 'A',
        //template: modalTemplate,
        templateUrl: './assets/js/dashboard/modalsPartial.html',
        scope: false,
        link: function (scope, element, attrs) {
            
            $('.modal').on("shown.bs.modal", function () {
                if ($rootScope.settings.modal.name == "Update Guest") {
                    console.log(scope.guest);
                    $rootScope.settings.utilities.loadJson2Form(scope.guest.jslist.selectedObj, '.inpRead');
                } else if ($rootScope.settings.modal.name == "Update Reservation") {
                    console.log(scope.reservation);
                    $rootScope.settings.utilities.loadJson2Form(scope.reservation.jslist.selectedObj, '.inpRead');
                } else if ($rootScope.settings.modal.name == "Update Single Reservation") {
                    console.log(scope.reservation.resvtn);
                    $rootScope.settings.utilities.loadJson2Form(scope.reservation.resvtn.jslist.selectedObj, '.inpRead');
                } else if ($rootScope.settings.modal.name == "Update Room Reservation") {
                    console.log(scope.rooms.resvtn.list);
                    $rootScope.settings.utilities.loadJson2Form(scope.rooms.resvtn.selectedObj, '.inpRead');
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
            addGuest = function () {
                $rootScope.settings.modal.adding = true;
                jsonForm = $(".addGuestForm").serializeObject();
                jsonForm.room_outstanding = 0;
                jsonForm.total_cost = scope.guest.addGuestForm.roomsProps.selectedRooms.cost;
                jsonForm.guest_type_gender = scope.guest.inputs.guest_type_gender;
                jsonForm.total_rooms_booked = scope.guest.addGuestForm.roomsProps.selectedRooms.num;
                jsonForm.balance = scope.guest.addGuestForm.roomsProps.selectedRooms.cost - jsonForm.deposited;
                jsonForm.frontdesk_rep = $rootScope.settings.user;
                jsonForm.rooms = scope.guest.addGuestForm.roomsProps.selectedRooms.selected;
                console.log(jsonForm);
                scope.guest.addGuest(jsonForm);
            };
            updateGuest = function () {
                $rootScope.settings.modal.adding = true;
                jsonForm = $(".updateGuestForm").serializeObject();
                jsonForm.new_guest_type_gender = scope.guest.inputs.new_guest_type_gender ||jsonForm.guest_type_gender;
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
                        scope.reservation.resvtn.updateResvtn(jsonForm);
                    break;
                    case "Update Room Reservation":
                        scope.rooms.resvtn.updateResvtn(jsonForm);
                    break;
                }
                
            };
            checkIn = function () {
                $rootScope.settings.modal.adding = true;
                jsonForm = $(".CheckInForm").serializeObject();
                jsonForm.room_outstanding = 0;
                jsonForm.total_cost = scope.guest.addGuestForm.roomsProps.selectedRooms.cost;
                jsonForm.total_rooms_booked = scope.guest.addGuestForm.roomsProps.selectedRooms.num;
                jsonForm.balance = scope.guest.addGuestForm.roomsProps.selectedRooms.cost - jsonForm.deposited;
                jsonForm.frontdesk_rep = $rootScope.settings.user;
                jsonForm.rooms = scope.guest.addGuestForm.roomsProps.selectedRooms.selected;
                console.log(jsonForm);
                scope.guest.checkIn(jsonForm);
            };
            changeRoom = function(){
                $rootScope.settings.modal.adding = true;
                jsonForm = $(".changeRoomForm").serializeObject();
                scope.rooms.changeRoom(jsonForm);
            }
            addReservation = function () {
                //$rootScope.settings.modal.adding = true;
                jsonForm = $(".addReservationForm").serializeObject();
                scope.guest.jslist.values = scope.guest.jslist.values || [];
                arr = scope.guest.jslist.values.find(function (elem) {
                    if ((elem.guest_name == jsonForm.guest_name) && (elem.guest_id == $rootScope.settings.AutoComplete.obj.guest_id)) {
                        jsonForm.guest_id = elem.guest_id;
                        jsonForm.guest_type_gender = elem.guest_type_gender;
                    }
                    return (elem.guest_name == jsonForm.guest_name) && (elem.guest_id == $rootScope.settings.AutoComplete.obj.guest_id);
                });

                if (!arr) {
                    jsonForm.guest_id = "";
                    jsonForm.guest_type_gender = $rootScope.settings.AutoComplete.obj.guest_type_gender;
                };
                jsonForm.amount_paid = 0;
                jsonForm.total_cost = scope.reservation.addResvtnForm.roomsProps.selectedRooms.cost;
                jsonForm.total_rooms_booked = scope.reservation.addResvtnForm.roomsProps.selectedRooms.num;
                jsonForm.frontdesk_rep = $rootScope.settings.user;
                jsonForm.rooms = scope.reservation.addResvtnForm.roomsProps.selectedRooms.selected;
                console.log(jsonForm);
                scope.reservation.addReservation(jsonForm);
            };
            checkOut = function () {
                scope.guest.checkOut();
            };
            rePrint = function () {
                scope.guest.rePrint();
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
                scope.guest.inputs = {};
                scope.reservation.inputs = {};
            }
        }
    }
}]);