app.directive('roomlist', ['$rootScope', '$filter', function ($rootScope, $filter) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/rooms/listTemplates.php?list=rooms',

        scope: false,

        link: function (scope, element, attrs) {
            var jslistObj;
            scope.rooms.jslist = {
                createList: function () {
                    listdetails = scope.rooms.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    jsonlist.then(function (result) {
                        console.log(result);
                        /* result.forEach(function(elem){
                            elem.category = elem.room_category;
                        }); */
                        scope.rooms.jslist.values = result;
                        scope.rooms.jslist.selected = null;
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


app.directive('categorylist', ['$rootScope', '$filter', function ($rootScope, $filter) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/rooms/listTemplates.php?list=category',

        scope: false,

        link: function (scope, element, attrs) {
            var jslistObj;
            scope.category.jslist = {
                createList: function () {
                    listdetails = scope.category.itemlist();
                    jsonlist = listdetails.jsonfunc;
                    jsonlist.then(function (result) {
                        console.log(result);
                        scope.category.jslist.values = result;
                        scope.category.jslist.selected = null;
                    });
                    scope.category.listhddata = [
                        {
                            name: "Category",
                            width: "col-4",
                        },
                        {
                            name: "Rate",
                            width: "col-4",
                        },
                        {
                            name: "Added By",
                            width: "col-4",
                        }
                    ];
                },
                select: function (index, id) {
                    scope.category.jslist.selected = id;
                    scope.category.jslist.selectedObj = scope.category.jslist.newItemArray[index];
                    console.log(scope.category.jslist.selectedObj);
                },
                toggleOut: function () {
                    $(".listcont").fadeOut(200);
                },
                toggleIn: function () {
                    $(".listcont").delay(500).fadeIn(200);
                }
            }
            scope.category.jslist.createList();
        }
    };
}]);


