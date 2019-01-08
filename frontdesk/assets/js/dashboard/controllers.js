dashApp.controller("dashboard", ["$rootScope", "$scope", 'jsonPost', '$filter', '$timeout', function ($rootScope, $scope, jsonPost, $filter, $timeout) {

    $scope.tabnav = {
        navs: {
            Guests: {
                name: 'Guests',
                options: {
                    rightbar: false
                }
            },
            Rooms: {
                name: 'Rooms',
                options: {
                    rightbar: {
                        present: true,
                        rightbarclass: 'w-35',
                        primeclass: 'w-65'
                    }
                }
            },
            Reservation: {
                name: 'Reservation',
                options: {
                    rightbar: {
                        present: true,
                        rightbarclass: 'w-35',
                        primeclass: 'w-65'
                    }
                }
            }
        },
        selected: {
            name: 'Guests',
            options: {
                rightbar: false
            }
        },
        selectNav: function (navname) {
            $scope.tabnav.selected = $scope.tabnav.navs[navname];
        }
    };

    $scope.guest = {
        init: function(){
            $rootScope.$on('guestselect', function (evt, param) {
                $scope.guest.roomBookings.getRoomBooking(param.guest_id);
            });

            $scope.$watch('guest.inputs.averagenyt', function(newVal){
                $scope.guest.addGuestForm.roomsProps.activePane = newVal ? 'category' : '';
                $scope.guest.addGuestForm.roomsProps.selectedRooms = {
                    categories:{},
                    num: 0,
                    cost: 0,
                    selected: []
                };
            });
        },
        inputs: {},
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/front_desk/list_guests_all.php", {})
            }
        },
        cancel: function(){
            msg = confirm('This will delete the booking of this guest and any reservation connected to it');
            if(msg){
                jsonPost.data("../php1/front_desk/cancel_booking.php", {
                    guest: $scope.guest.jslist.selectedObj.guest_id,
                }).then(function(result){
                    console.log(result);
                    $scope.guest.roomBookings.selected = [];
                    $scope.guest.jslist.selected = [];
                    $scope.guest.jslist.selectedObj = {};
                    $scope.guest.jslist.toggleOut();
                    $scope.guest.jslist.createList();
                    $scope.guest.jslist.toggleIn();
                });
            }else{
                return;
            }
            
        },
        addGuestForm : {
            getAvailablerooms: function(nyts, end_date, trigger){
                start_date = $filter('intervalGetDate')(0, new Date().toString());
                var result;
                if(trigger == "nyts"){
                    result = $filter('intervalGetDate')(nyts, start_date)
                    end_date = result;
                }else if(trigger == "leave"){
                    result = $filter('dateGetInterval')(end_date, start_date);
                }
                jsonPost.data("../php1/front_desk/list_rooms_custom.php", {
                    startDate: start_date,
                    nights: nyts,
                    endDate: end_date,
                    flag: 'booking'
                }).then(function (result) {
                    $scope.guest.addGuestForm.roomsProps.rooms = result;
                    console.log(result);
                });
                return result;
            },
            roomsProps: {
                rooms: [],
                activePane: '',
                roomModels : {},
                calculateTotal: function(){
                    this.selectedRooms.num = 0;
                    this.selectedRooms.cost = 0;
                    this.selectedRooms.selected = [];
                    Object.values(this.selectedRooms.categories).forEach(function(category){
                        //console.log(category);
                        this.selectedRooms.num += category.num;
                        this.selectedRooms.cost += category.cost;
                        this.selectedRooms.selected = this.selectedRooms.selected.concat(category.array);
                    }, this)
                    return this.selectedRooms;
                },
                selectRooms: function(category, selectedNum){
                    this.selectedRooms.categories[category] = {array: [], num:0, cost:0};
                    var categoryRooms = this.rooms[category]['rooms'];
                    if(selectedNum > categoryRooms.length) {
                        this.selectedRooms.categories[category]['num'] = categoryRooms.length;
                        selectedNum = categoryRooms.length;
                    }
                    categoryRooms.forEach(function(room, index){
                        room.selected = index < selectedNum ? true : false;
                        this.roomModels[room.room_id] = $scope.guest.inputs.averagenyt;
                        if(room.selected){
                            room.no_of_nights = this.roomModels[room.room_id];
                            room.room_total_cost = (parseInt(room.no_of_nights) * parseInt(room.room_rate));
                            this.selectedRooms.categories[category]['num']++;
                            this.selectedRooms.categories[category]['array'].push(room);
                            this.selectedRooms.categories[category]['cost'] += parseInt(room.room_rate) * parseInt(room.no_of_nights);
                        }
                    }, this);
                    console.log(this.calculateTotal());
                },
                toggleRooms: function(){
                    category = this.activePane;
                    this.selectedRooms.categories[category] = {array: [], num:0, cost:0};
                    //dis = this;
                    this.rooms[category]['rooms'].forEach(function(room){
                        if(room.selected){
                            room.no_of_nights = this.roomModels[room.room_id];
                            room.room_total_cost = (parseInt(room.no_of_nights) * parseInt(room.room_rate));
                            this.selectedRooms.categories[category]['num']++;
                            this.selectedRooms.categories[category]['array'].push(room);
                            this.selectedRooms.categories[category]['cost'] += parseInt(room.room_rate) * parseInt(room.no_of_nights);
                        }
                    }, this);
                    console.log(this.calculateTotal());
                },
                changeRoomNyts: function(room_id){
                    category = this.activePane;
                    this.selectedRooms.categories[category] = {array: [], num:0, cost:0};
                    this.rooms[category]['rooms'].forEach(function(room){
                        if(room.selected){
                            if(room.room_id == room_id) 
                            room.no_of_nights = this.roomModels[room.room_id];
                            room.room_total_cost = (parseInt(room.no_of_nights) * parseInt(room.room_rate));
                            this.selectedRooms.categories[category]['num']++;
                            this.selectedRooms.categories[category]['array'].push(room);
                            this.selectedRooms.categories[category]['cost'] += parseInt(room.room_rate) * parseInt(room.no_of_nights);
                        }
                    }, this);
                    console.log(this.calculateTotal());
                }
            }
        },
        rePrint: function(){
            jsonguest = {
                guest: $scope.guest.jslist.selectedObj,
                booking: $scope.guest.roomBookings.selected[0]
            }
            console.log(jsonguest);
            jsonPost.data("../php1/front_desk/reprint.php", {
                reprint: $filter('json')(jsonguest)
            }).then(function(result){
                console.log(result);
                $scope.guest.roomBookings.selected = [];
                $scope.guest.jslist.selected = null;
                $scope.guest.jslist.selectedObj = {};
                $scope.guest.jslist.toggleOut();
                $scope.guest.jslist.createList()
                $scope.guest.jslist.toggleIn();
            })
        },
        addGuest: function (jsonguest) {
            console.log("new Guest", jsonguest);
            /* $rootScope.settings.modal.adding = false;
            return; */
            jsonPost.data("../php1/front_desk/add_guest.php", {
                checkin_data: $filter('json')(jsonguest)
            }).then(function (response) {
                console.log(response);
                $scope.guest.addGuestForm.roomsProps.selectedRooms = {
                    categories:{},
                    num: 0,
                    cost: 0,
                    selected: []
                }
                $scope.guest.inputs = {};
                $scope.guest.jslist.toggleOut();
                res = $rootScope.settings.modal.msgprompt(response);
                res ? $scope.guest.jslist.createList() : null;
                $scope.guest.itemlist().jsonfunc.then(function (response) {
                    $scope.guest.jslist.selectedObj = $filter('filterObj')(response, $scope.guest.jslist.selected, ['guest_id']);
                    $scope.guest.jslist.selected = $scope.guest.jslist.selectedObj.guest_id;
                    console.log($scope.guest.jslist.selectedObj);
                });
                $scope.guest.jslist.toggleIn();
            });
        },
        checkIn: function (jsonguest) {
            console.log("new checkIn", jsonguest);
            jsonguest.guest_id = $scope.guest.jslist.selectedObj.guest_id;
            jsonguest.guest_name = $scope.guest.jslist.selectedObj.guest_name;
            console.log("new checkIn", jsonguest);

            jsonPost.data("../php1/front_desk/checkin.php", {
                checkin_data: $filter('json')(jsonguest)
            }).then(function (response) {
                $scope.guest.addGuestForm.roomsProps.selectedRooms = {
                    categories:{},
                    num: 0,
                    cost: 0,
                    selected: []
                }
                $scope.guest.inputs = {};
                console.log(response);
                $scope.guest.jslist.toggleOut();
                res = $rootScope.settings.modal.msgprompt(response);
                res ? $scope.guest.jslist.createList() : null;
                $scope.guest.itemlist().jsonfunc.then(function (response) {
                    $scope.guest.jslist.selectedObj = $filter('filterObj')(response, $scope.guest.jslist.selected, ['guest_id']);
                    $scope.guest.jslist.selected = $scope.guest.jslist.selectedObj.guest_id;
                    console.log($scope.guest.jslist.selectedObj);
                    $scope.guest.roomBookings.getRoomBooking($scope.guest.jslist.selected);
                });
                $scope.guest.jslist.toggleIn();
            });
        },
        checkOut: function () {
            jsonguest = $scope.guest.jslist.selectedObj;
            jsonguest.frontdesk_rep = $rootScope.settings.user;
            jsonguest.rooms = $scope.guest.roomBookings.selected;
            jsonguest.booking_ref = $scope.guest.roomBookings.selected[0].booking_ref;
            console.log("new checkOut", jsonguest);

            jsonPost.data("../php1/front_desk/checkOut.php", {
                checkout_data: $filter('json')(jsonguest)
            }).then(function (response) {
                console.log(response);
                $scope.guest.jslist.toggleOut();
                $scope.guest.roomBookings.selected = [];
                res = $rootScope.settings.modal.msgprompt(response);
                res ? $scope.guest.jslist.createList() : null;
                $scope.guest.itemlist().jsonfunc.then(function (response) {
                    $scope.guest.jslist.selectedObj = $filter('filterObj')(response, $scope.guest.jslist.selected, ['guest_id']);
                    $scope.guest.jslist.selected = $scope.guest.jslist.selectedObj.guest_id;
                    console.log($scope.guest.jslist.selectedObj);
                    $scope.guest.roomBookings.getRoomBooking($scope.guest.jslist.selected);
                });

                $scope.guest.jslist.toggleIn();
            });
        },
        payBalance: function (jsonguest) {
            jsonguest.booking_ref = $scope.guest.roomBookings.rooms[0].booking_ref;
            jsonguest.guest_name = $scope.guest.roomBookings.rooms[0].guest_name;
            jsonguest.guest_id = $scope.guest.roomBookings.rooms[0].guest_id;
            jsonguest.frontdesk_rep = $rootScope.settings.user;
            console.log("new payment", jsonguest);

            jsonPost.data("../php1/front_desk/frontdesk_balance_pay.php", {
                payment_details: $filter('json')(jsonguest)
            }).then(function (response) {
                console.log(response);
                $scope.guest.inputs = {};
                $scope.guest.jslist.toggleOut();
                res = $rootScope.settings.modal.msgprompt(response);
                res ? $scope.guest.jslist.createList() : null;
                $scope.guest.itemlist().jsonfunc.then(function (response) {
                    $scope.guest.jslist.selectedObj = $filter('filterObj')(response, $scope.guest.jslist.selected, ['guest_id']);
                    $scope.guest.jslist.selected = $scope.guest.jslist.selectedObj.guest_id;
                    console.log($scope.guest.jslist.selectedObj);
                    $scope.guest.roomBookings.getRoomBooking($scope.guest.jslist.selected);
                });
                $scope.guest.jslist.toggleIn();
            });
        },
        updateGuest: function (jsonguest) {
            jsonguest.id = $scope.guest.jslist.selected;
            console.log("new product", jsonguest);
            jsonPost.data("../php1/front_desk/admin/edit_guest.php", {
                update_guest: $filter('json')(jsonguest)
            }).then(function (response) {
                $scope.guest.inputs = {};
                $scope.guest.jslist.toggleOut();
                console.log(response);
                res = $rootScope.settings.modal.msgprompt(response);
                res ? $scope.guest.jslist.createList() : null;
                $scope.guest.itemlist().jsonfunc.then(function (response) {
                    $scope.guest.jslist.selectedObj = $filter('filterObj')(response, $scope.guest.jslist.selected, ['guest_id']);
                    $scope.guest.jslist.selected = $scope.guest.jslist.selectedObj.guest_id;
                    console.log($scope.guest.jslist.selectedObj);
                    $scope.guest.roomBookings.getRoomBooking($scope.guest.jslist.selected);
                });
                $scope.guest.jslist.toggleIn();
            });
        },
        roomBookings: {
            /*used to select rooms within guest checkout modal*/
            select: function (booking, selectedBookings) {
                arr = selectedBookings.find(function (elem, index) {

                    if (elem.room_id == booking.room_id)
                        selectedBookings.splice(index, 1);

                    return elem.room_id == booking.room_id;

                });

                if (!arr)
                    selectedBookings.push({
                        room_id: booking.room_id,
                        booking_ref: booking.booking_ref
                    });
                return selectedBookings;
            },
            selected: [],
            getRoomBooking: function (id) {
                jsonPost.data("../php1/front_desk/list_bookings_custom.php", {
                    col: 'guest_id',
                    val: id
                }).then(function (result) {
                    console.log(result);
                    $scope.guest.roomBookings.roomNumbers = [];
                    $scope.guest.roomBookings.booking = [];
                    $scope.guest.roomBookings.rooms = result || [];
                    $scope.guest.roomBookings.rooms.forEach(function (elem) {
                        $scope.guest.roomBookings.roomNumbers.push(elem.room_number);
                        add = true;
                        add = $scope.guest.roomBookings.booking.forEach(function(room){
                            if(elem.booking_ref == room.booking_ref) return false;
                        });
                        console.log(add);
                        if(add || add == undefined) $scope.guest.roomBookings.booking.push(elem);
                    });
                });
            }
        }
    };

    $scope.reservation = {
        init: function(){

            $scope.$watch('reservation.inputs.averagenyt', function(newVal){
                $scope.reservation.addResvtnForm.roomsProps.activePane = newVal ? 'category' : '';
                $scope.reservation.addResvtnForm.roomsProps.selectedRooms = {
                    categories:{},
                    num: 0,
                    cost: 0,
                    selected: []
                };
            });
        },
        inputs:{},
        itemlist: function (type, callback) {
            jsonPost.data("../php1/front_desk/list_reservations.php", {}).then(function(resvtn){
                if(type == 'filter') {
                    newresvtn = [];
                    if(!resvtn) return;
                        resvtn.forEach(function(rtn){
                            if(rtn.booked == 'YES') return;
                            count = true;
                            rtn.sum_cost = parseInt(rtn.room_total_cost);
                            newresvtn.forEach(function(res){
                                if(rtn.reservation_ref == res.reservation_ref && rtn.guest_id == res.guest_id){
                                    res.sum_cost +=  parseInt(rtn.room_total_cost);
                                    count = false;
                                }
                            });
                            if(count){
                                newresvtn.push(rtn);
                            }
                        });
                    callback(newresvtn);
                }else{
                    callback(resvtn);
                }
            })
        },
        guestAutoComplete: {
            getGuest : function (obj) {
                jsonPost.data("../php1/front_desk/list_guests_all.php", {}).then(function (result) {
                    $scope.reservation.guestAutoComplete.guestArray = result || [];
                    $scope.reservation.guestAutoComplete.guestNamesArray = 
                    $filter('duplicatekey')(result, obj);
                });
            }
        },
        state: function () {
            if ($scope.reservation.jslist.selectedObj.deposit_confirmed == 'NO') {
                $rootScope.settings.modal.active = 'Reservation';
                $rootScope.settings.modal.name = 'Confirm Reservation';
                $rootScope.settings.modal.size = 'md';
            }
            else {
                $rootScope.settings.modal.active = 'Reservation';
                $rootScope.settings.modal.name = 'Claim Reservation';
                $rootScope.settings.modal.size = 'md';
            }

        },
        sendMail: {
            send: function(jsonresvtn){
                $scope.reservation.sendMail.label = 'Sending...';
                jsonPost.data("../php1/front_desk/sendMail.php", {
                    reservation_data: $filter('json')(jsonresvtn)
                }).then(function (response) {
                    console.log(response);
                    $scope.reservation.sendMail.label = $rootScope.settings.modal.msgprompt(response) ? $rootScope.settings.modal.msg : 'FAILED';
                    $timeout(function(){
                        $scope.reservation.sendMail.label = 'SendMail';
                    }, 4000);
    
                });
            },
            label: 'SendMail'
        },
        addReservation: function (jsonresvtn) {
            console.log("new Reservation", jsonresvtn);
            
            jsonPost.data("../php1/front_desk/add_reservation.php", {
                reservation_data: $filter('json')(jsonresvtn)
            }).then(function (response) {
                console.log(response);
                $scope.guest.addGuestForm.roomsProps.selectedRooms = {
                    categories:{},
                    num: 0,
                    cost: 0,
                    selected: []
                };
                
                $scope.reservation.inputs.nytstartdate = $rootScope.settings.getDate(0);
                $scope.reservation.inputs.leaveDate = $rootScope.settings.getDate(0);
                res = $rootScope.settings.modal.msgprompt(response);
                if(res) {
                    $scope.reservation.jslist.toggleOut();
                    $scope.reservation.jslist.createList()
                } else{
                    return;
                }


                $scope.reservation.itemlist('filter', function(newresvtn){
                    $scope.reservation.jslist.values = [];
                    $scope.reservation.jslist.values = newresvtn;
                    $scope.reservation.jslist.selectedObj = $filter('filterObj')(newresvtn, $scope.reservation.jslist.selected, ['reservation_ref']);
                    $scope.reservation.jslist.selected = $scope.reservation.jslist.selectedObj.reservation_ref;
                    console.log($scope.reservation.jslist.selectedObj);
                });

                $scope.reservation.jslist.toggleIn();
            });
        },
        updateReservation: function (jsonresvtn) {
            console.log("update Reservation", jsonresvtn);
            jsonresvtn.reservation_ref = $scope.reservation.jslist.selectedObj.reservation_ref;
            jsonPost.data("../php1/front_desk/update_reservation.php", {
                update_reservation: $filter('json')(jsonresvtn)
            }).then(function (response) {
                console.log(response);
                res = $rootScope.settings.modal.msgprompt(response);
                if(res) {
                    $scope.reservation.jslist.toggleOut();
                    $scope.reservation.jslist.createList()
                } else{
                    return;
                }

                $scope.reservation.itemlist('filter', function(newresvtn){
                    $scope.reservation.jslist.values = [];
                    $scope.reservation.jslist.values = newresvtn;
                    $scope.reservation.jslist.selectedObj = $filter('filterObj')(newresvtn, $scope.reservation.jslist.selected, ['reservation_ref']);
                    $scope.reservation.jslist.selected = $scope.reservation.jslist.selectedObj.reservation_ref;
                    console.log($scope.reservation.jslist.selectedObj);
                });
                $scope.reservation.resvtn.jslist.createList()
                $scope.reservation.resvtn.jslist.selected = null; $scope.reservation.resvtn.jslist.selectedObj = {};
                $scope.reservation.jslist.toggleIn();
            });
        },
        deleteReservation: function () {
            jsonresvtn = {}
            jsonresvtn.reservation_ref = $scope.reservation.jslist.selectedObj.reservation_ref;
            console.log("new resvtn", jsonresvtn);
            jsonform = {
                reservations: [jsonresvtn]
            }
            jsonPost.data("../php1/front_desk/delete_reservation.php", {
                reservation_ref: $filter('json')(jsonform)
            }).then(function (response) {
                $scope.reservation.jslist.toggleOut();
                console.log(response);
                $scope.reservation.jslist.createList();
                $scope.reservation.jslist.selectedObj = {};
                $scope.reservation.jslist.selected = null;
                $scope.reservation.jslist.toggleIn();
            });

        },
        claim: function (jsonform) {
            jsonclaim = Object.assign($scope.reservation.jslist.selectedObj, jsonform);
            jsonclaim.frontdesk_rep = $rootScope.settings.user;
            console.log(jsonclaim);
            jsonPost.data("../php1/front_desk/claim_reservation.php", {
                reservation_data: $filter('json')(jsonclaim)
            }).then(function (response) {
                console.log(response);
                res = $rootScope.settings.modal.msgprompt(response);
                if(res) {
                    $scope.reservation.jslist.toggleOut();
                    $scope.reservation.jslist.createList()
                } else{
                    return;
                }

                $scope.reservation.itemlist('filter', function(newresvtn){
                    $scope.reservation.jslist.values = [];
                    $scope.reservation.jslist.values = newresvtn;
                    $scope.reservation.jslist.selectedObj = $filter('filterObj')(newresvtn, $scope.reservation.jslist.selected, ['reservation_ref']);
                    $scope.reservation.jslist.selected = $scope.reservation.jslist.selectedObj.reservation_ref;
                    console.log($scope.reservation.jslist.selectedObj);
                });

                $scope.reservation.resvtn.jslist.createList()
                $scope.reservation.resvtn.jslist.selected = null; $scope.reservation.resvtn.jslist.selectedObj = {};
                $scope.reservation.jslist.toggleIn();
            });
        },
        confirm: function (jsonform) {
            jsonconfirm = $scope.reservation.jslist.selectedObj;
            jsonconfirm.amount_paid = jsonform.amount_paid;
            jsonconfirm.means_of_payment = jsonform.means_of_payment;
            jsonconfirm.frontdesk_rep = $rootScope.settings.user;
            console.log(jsonconfirm);
            jsonPost.data("../php1/front_desk/confirm_reservation.php", {
                reservation_data: $filter('json')(jsonconfirm)
            }).then(function (response) {
                console.log(response);
                res = $rootScope.settings.modal.msgprompt(response);
                if(res) {
                    $scope.reservation.jslist.toggleOut();
                    $scope.reservation.jslist.createList()
                } else{
                    return;
                }

                $scope.reservation.itemlist('filter', function(newresvtn){
                    $scope.reservation.jslist.values = [];
                    $scope.reservation.jslist.values = newresvtn;
                    $scope.reservation.jslist.selectedObj = $filter('filterObj')(newresvtn, $scope.reservation.jslist.selected, ['reservation_ref']);
                    $scope.reservation.jslist.selected = $scope.reservation.jslist.selectedObj.reservation_ref;
                    console.log($scope.reservation.jslist.selectedObj);
                });

                $scope.reservation.resvtn.jslist.createList()
                $scope.reservation.resvtn.jslist.selected = null; $scope.reservation.resvtn.jslist.selectedObj = {};
                $scope.reservation.jslist.toggleIn();
            });
        },
        addResvtnForm : {
            getAvailablerooms: function(nyts,start_date, end_date, trigger){
                var result;
                console.log(end_date, trigger);
                if(trigger == "nyts"){
                    result = $filter('intervalGetDate')(nyts, start_date)
                    end_date = result;
                }else if(trigger == "leave"){
                    result = $filter('dateGetInterval')(end_date, start_date);
                    console.log(result);
                }else if(trigger == "start"){
                    result = $filter('intervalGetDate')(nyts, start_date)
                    end_date = result;
                };
                jsonPost.data("../php1/front_desk/list_rooms_custom.php", {
                    startDate: start_date,
                    nights: nyts,
                    endDate: end_date,
                    flag: 'reservation'
                }).then(function (result) {
                    $scope.reservation.addResvtnForm.roomsProps.rooms = result;
                    console.log(result);
                });
                return result;
            },
            roomsProps: {
                rooms: [],
                activePane: '',
                roomModels : {},
                calculateTotal: function(){
                    this.selectedRooms.num = 0;
                    this.selectedRooms.cost = 0;
                    this.selectedRooms.selected = [];
                    Object.values(this.selectedRooms.categories).forEach(function(category){
                        //console.log(category);
                        this.selectedRooms.num += category.num;
                        this.selectedRooms.cost += category.cost;
                        this.selectedRooms.selected = this.selectedRooms.selected.concat(category.array);
                    }, this)
                    return this.selectedRooms;
                },
                selectRooms: function(category, selectedNum, averagenyt){
                    this.selectedRooms.categories[category] = {array: [], num:0, cost:0};
                    var categoryRooms = this.rooms[category]['rooms'];
                    if(selectedNum > categoryRooms.length) {
                        this.selectedRooms.categories[category]['num'] = categoryRooms.length;
                        selectedNum = categoryRooms.length;
                    }
                    categoryRooms.forEach(function(room, index){
                        room.selected = index < selectedNum ? true : false;
                        this.roomModels[room.room_id] = averagenyt;
                        if(room.selected){
                            room.no_of_nights = this.roomModels[room.room_id];
                            room.room_reservation_date = $scope.reservation.inputs.nytstartdate;
                            room.room_total_cost = (parseInt(room.no_of_nights) * parseInt(room.room_rate));
                            this.selectedRooms.categories[category]['num']++;
                            this.selectedRooms.categories[category]['array'].push(room);
                            this.selectedRooms.categories[category]['cost'] += parseInt(room.room_rate) * parseInt(room.no_of_nights);
                        }
                    }, this);
                    console.log(this.calculateTotal());
                },
                toggleRooms: function(){
                    category = this.activePane;
                    this.selectedRooms.categories[category] = {array: [], num:0, cost:0};
                    //dis = this;
                    this.rooms[category]['rooms'].forEach(function(room){
                        if(room.selected){
                            room.no_of_nights = this.roomModels[room.room_id];
                            room.room_reservation_date = $scope.reservation.inputs.nytstartdate;
                            room.room_total_cost = (parseInt(room.no_of_nights) * parseInt(room.room_rate));
                            this.selectedRooms.categories[category]['num']++;
                            this.selectedRooms.categories[category]['array'].push(room);
                            this.selectedRooms.categories[category]['cost'] += parseInt(room.room_rate) * parseInt(room.no_of_nights);
                        }
                    }, this);
                    console.log(this.calculateTotal());
                },
                changeRoomNyts: function(room_id){
                    category = this.activePane;
                    this.selectedRooms.categories[category] = {array: [], num:0, cost:0};
                    this.rooms[category]['rooms'].forEach(function(room){
                        if(room.selected){
                            if(room.room_id == room_id) 
                            room.no_of_nights = this.roomModels[room.room_id];
                            room.room_reservation_date = $scope.reservation.inputs.nytstartdate;
                            room.room_total_cost = (parseInt(room.no_of_nights) * parseInt(room.room_rate));
                            this.selectedRooms.categories[category]['num']++;
                            this.selectedRooms.categories[category]['array'].push(room);
                            this.selectedRooms.categories[category]['cost'] += parseInt(room.room_rate) * parseInt(room.no_of_nights);
                        }
                    }, this);
                    console.log(this.calculateTotal());
                }
            }
        },
        resvtn : {
            getallrooms: function () {
                jsonPost.data("../php1/front_desk/list_rooms.php", {}).then(function(result){
                    $scope.reservation.resvtn.allrooms = result;
                });
            },
            updateResvtn: function (jsonresvtn) {
                jsonresvtn.reservation_ref = this.jslist.selectedObj.reservation_ref;
                jsonresvtn.reserved_date = this.jslist.selectedObj.reserved_date;
                jsonresvtn.new_room_id = '';
                //console.log($scope.resvtn.jslist.selectedObj.reserved_date);
    
                jsonresvtn.room_id = this.jslist.selectedObj.room_id;
    
                jsonPost.data("../php1/front_desk/list_rooms.php", {}).then(function (result) {
                    result.forEach(function (elem) {
                        if (elem.room_number == jsonresvtn.new_room_number) {
                            jsonresvtn.new_room_id = elem.room_id;
                        } else if (elem.room_number == jsonresvtn.room_number) {
                            jsonresvtn.room_id = elem.room_id;
                        }
                    });
                    console.log("update Resvtn", jsonresvtn);
                    jsonPost.data("../php1/front_desk/update_reservation_room.php", {
                        update_reservation: $filter('json')(jsonresvtn)
                    }).then(function (response) {
                        console.log(response);
                        $scope.reservation.jslist.toggleOut();
                        res = $rootScope.settings.modal.msgprompt(response);
                        if(res) {
                            $scope.reservation.jslist.createList()
                        } else{
                            return;
                        }
    
                        $scope.reservation.itemlist('filter', function(newresvtn){
                            $scope.reservation.jslist.values = [];
                            $scope.reservation.jslist.values = newresvtn;
                            $scope.reservation.jslist.selectedObj = $filter('filterObj')(newresvtn, $scope.reservation.jslist.selected, ['reservation_ref']);
                            $scope.reservation.jslist.selected = $scope.reservation.jslist.selectedObj.reservation_ref;
                            console.log($scope.reservation.jslist.selectedObj);
                        });
    
                        res ? $scope.reservation.resvtn.jslist.createList() : null;
                        $scope.reservation.jslist.toggleIn();
                        $scope.reservation.resvtn.jslist.selectedObj = {};
                        $scope.reservation.resvtn.jslist.selected = null;
                    });
                });
            },
            deleteResvtn: function () {
                jsonresvtn = {}
                jsonresvtn.reservation_ref = this.jslist.selectedObj.reservation_ref;
                jsonresvtn.room_number = this.jslist.selectedObj.room_number;
    
                jsonPost.data("../php1/front_desk/list_rooms.php", {}).then(function (result) {
                    result.forEach(function (elem) {
                        if (elem.room_number == jsonresvtn.room_number) {
                            jsonresvtn.room_id = elem.room_id;
                        }
                    });
                    console.log("new resvtn", jsonresvtn);
                    jsonform = {
                        reservations: [jsonresvtn]
                    }
                    jsonPost.data("../php1/front_desk/del_reservation_room.php", {
                        reservation_ref: $filter('json')(jsonform)
                    }).then(function (response) {
                        $scope.reservation.jslist.toggleOut();
                        console.log(response);
                        $scope.reservation.jslist.createList();
                        $scope.reservation.resvtn.jslist.createList();
    
                        $scope.reservation.itemlist('filter', function(newresvtn){
                            $scope.reservation.jslist.values = [];
                            $scope.reservation.jslist.values = newresvtn;
                            $scope.reservation.jslist.selectedObj = $filter('filterObj')(newresvtn, $scope.reservation.jslist.selected, ['reservation_ref']);
                            $scope.reservation.jslist.selected = $scope.reservation.jslist.selectedObj.reservation_ref;
                            console.log($scope.reservation.jslist.selectedObj);
                        });
    
                        $scope.reservation.jslist.toggleIn();
                        $scope.reservation.resvtn.jslist.selectedObj = {};
                        $scope.reservation.resvtn.jslist.selected = null;
                    });
                });
    
            }
        }
    };


    $scope.rooms = {
        inputs:{},
        init: function(){
            $rootScope.$on('roomselect', function (evt, param) {
                $scope.rooms.getGuest(param.current_guest_id);
            });
        },
        changeRoom: function(jsonform){
            jsonform.booking_ref = $scope.rooms.current_booking.booking_ref;
            jsonPost.data("../php1/front_desk/change_room.php", {
                change_room: $filter('json')(jsonform)
            }).then(function (response) {
                console.log(response);
                $scope.rooms.inputs = {};
                $scope.rooms.jslist.toggleOut();
                console.log(response);
                res = $rootScope.settings.modal.msgprompt(response);
                res ? $scope.rooms.jslist.createList() : null;
                $scope.rooms.itemlist(function (response) {
                    $scope.rooms.jslist.selectedObj = $filter('filterObj')(response, $scope.rooms.jslist.selected, ['room_id']);
                    $scope.rooms.jslist.selected = $scope.rooms.jslist.selectedObj.room_id;
                    console.log($scope.rooms.jslist.selectedObj);
                    $scope.rooms.getGuest($scope.rooms.jslist.selectedObj.current_guest_id);
                });
                $scope.rooms.jslist.toggleIn();
            });
        },
        roomSubstitutes: [],
        getRoomSubstitutes: function(){
            this.inputs.current_room = this.jslist.selectedObj.room_number;
            jsonPost.data("../php1/front_desk/list_bookings_custom.php", {
                col: 'room_id',
                val: $scope.rooms.jslist.selected
            }).then(function(result){
                $scope.rooms.current_booking = result[0];
                console.log(result);
                jsonPost.data("../php1/front_desk/list_rooms_custom.php", {
                    startDate: $filter('limitTo')(result[0]['check_in_date'], 10),
                    nights: result[0]['no_of_nights'],
                    endDate: $filter('intervalGetDate')(this.nights, this.startDate),
                    flag: 'booking'
                }).then(function (result) {
                    $scope.rooms.roomSubstitutes = result[$scope.rooms.jslist.selectedObj.room_category] ? result[$scope.rooms.jslist.selectedObj.room_category].rooms : [];
                });
            })
        },
        current_guest: {},
        itemlist: function (callback) {
            jsonPost.data("../php1/front_desk/list_rooms.php", {}).then(function(result){
                $scope.rooms.allrooms = result;
                callback(result);
            });
        },
        resvtn : {
            list: [],
            getReservation: function () {
                console.log('arr');
                jsonPost.data("../php1/front_desk/list_reservations.php", {}).then(function (result) {
                    $scope.rooms.resvtn.list = [];
                    if(!result) return;
                    result.forEach(function (elem) {
                        if(elem.booked == 'NO' && elem.room_id == $scope.rooms.jslist.selected) $scope.rooms.resvtn.list.push(elem);

                    });
                    console.log($scope.rooms.resvtn.list);
                });
            },
            listhddata: [
                {
                    name: "Guest",
                    width: "col-2",
                },
                {
                    name: "Start",
                    width: "col-3",
                },
                {
                    name: "Nyts",
                    width: "col-1",
                },
                {
                    name: "Paid",
                    width: "col-3",
                },
                {
                    name: "Cost",
                    width: "col-3",
                }
            ],
            select: function (index, id) {
                $scope.rooms.resvtn.selected = id;
                $scope.rooms.resvtn.selectedObj = $scope.rooms.resvtn.newItemArray[index];
                console.log($scope.rooms.resvtn.newItemArray[index]);
            },
            updateResvtn: function (jsonresvtn) {
                jsonresvtn.reservation_ref = $scope.rooms.resvtn.selectedObj.reservation_ref;
                jsonresvtn.reserved_date = $scope.rooms.resvtn.selectedObj.reserved_date;
                jsonresvtn.new_room_id = '';
                console.log($scope.rooms.resvtn.selectedObj.reserved_date);

                jsonresvtn.room_id = $scope.rooms.resvtn.selectedObj.room_id;

                
                $scope.rooms.allrooms.forEach(function (elem) {
                    if (elem.room_number == jsonresvtn.new_room_number) {
                        jsonresvtn.new_room_id = elem.room_id;
                    } else if (elem.room_number == jsonresvtn.room_number) {
                        jsonresvtn.room_id = elem.room_id;
                    }
                });
                console.log("update Resvtn", jsonresvtn);

                jsonPost.data("../php1/front_desk/update_reservation_room.php", {
                    update_reservation: $filter('json')(jsonresvtn)
                }).then(function (response) {
                    console.log(response);
                    $scope.rooms.jslist.toggleOut();
                    res = $rootScope.settings.modal.msgprompt(response);
                    if(res) {
                        $scope.rooms.jslist.createList()
                    } else{
                        return;
                    }


                    $scope.rooms.itemlist(function (result) {
                        $scope.rooms.jslist.selectedObj = $filter('filterObj')(result, $scope.rooms.jslist.selected, ['room_id']);
                        $scope.rooms.jslist.selected = $scope.rooms.jslist.selectedObj.room_id;
                        console.log($scope.rooms.jslist.selectedObj);
                    });


                    $scope.rooms.jslist.toggleIn();
                    $scope.rooms.resvtn.getReservation();
                    $scope.rooms.resvtn.selectedObj = {}
                    $scope.rooms.resvtn.selected = null;
                });
            },
            deleteResvtn: function () {
                jsonresvtn = {}
                jsonresvtn.reservation_ref = $scope.rooms.resvtn.selectedObj.reservation_ref;
                jsonresvtn.room_number = $scope.rooms.resvtn.selectedObj.room_number;

                $scope.rooms.allrooms.forEach(function (elem) {
                    if (elem.room_number == jsonresvtn.room_number) {
                        jsonresvtn.room_id = elem.room_id;
                    }
                });
                console.log("new resvtn", jsonresvtn);
                jsonform = {
                    reservations: [jsonresvtn]
                }
                jsonPost.data("../php1/front_desk/del_reservation_room.php", {
                    reservation_ref: $filter('json')(jsonform)
                }).then(function (response) {
                    $scope.rooms.jslist.toggleOut();
                    console.log(response);
                    $scope.rooms.jslist.createList();

                    $scope.rooms.itemlist(function (result) {
                        $scope.rooms.jslist.selectedObj = $filter('filterObj')(result, $scope.rooms.jslist.selected, ['room_id']);
                        $scope.rooms.jslist.selected = $scope.rooms.jslist.selectedObj.room_id;
                        console.log($scope.rooms.jslist.selectedObj);
                    });

                    $scope.rooms.resvtn.getReservation();
                    $scope.rooms.jslist.toggleIn();
                    $scope.rooms.resvtn.selectedObj = {}
                    $scope.rooms.resvtn.selected = null;
                });

            }
        },
        getGuest: function (id) {
            jsonPost.data("../php1/front_desk/list_guests_all.php", {}).then(function (result) {
                found = false;
                result.forEach(function (elem) {
                    if (id == elem.guest_id) {
                        found = elem;
                    }
                })
                $scope.rooms.current_guest = found || {};
            })
        },


    };
    
    $scope.guest.init();
    $scope.rooms.init();
    $scope.reservation.init();

}]);
