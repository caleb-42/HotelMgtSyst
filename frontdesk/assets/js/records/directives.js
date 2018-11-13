app.directive('bookinghistory', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/records/listTemplates.php?list=booking',

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
