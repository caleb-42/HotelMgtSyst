<div ng-if = "<?php echo $_GET['list']   == 'stock'?>" class = "listcont">
    <div  class = "listhd pr-3 row">
        <span class="{{hd.width}}"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in productstock.listhddata">{{hd.name}}</span>
    </div>
    <div class = "hs-60 listbody ovflo-y pb-4" >
        <ul class = "list" >
            <li class = "anim-fast itemlistrow row align-items-center f-12" ng-repeat = "items in (productstock.jslist.newItemArray = (productstock.jslist.values | filter:{'item' : searchbox.imp}:strict))" ng-click = "productstock.jslist.select($index, items.id); details.discount.jslist.createList()" ng-class = "{'actparent' :productstock.jslist.selected == items.id}">
                <span class = "itemname col-2">{{items.item}}</span>
                <span class = "text-center stkleft col-1">{{items.current_stock}}</span>
                <span class = "text-center itemcost col-1">{{items.current_price}}</span>
                <span class = "text-center description col-2">{{items.description}}</span>
                <span class = "text-center category col-2">{{items.category}}</span>
                <span class = "text-center type col-2">{{items.type}}</span>
                <span class = "text-center shelfitem col-2">{{items.shelf_item}}</span>
            </li>
        </ul>
    </div>
</div>

<div  ng-if = "<?php echo $_GET['list'] == 'discount'?>"  ng-switch on = "details.discount.selected_discount" class = "w-100 h-70 ovflo-y mb-2 discountlist">

    <div ng-switch-when = "item" class = "w-100 ">

        <ul ng-if = "productstock.jslist.selectedObj">
            <li class = "row w-100 b-1 py-4 px-3" ng-class = "{'btn-lytgrn': details.discount.jslist.selected == discnt.id}" ng-repeat="discnt in details.discount.jslist.values">
                <div class = "col-4"><div class = "center text-center btn-info" ng-click="settings.modal.active = 'Discount'; settings.modal.name = 'Update Discount'; settings.modal.size = 'md';details.discount.jslist.select($index, discnt.id); " data-toggle="modal" data-target="#crud"><h4 class = "py-2 m-0">{{discnt.discount_value}}%</h4></div></div>
                <div class = "col-8 text-right dark pr-4 "><div ng-click = "details.discount.jslist.select($index, discnt.id);"><h5 class = "font-weight-bold">{{discnt.discount_name}}</h5><p class = "w-100 f-14 m-0">{{discnt.lower_limit | nairacurrency}} - {{discnt.upper_limit | nairacurrency}}</p></div></div>
            </li>
        </ul>
        <h4 class = "center w-100 opac-50" ng-if = "!productstock.jslist.selectedObj"> Select an item</h4>
    </div>
    <div ng-switch-when = "total">
        <ul>
            <li class = "row w-100 b-1 py-4 px-3" ng-class = "{'btn-lytgrn': details.discount.jslist.selected == discnt.id}" ng-repeat="discnt in details.discount.jslist.values" >
                <div class = "col-4">
                    <div class = "center text-center btn-info"  ng-click="settings.modal.active = 'Discount'; settings.modal.name = 'Update Discount'; settings.modal.size = 'md';details.discount.jslist.select($index, discnt.id); " data-toggle="modal" data-target="#crud">
                        <h4 class = "py-2 m-0">{{discnt.discount_value}}%</h4>
                    </div>
                </div>
                <div class = "col-8 text-right dark pr-4 ">
                    <div ng-click = "details.discount.jslist.select($index, discnt.id);">
                        <h5 class = "font-weight-bold">{{discnt.discount_name}}</h5>
                        <p class = "w-100 f-14 m-0">{{discnt.lower_limit | nairacurrency}} - {{discnt.upper_limit | nairacurrency}}</p>
                    </div>
                </div>
            </li>
        </ul>
    </div>

</div>


<div ng-if = "<?php echo $_GET['list']   == 'customers'?>">
    <div class = "listcont hs-100">
            <div class = "listhd pr-3 row">
                <span class="{{hd.width}}"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in customers.listhddata">{{hd.name}}</span>
            </div>
            <div class = "hs-70 listbody ovflo-y pb-4" ><ul class = "list" >
                <li class = "itemlistrow row align-items-center f-12" ng-repeat = "hist in (customers.jslist.newItemArray = (customers.jslist.values | filter:searchbox.imp))" ng-click = "customers.jslist.select($index, hist.customer_id);" ng-class = "{'actparent' : customers.jslist.selected == hist.customer_id}">
                    <span class = "text-left custid {{customers.listhddata[0].width}}">{{hist.customer_id}}</span>
                    <span class = "text-center fname {{customers.listhddata[1].width}}">{{hist.full_name}}</span>
                    <span class = "text-center phone {{customers.listhddata[2].width}}">{{hist.phone_number}}</span>
                    <span class = "text-center address {{customers.listhddata[3].width}}">{{hist.contact_address}}</span>
                    <span class = "text-center gender {{customers.listhddata[4].width}}">{{hist.gender}}</span>
                    <span class = "text-center outbal {{customers.listhddata[5].width}}">{{hist.outstanding_balance}}</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class = "listcont h-100" ng-if = "<?php echo $_GET['list']   == 'sales'?>">
    <div class = "listhd pr-3 row">
        <span class="{{hd.width}}"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in salesHistory.listhddata ">{{hd.name}}</span>
    </div>
    <div class = "h-80 listbody ovflo-y pb-4" >
        <ul class = "list" >
            <li class = "itemlistrow row align-items-center f-12" ng-repeat = "hist in (salesHistory.jslist.newItemArray = (salesHistory.jslist.values | filter:searchbox.imp))" ng-click = "salesHistory.jslist.select($index, hist.txn_ref)" ng-class = "{'actparent' : salesHistory.jslist.selected == hist.txn_ref}">
                <span class = "custref col-1">{{hist.txn_ref}}</span>
                <span class = "text-center paymeth col-2">{{hist.pay_method}}</span>
                <span class = "text-center items col-1">{{hist.total_items}}</span>
                <span class = "text-center cost col-1">{{hist.total_cost}}</span>
                <span class = "text-center discost col-1">{{hist.discounted_total_cost}}</span>
                <span class = "text-center discnt col-1">{{hist.transaction_discount}}</span>
                <span class = "text-center deposit col-2">{{hist.deposited}}</span>
                <span class = "text-center bal col-1">{{hist.balance}}</span>
                <span class = "text-center status col-2">{{hist.payment_status}}</span>
            </li>
        </ul>
    </div>
</div>

<div ng-if = "<?php echo $_GET['list']   == 'tranxsales'?>">
    <div class = "row hs-80 {{listsales.jslist.active ? 'gone' : 'align-items-center'}} relatv ">
        <h4 class=" text-center w-100 "> Select A Transaction</h4>
    </div>
    <div class = "listcont {{!listsales.jslist.active ? 'gone' : 'notgone'}}">
        <div class = "orange font-fam-Montserrat-bold row p-2 justify-content-between w-100" style = "border-radius: 5px; margin : 10px 0 !important;">
            <span>Sales Rep</span>
            <span>{{listsales.jslist.tranx.sales_rep}}</span>
        </div>
        <div class = "orange font-fam-Montserrat-bold row p-2 justify-content-between w-100" style = "border-radius: 5px; margin : 10px 0 !important;">
            <span>Tranx Time</span>
            <span>{{listsales.jslist.tranx.txn_time}}</span>
        </div>
        <div class = "orange font-fam-Montserrat-bold row p-2 justify-content-between w-100" style = "border-radius: 5px; margin : 10px 0 20px !important;">
            <span>Customer Ref</span>
            <span>{{listsales.jslist.tranx.customer_ref}}</span>
        </div>
        <div class = "listhd pr-3 row">
            <span class="{{hd.width}}"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in listsales.listhddata">{{hd.name}}</span>
        </div>
        <div class = "hs-40 listbody ovflo-y pb-4" >
            <ul class = "list" >
                <li class = "itemlistrow row align-items-center f-12" ng-repeat = "sales in listsales.jslist.values">
                    <span class = "item col-3">{{sales.item}}</span>
                    <span class = "text-center login col-1">{{sales.quantity}}</span>
                    <span class = "text-center login col-2">{{sales.unit_cost}}</span>
                    <span class = "text-center login col-2">{{sales.net_cost}}</span>
                    <span class = "text-center login col-2">{{sales.discount_amount}}</span>
                    <span class = "text-center logoff col-1">{{sales.discount_rate}}</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class = "listcont h-100" ng-if = "<?php echo $_GET['list']   == 'stocks'?>">
    <div class = "listhd pr-3 row">
        <span class="{{hd.width}}"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in stockHistory.listhddata">{{hd.name}}</span>
    </div>
    <div class = "h-80 listbody ovflo-y pb-4" >
        <ul class = "list" >
            <li class = "itemlistrow row align-items-center f-12" ng-repeat = "hist in (stockHistory.jslist.newItemArray = (stockHistory.jslist.values | filter:searchbox.imp))">
                <span class = "text-left tranxref col-2">{{hist.txn_ref}}</span>
                <span class = "text-center item col-1">{{hist.item}}</span>
                <span class = "text-center prevstk col-2">{{hist.prev_stock}}</span>
                <span class = "text-center qty col-1">{{hist.quantity}}</span>
                <span class = "text-center newstk col-2">{{hist.new_stock}}</span>
                <span class = "text-center cat col-2">{{hist.category}}</span>
                <span class = "text-center tranxdate col-2">{{hist.txn_date}}</span>
            </li>
        </ul>
    </div>
</div>


<div class = "listcont" ng-if = "<?php echo $_GET['list']   == 'users'?>">
    <div class = "listhd pr-3 row">
        <span class="{{hd.width}}"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in users.listhddata">{{hd.name}}</span>
    </div>
    <div class = "hs-60 listbody ovflo-y pb-4" >
        <ul class = "list" >
            <li class = "anim-fast itemlistrow row align-items-center f-12" ng-repeat = "items in (users.jslist.newItemArray = (users.jslist.values | filter:searchbox.imp))" ng-click = "users.jslist.select($index, items.id)" ng-class = "{'actparent' :users.jslist.selected == items.id}">
                <span class = "username col-6">{{items.user_name}}</span>
                <span class = "text-center role col-6">{{items.role}}</span>
            </li>
        </ul>
    </div>
</div>

<div ng-if = "<?php echo $_GET['list']   == 'sessions'?>">
    <div class = "row hs-85 {{users.jslist.selected ? 'gone' : 'align-items-center'}} relatv ">
        <h4 class=" text-center w-100 "> Select A User</h4>
    </div>
    <div class = "listcont {{!users.jslist.selected ? 'gone' : 'notgone'}}">
        <div class = "listhd pr-3 row">
            <span class="{{hd.width}}"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in sessions.listhddata">{{hd.name}}</span>
        </div>
        <div class = "hs-70 listbody ovflo-y pb-4" >
            <ul class = "list" >
                <li class = "itemlistrow row align-items-center f-12" ng-repeat = "session in sessions.jslist.values">
                    <span class = "username col-4">{{session.user_name}}</span>
                    <span class = "text-center login col-4">{{session.logged_on_time}}</span>
                    <span class = "text-center logoff col-4">{{session.logged_off_time}}</span>
                </li>
            </ul>
        </div>
    </div>
</div>