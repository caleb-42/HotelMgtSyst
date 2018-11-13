recordsApp.controller("records", ["$rootScope", "$scope", 'jsonPost', '$filter',  function ($rootScope, $scope, jsonPost, $filter) {
    $scope.tabnav = {
        navs: {
            Bookings: {
                name: 'Bookings',
                options: {
                    rightbar : false
                }
            }
        },
        selected: {
            name: 'Bookings',
            options: {
                rightbar : false
            }
        },
        selectNav: function (navname) {
            $scope.tabnav.selected = $scope.tabnav.navs[navname];
        }
    };
    $scope.rightSidebar = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/restaurant_bar/admin/list_sessions.php", {})
            }
        },
        subclass: {

        }
    };

    
}]);

recordsApp.controller("bookinghistory", ["$rootScope", "$scope", 'jsonPost', '$filter', function ($rootScope, $scope, jsonPost, $filter) {
    $scope.listbookings = {
        itemlist: function () {
            return {
                jsonfunc: jsonPost.data("../php1/front_desk/list_bookings.php", {})
            }
        }
    }

}]);



