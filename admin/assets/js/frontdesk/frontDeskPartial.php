<div ng-controller="frontdesk">
<div class="prime-hd anim  {{tabnav.selected.options.rightbar ? tabnav.selected.options.rightbar.primeclass : 'w-100'}}">
    <div class="statusbar blu row  align-items-end pl-1">
        <div class="tabnav {{tabnav.selected.options.rightbar ? 'col-12' : 'col-8'}} relatv row">
            <button ng-repeat='nav in tabnav.navs | objtoarray' class="abs h-100 tabpill btnnone" ng-click="tabnav.selectNav(nav.name)" ng-class="{focus:nav.name == tabnav.selected.name}" style = "left: {{($index * 150) + 20}}px;">
                <h5>{{nav.name}}</h5>
            </button>
        </div>
        <div class="searchbox h-100  {{tabnav.selected.options.rightbar ? 'gone' : 'col-4'}} row  align-items-end pb-1">
                <div class="col-8">
                    <input class="form-control float-right anim" ng-model="searchbox.imp" />
                </div>
                <div class="wht text-center col-4 px-0"><a  ng-mouseleave="settings.log = true;" href = "../php1/front_desk/frontdesk_logoff.php" ng-mouseenter="settings.log = false;" class = "anim btn w-100 font-fam-Montserrat-bold btn-sm custom-btn-outline-orange wht mb-2">{{settings.log ? settings.user : 'log out'}}</a>
            </div>
        </div>
        <!--tabnav end-->
        

    </div>
    <!--statusbar for primehd end-->

    <div class="prime-body {{tabnav.selected.options.rightbar ? '' : 'p-0'}}">
        <div class="animate-switch-container" ng-switch on="tabnav.selected.name">

            <div class="animate-switch Guests h-100" ng-switch-when = "Guests">
                <div class="guests  prime-footer anim h-80">
                    <div class="p-3 px-4 itemlayout w-100 h-93">
                        <div class="mb-5 item-container">
                            <div class="userlisthd row justify-content-between">
                                <h4 class=" my-4 py-2 font-fam-Montserrat-bold">Manage Guest</h4>
                                <div class="my-4">
                                    <button class="btn purp-back wht opac-50 mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'Guest'; settings.modal.name = 'Update Guest'; settings.modal.size = 'lg';" data-toggle="modal" data-target="#crud" ng-disabled="!guest.jslist.selected">Update</button>
                                </div>
                            </div>
                            <jslist class="font-fam-Montserrat"></jslist>
                        </div>
                    </div>
                </div>
                <div class="orders row align-items-center anim px-2 h-20">

                    <div class = "row w-100">
                        <h6 class = "text-left f-14 col-4 font-fam-Montserrat-bold purp-clr opac-70 py-1 br-1 m-0 py-1 px-3">Rooms</h6>
                        <p class = " col-8 f-13 opac-70 m-0 py-1 px-3">{{guest.jslist.selectedObj ? (guest.jslist.selectedObj.rooms | arraytostring) : '2, 4, 7'}} </p>
                        <h6 class = "text-left f-14 col-4 font-fam-Montserrat-bold purp-clr opac-70 py-1 br-1 m-0 py-1 px-3">Phone Number</h6>
                        <p class = " col-8 f-13 opac-70 m-0 py-1 px-3">{{guest.jslist.selectedObj ? guest.jslist.selectedObj.phone_number : '08130439102'}} </p>
                        <h6 class = "text-left f-14 col-4 font-fam-Montserrat-bold purp-clr opac-70 py-1 br-1 m-0 py-1 px-3">Address</h6>
                        <p class = "  col-8  f-13 opac-70 m-0 py-1 px-3">{{guest.jslist.selectedObj ? guest.jslist.selectedObj.contact_address : 'Conversion of Architectural Blueprints to well-designed Structural layouts (foundaton, beams, columns and bases, slabs'}} </p>
                    </div>

                </div>
            </div>
            <div class="animate-switch Reservation h-100" ng-switch-when = "Reservation">
                <div class="reservation  anim h-100">
                    <div class="p-3 px-4 itemlayout w-100 h-93">
                        <div class="mb-5 item-container">
                            <div class="userlisthd row justify-content-between">
                                <h4 class=" my-4 py-2 font-fam-Montserrat-bold">Manage Reservation</h4>
                                <div class="my-4">
                                    <button class="btn btn-success mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'Reservation'; settings.modal.name = 'Update Reservation'; settings.modal.size = 'lg';" data-toggle="modal" data-target="#crud" ng-disabled="!reservation.jslist.selected" >Update</button>
                                </div>
                            </div>
                            <reservationlist class="font-fam-Montserrat"></reservationlist>
                        </div>
                    </div>
                </div>
            </div>
            <div class="animate-switch Rooms px-4 h-100" ng-switch-when = "Rooms">
                <div class="prodlisthd row justify-content-between">
                    <h4 class=" my-4 py-2 font-fam-Montserrat-bold">Manage Rooms</h4>
                    <div class="my-4 row justify-content-between align-items-center">

                    <div class = "roomscrudbtns my-4 align-items-center ">
                    <button class="btn btn-outline-primary mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'Room'; settings.modal.name = 'Add Room'; settings.modal.size = 'md' " data-toggle="modal" data-target="#crud" >Add</button><button class="btn btn-outline-success mx-1 font-fam-Montserrat f-12" data-toggle="modal" data-target="#crud" ng-click="settings.modal.active = 'Room'; settings.modal.name = 'Update Room'; settings.modal.size = 'lg'; " ng-disabled="!rooms.jslist.selected">Update</button><button class="btn btn-outline-danger mx-1 font-fam-Montserrat f-12" ng-disabled="!room.jslist.selected" ng-click = "room.deleteRoom()">Delete</button>
                    </div>

                    </div>
                </div>
                <div class="rmlist h-80">
                    <roomlist class="font-fam-Montserrat"></roomlist>
                </div>
            </div>
            <div class="animate-switch User px-4 h-100" ng-switch-when = "Users">
                <div class="userlisthd row justify-content-between">
                    <h4 class=" my-4 py-2 font-fam-Montserrat-bold">Manage Users</h4>
                    <div class="my-4"><button class="btn btn-outline-primary mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'User'; settings.modal.name = 'Add User'; settings.modal.size = 'md' " data-toggle="modal" data-target="#crud" >Add</button><button class="btn btn-outline-success mx-1 font-fam-Montserrat f-12" data-toggle="modal" data-target="#crud" ng-click="settings.modal.active = 'User'; settings.modal.name = 'Update User'; settings.modal.size = 'lg'; " ng-disabled="!users.jslist.selected">Update</button><button class="btn btn-outline-danger mx-1 font-fam-Montserrat f-12" ng-click="users.deleteUser()"  ng-disabled="!users.jslist.selected">Delete</button></div>
                </div>
                <div class="userlist h-80">
                    <userlist></userlist>
                </div>
            </div>
        </div>
    </div>
</div>
<!--primehd end-->

<div class="main-sidebar-right hs-100 anim {{tabnav.selected.options.rightbar ? tabnav.selected.options.rightbar.rightbarclass : 'w-0 vanish'}}">
    <div class="statusbar blu row align-items-end justify-content-center">
        <div class="searchbox col-12 h-100 row  align-items-end pb-1 {{tabnav.selected.options.rightbar ? '' : 'gone'}}">
                <div class="col-8">
                    <input class="form-control float-right anim" ng-model="searchbox.imp" />
                </div>
                <div class="wht text-center col-4 px-0"><a  ng-mouseleave="settings.log = true;" href = "../php1/front_desk/frontdesk_logoff.php" ng-mouseenter="settings.log = false;" class = "anim btn w-100 font-fam-Montserrat-bold btn-sm custom-btn-outline-orange wht mb-2">{{settings.log ? settings.user : 'log out'}}</a>
            </div>
        </div>
    </div>
    <!--statusbar for main-sidebar-right end -->
    <div class="sidebar-body animate-switch-container" ng-switch on="tabnav.selected.name">
        <div ng-switch-when = "Reservation" class = "p-4 whtback hs-100 anim animate-switch">
            <resvtnlist></resvtnlist>
        </div>
        <div ng-switch-when = "Users">
                <div class = "sessions h-100 p-4 w-100">
                    
                <sessionlist></sessionlist>
                </div>
            </div> 
    </div>



</div>
<div class="modal fade" id="crud" role="dialog" modalentry></div>
<!--main-sidebar-right end-->
<div class="clr"></div>
</div>