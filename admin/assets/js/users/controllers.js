settingsApp.controller("settings", ["$rootScope", "$scope",  'jsonPost','$filter', function ($rootScope, $scope, jsonPost, $filter) {
    $scope.tabnav = {
        navs: {
            General: {
                name: 'General',
                options: {
                    rightbar: false
                }
            },
            Users: {
                name: 'Users',
                options: {
                    rightbar: {
                        present: true,
                        rightbarclass: 'w-30',
                        primeclass: 'w-70'
                    }
                }
            }
        },
        selected: {
            name: 'General',
            options: {
                rightbar: false
            }
        },
        selectNav: function (navname) {
            $scope.tabnav.selected = $scope.tabnav.navs[navname];
        }
    };
    $scope.general = {
        itemlist: function () {
            jsonPost.data("../php1/admin/settings_list.php", {}).then(function(resp){
                resp.forEach(function(result){
                    switch(result.shop_settings){
                        case "restaurant_top_msg":
                            $scope.general.restaurant_top_msg = result.property_value;
                        break;
                        case "restaurant_bottom_msg":
                            $scope.general.restaurant_bottom_msg = result.property_value;
                        break;
                        case "frontdesk_top_msg":
                            $scope.general.frontdesk_top_msg = result.property_value;
                        break;
                        case "frontdesk_bottom_msg":
                            $scope.general.frontdesk_bottom_msg = result.property_value;
                        break;
                        case "shop_name":
                            $scope.general.shop_name = result.property_value;
                        break;
                        case "shop_address":
                            $scope.general.shop_address = result.property_value;
                        break;
                        case "shop_contact":
                            $scope.general.shop_address = result.property_value;
                        break;
                        case "shop_email":
                            $scope.general.shop_email = result.property_value;
                        break;
                    }
                });
                console.log(resp);
            });
        },
        msg_Update : function(msg){
            json = {};
            json[msg] = $scope.general[msg];
            jsonPost.data("../php1/admin/settings.php", {
                settings_data : $filter('json')(json)
            }).then(function(result){
                console.log(result);
                $scope.general.itemlist();
            });
        }
    }
    $scope.users = {
        jslist:{},
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/admin/list_users.php", {})
            }
        },
        addUser: function (jsonprod) {
            console.log("new user", jsonprod);

            jsonPost.data("../php1/admin/add_user.php", {
                new_user: $filter('json')(jsonprod)
            }).then(function (response) {
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.users.jslist.createList();
            });
        },
        updateUser: function (jsonuser) {
            jsonuser.id = $scope.users.jslist.selected;
            console.log("new product", jsonuser);
            jsonPost.data("../php1/admin/edit_user.php", {
                update_user: $filter('json')(jsonuser)
            }).then(function (response) {
                $scope.users.jslist.toggleOut();
                console.log(response);
                $rootScope.settings.modal.msgprompt(response);
                $scope.users.jslist.createList();
                $scope.users.jslist.toggleIn();
            });
        },
        deleteUser: function () {
            jsonuser = {};
            jsonuser.users = [$scope.users.jslist.selectedObj];
            console.log("new users", jsonuser);
            jsonPost.data("../php1/admin/del_users.php", {
                del_users: $filter('json')(jsonuser)
            }).then(function (response) {
                $scope.users.jslist.toggleOut();
                console.log(response);
                $scope.users.jslist.createList();
                $scope.users.jslist.toggleIn();
            });
        }
    };

    $scope.sessions = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/admin/list_sessions.php", {})
            }
        }
    }

}]);
