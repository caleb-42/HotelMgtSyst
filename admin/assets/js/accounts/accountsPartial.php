<div ng-controller="accounts"> <!-- {{tabnav.selected == 'Customers' ? null : 'w-100'}} -->
    <div class="prime-hd anim {{tabnav.selected.options.rightbar ? tabnav.selected.options.rightbar.primeclass : 'w-100'}}">
        <div class="statusbar blu row  align-items-end pl-1">
            <div class="tabnav col-9 row">
                <button ng-repeat='nav in tabnav.navs | objtoarray' class="tabpill btnnone" ng-click="tabnav.selectNav(nav.name)" ng-class="{focus:nav.name == tabnav.selected.name}">
                <h5>{{nav.name}}</h5>
            </button>
            </div>
            <!--tabnav end-->
            <div class="searchbox col-3 h-100 row  align-items-end pb-1">
            <div class="col-8">
                    <input class="form-control float-right anim" ng-model="searchbox.imp" /></div>
                <!-- ng-class="{vanishsearch:searchbox.iconhover}" -->
                <div class="wht text-center col-4 px-0"><a  ng-mouseleave="settings.log = true;" ng-mouseenter="settings.log = false;" href = "../php1/front_desk/frontdesk_logoff.php" class = "anim btn w-100 font-fam-Montserrat-bold btn-sm custom-btn-outline-orange wht mb-2">{{settings.log ? settings.user : 'log out'}}</a></div>
            </div>

        </div>
        <div class="prime-body {{tabnav.selected.options.rightbar ? null : 'px-0'}}">
                <div class="animate-switch-container" ng-switch on="tabnav.selected.name">
                <div class="animate-switch Expenses h-100" ng-switch-when = "Expenses">
                    <div class="expenses prime-footer anim h-100">
                        <div class="p-3 px-4 itemlayout w-100 h-93">
                            <div class="mb-5 item-container">
                                <div class="userlisthd row justify-content-between">
                                    <h4 class=" my-4 py-2 font-fam-Montserrat-bold">Manage Expenses</h4>
                                    <div class="my-4">
                                        <button class="btn btn-info mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'Expenses'; settings.modal.name = 'Add Expenses'; settings.modal.size = 'md';" data-toggle="modal" data-target="#crud">Add</button>
                                        <button class="btn  purp-back wht opac-50 mx-1 font-fam-Montserrat f-12" ng-click="expenses.deleteExpenses()" ng-disabled="!expenses.jslist.selected">Delete</button>
                                    </div>
                                </div>
                                <expenselist class="font-fam-Montserrat"></expenselist>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="animate-switch User px-4 h-100" ng-switch-when = "Users">
                    <div class="userlisthd row justify-content-between">
                        <h4 class=" my-4 py-2 font-fam-Montserrat-bold">Manage Users</h4>
                        <div class="my-4"><button class="btn btn-outline-primary mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'User'; settings.modal.name = 'Add User'; settings.modal.size = 'md' " data-toggle="modal" data-target="#crud" >Add</button><button class="btn btn-outline-success mx-1 font-fam-Montserrat f-12" data-toggle="modal" data-target="#crud" ng-click="settings.modal.active = 'User'; settings.modal.name = 'Update User'; settings.modal.size = 'lg'; " ng-disabled="!users.jslist.selected">Update</button><button class="btn btn-outline-danger mx-1 font-fam-Montserrat f-12" ng-click="users.deleteUser()"  ng-disabled="!users.jslist.selected">Delete</button></div>
                    </div>
                    <div class="userlist h-80">
                        <accountsuserlist></accountsuserlist>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--statusbar for primehd end--><!-- {{tabnav.selected == 'Customers' ? null : 'w-0 gone'}} -->
    <div class="main-sidebar-right hs-100 whtback anim {{tabnav.selected.options.rightbar ? tabnav.selected.options.rightbar.rightbarclass : 'w-0 gone'}}">
        <div class="statusbar blu row align-items-end justify-content-center">
            <h4 class="text-center wht">{{tabnav.selected.name == 'Customers' ? 'Bookings Tranx' : 'Bookings List'}} <i class="fa fa-book"></i></h4>
        </div>
        <!--statusbar for main-sidebar-right end -->
        <div class="sidebar-body" ng-switch on="tabnav.selected.name">
            <div ng-switch-whwn = "Users">
                <div class = "sessions h-100 p-4 w-100">
                    <accountssessionlist></accountssessionlist>
                </div>
            </div>       
        </div>
    </div>
    <!--main-sidebar-right end-->
    <div class="clr"></div>
</div>
