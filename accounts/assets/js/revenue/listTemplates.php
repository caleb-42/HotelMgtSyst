
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


