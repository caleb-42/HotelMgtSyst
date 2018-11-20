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
            /* History: {
                name: 'History',
                options: {
                    rightbar: false
                }
            } */
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
                $rootScope.settings.modal.msgprompt(response);
                $scope.guest.jslist.createList();
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
                $rootScope.settings.modal.msgprompt(response);
                $scope.guest.jslist.createList();
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
                $scope.booking.selected = [];
                $rootScope.settings.modal.msgprompt(response);
                $scope.guest.jslist.createList();
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
                $rootScope.settings.modal.msgprompt(response);
                $scope.guest.jslist.createList();
            });
        },
        updateGuest: function (jsonguest) {
            jsonguest.id = $scope.guest.jslist.selected;
            console.log("new product", jsonguest);
            jsonPost.data("../php1/restaurant_bar/admin/edit_user.php", {
                update_user: $filter('json')(jsonguest)
            }).then(function (response) {
                $scope.guest.jslist.toggleOut();
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.guest.jslist.createList();
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

    $scope.rooms = {
        current_guest : {},
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/front_desk/list_rooms.php", {})
            }
        },
        reservations: {
            
            
            listReservation: function () {
                console.log('arr');
                jsonPost.data("../php1/front_desk/list_reservations.php", {}).then(function(result){
                    $scope.rooms.reservations.temp_reservation.reservation_list = [];
                    result.forEach(function(elem){
                        (elem.deposit_confirmed == 'NO' && elem.room_id == $scope.rooms.jslist.selected) ? $scope.rooms.reservations.temp_reservation.reservation_list.push(elem) : null;
                        (elem.deposit_confirmed == 'YES' && elem.room_id == $scope.rooms.jslist.selected) ? $scope.rooms.reservations.confirmed_reservation.reservation_list.push(elem) : null;
                        
                    });
                    console.log($scope.rooms.reservations.temp_reservation.reservation_list);
                });
            },
            addReservation : function (jsonresvtn) {
                console.log("new Reservation", jsonresvtn);
    
                jsonPost.data("../php1/front_desk/add_reservation.php", {
                    reservation_data: $filter('json')(jsonresvtn)
                }).then(function (response) {
                    console.log(response);
                    $scope.rooms.roomgrid.averagenyt = 0;
                    $scope.rooms.roomgrid.room_info.rooms = 0;
                    $scope.rooms.roomgrid.room_info.cost = 0;
                    $rootScope.settings.modal.msgprompt(response);
                    $scope.rooms.jslist.createList();
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
                confirm : function(jsonform){
                   console.log(jsonform);
                   jsonconfirm = $scope.rooms.reservations.temp_reservation.selectedObj;
                   jsonconfirm.amount_paid = jsonform.amount_paid;
                   jsonconfirm.means_of_payment = jsonform.means_of_payment;
                }
            }
            
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
                    rmtype = Object.keys($scope.rooms.roomgrid.room_details.rooms);
                    $scope.rooms.roomgrid.room_info.rooms = 0;
                    $scope.rooms.roomgrid.room_info.cost = 0;

                    rmtype.forEach(function(elem){

                        $scope.rooms.roomgrid.room_details.rooms[elem].num ? ($scope.rooms.roomgrid.room_info.rooms += parseInt($scope.rooms.roomgrid.room_details.rooms[elem].num)) : null;;
                        $scope.rooms.roomgrid.room_details.rooms[elem].arr.forEach(function(val){
                            if(val.selected == true){
                                val.no_of_nights = val.no_of_nights ? val.no_of_nights : 0;
                                $scope.rooms.roomgrid.room_info.cost += (parseInt(val.no_of_nights) * parseInt(val.room_rate));
                            }
                        })

                    });
                }
            },
            room_details: {
                rooms:{},
                selectrooms : function(roomtype){
                    if($scope.rooms.roomgrid.room_details.rooms[roomtype].num > $scope.rooms.roomgrid.room_details.rooms[roomtype].count){
                        $scope.rooms.roomgrid.room_details.rooms[roomtype].num = $scope.rooms.roomgrid.room_details.rooms[roomtype].count
                    }
                    for(var i = 0; i <= $scope.rooms.roomgrid.room_details.rooms[roomtype].arr.length - 1; i++){
                        console.log(roomtype);
                        $scope.rooms.roomgrid.room_details.rooms[roomtype].arr[i].selected = false;
                    };
                    for(var i = 0; i <= $scope.rooms.roomgrid.room_details.rooms[roomtype].num - 1; i++){
                        console.log(roomtype);
                        $scope.rooms.roomgrid.room_details.rooms[roomtype].arr[i].selected = true;
                    };
                    $scope.rooms.roomgrid.room_info.calc_room_info();
                },
                toggleroom : function(){
                    roomtype = Object.keys($scope.rooms.roomgrid.room_details.rooms);
                    $scope.rooms.roomgrid.room_info.rooms = 0;
                    $scope.rooms.roomgrid.room_info.cost = 0;
                    roomtype.forEach(function(elem){
                        num = 0;
                        $scope.rooms.roomgrid.room_details.rooms[elem].arr.forEach(function(val){
                            if(val.selected == true){
                                num++;
                                $scope.rooms.roomgrid.room_info.cost += (parseInt(val.no_of_nights) * parseInt(val.room_rate));
                            }
                        });
                        $scope.rooms.roomgrid.room_details.rooms[elem].num = num;
                        $scope.rooms.roomgrid.room_info.rooms += num;
                    });
                },
                change_nyt_no : function(id){
                    actv = $scope.rooms.roomgrid.type;
                    for(var i = 0; i < $scope.rooms.roomgrid.room_details.rooms[actv].arr.length; i++){
                        elem =  $scope.rooms.roomgrid.room_details.rooms[actv].arr[i]
                        if(elem.room_id == id){
                            if(!elem.reservations){
                                $scope.rooms.roomgrid.room_details.rooms[actv].arr[i].no_of_nights = $scope.rooms.roomgrid.roomid[id];
                                
                            }
                            else{
                                for(var j = 0; j < elem.reservations.length; j++){
                                    resvtn = elem.reservations[j];
                                    date1 = new Date($filter('intervalGetDate')($scope.rooms.roomgrid.roomid[id],$scope.rooms.roomgrid.roomdate[id]));

                                    date2 = new Date(resvtn.reserved_date);

                                    date3 = new Date($scope.rooms.roomgrid.roomdate[id]);

                                    date4 = new Date($filter('intervalGetDate')(resvtn.no_of_nights, resvtn.reserved_date));
                                    console.log(date3, date1, date2, date4);
                                    if((date3 >= date2 && date3 <= date4) || (date1 >= date2 && date1 <= date4)){
                                        console.log('no');
                                        $scope.rooms.roomgrid.reservedyes = id;
                                        $timeout(function(){
                                            $scope.rooms.roomgrid.reservedyes = '';
                                        }, 2000);
                                        console.log($scope.rooms.roomgrid.reservedyes);
                                        
                                        $scope.rooms.roomgrid.roomid[id] = $scope.rooms.roomgrid.averagenyt;
                                        
                                    }else if(j == (elem.reservations.length - 1)){
                                        console.log('yes');
                                        $scope.rooms.roomgrid.room_details.rooms[actv].arr[i].no_of_nights = $scope.rooms.roomgrid.roomid[id];
                                        $scope.rooms.roomgrid.room_details.rooms[actv].arr[i].room_reservation_date = $scope.rooms.roomgrid.roomdate[id];
                                        
                                    } 
                                }
                            }
                            
                            $scope.rooms.roomgrid.room_info.calc_room_info();
                        }
                    }
                }

            },
            averagenyt : 0,
            nytstartdate : 0,
            nytdate : $filter('intervalGetDate')(0),
            activate: function(room_type){
                //$scope.rooms.rooms[room_type] = 
                $scope.rooms.roomgrid.type = room_type;
                $scope.rooms.roomgrid.activated = 'true';
            },
            deactivate: function(){
                //$scope.rooms.rooms[room_type] = 
                $scope.rooms.roomgrid.type = '';
                $scope.rooms.roomgrid.activated = 'false';
            },
            getrooms : function(roomCat){
                roomCat.forEach(function(cat){
                    jsonPost.data("../php1/front_desk/list_rooms_for_reservations.php", {
                        category : cat
                    }).then(function(result){
                        $scope.rooms.roomgrid.room_details.rooms[cat] = {name: cat, arr: $scope.rooms.roomgrid.resvtn_room(result)};

                        $scope.rooms.roomgrid.room_details.rooms[cat].count= $scope.rooms.roomgrid.room_details.rooms[cat].arr.length
                        console.log($scope.rooms.roomgrid.room_details.rooms[cat]);
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

                    date1 = new Date($scope.rooms.roomgrid.nytdate);

                    date3 = new Date($scope.rooms.roomgrid.nytstartdate);

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
                                arr[i].no_of_nights = $scope.rooms.roomgrid.averagenyt;
                                arr[i].room_reservation_date = $scope.rooms.roomgrid.nytstartdate;
                                console.log('true', resvtn.reserved_date);
                               
                            }
                        };
                    }else{
                        console.log('noresvtn');
                        arr[i].can_be_booked = true;
                        arr[i].no_of_nights = $scope.rooms.roomgrid.averagenyt;
                        arr[i].room_reservation_date = $scope.rooms.roomgrid.nytstartdate;
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
                $scope.rooms.roomgrid.getrooms(['deluxe', 'standard']);
            },
            activated:'false'
        },
        getGuest : function(id){
            $scope.guest.itemlist().jsonfunc.then(function(result){
                result.forEach(function(elem){
                    if(id == elem.guest_id)
                    $scope.rooms.current_guest = elem;
                })
            })
        },
        

    };
}]);
