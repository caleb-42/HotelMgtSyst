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
            
            <div class="animate-switch h-100" ng-switch-when="Debts">
                <div class="debts prime-footer anim h-100">
                    <div class="p-3 px-4  itemlayout w-100 h-93">
                        <div class="mb-5 item-container">
                            <div class="userlisthd row justify-content-between">
                                <h4 class=" mt-4 py-2 font-fam-Montserrat-bold">Manage Debts</h4>
                                <div class="mt-4">
                                    <button class="btn btn-success wht opac-70 mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'Debts'; settings.modal.name = 'Pay Debts'; settings.modal.size = 'md';" data-toggle="modal" data-target="#crud" ng-disabled="!debts.jslist.selected">Pay</button>
                                </div>
                            </div>
                            <debtlist class="font-fam-Montserrat"></debtlist>
                        </div>
                    </div>
                </div>
            </div>
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
                            <jslist class="font-fam-Montserrat"></jslist>
                        </div>
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