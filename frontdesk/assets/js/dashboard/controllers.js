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

    $scope.guest = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/front_desk/list_guests_all.php", {})
            }
        },
        getguest : function(obj){$scope.guest.itemlist().jsonfunc.then(function(result){
            $scope.guest.arr = result;
            arr = $filter('duplicatekey')(result, obj);
            console.log(arr);
            $scope.guest.namesarr = arr;
        })},
        roomgrid:{
            type: '',
            rooms : {},
            roomid: {},
            room_info: {
                rooms: 0,
                cost: 0,
                calc_room_info : function(){
                    rmtype = Object.keys($scope.guest.roomgrid.room_details.rooms);
                    $scope.guest.roomgrid.room_info.rooms = 0;
                    $scope.guest.roomgrid.room_info.cost = 0;

                    rmtype.forEach(function(elem){

                        $scope.guest.roomgrid.room_details.rooms[elem].num ? ($scope.guest.roomgrid.room_info.rooms += parseInt($scope.guest.roomgrid.room_details.rooms[elem].num)) : null;;
                        $scope.guest.roomgrid.room_details.rooms[elem].arr.forEach(function(val){
                            if(val.selected == true){
                                val.no_of_nights = val.no_of_nights ? val.no_of_nights : 0;
                                $scope.guest.roomgrid.room_info.cost += (parseInt(val.no_of_nights) * parseInt(val.room_rate));
                            }
                        })

                    });
                }
            },
            room_details: {
                rooms:{},
                selectrooms : function(roomtype){
                    if($scope.guest.roomgrid.room_details.rooms[roomtype].num > $scope.guest.roomgrid.room_details.rooms[roomtype].count){
                        $scope.guest.roomgrid.room_details.rooms[roomtype].num = $scope.guest.roomgrid.room_details.rooms[roomtype].count
                    }
                    for(var i = 0; i <= $scope.guest.roomgrid.room_details.rooms[roomtype].arr.length - 1; i++){
                        console.log(roomtype);
                        $scope.guest.roomgrid.room_details.rooms[roomtype].arr[i].selected = false;
                    };
                    for(var i = 0; i <= $scope.guest.roomgrid.room_details.rooms[roomtype].num - 1; i++){
                        console.log(roomtype);
                        $scope.guest.roomgrid.room_details.rooms[roomtype].arr[i].selected = true;
                    };
                    $scope.guest.roomgrid.room_info.calc_room_info();
                },
                toggleroom : function(){
                    roomtype = Object.keys($scope.guest.roomgrid.room_details.rooms);
                    $scope.guest.roomgrid.room_info.rooms = 0;
                    $scope.guest.roomgrid.room_info.cost = 0;
                    roomtype.forEach(function(elem){
                        num = 0;
                        $scope.guest.roomgrid.room_details.rooms[elem].arr.forEach(function(val){
                            if(val.selected == true){
                                num++;
                                $scope.guest.roomgrid.room_info.cost += (parseInt(val.no_of_nights) * parseInt(val.room_rate));
                            }
                        });
                        $scope.guest.roomgrid.room_details.rooms[elem].num = num;
                        $scope.guest.roomgrid.room_info.rooms += num;
                    });
                },
                change_nyt_no : function(id){
                    actv = $scope.guest.roomgrid.type;
                    for(var i = 0; i < $scope.guest.roomgrid.room_details.rooms[actv].arr.length; i++){
                        elem =  $scope.guest.roomgrid.room_details.rooms[actv].arr[i]
                        if(elem.room_id == id){
                            if(!elem.reservations){
                                $scope.guest.roomgrid.room_details.rooms[actv].arr[i].no_of_nights = $scope.guest.roomgrid.roomid[id];
                                
                            }
                            else{
                                for(var j = 0; j < elem.reservations.length; j++){
                                    resvtn = elem.reservations[j];
                                    date1 = new Date($filter('intervalGetDate')($scope.guest.roomgrid.roomid[id]));
                                    date2 = new Date(resvtn.reserved_date);
                                    date3 = new Date();
                                    console.log(date1, date2);
                                    if(date1 > date2 && date3 < date2){
                                        console.log('no');
                                        $scope.guest.roomgrid.reservedyes = id;
                                        $timeout(function(){
                                            $scope.guest.roomgrid.reservedyes = '';
                                        }, 2000);
                                        console.log($scope.guest.roomgrid.reservedyes);
                                        
                                        $scope.guest.roomgrid.roomid[id] = $scope.guest.roomgrid.averagenyt;
                                        
                                    }else if(j == (elem.reservations.length - 1)){
                                        console.log('yes');
                                        $scope.guest.roomgrid.room_details.rooms[actv].arr[i].no_of_nights = $scope.guest.roomgrid.roomid[id];
                                        
                                    } 
                                }
                            }
                            
                            $scope.guest.roomgrid.room_info.calc_room_info();
                        }
                    }
                }

            },
            averagenyt : 0,
            nytdate : $filter('intervalGetDate')(0),
            activate: function(room_type){
                //$scope.guest.rooms[room_type] = 
                $scope.guest.roomgrid.type = room_type;
                $scope.guest.roomgrid.activated = 'true';
            },
            deactivate: function(){
                //$scope.guest.rooms[room_type] = 
                $scope.guest.roomgrid.type = '';
                $scope.guest.roomgrid.activated = 'false';
            },
            getrooms : function(roomCat){
                roomCat.forEach(function(cat){
                    jsonPost.data("../php1/front_desk/frontdesk_rooms_by_category.php", {
                        category : cat
                    }).then(function(result){
                        $scope.guest.roomgrid.room_details.rooms[cat] = {name: cat, arr: $scope.guest.roomgrid.resvtn_room(result)};

                        $scope.guest.roomgrid.room_details.rooms[cat].count= $scope.guest.roomgrid.room_details.rooms[cat].arr.length
                        console.log($scope.guest.roomgrid.room_details.rooms[cat]);
                    });
                });
            },
            resvtn_room : function(arr){
                if(!Array.isArray(arr)){
                    return [];
                }
                myarr = [];
                for(var i = 0; i < arr.length; i++){
                    elem = arr[i];
                    console.log(elem.reservations);
                    if(elem.reservations){
                        for(var j = 0; j < elem.reservations.length; j++){
                            resvtn = elem.reservations[j];
                            date1 = new Date($scope.guest.roomgrid.nytdate);
                            date2 = new Date(resvtn.reserved_date);
                            date3 = new Date();

                            if(date1 > date2 && date3 < date2){
                                elem.can_be_booked = false;
                                console.log('false', resvtn.reserved_date);
                                break;
                            }else if(date2 > date1 || date2 < date3){
                                arr[i].can_be_booked = true;
                                arr[i].no_of_nights = $scope.guest.roomgrid.averagenyt;
                                console.log('true', resvtn.reserved_date);
                               
                            }
                        };
                    }else{
                        console.log('noresvtn');
                        arr[i].can_be_booked = true;
                        arr[i].no_of_nights = $scope.guest.roomgrid.averagenyt;
                        
                    }
                    
                }
                for(var k = 0; k < arr.length; k++){
                    if(arr[k].can_be_booked == true){
                        myarr.push(arr[k]);
                    }
                }
                return myarr;
            },
            change_averagenyt : function(){
                $scope.guest.roomgrid.getrooms(['deluxe', 'standard']);
                $scope.guest.roomgrid.room_info.cost = 0;
                $scope.guest.roomgrid.room_info.rooms = 0;
            },
            activated:'false'
        },
        addGuest: function (jsonguest) {
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
        checkIn: function (jsonguest) {
            //console.log("new checkIn", jsonform);
            jsonguest.guest_id = $scope.guest.jslist.selectedObj.guest_id;
            jsonguest.guest_name = $scope.guest.jslist.selectedObj.guest_name;
            console.log("new checkIn", jsonguest);

            jsonPost.data("../php1/front_desk/checkin.php", {
                checkin_data: $filter('json')(jsonguest)
            }).then(function (response) {
                $scope.guest.roomgrid.averagenyt = 0;
                $scope.guest.roomgrid.room_info.rooms = 0;
                $scope.guest.roomgrid.room_info.cost = 0;
                console.log(response);
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
        checkOut: function(){
            jsonguest = $scope.guest.jslist.selectedObj;
            jsonguest.frontdesk_rep = $rootScope.settings.user;
            jsonguest.rooms = $scope.booking.selected;
            jsonguest.booking_ref = $scope.booking.selected[0].booking_ref;
            console.log("new checkOut", jsonguest);

            jsonPost.data("../php1/front_desk/checkOut.php", {
                checkout_data: $filter('json')(jsonguest)
            }).then(function (response) {
                console.log(response);
                $scope.guest.jslist.toggleOut();
                $scope.booking.selected = [];
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
        payBalance: function(jsonguest){
            jsonguest.booking_ref = $scope.booking.rooms[0].booking_ref;
            jsonguest.guest_name = $scope.booking.rooms[0].guest_name;
            jsonguest.guest_id = $scope.booking.rooms[0].guest_id;
            jsonguest.frontdesk_rep = $rootScope.settings.user;
            console.log("new payment", jsonguest);

            jsonPost.data("../php1/front_desk/frontdesk_balance_pay.php", {
                payment_details: $filter('json')(jsonguest)
            }).then(function (response) {
                console.log(response);
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
        updateGuest: function (jsonguest) {
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
        deleteGuest: function () {
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
        },
        getRoomBooking : function(id){
            $scope.booking.itemlist(id).jsonfunc.then(function(result){
                console.log(result);
                response = [];
                $scope.guest.jslist.selectedObj.rooms = [];
                if(result){
                    result.forEach(function(elem){
                        console.log(id, elem);
                        $scope.guest.jslist.selectedObj.rooms.push(elem.room_number);
                        response.push(elem);
                    });
                }
                return response;
            });
        }
    };

    $scope.reservation = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/front_desk/list_reservations.php", {})
            }
        },
        state : function(){
            if($scope.reservation.jslist.selectedObj.deposit_confirmed == 'NO') {
                $rootScope.settings.modal.active = 'Reservation'; 
                $rootScope.settings.modal.name =  'Confirm Reservation'; 
                $rootScope.settings.modal.size = 'md'; 
            }
            else{
                $rootScope.settings.modal.active = 'Reservation'; 
                $rootScope.settings.modal.name =  'Claim Reservation'; 
                $rootScope.settings.modal.size = 'md'; 
            } 

        },
        addReservation : function (jsonresvtn) {
            console.log("new Reservation", jsonresvtn);

            jsonPost.data("../php1/front_desk/add_reservation.php", {
                reservation_data: $filter('json')(jsonresvtn)
            }).then(function (response) {
                console.log(response);
                $scope.reservation.roomgrid.averagenyt = 0;
                $scope.reservation.roomgrid.room_info.rooms = 0;
                $scope.reservation.roomgrid.room_info.cost = 0;
                $scope.reservation.jslist.toggleOut();
                res = $rootScope.settings.modal.msgprompt(response);
                res ? $scope.reservation.jslist.createList() : null;

                
                $scope.reservation.itemlist().jsonfunc.then(function(result){
                    newresvtn = [];
                    result.forEach(function(rtn){
                        count = true;
                        for(var i = 0; i < newresvtn.length; i++){
                            res = newresvtn[i];
                            if(rtn.reservation_ref == res.reservation_ref && rtn.guest_id == res.guest_id){
                                count = false;
                            }
                        };
                        if(count){
                            newresvtn.push(rtn);
                        }
                    });
                    $scope.reservation.jslist.selectedObj =  $filter('filterObj')(newresvtn,$scope.reservation.jslist.selected, ['reservation_ref']);
                    $scope.reservation.jslist.selected = $scope.reservation.jslist.selectedObj.reservation_ref;
                    console.log($scope.reservation.jslist.selectedObj);
                });

                
                $scope.reservation.jslist.toggleIn();
            });
        },
        updateReservation : function (jsonresvtn) {
            console.log("update Reservation", jsonresvtn);
            jsonresvtn.reservation_ref = $scope.reservation.jslist.selectedObj.reservation_ref;
            jsonPost.data("../php1/front_desk/update_reservation.php", {
                update_reservation: $filter('json')(jsonresvtn)
            }).then(function (response) {
                console.log(response);
                $scope.reservation.jslist.toggleOut();
                res = $rootScope.settings.modal.msgprompt(response);
                res ? $scope.reservation.jslist.createList() : null;
                
                $scope.reservation.itemlist().jsonfunc.then(function(result){
                    newresvtn = [];
                    result.forEach(function(rtn){
                        count = true;
                        for(var i = 0; i < newresvtn.length; i++){
                            res = newresvtn[i];
                            if(rtn.reservation_ref == res.reservation_ref && rtn.guest_id == res.guest_id){
                                count = false;
                            }
                        };
                        if(count){
                            newresvtn.push(rtn);
                        }
                    });
                    $scope.reservation.jslist.selectedObj =  $filter('filterObj')(newresvtn,$scope.reservation.jslist.selected, ['reservation_ref']);
                    $scope.reservation.jslist.selected = $scope.reservation.jslist.selectedObj.reservation_ref;
                    console.log($scope.reservation.jslist.selectedObj);
                });
                $scope.resvtn.jslist.createList()
                $scope.resvtn.jslist.selected = null;$scope.resvtn.jslist.selectedObj = {};
                $scope.reservation.jslist.toggleIn();
            });
        },
        deleteReservation: function(){
            jsonresvtn = {}
            jsonresvtn.reservation_ref = $scope.reservation.jslist.selectedObj.reservation_ref;
            console.log("new resvtn", jsonresvtn);
            jsonform = {
                reservations : [jsonresvtn]
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
        claim : function(jsonform){
            jsonclaim = Object.assign($scope.reservation.jslist.selectedObj,jsonform);
            jsonclaim.frontdesk_rep = $rootScope.settings.user;
            console.log(jsonclaim);
            jsonPost.data("../php1/front_desk/claim_reservation.php", {
             reservation_data: $filter('json')(jsonclaim)
             }).then(function (response) {
                 console.log(response);
                 $scope.reservation.jslist.toggleOut();
                 res = $rootScope.settings.modal.msgprompt(response);
                 res ? $scope.reservation.jslist.createList() : null;
                 
                $scope.reservation.itemlist().jsonfunc.then(function(result){
                    newresvtn = [];
                    result.forEach(function(rtn){
                        count = true;
                        for(var i = 0; i < newresvtn.length; i++){
                            res = newresvtn[i];
                            if(rtn.reservation_ref == res.reservation_ref && rtn.guest_id == res.guest_id){
                                count = false;
                            }
                        };
                        if(count){
                            newresvtn.push(rtn);
                        }
                    });
                    $scope.reservation.jslist.selectedObj =  $filter('filterObj')(newresvtn,$scope.reservation.jslist.selected, ['reservation_ref']);
                    $scope.reservation.jslist.selected = $scope.reservation.jslist.selectedObj.reservation_ref;
                    console.log($scope.reservation.jslist.selectedObj);
                });

                $scope.resvtn.jslist.createList()
                $scope.resvtn.jslist.selected = null;$scope.resvtn.jslist.selectedObj = {};
                 $scope.reservation.jslist.toggleIn();
             });
        },
        confirm : function(jsonform){
            jsonconfirm = $scope.reservation.jslist.selectedObj;
            jsonconfirm.amount_paid = jsonform.amount_paid;
            jsonconfirm.means_of_payment = jsonform.means_of_payment;
            jsonconfirm.frontdesk_rep = $rootScope.settings.user;
            console.log(jsonconfirm);
            jsonPost.data("../php1/front_desk/confirm_reservation.php", {
             reservation_data: $filter('json')(jsonconfirm)
             }).then(function (response) {
                 console.log(response);
                 $scope.reservation.jslist.toggleOut();
                 res = $rootScope.settings.modal.msgprompt(response);
                 res ? $scope.reservation.jslist.createList() : null;
                 
                $scope.reservation.itemlist().jsonfunc.then(function(result){
                    newresvtn = [];
                    result.forEach(function(rtn){
                        count = true;
                        for(var i = 0; i < newresvtn.length; i++){
                            res = newresvtn[i];
                            if(rtn.reservation_ref == res.reservation_ref && rtn.guest_id == res.guest_id){
                                count = false;
                            }
                        };
                        if(count){
                            newresvtn.push(rtn);
                        }
                    });
                    $scope.reservation.jslist.selectedObj =  $filter('filterObj')(newresvtn,$scope.reservation.jslist.selected, ['reservation_ref']);
                    $scope.reservation.jslist.selected = $scope.reservation.jslist.selectedObj.reservation_ref;
                    console.log($scope.reservation.jslist.selectedObj);
                });

                $scope.resvtn.jslist.createList()
                $scope.resvtn.jslist.selected = null;$scope.resvtn.jslist.selectedObj = {};
                 $scope.reservation.jslist.toggleIn();
             });
         },
        roomgrid:{
            type: '',
            rooms : {},
            roomid: {},
            roomdate: {},
            room_info: {
                rooms: 0,
                cost: 0,
                calc_room_info : function(){
                    rmtype = Object.keys($scope.reservation.roomgrid.room_details.rooms);
                    $scope.reservation.roomgrid.room_info.rooms = 0;
                    $scope.reservation.roomgrid.room_info.cost = 0;

                    rmtype.forEach(function(elem){

                        $scope.reservation.roomgrid.room_details.rooms[elem].num ? ($scope.reservation.roomgrid.room_info.rooms += parseInt($scope.reservation.roomgrid.room_details.rooms[elem].num)) : null;;
                        $scope.reservation.roomgrid.room_details.rooms[elem].arr.forEach(function(val){
                            if(val.selected == true){
                                val.no_of_nights = val.no_of_nights ? val.no_of_nights : 0;
                                $scope.reservation.roomgrid.room_info.cost += (parseInt(val.no_of_nights) * parseInt(val.room_rate));
                            }
                        })

                    });
                }
            },
            room_details: {
                rooms:{},
                selectrooms : function(roomtype){
                    if($scope.reservation.roomgrid.room_details.rooms[roomtype].num > $scope.reservation.roomgrid.room_details.rooms[roomtype].count){
                        $scope.reservation.roomgrid.room_details.rooms[roomtype].num = $scope.reservation.roomgrid.room_details.rooms[roomtype].count
                    }
                    for(var i = 0; i <= $scope.reservation.roomgrid.room_details.rooms[roomtype].arr.length - 1; i++){
                        console.log(roomtype);
                        $scope.reservation.roomgrid.room_details.rooms[roomtype].arr[i].selected = false;
                    };
                    for(var i = 0; i <= $scope.reservation.roomgrid.room_details.rooms[roomtype].num - 1; i++){
                        console.log(roomtype);
                        $scope.reservation.roomgrid.room_details.rooms[roomtype].arr[i].selected = true;
                    };
                    $scope.reservation.roomgrid.room_info.calc_room_info();
                },
                toggleroom : function(){
                    roomtype = Object.keys($scope.reservation.roomgrid.room_details.rooms);
                    $scope.reservation.roomgrid.room_info.rooms = 0;
                    $scope.reservation.roomgrid.room_info.cost = 0;
                    roomtype.forEach(function(elem){
                        num = 0;
                        $scope.reservation.roomgrid.room_details.rooms[elem].arr.forEach(function(val){
                            if(val.selected == true){
                                num++;
                                $scope.reservation.roomgrid.room_info.cost += (parseInt(val.no_of_nights) * parseInt(val.room_rate));
                            }
                        });
                        $scope.reservation.roomgrid.room_details.rooms[elem].num = num;
                        $scope.reservation.roomgrid.room_info.rooms += num;
                    });
                },
                change_nyt_no : function(id){
                    actv = $scope.reservation.roomgrid.type;
                    for(var i = 0; i < $scope.reservation.roomgrid.room_details.rooms[actv].arr.length; i++){
                        elem =  $scope.reservation.roomgrid.room_details.rooms[actv].arr[i]
                        if(elem.room_id == id){
                            if(!elem.reservations){
                                $scope.reservation.roomgrid.room_details.rooms[actv].arr[i].no_of_nights = $scope.reservation.roomgrid.roomid[id];
                                
                            }
                            else{
                                for(var j = 0; j < elem.reservations.length; j++){
                                    resvtn = elem.reservations[j];
                                    date1 = new Date($filter('intervalGetDate')($scope.reservation.roomgrid.roomid[id],$scope.reservation.roomgrid.roomdate[id]));

                                    date2 = new Date(resvtn.reserved_date);

                                    date3 = new Date($scope.reservation.roomgrid.roomdate[id]);

                                    date4 = new Date($filter('intervalGetDate')(resvtn.no_of_nights, resvtn.reserved_date));
                                    console.log(date3, date1, date2, date4);
                                    if((date3 >= date2 && date3 <= date4) || (date1 >= date2 && date1 <= date4)){
                                        console.log('no');
                                        $scope.reservation.roomgrid.reservedyes = id;
                                        $timeout(function(){
                                            $scope.reservation.roomgrid.reservedyes = '';
                                        }, 2000);
                                        console.log($scope.reservation.roomgrid.reservedyes);
                                        
                                        $scope.reservation.roomgrid.roomid[id] = $scope.reservation.roomgrid.averagenyt;
                                        
                                    }else if(j == (elem.reservations.length - 1)){
                                        console.log('yes');
                                        $scope.reservation.roomgrid.room_details.rooms[actv].arr[i].no_of_nights = $scope.reservation.roomgrid.roomid[id];
                                        $scope.reservation.roomgrid.room_details.rooms[actv].arr[i].room_reservation_date = $scope.reservation.roomgrid.roomdate[id];
                                        
                                    } 
                                }
                            }
                            
                            $scope.reservation.roomgrid.room_info.calc_room_info();
                        }
                    }
                }

            },
            averagenyt : 0,
            nytstartdate : $filter('intervalGetDate')(0,$rootScope.settings.date),
            nytdate : $filter('intervalGetDate')(0),
            activate: function(room_type){
                //$scope.reservation.rooms[room_type] = 
                $scope.reservation.roomgrid.type = room_type;
                $scope.reservation.roomgrid.activated = 'true';
            },
            deactivate: function(){
                //$scope.reservation.rooms[room_type] = 
                $scope.reservation.roomgrid.type = '';
                $scope.reservation.roomgrid.activated = 'false';
            },
            getrooms : function(roomCat){
                roomCat.forEach(function(cat){
                    jsonPost.data("../php1/front_desk/list_rooms_for_reservations.php", {
                        category : cat
                    }).then(function(result){
                        $scope.reservation.roomgrid.room_details.rooms[cat] = {name: cat, arr: $scope.reservation.roomgrid.resvtn_room(result)};

                        $scope.reservation.roomgrid.room_details.rooms[cat].count= $scope.reservation.roomgrid.room_details.rooms[cat].arr.length
                        console.log($scope.reservation.roomgrid.room_details.rooms[cat]);
                    });
                });
            },
            resvtn_room : function(arr){
                if(!Array.isArray(arr)){
                    return [];
                }
                myarr = [];
                for(var i = 0; i < arr.length; i++){
                    elem = arr[i];
                    console.log(elem.reservations);
                    bookedon = new Date(elem.booked_on);
                    bookedoff = new Date(elem.booking_expires);

                    date1 = new Date($scope.reservation.roomgrid.nytdate);

                    date3 = new Date($scope.reservation.roomgrid.nytstartdate);

                    if(((date3 >= bookedon && date3 <= bookedoff) || (date1 >= bookedon && date1 <= bookedoff)) && elem.booked_on != '0000-00-00 00:00:00'){
                        console.log('aawwee');
                        elem.can_be_booked = false;
                        break;
                    }
                    

                    if(elem.reservations){
                        for(var j = 0; j < elem.reservations.length; j++){
                            resvtn = elem.reservations[j];
                            
                            date2 = new Date(resvtn.reserved_date);
                            
                            date4 = new Date($filter('intervalGetDate')(resvtn.no_of_nights, resvtn.reserved_date));
                            
                            console.log(date1,date2,date3,date4);
                            
                            if((date3 >= date2 && date3 <= date4) || (date1 >= date2 && date1 <= date4)){
                                elem.can_be_booked = false;
                                console.log('false', resvtn.reserved_date);
                                break;
                            }else{
                                arr[i].can_be_booked = true;
                                arr[i].no_of_nights = $scope.reservation.roomgrid.averagenyt;
                                arr[i].room_reservation_date = $scope.reservation.roomgrid.nytstartdate;
                                console.log('true', resvtn.reserved_date);
                            }
                        };
                    }else{
                        console.log('noresvtn');
                        arr[i].can_be_booked = true;
                        arr[i].no_of_nights = $scope.reservation.roomgrid.averagenyt;
                        arr[i].room_reservation_date = $scope.reservation.roomgrid.nytstartdate;
                    }
                    
                }
                for(var k = 0; k < arr.length; k++){
                    if(arr[k].can_be_booked == true){
                        myarr.push(arr[k]);
                    }
                }
                return myarr;
            },
            change_averagenyt : function(){
                $scope.reservation.roomgrid.getrooms(['deluxe', 'standard']);
                $scope.reservation.roomgrid.room_info.cost = 0;
                $scope.reservation.roomgrid.room_info.rooms = 0;
            },
            activated:'false'
        }
    };

    $scope.resvtn = {
        updateResvtn : function (jsonresvtn) {
            jsonresvtn.reservation_ref = $scope.resvtn.jslist.selectedObj.reservation_ref;
            jsonresvtn.reserved_date = $scope.resvtn.jslist.selectedObj.reserved_date;
            jsonresvtn.new_room_id = '';
            //console.log($scope.resvtn.jslist.selectedObj.reserved_date);

            jsonresvtn.room_id = $scope.resvtn.jslist.selectedObj.room_id;

            $scope.rooms.itemlist().jsonfunc.then(function(result){
                result.forEach(function(elem){
                    if(elem.room_number == jsonresvtn.new_room_number){
                        jsonresvtn.new_room_id = elem.room_id;
                    }else if(elem.room_number == jsonresvtn.room_number){
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
                    res ? $scope.reservation.jslist.createList() : null;
                    
                    $scope.reservation.itemlist().jsonfunc.then(function(result){
                        newresvtn = [];
                        result.forEach(function(rtn){
                            count = true;
                            for(var i = 0; i < newresvtn.length; i++){
                                res = newresvtn[i];
                                if(rtn.reservation_ref == res.reservation_ref && rtn.guest_id == res.guest_id){
                                    count = false;
                                }
                            };
                            if(count){
                                newresvtn.push(rtn);
                            }
                        });
                        $scope.reservation.jslist.selectedObj =  $filter('filterObj')(newresvtn,$scope.reservation.jslist.selected, ['reservation_ref']);
                        $scope.reservation.jslist.selected = $scope.reservation.jslist.selectedObj.reservation_ref;
                        console.log($scope.reservation.jslist.selectedObj);
                    });

                    res ? $scope.resvtn.jslist.createList() : null;
                    $scope.reservation.jslist.toggleIn();
                    $scope.resvtn.jslist.selectedObj =  {};
                    $scope.resvtn.jslist.selected = null;
                });
            });
        },
        deleteResvtn: function(){
            jsonresvtn = {}
            jsonresvtn.reservation_ref = $scope.resvtn.jslist.selectedObj.reservation_ref;
            jsonresvtn.room_number = $scope.resvtn.jslist.selectedObj.room_number;
            
            $scope.rooms.itemlist().jsonfunc.then(function(result){
                result.forEach(function(elem){
                    if(elem.room_number == jsonresvtn.room_number){
                        jsonresvtn.room_id = elem.room_id;
                    }
                });
                console.log("new resvtn", jsonresvtn);
                jsonform = {
                    reservations : [jsonresvtn]
                }
                jsonPost.data("../php1/front_desk/del_reservation_room.php", {
                    reservation_ref: $filter('json')(jsonform)
                }).then(function (response) {
                    $scope.reservation.jslist.toggleOut();
                    console.log(response);
                    $scope.reservation.jslist.createList();
                    $scope.resvtn.jslist.createList();
                    
                    $scope.reservation.itemlist().jsonfunc.then(function(result){
                        newresvtn = [];
                        if(!result){return;}
                        result.forEach(function(rtn){
                            count = true;
                            for(var i = 0; i < newresvtn.length; i++){
                                res = newresvtn[i];
                                if(rtn.reservation_ref == res.reservation_ref && rtn.guest_id == res.guest_id){
                                    count = false;
                                }
                            };
                            if(count){
                                newresvtn.push(rtn);
                            }
                        });
                        $scope.reservation.jslist.selectedObj =  $filter('filterObj')(newresvtn,$scope.reservation.jslist.selected, ['reservation_ref']);
                        $scope.reservation.jslist.selected = $scope.reservation.jslist.selectedObj.reservation_ref;
                        console.log($scope.reservation.jslist.selectedObj);
                    });

                    $scope.reservation.jslist.toggleIn();
                    $scope.resvtn.jslist.selectedObj = {};
                    $scope.resvtn.jslist.selected = null;
                });
            });
            
        }
    }

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
        reservations: {
            
            listReservation: function () {
                console.log('arr');
                jsonPost.data("../php1/front_desk/list_reservations.php", {}).then(function(result){
                    $scope.rooms.reservations.temp_reservation.reservation_list = [];
                    $scope.rooms.reservations.confirmed_reservation.reservation_list = [];
                    result.forEach(function(elem){
                        (elem.booked == 'NO' &&elem.deposit_confirmed == 'NO' && elem.room_id == $scope.rooms.jslist.selected) ? $scope.rooms.reservations.temp_reservation.reservation_list.push(elem) : null;
                        (elem.booked == 'NO' &&elem.deposit_confirmed == 'YES' && elem.room_id == $scope.rooms.jslist.selected) ? $scope.rooms.reservations.confirmed_reservation.reservation_list.push(elem) : null;
                        
                    });
                    console.log($scope.rooms.reservations.temp_reservation.reservation_list);
                });
            },
            confirmed_reservation : {
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
                reservation_list : [],
                select: function (index, id) {
                    $scope.rooms.reservations.confirmed_reservation.selected = id;
                    $scope.rooms.reservations.confirmed_reservation.selectedObj = $scope.rooms.reservations.confirmed_reservation.newItemArray[index];
                    console.log($scope.rooms.reservations.confirmed_reservation.newItemArray[index]);
                },
                updateResvtn : function (jsonresvtn) {
                    jsonresvtn.reservation_ref = $scope.rooms.reservations.confirmed_reservation.selectedObj.reservation_ref;
                    jsonresvtn.reserved_date = $scope.rooms.reservations.confirmed_reservation.selectedObj.reserved_date;
                    jsonresvtn.new_room_id = '';
                    console.log($scope.rooms.reservations.confirmed_reservation.selectedObj.reserved_date);

                    jsonresvtn.room_id = $scope.rooms.reservations.confirmed_reservation.selectedObj.room_id;
                    
                    $scope.rooms.itemlist().jsonfunc.then(function(result){
                        result.forEach(function(elem){
                            if(elem.room_number == jsonresvtn.new_room_number){
                                jsonresvtn.new_room_id = elem.room_id;
                            }else if(elem.room_number == jsonresvtn.room_number){
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
                            res ? $scope.rooms.jslist.createList() : null;


                            $scope.rooms.itemlist().jsonfunc.then(function(result){
                                $scope.rooms.jslist.selectedObj =  $filter('filterObj')(result,$scope.rooms.jslist.selected, ['room_id']);
                                $scope.rooms.jslist.selected = $scope.rooms.jslist.selectedObj.room_id;
                                console.log($scope.rooms.jslist.selectedObj);
                            });

                            
                            $scope.rooms.jslist.toggleIn();
                            $scope.rooms.reservations.listReservation();
                            $scope.rooms.reservations.confirmed_reservation.selectedObj = {}
                            $scope.rooms.reservations.confirmed_reservation.selected = null;
                        });
                    });
                },
                deleteResvtn: function(){
                    jsonresvtn = {}
                    jsonresvtn.reservation_ref = $scope.rooms.reservations.confirmed_reservation.selectedObj.reservation_ref;
                    jsonresvtn.room_number = $scope.rooms.reservations.confirmed_reservation.selectedObj.room_number;
                    
                    $scope.rooms.itemlist().jsonfunc.then(function(result){
                        result.forEach(function(elem){
                            if(elem.room_number == jsonresvtn.room_number){
                                jsonresvtn.room_id = elem.room_id;
                            }
                        });
                        console.log("new resvtn", jsonresvtn);
                        jsonform = {
                            reservations : [jsonresvtn]
                        }
                        jsonPost.data("../php1/front_desk/del_reservation_room.php", {
                            reservation_ref: $filter('json')(jsonform)
                        }).then(function (response) {
                            $scope.rooms.jslist.toggleOut();
                            console.log(response);
                            $scope.rooms.jslist.createList();

                            $scope.rooms.itemlist().jsonfunc.then(function(result){
                                $scope.rooms.jslist.selectedObj =  $filter('filterObj')(result,$scope.rooms.jslist.selected, ['room_id']);
                                $scope.rooms.jslist.selected = $scope.rooms.jslist.selectedObj.room_id;
                                console.log($scope.rooms.jslist.selectedObj);
                            });

                            $scope.rooms.reservations.listReservation();
                            $scope.rooms.jslist.toggleIn();
                            $scope.rooms.reservations.confirmed_reservation.selectedObj = {}
                            $scope.rooms.reservations.confirmed_reservation.selected = null;
                        });
                    });
                    
                }
            },
            temp_reservation: {
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
                        name: "Leave",
                        width: "col-3",
                    },
                    {
                        name: "Cost",
                        width: "col-3",
                    }
                ],
                reservation_list : [],
                select: function (index, id) {
                    $scope.rooms.reservations.temp_reservation.selected = id;
                    $scope.rooms.reservations.temp_reservation.selectedObj = $scope.rooms.reservations.temp_reservation.newItemArray[index];
                    console.log($scope.rooms.reservations.temp_reservation.newItemArray[index]);
                },
                updateResvtn : function (jsonresvtn) {
                    jsonresvtn.reservation_ref = $scope.rooms.reservations.temp_reservation.selectedObj.reservation_ref;
                    jsonresvtn.reserved_date = $scope.rooms.reservations.temp_reservation.selectedObj.reserved_date;
                    jsonresvtn.new_room_id = '';

                    jsonresvtn.room_id = $scope.rooms.reservations.temp_reservation.selectedObj.room_id;
                    
                    $scope.rooms.itemlist().jsonfunc.then(function(result){
                        result.forEach(function(elem){
                            if(elem.room_number == jsonresvtn.new_room_number){
                                jsonresvtn.new_room_id = elem.room_id;
                            }else if(elem.room_number == jsonresvtn.room_number){
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
                            res ? $scope.rooms.jslist.createList() : null;

                            $scope.rooms.itemlist().jsonfunc.then(function(result){
                                $scope.rooms.jslist.selectedObj =  $filter('filterObj')(result,$scope.rooms.jslist.selected, ['room_id']);
                                $scope.rooms.jslist.selected = $scope.rooms.jslist.selectedObj.room_id;
                                console.log($scope.rooms.jslist.selectedObj);
                            });

                            $scope.rooms.jslist.toggleIn();
                            $scope.rooms.reservations.listReservation();
                            $scope.rooms.reservations.temp_reservation.selectedObj = {}
                            $scope.rooms.reservations.temp_reservation.selected = null;
                        });
                    });
                },
                deleteResvtn: function(){
                    jsonresvtn = {}
                    jsonresvtn.reservation_ref = $scope.rooms.reservations.temp_reservation.selectedObj.reservation_ref;
                    jsonresvtn.room_number = $scope.rooms.reservations.temp_reservation.selectedObj.room_number;
                    
                    $scope.rooms.itemlist().jsonfunc.then(function(result){
                        result.forEach(function(elem){
                            if(elem.room_number == jsonresvtn.room_number){
                                jsonresvtn.room_id = elem.room_id;
                            }
                        });
                        console.log("new resvtn", jsonresvtn);
                        jsonform = {
                            reservations : [jsonresvtn]
                        }
                        jsonPost.data("../php1/front_desk/del_reservation_room.php", {
                            reservation_ref: $filter('json')(jsonform)
                        }).then(function (response) {
                            $scope.rooms.jslist.toggleOut();
                            console.log(response);
                            $scope.rooms.jslist.createList(); 

                            $scope.rooms.itemlist().jsonfunc.then(function(result){
                                $scope.rooms.jslist.selectedObj =  $filter('filterObj')(result,$scope.rooms.jslist.selected, ['room_id']);
                                $scope.rooms.jslist.selected = $scope.rooms.jslist.selectedObj.room_id;
                                console.log($scope.rooms.jslist.selectedObj);
                            });

                            $scope.rooms.reservations.listReservation();
                            $scope.rooms.jslist.toggleIn();
                            $scope.rooms.reservations.temp_reservation.selectedObj = {}
                            $scope.rooms.reservations.temp_reservation.selected = null;
                        });
                    });
                    
                }
            }
            
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
