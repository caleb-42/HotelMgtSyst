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
                    <div ng-controller="transactionhistory">
                        <div class="prodlisthd row justify-content-between">
                            <h4 class=" col-4 px-0 my-4 py-2 font-fam-Montserrat-bold text-left">Transaction History</h4>
                            <div class = "col-8 p-0 row justify-content-around">
                                <select ng-change = "transaction.fetchdate()" ng-model = "transaction.table" class="form-control methpay my-4 col-2 f-13" name="means_of_payment">
                                    <option value="frontdesk">Frontdesk</option>
                                    <option value="restaurant">Restaurant</option>
                                    <option value="reservations">Reservation</option>
                                </select>
                                <datepicker date-max-limit = "{{transaction.todate}}" date-format="yyyy-MM-dd" class="ml-5 col-3 my-4 text-center" selector="form-control">
                                    <input class=" clearinput password form-control font-fam-Montserrat text-center d-block"
                                        placeholder="From Date" name="fromdate" 
                                        ng-model = "transaction.fromdate" onkeydown="javascript: return false"/>
                                </datepicker>
                                <datepicker date-min-limit = "{{transaction.fromdate}}" date-format="yyyy-MM-dd" class=" col-3 my-4 text-center" selector="form-control">
                                    <input class=" clearinput password form-control font-fam-Montserrat text-center d-block"
                                        placeholder="To Date" ng-model = "transaction.todate" name="todate"  onkeydown="javascript: return false"/>
                                </datepicker>
                                <div class = "pr-0 py-4 row justify-content-between col-3">
                                    <button ng-click = "transaction.fetchdate()" class = "w-45 f-14 btn  btn-sm btn-info">
                                    Fetch
                                    </button>
                                    <button ng-click = "transaction.todate = null; transaction.fromdate=null;" class = "w-45 f-14 btn  btn-sm purp-back wht opac-70">
                                    Clear
                                    </button>
                                </div>
                                <!-- $filter('intervalGetDate')(-1, new Date().toString()) -->
                            </div>
                        </div>
                        <div class="saleshistorylist h-80 " >
                            <history evt = "transactionslist" script = "list_transactions" list = "frontdesk" listhddata = "transaction.listhddata" itemlist = "transaction.itemlist(range)"></history>
                        </div>
                    </div>
                </div>
                <div class="animate-switch History px-4 h-100" ng-switch-when = "Payments">
                    <div ng-controller="paymentshistory">
                        <div class="prodlisthd row justify-content-center">
                            <h4 class="col-4 my-4 py-2 font-fam-Montserrat-bold text-left px-0">Payment History</h4>
                            
                            <div class = "col-8 p-0 row justify-content-around">
                                <select ng-change = "payment.fetchdate()" ng-model = "payment.table" class="form-control methpay my-4 col-2 f-13" name="means_of_payment">
                                    <option value="frontdesk">Frontdesk</option>
                                    <option value="restaurant">Restaurant</option>
                                </select>
                                <datepicker date-max-limit = "{{payment.todate}}" date-format="yyyy-MM-dd" class="ml-5  col-3 my-4 text-center" selector="form-control">
                                    <input class=" clearinput password form-control font-fam-Montserrat text-center d-block"
                                        placeholder="From Date" name="fromdate" 
                                        ng-model = "payment.fromdate" onkeydown="javascript: return false"/>
                                </datepicker>
                                <datepicker date-min-limit = "{{payment.fromdate}}" date-format="yyyy-MM-dd" class=" col-3 my-4 text-center" selector="form-control">
                                    <input class=" clearinput password form-control font-fam-Montserrat text-center d-block"
                                        placeholder="To Date" ng-model = "payment.todate" name="todate"  onkeydown="javascript: return false"/>
                                </datepicker>
                                <div class = "pr-0 py-4 row justify-content-between col-3">
                                    <button ng-click = "payment.fetchdate()" class = "w-45 f-14 btn  btn-sm btn-info">
                                    Fetch
                                    </button>
                                    <button ng-click = "payment.todate = null; payment.fromdate=null;" class = "w-45 f-14 btn  btn-sm purp-back wht opac-70">
                                    Clear
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="saleshistorylist h-80 " >
                            <history evt = "paymentslist" script = "list_revenues" list = "frontdesk" listhddata = "payment.listhddata" itemlist = "payment.itemlist(range)"></history>
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
