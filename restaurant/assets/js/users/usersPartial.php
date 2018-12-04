<div ng-controller="users">
    <div class="prime-hd anim {{tabnav.selected.options.rightbar ? tabnav.selected.options.rightbar.primeclass : 'w-100'}}">
        <div class="statusbar grn row  align-items-end pl-1">
            <div class="tabnav col-5 row">
                <button ng-repeat='nav in tabnav.navs | objtoarray' class="tabpill btnnone" ng-click="tabnav.selectNav(nav.name)" ng-class="{focus:nav.name == tabnav.selected.name}">
                <h5>{{nav.name}}</h5>
            </button>
            </div>
            <!--tabnav end-->
            <div class="searchbox col-7 h-100 row  align-items-end pb-1">
            <div class="col-8">
                    <input class="form-control float-right anim" ng-model="searchbox.imp" /></div>
                <!-- ng-class="{vanishsearch:searchbox.iconhover}" -->
                <div class="wht text-center col-4 px-0"><a  ng-mouseleave="settings.log = true;" ng-mouseenter="settings.log = false;" href = "../php1/restaurant_bar/restaurant_logoff.php" class = "anim btn w-100 pointer font-fam-Montserrat-bold btn-sm btn-outline-secondary wht mb-2">{{settings.log ? settings.user : 'log out'}}</a></div>
            </div>

        </div>
        <div class="prime-body {{tabnav.selected.options.rightbar ? '' : 'pr-0'}}">
            <div class="animate-switch-container" ng-switch on="tabnav.selected.name">
                <div class="animate-switch User px-4 h-100" ng-switch-default>
                    <div class="userlisthd row justify-content-between">
                        <h4 class=" my-4 py-2 font-fam-Montserrat-bold">Manage Users</h4>
                        <div class="my-4"><button class="btn btn-outline-primary mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'User'; settings.modal.name = 'Add User'; settings.modal.size = 'md' " data-toggle="modal" data-target="#crud" >Add</button><button class="btn btn-outline-success mx-1 font-fam-Montserrat f-12" data-toggle="modal" data-target="#crud" ng-click="settings.modal.active = 'User'; settings.modal.name = 'Update User'; settings.modal.size = 'lg'; " ng-disabled="!users.jslist.selected">Update</button><button class="btn btn-outline-danger mx-1 font-fam-Montserrat f-12" ng-click="users.deleteUser()"  ng-disabled="!users.jslist.selected">Delete</button></div>
                    </div>
                    <div class="userlist h-80">
                        <userlist></userlist>
                    </div>
                </div>
                <div class="animate-switch h-95 ovflo-y px-4" ng-switch-when="General">
                <div class = "w-100 row justify-content-start float-left text-center pt-4">
                        <div class = "col-5 mt-2">
                            <div class="rest-demo h-80"></div>
                            <div class = "w-70 mx-auto">
                                <input class = " w-100" type="file" name="rest-upload-img" id="rest-upload-img" />
                                <button class="mt-3 rest-cropImg btn btn-success w-100 ">Save</button>
                            </div>
                        </div>
                        <div class="row col-7 justify-content-center text-center pb-4 pr-5" ng-init = "general.itemlist()">
                            <h6 class="w-100 mt-3">Top Message</h6>
                            <textarea placeholder = "Top Message" ng-model = "general.restaurant_top_msg" class="text-center form-control f-13 col-12 m-0" rows='3'></textarea>
                            <button class="mt-3 btn btn-danger py-0 w-25" ng-click = "general.msg_Update('restaurant_top_msg')">Save</button>
                            <h6 class="w-100 mt-5">Bottom Message</h6>
                            <textarea ng-model = "general.restaurant_bottom_msg" placeholder = "Top Message" class="text-center form-control f-13 col-12" rows='3'></textarea>
                            <button class="mt-3 btn btn-danger py-0 w-25" ng-click = "general.msg_Update('restaurant_bottom_msg')">Save</button>
                        </div>
                    <croppie url = "../php1/restaurant_bar/admin/settings_img_restaurant_bar.php" cont = ".rest-demo" upload = "#rest-upload-img" save = ".rest-cropImg"></croppie>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--statusbar for primehd end-->
    <div class="main-sidebar-right hs-100 anim {{tabnav.selected.options.rightbar ? tabnav.selected.options.rightbar.rightbarclass : 'w-0 gone'}}">
        <div class="statusbar grn row align-items-end justify-content-center">
            <h4 class="text-center wht">Sessions <i class="fa fa-book"></i></h4>
        </div>
        <!--statusbar for main-sidebar-right end -->
        <div class="sidebar-body" ng-switch on="tabnav.selected.name">
            <div ng-switch-when = "Users">
                <div class = "sessions p-4 w-100">
                    
                <sessionlist></sessionlist>
                </div>
            </div>            
        </div>
    </div>
    <!--main-sidebar-right end-->
    <div class="clr"></div>
    <div class="modal fade" id="crud" role="dialog" modalentry></div>
</div>
