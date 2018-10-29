dashApp.controller("dashboard", ["$rootScope", "$scope", 'jsonPost', '$filter', function ($rootScope, $scope, jsonPost, $filter) {
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
            activate: function(room_type){
                //$scope.guest.rooms[room_type] = 
                $scope.guest.roomgrid.type = room_type;
                $scope.guest.roomgrid.activated = 'true';
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
            addnyts : function(num){
                console.log($scope.guest.roomgrid.rooms.toArray);
                ($scope.guest.roomgrid.rooms.toArray()).forEach(function(cat){
                    (cat.toArray()).forEach(function(room){
                        room.no_of_nights = num;
                    });
                });
            },
            activated:'false'
        },
        catRoom : function(){
            jsonPost.data("../php1/front_desk/list_rooms.php", {}).then(function(result){



            });

            
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
