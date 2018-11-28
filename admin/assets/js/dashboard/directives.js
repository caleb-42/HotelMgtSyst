app.directive('jslist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/dashboard/listTemplates.php?list=guest',

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

app.directive('reservationlist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/dashboard/listTemplates.php?list=reservation',

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


app.directive('resvtnlist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/dashboard/listTemplates.php?list=resvtn',

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

dashApp.directive('roomgrid', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/dashboard/listTemplates.php?list=roomgrid',

        scope: false,

        link: function (scope, element, attrs) {
            scope.rooms.jslist = {
                createList: function () {
                    listdetails = scope.rooms.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    jsonlist.then(function (result) {
                        console.log(result);
                        scope.rooms.jslist.values = result;
                        /* scope.rooms.jslist.selected = null; */
                    });
                    scope.rooms.listhddata = [
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
                    scope.rooms.jslist.selected = id;
                    scope.rooms.jslist.selectedObj = scope.rooms.jslist.newItemArray[index];
                    console.log(scope.rooms.jslist.newItemArray[index]);$rootScope.$emit('roomselect', scope.rooms.jslist.selectedObj);
                    scope.rooms.reservations.confirmed_reservation.selectedObj = {}
                    scope.rooms.reservations.confirmed_reservation.selected = null;
                    scope.rooms.reservations.temp_reservation.selectedObj = {}
                    scope.rooms.reservations.temp_reservation.selected = null;
                },
                toggleOut : function(){
                    $(".listcont").fadeOut(200);
                },
                toggleIn : function(){
                    $(".listcont").delay(500).fadeIn(200);
                }
            }
            scope.rooms.jslist.createList();
        }
    };
}]);
 
dashApp.directive('accordion', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/dashboard/listTemplates.php?list=accordion',
        scope: false,
        link: function (scope, element, attrs) {
            scope.type = attrs.type;
        }
    };
}]);



