<div ng-controller="rooms">
    <div class="prime-hd anim {{tabnav.selected.options.rightbar ? tabnav.selected.options.rightbar.primeclass : 'w-100'}}">
        <div class="statusbar blu row  align-items-end pl-1">
            <div class="tabnav col-9 row">
                <button ng-repeat='nav in tabnav.navs | objtoarray' class="tabpill btnnone" ng-click="tabnav.selectNav(nav.name)" ng-class="{focus:nav.name == tabnav.selected.name}">
                <h5>{{nav.name}}</h5>
            </button>
            </div>
            <!--tabnav end-->
            <div class="searchbox col-3 h-100 row  align-items-end pb-1" >
                <div class="col-8">
                    <input class="form-control float-right anim" ng-model="searchbox.imp" /></div>
                <!-- ng-class="{vanishsearch:searchbox.iconhover}" -->
                <div class="wht text-center col-4 px-0"><a  ng-mouseleave="settings.log = true;" ng-mouseenter="settings.log = false;" href = "../php1/front_desk/frontdesk_logoff.php" class = "anim btn w-100 font-fam-Montserrat-bold btn-sm custom-btn-outline-orange wht mb-2">{{settings.log ? settings.user : 'log out'}}</a></div>
            </div>

        </div>
        <div class="prime-body {{tabnav.selected.options.rightbar ? '' : 'pr-0'}}">
            <div class="animate-switch-container" ng-switch on="tabnav.selected.name">
                <div class="animate-switch Rooms px-4 h-100" ng-switch-default>
                    <div class="prodlisthd row justify-content-between">
                        <h4 class=" my-4 py-2 font-fam-Montserrat-bold">Manage Rooms</h4>
                        <div class="my-4 row justify-content-between align-items-center">

                        <div class = "roomscrudbtns my-4 align-items-center ">
                        <button class="btn btn-outline-primary mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'Room'; settings.modal.name = 'Add Room'; settings.modal.size = 'md' " data-toggle="modal" data-target="#crud" >Add</button><button class="btn btn-outline-success mx-1 font-fam-Montserrat f-12" data-toggle="modal" data-target="#crud" ng-click="settings.modal.active = 'Room'; settings.modal.name = 'Update Room'; settings.modal.size = 'lg'; " ng-disabled="!rooms.jslist.selected">Update</button><button class="btn btn-outline-danger mx-1 font-fam-Montserrat f-12" ng-disabled="!rooms.jslist.selected" ng-click = "rooms.deleteRoom()">Delete</button>
                        </div>

                        </div>
                    </div>
                    <div class="rmlist h-80">
                        <roomlist class="font-fam-Montserrat"></roomlist>
                    </div>
                </div>
                <div class="animate-switch" ng-switch-when="History">HomeSpan</div>
            </div>
        </div>
    </div>
    <!--statusbar for primehd end-->
    <div class="main-sidebar-right hs-100 anim {{tabnav.selected.options.rightbar ? tabnav.selected.options.rightbar.rightbarclass : 'w-0 gone'}}">
        <div class="statusbar blu row align-items-end justify-content-center">
            <h4 class="text-center wht">Details <i class="fa fa-book"></i></h4>
        </div>
        <!--statusbar for main-sidebar-right end -->
        <div class="sidebar-body" ng-switch on="tabnav.selected.name">
            <div ng-switch-default>
               
            </div>
            
        </div>
    </div>
    <!--main-sidebar-right end-->
    <div class="clr"></div>
    <div class="modal fade" id="crud" role="dialog" modalentry></div>
</div>
