lodgeApp.directive('roomsmodalentry', ['$rootScope', 'jsonPost', '$filter', function ($rootScope, jsonPost, $filter) {
    return {
        restrict: 'A',
        //template: modalTemplate,
        templateUrl: './assets/js/lodge/modalsPartial.html',
        scope: false,
        link: function (scope, element, attrs) {

            $('.modal').on("shown.bs.modal", function () {
                if ($rootScope.settings.modal.name == "Update Room") {
                    console.log(scope.rooms);
                    $rootScope.settings.utilities.loadJson2Form(scope.rooms.jslist.selectedObj, '.inpRead');
                } else if ($rootScope.settings.modal.name == "Update Category") {
                    console.log(scope.category);
                    $rootScope.settings.utilities.loadJson2Form(scope.category.jslist.selectedObj, '.inpRead');
                }
            });
            updateRoom = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".updateRoomForm").serializeObject();
                console.log(scope.rooms.jslist.new_room_category);
                jsonForm.new_room_category = scope.rooms.inputs.new_room_category ? scope.rooms.inputs.new_room_category : "";
                scope.rooms.updateRoom(jsonForm);
                scope.rooms.inputs = {};
            };
            addRoom = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".addRoomForm").serializeObject();
                //console.log();
                jsonForm.room_category = scope.rooms.inputs.room_category == undefined ? "" : scope.rooms.inputs.room_category;
                scope.rooms.addRoom(jsonForm);
                scope.rooms.inputs = {};
            };
            addCategory = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".addCategoryForm").serializeObject();
                scope.category.addCategory(jsonForm);
                scope.category.inputs = {};
            };
            updateCategory = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".updateCategoryForm").serializeObject();
                scope.category.updateCategory(jsonForm);
                scope.category.inputs = {};
            };
            $rootScope.settings.modal.close = function () {
                $(".report").fadeIn(100, function () {
                    $(".report").delay(1500).fadeOut(100, function () {
                        $(".modal .close").trigger("click");
                        $rootScope.settings.modal.msg = "";
                    });
                });
            }
            $rootScope.settings.modal.fademsg = function () {
                console.log('dvs');
                $(".report").fadeIn(50, function () {
                    $('.report').delay(3500).fadeOut(10);
                });
            };
            $('.modal').on('hidden.bs.modal', function () {
                $rootScope.settings.modal.msg = '';
                $rootScope.settings.modal.active = "";
                $rootScope.settings.AutoComplete.obj = {};
                $(".modal .clearinput").val("");
                reset();
            });
            $('.modal .close').on('click', function () {
                $rootScope.settings.modal.msg = '';
                $rootScope.settings.modal.active = "";
                $rootScope.settings.AutoComplete.obj = {};
                $(".modal .clearinput").val("");
                reset();
            });
            function reset(){ 
                scope.rooms.inputs = {}; 
                scope.category.inputs = {};
            }
        }
    }
}]);