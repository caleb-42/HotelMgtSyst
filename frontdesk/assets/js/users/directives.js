usersApp.directive('userlist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/users/listTemplates.php?list=users',

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

usersApp.directive('sessionlist', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/users/listTemplates.php?list=sessions',

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


usersApp.directive('croppie', ['$rootScope', '$filter', function ($rootScope, $filter) {
    return {
        restrict: 'E',
        templateUrl: './assets/js/users/listTemplates.php?list=croppie',

        scope: false,

        link: function (scope, element, attrs) {
            var basic = $(attrs.cont).croppie({
                viewport: {
                    width: 200,
                    height: 200,
                    type: 'circle'
                },
                boundary: {
                    width: 250,
                    height: 250
                }
    
            });
            var uploaded = false;
            console.log(basic);
            basic.croppie('bind', {
                url: './assets/img/4.png'
            });
            //on button click
            basic.croppie('result', 'html').then(function(html) {
                // html is div (overflow hidden)
                // with img positioned inside.
            });
            $(attrs.upload).on("change", function() {
                uploaded = true;
                var reader = new FileReader();
                reader.onload = function(event) {
                    basic.croppie("bind", {
                        url: event.target.result
                    })/* .then(function() {
                        console.log(event.target.result);
                    }) */
                }
                reader.readAsDataURL(this.files[0]);
            });
            $(attrs.save).click(function(event) {
                if(!uploaded) {scope.general.loader.img = false;$rootScope.$apply();return;}
                basic.croppie('result', {
                    type: 'canvas',
                    size: 'viewport',
                    format: 'png'
                }).then(function(response) {
                    $.ajax({
                        url: attrs.url,
                        method: "POST",
                        data: {
                            "settings_data" :  $filter('json')({"img_frontdesk_data": response})
                        },
                        success: function(data) {
                            //$('.fdemo').html(data);
                            console.log(data);
                            scope.general.loader.img = false;
                            $rootScope.$apply();
                        }
                    });
                    //console.log(response);
                })
            })
            
        }
    };
}]);



