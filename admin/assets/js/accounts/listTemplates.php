<!-- ............jslist start ..............-->
<div class = "listcont" ng-if = "<?php echo $_GET['list']   == 'expenses'?>">
    <div class = "listhd pr-3 row font-fam-Montserrat-bold">
        <span class="{{hd.width}} f-13 opac-70"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in expenses.listhddata">{{hd.name}}</span>
    </div>
    <div class = "hs-40 listbody ovflo-y pb-4" >
        <ul class = "list" >
            <li class = "anim-fast itemlistrow row align-items-center f-12" ng-repeat = "exp in (expenses.jslist.newItemArray = (expenses.jslist.values | filter:searchbox.imp))" ng-click = "expenses.jslist.select($index, exp.expense_ref)" ng-class = "{'actparent' :expenses.jslist.selected == exp.expense_ref}">
                <span class = "username col-3">{{exp.expense}}</span>
                <span class = "text-center role col-2">{{exp.expense_description}}</span>
                <span class = "text-center role col-2">{{exp.expense_cost}}</span>
                <span class = "text-center role col-2">{{exp.amount_paid}}</span>
                <span class = "text-center role col-3">{{exp.balance}}</span>
            </li>
        </ul>
    </div>
</div>
<!-- ............jslist start ..............-->

<!-- ............jslist start ..............-->
<div class = "listcont" ng-if = "<?php echo $_GET['list']   == 'debts'?>">
    <div class = "listhd pr-3 row font-fam-Montserrat-bold">
        <span class="{{hd.width}} f-13 opac-70"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in debts.listhddata">{{hd.name}}</span>
    </div>
    <div class = "hs-40 listbody ovflo-y pb-4" >
        <ul class = "list" >
            <li class = "anim-fast itemlistrow row align-items-center f-12" ng-repeat = "deb in (debts.jslist.newItemArray = (debts.jslist.values | filter:searchbox.imp))" ng-click = "debts.jslist.select($index, deb.expense_ref)" ng-class = "{'actparent' :debts.jslist.selected == deb.expense_ref}">
                <span class = "username col-3">{{deb.expense}}</span>
                <span class = "text-center role col-2">{{deb.expense_description}}</span>
                <span class = "text-center role col-2">{{deb.expense_cost}}</span>
                <span class = "text-center role col-2">{{deb.amount_paid}}</span>
                <span class = "text-center role col-3">{{deb.balance}}</span>
            </li>
        </ul>
    </div>
</div>
<!-- ............jslist start ..............-->


<div class = "listcont" ng-if = "<?php echo $_GET['list']   == 'users'?>">
    <div class = "listhd row font-fam-Montserrat-bold">
        <span class="{{hd.width}} f-13 opac-70"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in users.listhddata">{{hd.name}}</span>
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

<div ng-if = "<?php echo $_GET['list'] == 'sessions'?>">
    <div class = "row hs-80 {{users.jslist.selected ? 'gone' : 'align-items-center'}} relatv ">
        <h4 class=" text-center w-100 "> Select A User</h4>
    </div>
    <div class = "listcont {{!users.jslist.selected ? 'gone' : 'notgone'}}">
        <div class = "listhd pr-3 row font-fam-Montserrat-bold">
            <span class="{{hd.width}} f-13 opac-70"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in sessions.listhddata">{{hd.name}}</span>
        </div>
        <div class = "hs-70 listbody ovflo-y pb-4" >
            <ul class = "list" >
                <li class = "itemlistrow row align-items-center f-12" ng-repeat = "session in sessions.jslist.values">
                    <span class = " login col-6">{{session.logged_on_time}}</span>
                    <span class = "text-center logoff col-6">{{session.logged_off_time}}</span>
                </li>
            </ul>
        </div>
    </div>
</div>


<div class = "listcont h-100" ng-if = "<?php echo $_GET['list']   == 'frontdesk'?>">
    <div class = "listhd pr-3 row font-fam-Montserrat-bold">
        <span class="{{hd.width}} f-13 opac-70"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in listhddata ">{{hd.name}}</span>
    </div>
    <div class = "h-80 listbody ovflo-y pb-4" >
        <ul>
            <li class = "itemlistrow row align-items-center f-12" ng-repeat = "hist in (jslist.newItemArray = (jslist.values | filter:searchbox.imp))">
                <span  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in listhddata" class = " paymeth {{hd.width}}">{{hist[hd.body]}}</span>
            </li>
        </ul>
    </div>
</div>


