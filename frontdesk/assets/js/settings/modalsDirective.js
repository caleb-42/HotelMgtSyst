settingsApp.directive('usermodalentry', ['$rootScope', 'jsonPost', '$filter', function ($rootScope, jsonPost, $filter) {
    return {
        restrict: 'A',
        //template: modalTemplate,
        templateUrl: './assets/js/users/modalsPartial.html',
        scope: false,
        link: function (scope, element, attrs) {
            $('.modal').on("shown.bs.modal", function () {
                if ($rootScope.settings.modal.name == "Update User") {
                    console.log(scope.users);
                    $rootScope.settings.utilities.loadJson2Form(scope.users.jslist.selectedObj, '.inpRead');
                }
            });
            addUser = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".addUserForm").serializeObject();
                jsonForm.role = scope.users.inputs.role == undefined ? "" : scope.users.inputs.role ;
                console.log(scope.users);
                scope.users.addUser(jsonForm);
                scope.users.inputs = {};
            };
            updateUser = function () {
                $rootScope.settings.modal.adding = true
                jsonForm = $(".updateUserForm").serializeObject();
                jsonForm.new_role = scope.users.inputs.new_role == undefined ? "" : scope.users.inputs.new_role;
                scope.users.updateUser(jsonForm);
                scope.users.inputs = {};
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
                
            }
        }
    }
}]);