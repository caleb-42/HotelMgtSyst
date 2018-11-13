dashApp.controller("dashboard", ["$rootScope", "$scope", 'jsonPost', '$filter', '$timeout', function ($rootScope, $scope, jsonPost, $filter, $timeout) {

    $rootScope.$on('guestselect', function(evt,param){
        console.log($scope.guest.getRoomBooking(param.guest_id));
        $scope.booking.itemlist(param.guest_id).jsonfunc.then(function(result){
            $scope.booking.rooms = result ? result : [];
            console.log(result);
        });
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
                        rightbarclass: 'w-30',
                        primeclass: 'w-70'
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
                jsonfunc: jsonPost.data("../php1/front_desk/list_guests.php", {})
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
        
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/front_desk/list_rooms.php", {})
            }
        },
        addGuest: function (jsonrooms) {
            console.log("new Guest", jsonrooms);

            jsonPost.data("../php1/front_desk/add_guest.php", {
                new_guest: $filter('json')(jsonrooms)
            }).then(function (response) {
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.guest.jslist.createList();
            });
        },
        updateGuest: function (jsonrooms) {
            jsonrooms.id = $scope.guest.jslist.selected;
            console.log("new product", jsonrooms);
            jsonPost.data("../php1/restaurant_bar/admin/edit_user.php", {
                update_user: $filter('json')(jsonrooms)
            }).then(function (response) {
                $scope.guest.jslist.toggleOut();
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.guest.jslist.createList();
                $scope.guest.jslist.toggleIn();
            });
        },
        deleteGuest: function () {
            jsonrooms = {};
            jsonrooms.guest = [$scope.guest.jslist.selectedObj];
            console.log("new users", jsonrooms);
            jsonPost.data("../php1/restaurant_bar/admin/del_user.php", {
                del_users: $filter('json')(jsonrooms)
            }).then(function (response) {
                $scope.guest.jslist.toggleOut();
                console.log(response);
                $scope.guest.jslist.createList();
                $scope.guest.jslist.toggleIn();
            });
        }
    };
}]);
