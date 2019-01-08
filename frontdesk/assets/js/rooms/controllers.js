roomsApp.controller("rooms", ["$rootScope", "$scope", 'jsonPost', '$filter', function ($rootScope, $scope, jsonPost, $filter) {
    $scope.tabnav = {
        navs: {
            /* Overview: {
                name: 'Overview',
                options: {
                    rightbar: false
                }
            }, */
            Rooms: {
                name: 'Rooms',
                options: {
                    rightbar: false/* {
                        present: true,
                        rightbarclass: 'w-30',
                        primeclass: 'w-70'
                    } */
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
            name: 'Rooms',
            options: {
                rightbar: false/* {
                    present: true,
                    rightbarclass: 'w-30',
                    primeclass: 'w-70'
                } */
            }
        },
        selectNav: function (navname) {
            $scope.tabnav.selected = $scope.tabnav.navs[navname];
        }
    };
    $scope.rooms = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/front_desk/admin/list_room.php", {})
            }
        },
        addRoom: function (jsonrm) {
            console.log("new room", jsonrm);
            jsonrm.category = jsonrm.room_category;
            jsonPost.data("../php1/front_desk/admin/add_room.php", {
                new_room: $filter('json')(jsonrm)
            }).then(function (response) {
                $scope.rooms.jslist.toggleOut();
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.rooms.jslist.createList();
                $scope.rooms.jslist.toggleIn();
            });
        },
        updateRoom: function (jsonrm) {
            jsonrm.room_id = $scope.rooms.jslist.selected;
            console.log("new room", jsonrm);
            jsonPost.data("../php1/front_desk/admin/edit_room.php", {
                update_room: $filter('json')(jsonrm)
            }).then(function (response) {
                $scope.rooms.jslist.toggleOut();
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.rooms.jslist.createList();
                $scope.rooms.jslist.toggleIn();
            });
        },
        deleteRoom: function () {
            jsonrm = {};
            jsonrm.rooms = [$scope.rooms.jslist.selectedObj];
            console.log("new product", jsonrm);
            jsonPost.data("../php1/front_desk/admin/del_room.php", {
                del_rooms: $filter('json')(jsonrm)
            }).then(function (response) {
                $scope.rooms.jslist.toggleOut();
                console.log(response);
                $scope.rooms.jslist.createList();
                $scope.rooms.jslist.toggleIn();
            });
        }
    };

}]);
