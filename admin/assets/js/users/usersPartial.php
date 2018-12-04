<div ng-controller="settings">
    <div class="prime-hd anim {{tabnav.selected.options.rightbar ? tabnav.selected.options.rightbar.primeclass : 'w-100'}}">
        <div class="statusbar blu row  align-items-end pl-1">
            <div class="tabnav {{tabnav.selected.options.rightbar ? 'col-12' : 'col-8'}} relatv row">
                <button ng-repeat='nav in tabnav.navs | objtoarray' class="abs h-100 tabpill btnnone" ng-click="tabnav.selectNav(nav.name)" ng-class="{focus:nav.name == tabnav.selected.name}" style = "left: {{($index * 150) + 20}}px;">
                <h5>{{nav.name}}</h5>
            </button>
            </div>
            <!--tabnav end-->
            <div class="searchbox  {{tabnav.selected.options.rightbar ? 'gone' : 'col-4'}} h-100 row  align-items-end pb-1">
            <div class="col-8">
                    <input class="form-control float-right anim" ng-model="searchbox.imp" /></div>
                <!-- ng-class="{vanishsearch:searchbox.iconhover}" -->
                <div class="wht text-center col-4 px-0"><a  ng-mouseleave="settings.log = true;" ng-mouseenter="settings.log = false;" href = "../php1/admin/admin_logoff.php" class = "anim btn w-100 font-fam-Montserrat-bold btn-sm custom-btn-outline-orange wht mb-2">{{settings.log ? settings.user : 'log out'}}</a></div>
            </div>

        </div>
        <div class="prime-body {{tabnav.selected.options.rightbar ? '' : 'p-0'}}">
            <div class="animate-switch-container" ng-switch on="tabnav.selected.name">
                <div class="animate-switch User px-4 h-100" ng-switch-when = "Users">
                    <div class="userlisthd row justify-content-between">
                        <h4 class=" my-4 py-2 font-fam-Montserrat-bold">Manage Users</h4>
                        <div class="my-4"><button class="btn btn-outline-primary mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'User'; settings.modal.name = 'Add User'; settings.modal.size = 'md' " data-toggle="modal" data-target="#crud" >Add</button><button class="btn btn-outline-success mx-1 font-fam-Montserrat f-12" data-toggle="modal" data-target="#crud" ng-click="settings.modal.active = 'User'; settings.modal.name = 'Update User'; settings.modal.size = 'lg'; " ng-disabled="!users.jslist.selected">Update</button><button class="btn btn-outline-danger mx-1 font-fam-Montserrat f-12" ng-click="users.deleteUser()"  ng-disabled="!users.jslist.selected">Delete</button></div>
                    </div>
                    <div class="userlist h-80">
                        <userlist></userlist>
                    </div>
                </div>
                
                <div class="animate-switch row justify-content-center h-95 p-4 ovflo-y" ng-switch-when="General">
                    <div class="w-80 text-center" ng-init = "general.itemlist()">
                        <h5 class="w-100 font-fam-Montserrat-bold opac-70">Company Info</h5>
                        <div class = "w-45 mt-5 float-left">
                            <h6 class="w-100 purp-clr opac-70">Name</h6>
                            <textarea placeholder = "Top Message" class="form-control f-13 col-12 m-0" rows='3'></textarea>
                            <button class="mt-3 btn btn-warning py-0 w-25" ng-click = "general.msg_Update('restaurant_top_msg')">Save</button>
                        </div>
                        <div class = "w-45 mt-5 float-right">
                            <h6 class="w-100 purp-clr opac-70">Address</h6>
                            <textarea placeholder = "Top Message" class="form-control f-13 col-12 m-0" rows='3'></textarea>
                            <button class="mt-3 btn btn-warning py-0 w-25" ng-click = "general.msg_Update('restaurant_top_msg')">Save</button>
                        </div>
                        <div class = "w-45 mt-4 float-left">
                            <h6 class="w-100 purp-clr opac-70">Phone Number</h6>
                            <textarea placeholder = "Top Message" class="form-control f-13 col-12 m-0" rows='3'></textarea>
                            <button class="mt-3 btn btn-warning py-0 w-25" ng-click = "general.msg_Update('restaurant_top_msg')">Save</button>
                        </div>
                        <div class = "w-45 mt-4 float-right">
                            <h6 class="w-100 purp-clr opac-70">Email</h6>
                            <textarea placeholder = "Top Message" class="form-control f-13 col-12 m-0" rows='3'></textarea>
                            <button class="mt-3 btn btn-warning py-0 w-25" ng-click = "general.msg_Update('restaurant_top_msg')">Save</button>
                        </div>
                        <div class = "w-45 mt-4 float-left">
                            <h6 class="w-100 purp-clr opac-70">Frontdesk Top Message</h6>
                            <textarea placeholder = "Top Message" class="form-control f-13 col-12 m-0" ng-model = "general.frontdesk_top_msg" rows='3'></textarea>
                            <button class="mt-3 btn btn-warning py-0 w-25" ng-click = "general.msg_Update('frontdesk_top_msg')">Save</button>
                        </div>
                        <div class = "w-45 mt-4 float-right">
                            <h6 class="w-100 purp-clr opac-70">Frontdesk Bottom Message</h6>
                            <textarea ng-model = "general.frontdesk_bottom_msg" placeholder = "Top Message" class="form-control f-13 col-12 m-0" rows='3'></textarea>
                            <button class="mt-3 btn btn-warning py-0 w-25" ng-click = "general.msg_Update('frontdesk_top_msg')">Save</button>
                        </div>
                        <div class = "w-45 mt-4 float-left">
                            <h6 class="w-100 purp-clr opac-70">Restaurant Top Message</h6>
                            <textarea placeholder = "Top Message" class="form-control f-13 col-12 m-0" ng-model = "general.restaurant_top_msg" rows='3'></textarea>
                            <button class="mt-3 btn btn-warning py-0 w-25" ng-click = "general.msg_Update('restaurant_top_msg')">Save</button>
                        </div>
                        <div class = "w-45 mt-4 float-right">
                            <h6 class="w-100 purp-clr opac-70">Restaurant Bottom Message</h6>
                            <textarea ng-model = "general.restaurant_bottom_msg" placeholder = "Top Message" class="form-control f-13 col-12 m-0" rows='3'></textarea>
                            <button class="mt-3 btn btn-warning py-0 w-25" ng-click = "general.msg_Update('restaurant_top_msg')">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--statusbar for primehd end-->
    <div class="main-sidebar-right hs-100 anim {{tabnav.selected.options.rightbar ? tabnav.selected.options.rightbar.rightbarclass : 'w-0 vanish'}}">
        <div class="statusbar blu row align-items-end justify-content-center">
            <div class="searchbox col-12 h-100 row  align-items-end pb-1 {{tabnav.selected.options.rightbar ? '' : 'gone'}}">
                    <div class="col-8">
                        <input class="form-control float-right anim" ng-model="searchbox.imp" />
                    </div>
                    <div class="wht text-center col-4 px-0"><a  ng-mouseleave="settings.log = true;" href = "../php1/admin/admin_logoff.php" ng-mouseenter="settings.log = false;" class = "anim btn w-100 font-fam-Montserrat-bold btn-sm custom-btn-outline-orange wht mb-2">{{settings.log ? settings.user : 'log out'}}</a>
                </div>
            </div>
        </div>
        <!--statusbar for main-sidebar-right end -->
        <div class="sidebar-body h-100 whtback" ng-switch on="tabnav.selected.name">
            <div ng-switch-default>
                <div class = "sessions h-100 p-4 w-100">
                    
                <sessionlist></sessionlist>
                </div>
            </div>            
            <div ng-switch-when = "General">
                <div class = "text-center sessions h-100 p-4 w-100">
                    
                </div>
            </div>            
        </div>
    </div>
    <!--main-sidebar-right end-->
    <div class="clr"></div>
    <div class="modal fade" id="crud" role="dialog" modalentry></div>
</div>
