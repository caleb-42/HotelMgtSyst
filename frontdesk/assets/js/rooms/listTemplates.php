<div ng-if = "<?php echo $_GET['list']   == 'rooms'?>" class = "listcont">
    <div  class = "listhd pr-2 row font-fam-Montserrat-bold opac-70">
        <span class="{{hd.width}} f-13"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in rooms.listhddata">{{hd.name}}</span>
    </div>
    <div class = "hs-60 listbody ovflo-y pb-4" >
        <ul class = "list" >
            <li class = "anim-fast itemlistrow row align-items-center f-12" ng-repeat = "room in (rooms.jslist.newItemArray = (rooms.jslist.values | filter:searchbox.imp))" ng-click = "rooms.jslist.select($index, room.room_id);" ng-class = "{'actparent' :rooms.jslist.selected == room.room_id}">
                <span class = "itemname col-1">{{room.room_number}}</span>
                <span class = "text-center stkleft col-2">{{room.room_id}}</span>
                <span class = "text-center itemcost col-1">{{room.room_rate}}</span>
                <span class = "text-center description col-2">{{room.room_category}}</span>
                <span class = "text-center category col-1">{{room.current_guest_id}}</span>
                <span class = "text-center type col-2">{{room.guests}}</span>
                <span class = "text-center shelfitem col-1">{{room.booked}}</span>
                <span class = "text-center shelfitem col-2">{{room.reserved}}</span>
            </li>
        </ul>
    </div>
</div>

<div ng-if = "<?php echo $_GET['list']   == 'category'?>" class = "listcont">
    <div  class = "listhd pr-2 row font-fam-Montserrat-bold opac-70">
        <span class="{{hd.width}} f-13"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in category.listhddata">{{hd.name}}</span>
    </div>
    <div class = "hs-60 listbody ovflo-y pb-4" >
        <ul class = "list" >
            <li class = "anim-fast itemlistrow row align-items-center f-12" ng-repeat = "cat in (category.jslist.newItemArray = (category.jslist.values | filter:searchbox.imp))" ng-click = "category.jslist.select($index, cat.id);" ng-class = "{'actparent' :category.jslist.selected == cat.id}">
                <span class = "category col-4">{{cat.category}}</span>
                <span class = "text-center rate col-4">{{cat.rate}}</span>
                <span class = "text-center user col-4">{{cat.sales_rep}}</span>
            </li>
        </ul>
    </div>
</div>
