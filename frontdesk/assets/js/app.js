var app = angular.module('app', ['ngAnimate', 'ngRoute', 'ngSanitize', 'dashApp', 'roomsApp', 'usersApp', 'recordsApp', 'ngCroppie','720kb.datepicker']);

app.controller("appctrl", ["$rootScope", "$scope","$filter", function ($rootScope, $scope, $filter) {
    $rootScope.settings = {
        modal: {
            active: "",
            name: "",
            size: "",
            msg: "",
            adding : false,
            msgprompt: function (arr) {
                if (typeof (arr) == "string") {
                    $rootScope.settings.modal.msg = "BACKEND CODE ERROR";
                    $rootScope.settings.modal.msgcolor = "choral";
                    $rootScope.settings.modal.fademsg();
                    $rootScope.settings.modal.adding = false;
                    return false;
                } else {
                    $rootScope.settings.modal.msg = arr[1];
                    if(arr[0] == "OUTPUT"){
                        $rootScope.settings.modal.msgcolor = "green";
                        /* $rootScope.settings.AutoComplete.obj = {}; */
                        $rootScope.settings.modal.close();
                        $rootScope.settings.modal.adding = false;
                        return true;
                    }else{
                        $rootScope.settings.modal.msgcolor = "choral";
                        $rootScope.settings.modal.fademsg();
                        $rootScope.settings.modal.adding = false;
                        return false;
                    }
                }
            }
        },
        date : new Date().toString(),
        ydate : $filter('intervalGetDate')(-1, new Date().toString()),
        userDefinition : function (user, role) {
            $rootScope.settings.user = user;
            $rootScope.settings.role = role;
        },        
        user: "",
        role: "",
        log: true,
        AutoComplete : {
            obj: {},
            activate  : function(input, datas, dataSources, prop) {
                dataSource = dataSources.slice();
                if (!$(input).autocomplete("instance")) {
                    $(input.currentTarget).autocomplete({
                        source: dataSource,

                        select: function (event, ui) {
                            data = datas.slice();
                            for (var p = 0; p < data.length; p++) {
                                console.log(data);
                                ans = data[p][prop];
                                console.log(ans, ui.item.label);
                                if (data[p][prop] == ui.item.label) {
                                    //console.log(dataSource);
                                    $rootScope.settings.AutoComplete.obj = {};
                                    $rootScope.settings.AutoComplete.obj = Object.assign({}, data[p]);
                                    console.log($rootScope.settings.AutoComplete.obj);
                                    $rootScope.$apply();
                                }
                            }
                        }
                    });
                }
            }
        }
    }
    $scope.sidebarnav = {
        navig: {
            activeNav: "Dashboard",
            mkactiveNav: function (nav) {
                $scope.sidebarnav.navig.activeNav = nav;
            },
            navs: [
                {
                    name: "Dashboard",
                    listClass: "anim",
                    iconClass: "mr-3",
                    innerHtml: '<img width = 15px height = 20px style="margin-top:-20px;" src = "assets/img/moneybag-08.png"/>',
                },
                {
                    name: "Lodge",
                    listClass: "anim",
                    iconClass: "mr-3 fa fa-foursquare",
                    innerHtml: '',
                },
                {
                    name: "Settings",
                    listClass: "anim",
                    iconClass: "mr-3 fa fa-user",
                    innerHtml: '',
                },
                {
                    name: "Records",
                    listClass: "anim",
                    iconClass: "mr-3 fa fa-history",
                    innerHtml: '',
                }
            ]
        },
        menuicon: {
            active : true,
            toggleactive: function () {
                console.log("rertr");
                $scope.sidebarnav.menuicon.active = $scope.sidebarnav.menuicon.active ? false : true;
            }
        }
    };
}]);

var dashApp = angular.module('dashApp', []);
var roomsApp = angular.module('roomsApp', []);
var usersApp = angular.module('usersApp', []);
var recordsApp = angular.module('recordsApp', []);
