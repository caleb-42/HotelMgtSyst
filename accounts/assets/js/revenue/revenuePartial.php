<div ng-controller="revenue" > <!-- {{tabnav.selected == 'Customers' ? null : 'w-100'}} -->
    <div class="prime-hd anim {{tabnav.selected.options.rightbar ? tabnav.selected.options.rightbar.primeclass : 'w-100'}}">
        <div class="statusbar darkred row  align-items-end pl-1">
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
                <div class="wht text-center col-4 px-0"><a  ng-mouseleave="settings.log = true;" ng-mouseenter="settings.log = false;" href = "../php1/accounts/account_logoff.php" class = "anim btn w-100 font-fam-Montserrat-bold btn-sm custom-btn-outline-orange wht mb-2">{{settings.log ? settings.user : 'log out'}}</a></div>
            </div>

        </div>
        <div class="prime-body {{tabnav.selected.options.rightbar ? null : 'px-0'}}">
            <div class="animate-switch-container" ng-switch on="tabnav.selected.name">
                <div class="animate-switch History px-4 h-100" ng-switch-default>
                    <div ng-controller="frontdeskhistory">
                        <div class="prodlisthd row justify-content-between">
                            <h4 class=" col-6 px-0 my-4 py-2 font-fam-Montserrat-bold text-left">Payment History</h4>
                            <div class = "col-6 p-0 row justify-content-around">
                                <datepicker date-max-limit = "{{frontdesk.todate}}" date-format="yyyy-MM-dd" class="col-4 my-4 text-center" selector="form-control">
                                    <input class=" clearinput password form-control font-fam-Montserrat text-center d-block"
                                        placeholder="From Date" name="fromdate" 
                                        ng-model = "frontdesk.fromdate" onkeydown="javascript: return false"/>
                                </datepicker>
                                <datepicker date-min-limit = "{{frontdesk.fromdate}}" date-format="yyyy-MM-dd" class=" col-4 my-4 text-center" selector="form-control">
                                    <input class=" clearinput password form-control font-fam-Montserrat text-center d-block"
                                        placeholder="To Date" ng-model = "frontdesk.todate" name="todate"  onkeydown="javascript: return false"/>
                                </datepicker>
                                <div class = "pr-0 py-4 row justify-content-between col-4">
                                    <button ng-click = "frontdesk.fetchdate()" class = "w-45 f-14 btn  btn-sm btn-info">
                                    Fetch
                                    </button>
                                    <button ng-click = "frontdesk.todate = null; frontdesk.fromdate=null;" class = "w-45 f-14 btn  btn-sm purp-back wht opac-70">
                                    Clear
                                    </button>
                                </div>
                                <!-- $filter('intervalGetDate')(-1, new Date().toString()) -->
                            </div>
                        </div>
                        <div class="saleshistorylist h-80 " >
                            <history evt = "frontdesklist" list = "frontdesk" listhddata = "frontdesk.listhddata" itemlist = "frontdesk.itemlist(range)"></history>
                        </div>
                    </div>
                </div>
                <div class="animate-switch History px-4 h-100" ng-switch-when = "Restaurant">
                    <div ng-controller="restauranthistory">
                        <div class="prodlisthd row justify-content-center">
                            <h4 class="col-6 my-4 py-2 font-fam-Montserrat-bold text-left px-0">Payment History</h4>
                            
                            <div class = "col-6 p-0 row justify-content-around">
                                <datepicker date-max-limit = "{{restaurant.todate}}" date-format="yyyy-MM-dd" class="col-4 my-4 text-center" selector="form-control">
                                    <input class=" clearinput password form-control font-fam-Montserrat text-center d-block"
                                        placeholder="From Date" name="fromdate" 
                                        ng-model = "restaurant.fromdate" onkeydown="javascript: return false"/>
                                </datepicker>
                                <datepicker date-min-limit = "{{restaurant.fromdate}}" date-format="yyyy-MM-dd" class=" col-4 my-4 text-center" selector="form-control">
                                    <input class=" clearinput password form-control font-fam-Montserrat text-center d-block"
                                        placeholder="To Date" ng-model = "restaurant.todate" name="todate"  onkeydown="javascript: return false"/>
                                </datepicker>
                                <div class = "pr-0 py-4 row justify-content-between col-4">
                                    <button ng-click = "restaurant.fetchdate()" class = "w-45 f-14 btn  btn-sm btn-info">
                                    Fetch
                                    </button>
                                    <button ng-click = "restaurant.todate = null; restaurant.fromdate=null;" class = "w-45 f-14 btn  btn-sm purp-back wht opac-70">
                                    Clear
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="saleshistorylist h-80 " >
                            <history evt = "restaurantlist" list = "restaurant" listhddata = "restaurant.listhddata" itemlist = "restaurant.itemlist(range)"></history>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--statusbar for primehd end--><!-- {{tabnav.selected == 'Customers' ? null : 'w-0 gone'}} -->
    <div class="main-sidebar-right hs-100 whtback anim {{tabnav.selected.options.rightbar ? tabnav.selected.options.rightbar.rightbarclass : 'w-0 gone'}}">
        <div class="statusbar darkred row align-items-end justify-content-center">
            <h4 class="text-center wht">{{tabnav.selected.name == 'Customers' ? 'Bookings Tranx' : 'Bookings List'}} <i class="fa fa-book"></i></h4>
        </div>
        <!--statusbar for main-sidebar-right end -->
        <div class="sidebar-body" ng-switch on="tabnav.selected.name">
            <div ng-switch-when = 'Bookings'>
                <div class = "sidebar-content p-4 w-100">
                   
                </div>
            </div>            
            <div ng-switch-when = 'Guest'>
                <div class = "sidebar-content p-4 w-100">
                    
                </div>
            </div>            
        </div>
    </div>
    <!--main-sidebar-right end-->
    <div class="clr"></div>
</div>
