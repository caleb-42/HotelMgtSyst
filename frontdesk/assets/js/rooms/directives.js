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


