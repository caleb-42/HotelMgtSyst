lodgeApp.controller("lodge", ["$rootScope", "$scope", 'jsonPost', '$filter', function ($rootScope, $scope, jsonPost, $filter) {
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
            Category: {
                name: 'Category',
                options: {
                    rightbar: false/* {
                        present: true,
                        rightbarclass: 'w-30',
                        primeclass: 'w-70'
                    } */
                }
            },
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
        inputs : {},
        categories:{
            getCategories:function(){
                jsonPost.data("../php1/front_desk/admin/list_room_categories.php", {}).then(function(result){
                    $scope.rooms.categories.roomCategories = result;
                })
            },
            roomCategories:[],
            changeCategory : function(categories, category){
                for(var i = 0; i < categories.length; i++){
                    var elem = categories[i];
                    if (elem.category.toLowerCase() === category.toLowerCase()){
                        return Number(elem.rate);
                    }
                }
                return '';
            }
        },
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
    $scope.category = {
        inputs : {},
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/front_desk/admin/list_room_categories.php", {})
            }
        },
        addCategory: function (jsonrm) {
            console.log("new room", jsonrm);
            jsonrm.sales_rep = $rootScope.settings.user;
            jsonPost.data("../php1/front_desk/admin/add_room_category.php", {
                new_room_category: $filter('json')(jsonrm)
            }).then(function (response) {
                $scope.category.jslist.toggleOut();
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.category.jslist.createList();
                $scope.category.jslist.toggleIn();
            });
        },
        updateCategory: function (jsonrm) {
            jsonrm.id = $scope.category.jslist.selected;
            console.log("new room", jsonrm);
            jsonPost.data("../php1/front_desk/admin/edit_room_category.php", {
                update_room_category: $filter('json')(jsonrm)
            }).then(function (response) {
                $scope.category.jslist.toggleOut();
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.category.jslist.createList();
                $scope.category.jslist.toggleIn();
            });
        },
        deleteCategory: function () {
            jsonrm = {};
            jsonrm.category = [$scope.category.jslist.selectedObj];
            console.log("new product", jsonrm);
            jsonPost.data("../php1/front_desk/admin/del_room.php", {
                del_category: $filter('json')(jsonrm)
            }).then(function (response) {
                $scope.category.jslist.toggleOut();
                console.log(response);
                $scope.category.jslist.createList();
                $scope.category.jslist.toggleIn();
            });
        }
    };

}]);
