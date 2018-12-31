
        roomgrid = {
            type: '',
            rooms: {},
            roomid: {},
            room_info: {
                rooms: 0,
                cost: 0,
                calc_room_info: function () {
                    rmtype = Object.keys($scope.guest.roomgrid.room_details.rooms);
                    $scope.guest.roomgrid.room_info.rooms = 0;
                    $scope.guest.roomgrid.room_info.cost = 0;

                    rmtype.forEach(function (elem) {

                        $scope.guest.roomgrid.room_details.rooms[elem].num ? ($scope.guest.roomgrid.room_info.rooms += parseInt($scope.guest.roomgrid.room_details.rooms[elem].num)) : null;;
                        $scope.guest.roomgrid.room_details.rooms[elem].arr.forEach(function (val) {
                            if (val.selected == true) {
                                val.no_of_nights = val.no_of_nights ? val.no_of_nights : 0;
                                $scope.guest.roomgrid.room_info.cost += (parseInt(val.no_of_nights) * parseInt(val.room_rate));
                            }
                        })

                    });
                }
            },
            room_details: {
                rooms: {},
                selectrooms: function (roomtype) {
                    if ($scope.guest.roomgrid.room_details.rooms[roomtype].num > $scope.guest.roomgrid.room_details.rooms[roomtype].count) {
                        $scope.guest.roomgrid.room_details.rooms[roomtype].num = $scope.guest.roomgrid.room_details.rooms[roomtype].count
                    }
                    for (var i = 0; i <= $scope.guest.roomgrid.room_details.rooms[roomtype].arr.length - 1; i++) {
                        console.log(roomtype);
                        $scope.guest.roomgrid.room_details.rooms[roomtype].arr[i].selected = false;
                    };
                    for (var i = 0; i <= $scope.guest.roomgrid.room_details.rooms[roomtype].num - 1; i++) {
                        console.log(roomtype);
                        $scope.guest.roomgrid.room_details.rooms[roomtype].arr[i].selected = true;
                    };
                    $scope.guest.roomgrid.room_info.calc_room_info();
                },
                toggleroom: function () {
                    roomtype = Object.keys($scope.guest.roomgrid.room_details.rooms);
                    $scope.guest.roomgrid.room_info.rooms = 0;
                    $scope.guest.roomgrid.room_info.cost = 0;
                    roomtype.forEach(function (elem) {
                        num = 0;
                        $scope.guest.roomgrid.room_details.rooms[elem].arr.forEach(function (val) {
                            if (val.selected == true) {
                                num++;
                                $scope.guest.roomgrid.room_info.cost += (parseInt(val.no_of_nights) * parseInt(val.room_rate));
                            }
                        });
                        $scope.guest.roomgrid.room_details.rooms[elem].num = num;
                        $scope.guest.roomgrid.room_info.rooms += num;
                    });
                },
                change_nyt_no: function (id) {
                    actv = $scope.guest.roomgrid.type;
                    for (var i = 0; i < $scope.guest.roomgrid.room_details.rooms[actv].arr.length; i++) {
                        elem = $scope.guest.roomgrid.room_details.rooms[actv].arr[i]
                        if (elem.room_id == id) {
                            if (!elem.reservations) {
                                $scope.guest.roomgrid.room_details.rooms[actv].arr[i].no_of_nights = $scope.guest.roomgrid.roomid[id];

                            }
                            else {
                                for (var j = 0; j < elem.reservations.length; j++) {
                                    resvtn = elem.reservations[j];
                                    date1 = new Date($filter('intervalGetDate')($scope.guest.roomgrid.roomid[id]));
                                    date2 = new Date(resvtn.reserved_date);
                                    date3 = new Date();
                                    console.log(date1, date2);
                                    if (date1 > date2 && date3 < date2) {
                                        console.log('no');
                                        $scope.guest.roomgrid.reservedyes = id;
                                        $timeout(function () {
                                            $scope.guest.roomgrid.reservedyes = '';
                                        }, 2000);
                                        console.log($scope.guest.roomgrid.reservedyes);

                                        $scope.guest.roomgrid.roomid[id] = $scope.guest.roomgrid.averagenyt;

                                    } else if (j == (elem.reservations.length - 1)) {
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
            averagenyt: 0,
            nytdate: $filter('intervalGetDate')(0),
            activate: function (room_type) {
                //$scope.guest.rooms[room_type] = 
                $scope.guest.roomgrid.type = room_type;
                $scope.guest.roomgrid.activated = 'true';
            },
            deactivate: function () {
                //$scope.guest.rooms[room_type] = 
                $scope.guest.roomgrid.type = '';
                $scope.guest.roomgrid.activated = 'false';
            },
            getrooms: function (roomCat) {
                roomCat.forEach(function (cat) {
                    jsonPost.data("../php1/front_desk/frontdesk_rooms_by_category.php", {
                        category: cat
                    }).then(function (result) {
                        $scope.guest.roomgrid.room_details.rooms[cat] = { name: cat, arr: $scope.guest.roomgrid.resvtn_room(result) };

                        $scope.guest.roomgrid.room_details.rooms[cat].count = $scope.guest.roomgrid.room_details.rooms[cat].arr.length
                        console.log($scope.guest.roomgrid.room_details.rooms[cat]);
                    });
                });
            },
            resvtn_room: function (arr) {
                if (!Array.isArray(arr)) {
                    return [];
                }
                myarr = [];
                for (var i = 0; i < arr.length; i++) {
                    elem = arr[i];
                    console.log(elem.reservations);
                    if (elem.reservations) {
                        for (var j = 0; j < elem.reservations.length; j++) {
                            resvtn = elem.reservations[j];
                            date1 = new Date($scope.guest.roomgrid.nytdate);
                            date2 = new Date(resvtn.reserved_date);
                            date3 = new Date();

                            if (date1 > date2 && date3 < date2) {
                                elem.can_be_booked = false;
                                console.log('false', resvtn.reserved_date);
                                break;
                            } else if (date2 > date1 || date2 < date3) {
                                arr[i].can_be_booked = true;
                                arr[i].no_of_nights = $scope.guest.roomgrid.averagenyt;
                                console.log('true', resvtn.reserved_date);

                            }
                        };
                    } else {
                        console.log('noresvtn');
                        arr[i].can_be_booked = true;
                        arr[i].no_of_nights = $scope.guest.roomgrid.averagenyt;

                    }

                }
                for (var k = 0; k < arr.length; k++) {
                    if (arr[k].can_be_booked == true) {
                        myarr.push(arr[k]);
                    }
                }
                return myarr;
            },
            change_averagenyt: function () {
                $scope.guest.roomgrid.getrooms(['deluxe', 'standard']);
                $scope.guest.roomgrid.room_info.cost = 0;
                $scope.guest.roomgrid.room_info.rooms = 0;
            },
            activated: 'false'
        }
