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
                
                <div class="animate-switch row justify-content-center h-95 p-4 ovflo-y " ng-switch-when="General">
                    <div class="w-80 text-center pb-5" ng-init = "general.itemlist()">
                        <h5 class="w-100 font-fam-Montserrat-bold opac-70 purp-clr">Company Info</h5>
                        <div class = "w-100 mb-4">
                        <div class = "w-45 pt-5 float-left row justify-content-center">
                            <h6 class="w-100 opac-70 font-weight-bold">Name</h6>
                            <textarea ng-model = "general.shop_name" placeholder = "Comapany Name" class="text-center form-control f-13 col-12 mt-3" rows='3'></textarea>
                            <div class="w-25 mt-3 py-0">
                                <img src="./assets/img/loader.gif" width="50px" height="30px" ng-class="{gone : !general.loader.shop_name}"/>
                                <button  class="{{general.loader.shop_name ? 'gone' : ''}} btn btn-warning py-1 w-100" ng-click = "general.loader.shop_name = true;general.msg_Update('shop_name')">Save</button>
                            </div>
                        </div>
                        <div class = "w-45 pt-5 float-right row justify-content-center">
                            <h6 class="w-100 opac-70 font-weight-bold">Address</h6>
                            <textarea ng-model = "general.shop_address" placeholder = "Comapany Address" class="text-center form-control f-13 col-12 mt-3" rows='3'></textarea>
                            <div class="w-25 mt-3 py-0">
                                <img src="./assets/img/loader.gif" width="50px" height="30px" ng-class="{gone : !general.loader.shop_address}"/>
                                <button  class="{{general.loader.shop_address ? 'gone' : ''}} btn btn-warning py-1 w-100" ng-click = "general.loader.shop_address = true;general.msg_Update('shop_address')">Save</button>
                            </div>
                        </div>
                        </div>
                        <div class = "w-100 mb-4 relatv">
                        <div class = "w-45 pt-5 float-left row justify-content-center">
                            <h6 class="w-100 opac-70 font-weight-bold">Phone Number</h6>
                            <textarea ng-model = "general.shop_contact" placeholder = "Comapany Contact" class="text-center form-control f-13 col-12 mt-3" rows='3'></textarea>
                            <div class="w-25 mt-3 py-0">
                                <img src="./assets/img/loader.gif" width="50px" height="30px" ng-class="{gone : !general.loader.shop_contact}"/>
                                <button  class="{{general.loader.shop_contact ? 'gone' : ''}} btn btn-warning py-1 w-100" ng-click = "general.loader.shop_contact = true;general.msg_Update('shop_contact')">Save</button>
                            </div>
                        </div>
                        <div class = "w-45 pt-5 float-right row justify-content-center">
                            <h6 class="w-100 opac-70 font-weight-bold">Email</h6>
                            <textarea ng-model = "general.shop_email" placeholder = "Comapany Mail" class="text-center form-control f-13 col-12 mt-3" rows='3'></textarea>
                            <div class="w-25 mt-3 py-0">
                                <img src="./assets/img/loader.gif" width="50px" height="30px" ng-class="{gone : !general.loader.shop_email}"/>
                                <button  class="{{general.loader.shop_email ? 'gone' : ''}} btn btn-warning py-1 w-100" ng-click = "general.loader.shop_email = true;general.msg_Update('shop_email')">Save</button>
                            </div>
                        </div>
                        </div>
                         <div class = "w-100">                       
                        <div class = "w-45 pt-5 float-left row justify-content-center">
                            <h6 class="w-100 opac-70 font-weight-bold">Frontdesk Bottom Message</h6>
                            <textarea ng-model = "general.frontdesk_bottom_msg" placeholder = "Frontdesk Bottom Message" class="text-center form-control f-13 col-12 mt-3" rows='3'></textarea>
                            <div class="w-25 mt-3 py-0">
                                <img src="./assets/img/loader.gif" width="50px" height="30px" ng-class="{gone : !general.loader.frontdesk_bottom_msg}"/>
                                <button  class="{{general.loader.frontdesk_bottom_msg ? 'gone' : ''}} btn btn-warning py-1 w-100" ng-click = "general.loader.frontdesk_bottom_msg = true;general.msg_Update('frontdesk_bottom_msg')">Save</button>
                            </div>
                        </div>
                        <div class = "w-45 pt-5 float-right row justify-content-center">
                            <h6 class="w-100 opac-70 font-weight-bold">Restaurant Bottom Message</h6>
                            <textarea ng-model = "general.restaurant_bottom_msg" placeholder = "Restaurant Bottom Messag" class="text-center form-control f-13 col-12 mt-3" rows='3'></textarea>
                            <div class="w-25 mt-3 py-0">
                                <img src="./assets/img/loader.gif" width="70px" height="45px" ng-class="{gone : !general.loader.restaurant_bottom_msg}"/>
                                <button  class="{{general.loader.restaurant_bottom_msg ? 'gone' : ''}} btn btn-warning py-1 w-100" ng-click = "general.loader.restaurant_bottom_msg = true; general.msg_Update('restaurant_bottom_msg')">Save</button>
                            </div>
                        </div>
                        </div>
                        <!-- <div class = "w-45 mt-5 float-left">
                            <h6 class="w-100 opac-70 font-weight-bold">Restaurant Top Message</h6>
                            <textarea placeholder = "Restaurant Top Message" class="text-center form-control f-13 col-12 mt-3" ng-model = "general.restaurant_top_msg" rows='3'></textarea>
                            <button class="mt-3 btn btn-warning py-1 w-25" ng-click = "general.msg_Update('restaurant_top_msg')">Save</button>
                        </div>
                        <div class = "w-45 mt-5 float-left">
                            <h6 class="w-100 opac-70 font-weight-bold">Frontdesk Top Message</h6>
                            <textarea placeholder = "Frontdesk Top Message" class="text-center form-control f-13 col-12 mt-3" ng-model = "general.frontdesk_top_msg" rows='3'></textarea>
                            <button class="mt-3 btn btn-warning py-1 w-25" ng-click = "general.msg_Update('frontdesk_top_msg')">Save</button>
                        </div> -->
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
