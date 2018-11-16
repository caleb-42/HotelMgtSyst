app.directive('modalentry', ['$rootScope', 'jsonPost', function ($rootScope, jsonPost, $filter) {
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
                    if(key != "$$hashKey")
                    $(cont + " input[name = " + key + "]").val(json[key]);
                }
            }
            $('.modal').on("shown.bs.modal", function () {
                if ($rootScope.settings.modal.name == "Update Room") {
                    console.log(scope.rooms);
                    loadJson2Form(scope.rooms.jslist.selectedObj, '.inpRead');
                }else if ($rootScope.settings.modal.name == "Update User") {
                    console.log(scope.users);
                    loadJson2Form(scope.users.jslist.selectedObj, '.inpRead');
                }
            });
            updateRoom = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".updateRoomForm").serializeObject();
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
                jsonForm.total_rooms_booked = scope.guest.roomgrid.room_info.rooms;
                jsonForm.balance = scope.guest.roomgrid.room_info.cost - jsonForm.deposited ;
                jsonForm.frontdesk_rep = $rootScope.settings.user;
                jsonForm.rooms = [];
                arryy = Object.values(scope.guest.roomgrid.room_details.rooms);
                arryy.forEach(function(rm){
                    if(rm.arr){
                        rm.arr.forEach(function(elem){
                            if(elem.selected == true){
                                elem.room_total_cost = (parseInt(elem.no_of_nights) * parseInt(elem.room_rate));
                                jsonForm.rooms.push(elem);
                            }
                        });
                    }
                });
                console.log(jsonForm);
                scope.guest.addGuest(jsonForm);
            };
            checkIn = function () {
                $rootScope.settings.modal.adding = true;
                jsonForm = $(".CheckInForm").serializeObject();
                jsonForm.room_outstanding = 0;
                jsonForm.total_cost = scope.guest.roomgrid.room_info.cost;
                jsonForm.total_rooms_booked = scope.guest.roomgrid.room_info.rooms;
                jsonForm.balance = scope.guest.roomgrid.room_info.cost - jsonForm.deposited ;
                jsonForm.frontdesk_rep = $rootScope.settings.user;
                jsonForm.rooms = [];
                arryy = Object.values(scope.guest.roomgrid.room_details.rooms);
                arryy.forEach(function(rm){
                    if(rm.arr){
                        rm.arr.forEach(function(elem){
                            if(elem.selected == true){
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
                arr = scope.guest.jslist.values.find(function(elem){
                    if((elem.guest_name == jsonForm.guest_name) && (elem.guest_id == $rootScope.settings.AutoComplete.obj.guest_id)){
                        jsonForm.guest_id = elem.guest_id;
                    }
                    return (elem.guest_name == jsonForm.guest_name) && (elem.guest_id == $rootScope.settings.AutoComplete.obj.guest_id);
                });

                if(!arr){
                    jsonForm.guest_id = "";
                }
                jsonForm.amount_paid = 0;
                jsonForm.total_cost = scope.rooms.roomgrid.room_info.cost;
                jsonForm.total_rooms_booked = scope.rooms.roomgrid.room_info.rooms;
                jsonForm.frontdesk_rep = $rootScope.settings.user;
                jsonForm.rooms = [];
                arryy = Object.values(scope.rooms.roomgrid.room_details.rooms);
                arryy.forEach(function(rm){
                    if(rm.arr){
                        rm.arr.forEach(function(elem){
                            if(elem.selected == true){
                                elem.room_total_cost = (parseInt(elem.no_of_nights) * parseInt(elem.room_rate));
                                jsonForm.rooms.push(elem);
                            }
                        });
                    }
                });
                console.log(jsonForm);
                scope.rooms.reservations.addReservation(jsonForm);
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
                if(parseInt(jsonForm.amount_paid) < 1 || jsonForm.amount_paid == ''){
                    $rootScope.settings.modal.msgprompt(['ERROR', 'FILL AMOUNT PAID WITH A VALUE']);
                    //console.log($rootScope.settings.modal.msg);
                    $rootScope.$apply();
                    return;
                }
                scope.guest.payBalance(jsonForm);
            };
            $rootScope.settings.modal.close = function () {
                $(".report").fadeIn(100, function () {
                    $(".report").delay(1500).fadeOut(100, function(){
                        $(".modal .close").trigger("click");
                        $rootScope.settings.modal.msg = "";
                        $(".modal input").val("");
                    });
                });
            }
            $rootScope.settings.modal.fademsg = function(){
                console.log('dvs');
                $(".report").fadeIn(50, function(){
                    $('.report').delay(3500).fadeOut(10);
                });
            };
            $('.modal').on('hidden.bs.modal', function(){
                $rootScope.settings.modal.msg = '';
                $rootScope.settings.modal.active = "";
            });
            $('.modal .close').on('click', function(){
                $rootScope.settings.modal.msg = '';
                $rootScope.settings.modal.active = "";
            });

        }
    };
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