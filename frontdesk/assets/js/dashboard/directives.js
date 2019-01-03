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
                            width: "col-2",
                        },
                        {
                            name: "Gender",
                            width: "col-2",
                        },
                        {
                            name: "Phone No.",
                            width: "col-2",
                        },
                        {
                            name: "Rooms",
                            width: "col-1",
                        },
                        {
                            name: "Visit Count",
                            width: "col-2",
                        },
                        {
                            name: "CheckedIn",
                            width: "col-1",
                        },
                        {
                            name: "Out bal.",
                            width: "col-2",
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
                    listdetails = scope.reservation.itemlist('filter', function(res){
                        scope.reservation.jslist.values = [];
                        scope.reservation.jslist.values = res;
                    });
                    scope.reservation.listhddata = [
                        {
                            name: "Resvtn ID",
                            width: "col-2",
                        },
                        {
                            name: "Guest",
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
                    scope.reservation.resvtn.jslist.createList();
                    scope.reservation.resvtn.jslist.selectedObj = {};
                    scope.reservation.resvtn.jslist.selected = null;
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
            scope.reservation.resvtn.jslist = {
                createList: function () {
                    if(!scope.reservation.jslist.selected){
                        return;
                    }
                    listdetails = scope.reservation.itemlist('all', function(result){
                        resultfiltered = [];
                        scope.reservation.resvtn.jslist.values = [];
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
                        scope.reservation.resvtn.jslist.values = resultfiltered;
                        //scope.reservation.jslist.selected = null;
                    });

                    scope.reservation.resvtn.listhddata = [
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
                    scope.reservation.resvtn.jslist.selected = id;
                    scope.reservation.resvtn.jslist.selectedObj = scope.reservation.resvtn.jslist.newItemArray[index];
                    console.log(scope.reservation.resvtn.jslist.newItemArray[index]);
                    
                },
                toggleOut : function(){
                    $(".listcont").fadeOut(200);
                },
                toggleIn : function(){
                    $(".listcont").delay(500).fadeIn(200);
                }
            }
            scope.reservation.resvtn.jslist.createList();
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
                    listdetails = scope.rooms.itemlist(function(result){
                        console.log(result);
                        scope.rooms.jslist.values = result;
                        scope.rooms.current_guest = {};
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
                    scope.rooms.resvtn.selectedObj = {}
                    scope.rooms.resvtn.selected = null;
                    scope.rooms.resvtn.selectedObj = {}
                    scope.rooms.resvtn.selected = null;
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



