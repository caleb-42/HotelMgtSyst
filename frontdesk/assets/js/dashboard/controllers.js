dashApp.controller("dashboard", ["$rootScope", "$scope", 'jsonPost', '$filter', '$timeout', function ($rootScope, $scope, jsonPost, $filter, $timeout) {
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
                    rightbar: {
                        present: true,
                        rightbarclass: 'w-30',
                        primeclass: 'w-70'
                    }
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
                rightbar: {
                    present: true,
                    rightbarclass: 'w-30',
                    primeclass: 'w-70'
                }
            }
        },
        selectNav: function (navname) {
            $scope.tabnav.selected = $scope.tabnav.navs[navname];
        }
    };
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
            activate: function(room_type){
                //$scope.guest.rooms[room_type] = 
                $scope.guest.roomgrid.type = room_type;
                $scope.guest.roomgrid.activated = 'true';
            },
            nyt_no : function(nyts, room_resvtn, id){
                //$scope.guest.roomgrid.selected = 
                if(!room_resvtn){
                    return nyts;
                }
                for(var j = 0; j < room_resvtn.length; j++){
                    resvtn = room_resvtn[j];
                    date1 = new Date($filter('intervalGetDate')(nyts));
                    date2 = new Date(resvtn.reserved_date);
                    console.log(date1, date2, nyts);
                    if(date1 > date2){
                        console.log('no');
                        $scope.guest.roomgrid.reservedyes = id;
                        $timeout(function(){
                            $scope.guest.roomgrid.reservedyes = '';
                        }, 2000);
                        console.log($scope.guest.roomgrid.reservedyes);
                        return $scope.guest.roomgrid.nyt;
                    }else if(j == (room_resvtn.length - 1)){
                        console.log('yes');
                        return nyts;
                    }
                };
            },
            toggleroom : function(){
                count = 0;
                $scope.guest.roomgrid.room_details[$scope.guest.roomgrid.type].roomarray.forEach(function(elem){
                    if(elem.selected == true){
                        count++;
                    }
                });
                $scope.guest.roomgrid.roomtotal[$scope.guest.roomgrid.type] = count;
            },
            deactivate: function(){
                $scope.guest.roomgrid.type = '';
                $scope.guest.roomgrid.activated = 'false';
            },
            getrooms : function(roomCat){
                roomCat.forEach(function(cat){
                    jsonPost.data("../php1/front_desk/frontdesk_rooms_by_category.php", {
                        category : cat
                    }).then(function(result){
                        $scope.guest.roomgrid.rooms[cat] = result;
                        console.log($scope.guest.roomgrid.rooms);
                    });
                });
                
            },
            roomtotal : {},
            selectrooms : function(room, num){
                for(var i = 0; i <= $scope.guest.roomgrid.room_details[room].roomarray.length - 1; i++){
                    console.log(room);
                    $scope.guest.roomgrid.room_details[room].roomarray[i].selected = false;
                };
                for(var i = 0; i <= num - 1; i++){
                    console.log(room);
                    $scope.guest.roomgrid.room_details[room].roomarray[i].selected = true;
                };
                console.log($scope.guest.roomgrid.room_details[room]);
            },
            room_details : {},
            get_no_room : function (){
                arry = Object.keys($scope.guest.roomgrid.rooms);
                arry.forEach(function(room){
                    num = $filter('filter')($scope.guest.roomgrid.rooms[room], {can_be_booked : true}, true);
                    $scope.guest.roomgrid.room_details[room] = {roomarray : num, roomcount : num.length};
                });
                
            },
            addnyts : function(num){
                arr = Object.keys($scope.guest.roomgrid.roomid);
                arr.forEach(function(elem){
                    $scope.guest.roomgrid.roomid[elem] = num;
                });
                arry = Object.values($scope.guest.roomgrid.rooms);
                arry.forEach(function(roomtype){
                    for(var i = 0; i < roomtype.length; i++){
                        room = roomtype[i];
                        if(room.reservations){
                            for(var j = 0; j < room.reservations.length; j++){
                                resvtn = room.reservations[j];
                                date1 = new Date($scope.guest.roomgrid.nytdate);
                                date2 = new Date(resvtn.reserved_date);

                                if(date1 > date2){
                                    type = $scope.guest.roomgrid.rooms[room.category][i].can_be_booked = false;
                                    console.log('false', resvtn.reserved_date);
                                    break;
                                }else if(date2 > date1){
                                    $scope.guest.roomgrid.rooms[room.category][i].can_be_booked = true;
                                    console.log('true', resvtn.reserved_date);
                                }
                            };
                        }else{
                            $scope.guest.roomgrid.rooms[room.category][i].can_be_booked = true;
                        }
                    }
                    
                });
                keyarr = Object.keys($scope.guest.roomgrid.roomtotal);
                keyarr.forEach(function(elem){
                    for(var i = 0; i <= $scope.guest.roomgrid.room_details[elem].roomarray.length - 1; i++){
                        console.log(elem);
                        $scope.guest.roomgrid.room_details[elem].roomarray[i].selected = false;
                    };
                    $scope.guest.roomgrid.roomtotal[elem] = 0;
                });
                console.log($scope.guest.roomgrid.rooms);
            },
            activated:'false'
        },
        addGuest: function (jsonguest) {
            console.log("new Guest", jsonguest);

            jsonPost.data("../php1/front_desk/add_guest.php", {
                new_guest: $filter('json')(jsonguest)
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
