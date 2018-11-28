
<div class = "listcont h-100" ng-if = "<?php echo $_GET['list']   == 'frontdesk'?>">
    <div class = "listhd pr-3 row font-fam-Montserrat-bold">
        <span class="{{hd.width}} f-13 opac-70"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in listhddata ">{{hd.name}}</span>
    </div>
    <div class = "h-80 listbody ovflo-y pb-4" >
        <ul>
            <li class = "itemlistrow row align-items-center f-12" ng-repeat = "hist in (jslist.newItemArray = (jslist.values | filter:searchbox.imp))">
                <span class = "text-center paymeth col-1">{{hist.txn_id}}</span>
                <span class = "text-center paymeth col-2">{{hist.txn_date}}</span>
                <span class = "text-center paymeth col-1">{{hist.amount_paid}}</span>
                <span class = "text-center paymeth col-2">{{hist.date_of_payment}}</span>
                <span class = "text-center paymeth col-1">{{hist.amount_balance}}</span>
                <span class = "text-center items col-2">{{hist.net_paid}}</span>
                <span class = "text-center cost col-2">{{hist.txn_worth}}</span>
                <span class = "text-center discost col-1">{{hist.means_of_payment}}</span>
                <!-- <span class = "text-center discnt col-1">{{hist.frontdesk_rep}}</span> -->
            </li>
        </ul>
    </div>
</div>


