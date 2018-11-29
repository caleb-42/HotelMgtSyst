<div ng-controller="restaurant">
    <link href="./assets/css/index2.css" rel="stylesheet">   
    <div class="prime-hd anim {{tabnav.selected.options.rightbar ? tabnav.selected.options.rightbar.primeclass : 'w-100'}}">
        <div class="statusbar blu row  align-items-end pl-1">
            <div class="tabnav {{tabnav.selected.options.rightbar ? 'col-12' : 'col-8'}} relatv row">
                <button ng-repeat='nav in tabnav.navs | objtoarray' class="abs  h-100 tabpill btnnone" ng-click="tabnav.selectNav(nav.name)" ng-class="{focus:nav.name == tabnav.selected.name}" style = "left: {{($index * 150) + 20}}px;">
                <h5>{{nav.name}}</h5>
            </button>
            </div>
            <!--tabnav end-->
            <div class="searchbox col-3 h-100 {{tabnav.selected.options.rightbar ? 'gone' : 'col-4'}} row  align-items-end pb-1" >
                <div class="col-8">
                    <input class="form-control float-right anim" ng-model="searchbox.imp" /></div>
                <!-- ng-class="{vanishsearch:searchbox.iconhover}" -->
                <div class="wht text-center col-4 px-0"><a  ng-mouseleave="settings.log = true;" ng-mouseenter="settings.log = false;" href = "../php1/admin/admin_logoff.php" class = "anim btn w-100 font-fam-Montserrat-bold btn-sm custom-btn-outline-orange wht mb-2">{{settings.log ? settings.user : 'log out'}}</a></div>
            </div>

        </div>
        <div class="prime-body {{tabnav.selected.options.rightbar ? '' : 'pr-0'}}">
            <div class="animate-switch-container" ng-switch on="tabnav.selected.name">
                <div class="animate-switch Products px-4 h-100" ng-switch-when = "Products">
                    <div class="prodlisthd row justify-content-between">
                        <h4 class=" my-4 py-2 font-fam-Montserrat-bold">Manage Products</h4>
                        <div class="my-4 row justify-content-between align-items-center">

                        <div class = "stockcrudbtns my-4 mr-4">
                        <button class="btn btn-sm btn-primary mx-1 font-fam-Montserrat f-12" ng-disabled="!productstock.jslist.selected" ng-click="stock.activateStockModal();" data-toggle="{{stock.modal}}" data-target="#crud" >Add Stock</button>
                        </div>

                        <div class = "productcrudbtns my-4 align-items-center ">
                        <button class="btn btn-outline-primary mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'Add Product'; settings.modal.name = 'Add Product'; settings.modal.size = 'md' " data-toggle="modal" data-target="#crud" >Add</button><button class="btn btn-outline-success mx-1 font-fam-Montserrat f-12" data-toggle="modal" data-target="#crud" ng-click="settings.modal.active = 'Update Product'; settings.modal.name = 'Update Product'; settings.modal.size = 'lg'; " ng-disabled="!productstock.jslist.selected">Update</button><button class="btn btn-outline-danger mx-1 font-fam-Montserrat f-12" ng-disabled="!productstock.jslist.selected" ng-click = "productstock.deleteProduct()">Delete</button>
                        </div>

                        </div>
                    </div>
                    <div class="prodlist h-80">
                        <productlist></productlist>
                    </div>
                </div>
                <div class="animate-switch Customers px-4 h-100" ng-switch-when="Customers">
                    <div class="customerslist h-80">
                        <div class="prodlisthd row justify-content-between">
                            <h4 class=" my-4 py-2 font-fam-Montserrat-bold text-center">Manage Customers</h4>
                            
                            <div class="my-4">
                                <button class="btn btn-outline-primary mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'Customers'; settings.modal.name = 'Add Customer'; settings.modal.size = 'md' " data-toggle="modal" data-target="#crud" >Add</button>
                                <button class="btn btn-outline-success mx-1 font-fam-Montserrat f-12" data-toggle="modal" data-target="#crud" ng-click="settings.modal.active = 'Customers'; settings.modal.name = 'Update Customer'; settings.modal.size = 'lg'; " ng-disabled="!customers.jslist.selected || (customers.jslist.selected | limitTo:3) == 'LOD'">Update</button>
                                <button class="btn btn-outline-danger mx-1 font-fam-Montserrat f-12" ng-click="customers.deleteCustomer()"  ng-disabled="!customers.jslist.selected || (customers.jslist.selected | limitTo:3) == 'LOD'">Delete</button>
                            </div>
                        </div>
                        <customerslist></customerslist> 
                        <div class="modal fade" id="crud" role="dialog" modalentry></div>
                    </div>
                </div>
                <div class="animate-switch SalesHistory px-4 h-100" ng-switch-when = "Sales">
                    <div class="prodlisthd row justify-content-center">
                        <h4 class=" my-4 py-2 font-fam-Montserrat-bold text-center">Sales History</h4>
                    </div>
                    <div class="saleshistorylist h-80">
                        <saleshistorylist></saleshistorylist>
                    </div>
                </div>
                <div class="animate-switch StockHistory px-4 h-100" ng-switch-when="Stocks">
                    <div class="prodlisthd row justify-content-center">
                    <h4 class=" my-4 py-2 font-fam-Montserrat-bold text-center">Stock History</h4>
                    </div>
                    <div class="stockhistorylist h-80" >
                         <stockhistorylist></stockhistorylist> 
                    </div>
                </div>
                <div class="animate-switch User px-4 h-100" ng-switch-when = "Users">
                    <div class="userlisthd row justify-content-between">
                        <h4 class=" my-4 py-2 font-fam-Montserrat-bold">Manage Users</h4>
                        <div class="my-4"><button class="btn btn-outline-primary mx-1 font-fam-Montserrat f-12" ng-click="settings.modal.active = 'User'; settings.modal.name = 'Add User'; settings.modal.size = 'md' " data-toggle="modal" data-target="#crud" >Add</button><button class="btn btn-outline-success mx-1 font-fam-Montserrat f-12" data-toggle="modal" data-target="#crud" ng-click="settings.modal.active = 'User'; settings.modal.name = 'Update User'; settings.modal.size = 'lg'; " ng-disabled="!users.jslist.selected">Update</button><button class="btn btn-outline-danger mx-1 font-fam-Montserrat f-12" ng-click="users.deleteUser()"  ng-disabled="!users.jslist.selected">Delete</button></div>
                    </div>
                    <div class="userlist h-80">
                        <restaurantuserlist></restaurantuserlist>
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
        <div class="sidebar-body whtback" ng-switch on="tabnav.selected.name">
            <div ng-switch-when = "Products">
                <div class = "photodetails">
                    <div class = "productpic center"></div>
                </div>
                <div class = "discount text-center">
                    <div class = "row header">
                        <div class = "anim text-center col-6 py-2 pointer font-weight-bold" ng-click = "details.discount.select_discount('item');" ng-class = "{'btn-warning': details.discount.selected_discount == 'item','dark': details.discount.selected_discount != 'item'}">
                            <h6>Item Discount</h6>
                        </div>
                        <div class = "anim text-center col-6 py-2 pointer font-weight-bold" ng-click = "details.discount.select_discount('total');" ng-class = "{'btn-warning': details.discount.selected_discount == 'total','dark': details.discount.selected_discount != 'total'}">
                            <h6>Total Discount</h6>
                        </div>

                    </div>
                    <discountlist class = "discntfade"></discountlist>
                    <div class="row w-100 justify-content-around discntfade">
                    <button class="btn w-40 btn-success f-14" ng-click="settings.modal.active = 'Discount'; settings.modal.name = 'Add Discount'; settings.modal.size = 'md' " data-toggle="modal" data-target="#crud" ng-disabled= "!productstock.jslist.selected && details.discount.selected_discount == 'item'">Add Discount</button>
                    <button class="btn w-40 btn-danger f-14" ng-click="details.discount.deleteDiscount()" ng-disabled= "!details.discount.jslist.selected">Delete Discount</button>
                    </div>
                </div>
            </div>
            <div ng-switch-when = 'Sales'>
                <div class = "sidebar-content p-4 w-100">
                    <listsale></listsale>
                </div>
            </div>
            <div ng-switch-when = "Users">
                <div class = "sessions p-4 w-100">
                    <restaurantsessionlist></restaurantsessionlist>
                </div>
            </div>  
        </div>
    </div>
    <!--main-sidebar-right end-->
    <div class="clr"></div>
    <div class="modal fade" id="crud" role="dialog" modalentry></div>
</div>
