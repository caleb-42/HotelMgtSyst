<div ng-controller="dashboard">
<div class="prime-hd anim  {{tabnav.selected.options.rightbar ? tabnav.selected.options.rightbar.primeclass : 'w-100'}}">
    <div class="statusbar darkred row  align-items-end pl-1">
        <div class="tabnav col-8 row">
            <button ng-repeat='nav in tabnav.navs | objtoarray' class="tabpill btnnone" ng-click="tabnav.selectNav(nav.name)" ng-class="{focus:nav.name == tabnav.selected.name}">
                <h5>{{nav.name}}</h5>
            </button>
        </div>
        <div class="searchbox col-4 h-100  {{tabnav.selected.options.rightbar ? 'gone' : ''}} row  align-items-end pb-1">
                <div class="col-8">
                    <input class="form-control float-right anim" ng-model="searchbox.imp" />
                </div>
                <div class="wht text-center col-4 px-0"><a  ng-mouseleave="settings.log = true;" href = "../php1/accounts/account_logoff.php" ng-mouseenter="settings.log = false;" class = "anim btn w-100 font-fam-Montserrat-bold btn-sm custom-btn-outline-orange wht mb-2">{{settings.log ? settings.user : 'log out'}}</a>
            </div>
        </div>
        <!--tabnav end-->
        

    </div>
    <!--statusbar for primehd end-->

    <div class="prime-body {{tabnav.selected.options.rightbar ? '' : 'p-0'}}">
        <div class="animate-switch-container" ng-switch on="tabnav.selected.name">
            
            <div class="animate-switch h-100" ng-switch-when="Revenue">
                <div class="guests prime-footer anim h-80">
                    <div class=" itemlayout w-100 h-93">
                        <div class="mb-5 item-container">
                            <div class="userlisthd row justify-content-between px-4">
                                <h4 class=" mt-4 py-2 font-fam-Montserrat-bold">Manage Rooms</h4>
                                <div class="mt-4">
                                    <!-- <button class="btn btn-outline-success mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'Reservation';settings.modal.name = 'Add Reservation'; settings.modal.size = 'lg';rooms.roomgrid.getrooms(['deluxe','standard']);  guest.getguest({value : 'guest_name'});" data-toggle="modal" data-target="#crud">Add Reservation</button> -->
                                </div>
                            </div>
                                <!-- <revenuelist class="font-fam-Montserrat"></revenuelist -->>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center anim py-3 px-2 h-20 relatv">

                    <!-- <div class = "row w-100">
                        <h6 class = "text-left f-14 col-4 font-fam-Montserrat-bold purp-clr opac-70 br-1 m-0 pb-3 px-3">Current Guest</h6>
                        <p class = " col-8 f-13 opac-70 m-0 pb-2 px-3">{{rooms.current_guest.guest_name}} </p>
                        <h6 class = "text-left f-14 col-4 font-fam-Montserrat-bold purp-clr opac-70 pb-3 br-1 m-0 px-3">Phone Number</h6>
                        <p class = " col-8 f-13 opac-70 m-0 pb-2 px-3">{{rooms.current_guest.phone_number}} </p>
                        <h6 class = "text-left f-14 col-4 font-fam-Montserrat-bold purp-clr opac-70 pb-3 br-1 m-0 px-3">Room Outstanding</h6>
                        <p class = "  col-8  f-13 opac-70 m-0 pb-2 px-3">{{rooms.current_guest.room_outstanding}} </p>
                    </div> -->

                </div>
            </div>
            <div class="animate-switch Guests h-100" ng-switch-when = "Expenses">
                <div class="guests  prime-footer anim h-80">
                    <div class="p-3 px-4 itemlayout w-100 h-93">
                        <div class="mb-5 item-container">
                            <div class="userlisthd row justify-content-between">
                                <h4 class=" my-4 py-2 font-fam-Montserrat-bold">Manage Expenses</h4>
                                <div class="my-4">
                                    <button class="btn btn-info mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'Expenses'; settings.modal.name = 'Add Expenses'; settings.modal.size = 'md';" data-toggle="modal" data-target="#crud">Add</button>
                                    <button class="btn  purp-back wht opac-50 mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'Expenses'; settings.modal.name = 'Update Expenses'; settings.modal.size = 'md';" data-toggle="modal" data-target="#crud" ng-disabled="!expenses.jslist.selected">Update</button>
                                    <button class="btn btn-success wht opac-70 mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'Expenses'; settings.modal.name = 'Pay Expense'; settings.modal.size = 'md';" data-toggle="modal" data-target="#crud" ng-disabled="!expenses.jslist.selected">Pay</button>
                                </div>
                            </div>
                            <jslist class="font-fam-Montserrat"></jslist>
                        </div>
                    </div>
                </div>
                <div class="orders row align-items-center anim px-2 h-20">

                    <div class = "row w-100">
                        <!-- <h6 class = "text-left f-14 col-4 font-fam-Montserrat-bold purp-clr opac-70 py-1 br-1 m-0 py-1 px-3">Rooms</h6>
                        <p class = " col-8 f-13 opac-70 m-0 py-1 px-3">{{guest.jslist.selectedObj ? (guest.jslist.selectedObj.rooms | arraytostring) : '2, 4, 7'}} </p>
                        <h6 class = "text-left f-14 col-4 font-fam-Montserrat-bold purp-clr opac-70 py-1 br-1 m-0 py-1 px-3">Phone Number</h6>
                        <p class = " col-8 f-13 opac-70 m-0 py-1 px-3">{{guest.jslist.selectedObj ? guest.jslist.selectedObj.phone_number : '08130439102'}} </p>
                        <h6 class = "text-left f-14 col-4 font-fam-Montserrat-bold purp-clr opac-70 py-1 br-1 m-0 py-1 px-3">Address</h6>
                        <p class = "  col-8  f-13 opac-70 m-0 py-1 px-3">{{guest.jslist.selectedObj ? guest.jslist.selectedObj.contact_address : 'Conversion of Architectural Blueprints to well-designed Structural layouts (foundaton, beams, columns and bases, slabs'}} </p> -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!--primehd end-->

<div class="main-sidebar-right hs-100 anim {{tabnav.selected.options.rightbar ? tabnav.selected.options.rightbar.rightbarclass : 'w-0 vanish'}}">
    <div class="statusbar darkred row align-items-end justify-content-center">
        <div class="searchbox col-12 h-100 row  align-items-end pb-1 {{tabnav.selected.options.rightbar ? '' : 'gone'}}">
                <div class="col-8">
                    <input class="form-control float-right anim" ng-model="searchbox.imp" />
                </div>
                <div class="wht text-center col-4 px-0"><a  ng-mouseleave="settings.log = true;" href = "../php1/accounts/account_logoff.php" ng-mouseenter="settings.log = false;" class = "anim btn w-100 font-fam-Montserrat-bold btn-sm custom-btn-outline-orange wht mb-2">{{settings.log ? settings.user : 'log out'}}</a>
            </div>
        </div>
    </div>
    <!--statusbar for main-sidebar-right end -->
    <div class="sidebar-body animate-switch-container" ng-switch on="tabnav.selected.name">
        <div ng-switch-when = "Expenses" class = " whtback hs-100 anim animate-switch">
            <!--<ordersgrid list = "sales.order.list"></ordersgrid>-->
            
        </div>
        <div ng-switch-when = "Revenue" class = " whtback hs-100 anim animate-switch">
            <!--<ordersgrid list = "sales.order.list"></ordersgrid>-->
           
        </div>
    </div>



</div>
<div class="modal fade" id="crud" role="dialog" modalentry></div>
<!--main-sidebar-right end-->
<div class="clr"></div>
</div>