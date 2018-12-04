<div ng-controller="accounts"> <!-- {{tabnav.selected == 'Customers' ? null : 'w-100'}} -->
    <div class="prime-hd anim {{tabnav.selected.options.rightbar ? tabnav.selected.options.rightbar.primeclass : 'w-100'}}">
        <div class="statusbar blu row  align-items-end pl-1">
            <div class="tabnav {{tabnav.selected.options.rightbar ? 'col-12' : 'col-8'}} relatv row">
                <button ng-repeat='nav in tabnav.navs | objtoarray' class="abs h-100 tabpill btnnone" ng-click="tabnav.selectNav(nav.name)" ng-class="{focus:nav.name == tabnav.selected.name}" style = "left: {{($index * 150) + 20}}px;">
                <h5>{{nav.name}}</h5>
            </button>
            </div>
            <!--tabnav end-->
            <div class="searchbox col-3 h-100  {{tabnav.selected.options.rightbar ? 'gone' : 'col-4'}} row  align-items-end pb-1">
            <div class="col-8">
                    <input class="form-control float-right anim" ng-model="searchbox.imp" /></div>
                <!-- ng-class="{vanishsearch:searchbox.iconhover}" -->
                <div class="wht text-center col-4 px-0"><a  ng-mouseleave="settings.log = true;" ng-mouseenter="settings.log = false;" href = "../php1/admin/admin_logoff.php" class = "anim btn w-100 font-fam-Montserrat-bold btn-sm custom-btn-outline-orange wht mb-2">{{settings.log ? settings.user : 'log out'}}</a></div>
            </div>

        </div>
        <div class="prime-body {{tabnav.selected.options.rightbar ? null : 'px-0'}}">
                <div class="animate-switch-container" ng-switch on="tabnav.selected.name">
                <div class="animate-switch Expenses h-100" ng-switch-when = "Expenses">
                    <div class="expenses prime-footer anim h-100">
                        <div class="p-3 px-4 itemlayout w-100 h-93">
                            <div class="mb-5 item-container">
                                <div class="userlisthd row justify-content-between">
                                    <h4 class=" my-4 col-4 py-2 font-fam-Montserrat-bold">Manage Expenses</h4>
                                    <div class="col-8 p-0 row justify-content-around">
                                        <datepicker date-max-limit = "{{expenses.todate}}" date-format="yyyy-MM-dd" class=" col-4 my-4 text-center" selector="form-control">
                                        <input class=" clearinput password form-control font-fam-Montserrat text-center d-block"
                                        placeholder="From Date" name="fromdate" 
                                        ng-model = "expenses.fromdate" onkeydown="javascript: return false"/>
                                        </datepicker>
                                        <datepicker date-min-limit = "{{expenses.fromdate}}" date-format="yyyy-MM-dd" class=" col-4 my-4 text-center" selector="form-control">
                                            <input class=" clearinput password form-control font-fam-Montserrat text-center d-block"
                                                placeholder="To Date" ng-model = "expenses.todate" name="todate"  onkeydown="javascript: return false"/>
                                        </datepicker>
                                        <div class = "pr-0 py-4 row justify-content-between col-4">
                                            <button ng-click = "expenses.fetchdate()" class = "w-30 f-14 btn  btn-sm btn-info">
                                            Fetch
                                            </button>
                                            <button ng-click = "expenses.todate = null; expenses.fromdate=null;" class = "w-30 f-14 btn  btn-sm purp-back wht opac-70">
                                            Clear
                                            </button>
                                            <!-- <button class="btn btn-info mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'Expenses'; settings.modal.name = 'Add Expenses'; settings.modal.size = 'md';" data-toggle="modal" data-target="#crud">Add</button> -->
                                            <button class="w-30 btn  btn-sm btn-danger" ng-click="expenses.deleteExpenses()" ng-disabled="!expenses.jslist.selected">Delete</button>
                                        </div>
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
                        <div class="my-4">
                        <button class="btn btn-outline-primary mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'User'; settings.modal.name = 'Add User'; settings.modal.size = 'md' " data-toggle="modal" data-target="#crud" >Add</button>
                        <button class="btn btn-outline-success mx-1 font-fam-Montserrat f-12" data-toggle="modal" data-target="#crud" ng-click="settings.modal.active = 'User'; settings.modal.name = 'Update User'; settings.modal.size = 'lg'; " ng-disabled="!users.jslist.selected">Update</button><button class="btn btn-outline-danger mx-1 font-fam-Montserrat f-12" ng-click="users.deleteUser()"  ng-disabled="!users.jslist.selected">Delete</button></div>
                    </div>
                    <div class="userlist h-80">
                        <accountsuserlist></accountsuserlist>
                    </div>
                </div>
                
                <div class="animate-switch h-100" ng-switch-when="Debts">
                    <div class="debts prime-footer anim h-100">
                        <div class="p-3 px-4  itemlayout w-100 h-93">
                            <div class="mb-5 item-container">
                                <div class="userlisthd row justify-content-between">
                                    <h4 class=" mt-4 py-2 font-fam-Montserrat-bold">Manage Debts</h4>
                                    <div class="mt-4">
                                        <!-- <button class="btn btn-success wht opac-70 mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'Debts'; settings.modal.name = 'Pay Debts'; settings.modal.size = 'md';" data-toggle="modal" data-target="#crud" ng-disabled="!debts.jslist.selected">Pay</button> -->
                                    </div>
                                </div>
                                <debtlist class="font-fam-Montserrat"></debtlist>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="animate-switch History px-4 h-100" ng-switch-when = "Transactions">
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
                <div class="animate-switch History px-4 h-100" ng-switch-when = "Payments">
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
    <!--statusbar for primehd end--><!-- {{tabnav.selected == 'Customers' ? null : 'w-0 gone'}} -->
    <div class="main-sidebar-right hs-100 whtback anim {{tabnav.selected.options.rightbar ? tabnav.selected.options.rightbar.rightbarclass : 'w-0 vanish'}}">
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
        <div class="sidebar-body" ng-switch on="tabnav.selected.name">
            <div ng-switch-whwn = "Users">
                <div class = "sessions h-100 p-4 w-100">
                    <accountssessionlist></accountssessionlist>
                </div>
            </div>       
        </div>
    </div>
    <div class="modal fade" id="crud" role="dialog" modalentry></div>
    <!--main-sidebar-right end-->
    <div class="clr"></div>
</div>
