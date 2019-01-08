frontdeskApp.directive('jslist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/frontdesk/listTemplates.php?list=guest',

        scope: false,

        link: function (scope, element, attrs) {
            scope.guest.jslist = {
                createList: function () {
                    listdetails = scope.guest.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    jsonlist.then(function (result) {
                        console.log(result);
                        scope.guest.jslist.values = result;
                        /* scope.guest.jslist.values.forEach(function(elem){
                            elem.value = elem.guest_name;
                        }); */
                        //scope.guest.jslist.selected = null;
                    });
                    scope.guest.listhddata = [
                        {
                            name: "Name",
                            width: "col-3",
                        },
                        {
                            name: "Gender",
                            width: "col-2",
                        },
                        {
                            name: "Rooms",
                            width: "col-2",
                        },
                        {
                            name: "Visit Count",
                            width: "col-2",
                        },
                        {
                            name: "Out bal.",
                            width: "col-3",
                        }
                    ];
                },
                select: function (index, id) {
                    console.log(id);
                    scope.guest.jslist.selected = id;
                    scope.guest.jslist.selectedObj = scope.guest.jslist.newItemArray[index];
                    console.log(scope.guest.jslist.newItemArray[index]);
                    $rootScope.$emit('guestselect', scope.guest.jslist.selectedObj)
                },
                toggleOut : function(){
                    $(".listcont").fadeOut(200);
                },
                toggleIn : function(){
                    $(".listcont").delay(500).fadeIn(200);
                },
                gender : 'male'
            }
            scope.guest.jslist.createList();
        }
    };
}]);

frontdeskApp.directive('reservationlist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/frontdesk/listTemplates.php?list=reservation',

        scope: false,

        link: function (scope, element, attrs) {
            scope.reservation.jslist = {
                createList: function () {
                    listdetails = scope.reservation.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    jsonlist.then(function (result) {
                        scope.reservation.jslist.values = [];
                        resvtn = result;
                        newresvtn = [];
                        if(!resvtn){
                            return;
                        }
                        resvtn.forEach(function(rtn){
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
                        scope.reservation.jslist.values = newresvtn;
                        console.log(newresvtn);
                        //scope.reservation.jslist.selected = null;
                    });
                    scope.reservation.listhddata = [
                        {
                            name: "Resvtn ID",
                            width: "col-2",
                        },
                        {
                            name: "GuestID",
                            width: "col-2",
                        },
                        {
                            name: "Inquiry Date",
                            width: "col-3",
                        },
                        {
                            name: "Start Date",
                            width: "col-3",
                        },
                        {
                            name: "State",
                            width: "col-2",
                        }
                    ];
                },
                select: function (index, id) {
                    console.log(id);
                    scope.reservation.jslist.selected = id;
                    scope.reservation.jslist.selectedObj = scope.reservation.jslist.newItemArray[index];
                    console.log(scope.reservation.jslist.newItemArray[index]);
                    $rootScope.$emit('reservationselect', scope.reservation.jslist.selectedObj);
                    scope.resvtn.jslist.createList();
                    scope.resvtn.jslist.selectedObj = {};
                    scope.resvtn.jslist.selected = null;
                },
                toggleOut : function(){
                    $(".listcont").fadeOut(200);
                },
                toggleIn : function(){
                    $(".listcont").delay(500).fadeIn(200);
                },
                gender : 'male'
            }
            scope.reservation.jslist.createList();
        }
    };
}]);

frontdeskApp.directive('resvtnlist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/frontdesk/listTemplates.php?list=resvtn',

        scope: false,

        link: function (scope, element, attrs) {
            scope.resvtn.jslist = {
                createList: function () {
                    if(!scope.reservation.jslist.selected){
                        return;
                    }
                    listdetails = scope.reservation.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    resultfiltered = [];

                    jsonlist.then(function (result) {
                        scope.resvtn.jslist.values = [];
                        if (!result) {
                            return 0;
                        }
                        console.log(result);
                        result.forEach(function (element) {
                            if (element.reservation_ref == scope.reservation.jslist.selectedObj.reservation_ref && element.guest_name == scope.reservation.jslist.selectedObj.guest_name) {
                                resultfiltered.push(element);
                                console.log(element);
                            }else{
                                return;
                            }
                        });
                        scope.resvtn.jslist.values = resultfiltered;
                        //scope.reservation.jslist.selected = null;
                    });
                    scope.resvtn.listhddata = [
                        {
                            name: "Room No.",
                            width: "col-2",
                        },
                        {
                            name: "Room Rate",
                            width: "col-2",
                        },
                        {
                            name: "Total",
                            width: "col-3",
                        },
                        {
                            name: "Nights",
                            width: "col-2",
                        },
                        {
                            name: "Leave",
                            width: "col-3",
                        }
                    ];
                },
                select: function (index, id) {
                    console.log(id);
                    scope.resvtn.jslist.selected = id;
                    scope.resvtn.jslist.selectedObj = scope.resvtn.jslist.newItemArray[index];
                    console.log(scope.resvtn.jslist.newItemArray[index]);
                    
                },
                toggleOut : function(){
                    $(".listcont").fadeOut(200);
                },
                toggleIn : function(){
                    $(".listcont").delay(500).fadeIn(200);
                }
            }
            scope.resvtn.jslist.createList();
        }
    };
}]);

frontdeskApp.directive('frontdeskuserlist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/frontdesk/listTemplates.php?list=users',

        scope: false,

        link: function (scope, element, attrs) {
            scope.users.jslist = {
                createList: function () {
                    listdetails = scope.users.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    jsonlist.then(function (result) {
                        console.log(result);
                        scope.users.jslist.values = result;
                        scope.users.jslist.selected = null;
                    });
                    scope.users.listhddata = [
                        {
                            name: "Name",
                            width: "col-6",
                        },
                        {
                            name: "Role",
                            width: "col-6",
                        }
                    ];
                },
                select: function (index, id) {
                    scope.users.jslist.selected = id;
                    scope.users.jslist.selectedObj = scope.users.jslist.newItemArray[index];
                    console.log(scope.users.jslist.newItemArray[index]);
                    scope.sessions.jslist.createList();
                },
                toggleOut : function(){
                    $(".listcont").fadeOut(200);
                },
                toggleIn : function(){
                    $(".listcont").delay(500).fadeIn(200);
                }
            }
            scope.users.jslist.createList();
        }
    };
}]);


frontdeskApp.directive('frontdesksessionlist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/frontdesk/listTemplates.php?list=sessions',

        scope: false,

        link: function (scope, element, attrs) {
            scope.sessions.jslist = {
                createList: function () {
                    if(!scope.users.jslist.selected){
                        return;
                    }
                    listdetails = scope.sessions.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    resultfiltered = [];

                    jsonlist.then(function (result) {
                        if (!result) {
                            return 0;
                        }
                        console.log(result);
                        result.forEach(function (element) {
                            if (element.user_name == scope.users.jslist.selectedObj.user_name && element.role == scope.users.jslist.selectedObj.role) {
                                resultfiltered.push(element);
                                console.log(element);
                            }else{
                                return;
                            }
                        });
                        scope.sessions.jslist.values = resultfiltered;
                        //scope.users.jslist.selected = null;
                    });
                    scope.sessions.listhddata = [
                        {
                            name: "Logged On",
                            width: "col-6",
                        },
                        {
                            name: "Logged Off",
                            width: "col-6",
                        }
                    ];
                }
            }
            scope.sessions.jslist.createList();
        }
    };
}]);

frontdeskApp.directive('roomlist', ['$rootScope', '$filter', function ($rootScope, $filter) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/frontdesk/listTemplates.php?list=rooms',

        scope: false,

        link: function (scope, element, attrs) {
            var jslistObj;
            scope.rooms.jslist = {
                createList: function () {
                    scope.rooms.jslist.values = [];
                    listdetails = scope.rooms.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    jsonlist.then(function (result) {
                        console.log(result);
                        /* result.forEach(function(elem){
                            elem.category = elem.room_category;
                        }); */
                        scope.rooms.jslist.values = result;
                        //scope.rooms.jslist.selected = null;
                    });
                    scope.rooms.listhddata = [
                        {
                            name: "Number",
                            width: "col-1",
                        },
                        {
                            name: "ID",
                            width: "col-2",
                        },
                        {
                            name: "Rate",
                            width: "col-1",
                        },
                        {
                            name: "Category",
                            width: "col-2",
                        },
                        {
                            name: "Guest",
                            width: "col-1",
                        },
                        {
                            name: "Guest No",
                            width: "col-2",
                        },
                        {
                            name: "Booked",
                            width: "col-1",
                        },
                        {
                            name: "Reserved",
                            width: "col-2",
                        },
                    ];
                },
                select: function (index, id) {
                    scope.rooms.jslist.selected = id;
                    scope.rooms.jslist.selectedObj = scope.rooms.jslist.newItemArray[index];
                    console.log(scope.rooms.jslist.selectedObj);
                },
                toggleOut: function () {
                    $(".listcont").fadeOut(200);
                },
                toggleIn: function () {
                    $(".listcont").delay(500).fadeIn(200);
                },
                shelfitem : 'yes'
            }
            scope.rooms.jslist.createList();
        }
    };
}]);

frontdeskApp.directive('bookinghistory', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/frontdesk/listTemplates.php?list=booking',

        scope: false,

        link: function (scope, element, attrs) {
            scope.listbookings.jslist = {
                createList: function () {
                    listdetails = scope.listbookings.itemlist();
                    jsonlist = listdetails.jsonfunc;

                    jsonlist.then(function (result) {
                        if (!result) {
                            return 0;
                        }
                        console.log(result);
                        scope.listbookings.jslist.values = result;
                    });
                    scope.listbookings.listhddata = [
                        {
                            name: "Booking Ref",
                            width: "col-1",
                        },
                        {
                            name: "Room Number",
                            width: "col-1",
                        },
                        {
                            name: "Room Category",
                            width: "col-1",
                        },
                        {
                            name: "Room Rate",
                            width: "col-1",
                        },
                        {
                            name: "Guest Name",
                            width: "col-1",
                        },
                        {
                            name: "Nights",
                            width: "col-1",
                        },
                        {
                            name: "Guest",
                            width: "col-1",
                        },
                        {
                            name: "Checked In Time",
                            width: "col-2",
                        },
                        {
                            name: "Checked Out Time",
                            width: "col-2",
                        },
                        {
                            name: "Checked Out",
                            width: "col-1",
                        }
                    ];
                },
                select: function (index, id) {
                    scope.listbookings.jslist.selected = id;
                    scope.listbookings.jslist.selectedObj = scope.listbookings.jslist.newItemArray[index];
                    console.log(scope.listbookings.jslist.selectedObj);/* 
                    $rootScope.$emit('tranxselect', {sales_ref : id, obj: scope.listbookings.jslist.selectedObj}); */
                }
            }
            scope.listbookings.jslist.createList();
        }
    };
}]);




