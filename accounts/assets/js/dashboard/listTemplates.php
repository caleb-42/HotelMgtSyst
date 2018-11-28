
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
