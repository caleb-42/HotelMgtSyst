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
                        scope.guest.jslist.selected = null;
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
                },
                toggleOut : function(){
                    $(".listcont").fadeOut(200);
                },
                toggleIn : function(){
                    $(".listcont").delay(500).fadeIn(200);
                }
            }
            scope.guest.jslist.createList();
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
                        scope.rooms.jslist.selected = null;
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
                    console.log(scope.rooms.jslist.newItemArray[index]);
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
        scope: {
            
        },
        link: function (scope, element, attrs) {
            scope.type = attrs.type;
        }
    };
}]);



