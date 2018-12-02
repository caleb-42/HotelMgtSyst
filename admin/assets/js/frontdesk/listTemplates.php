
<div class = "listcont h-100" ng-if = "<?php echo $_GET['list']   == 'booking'?>">
    <div class = "listhd pr-3 row font-fam-Montserrat-bold">
        <span class="{{hd.width}} f-13 opac-70"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in listbookings.listhddata ">{{hd.name}}</span>
    </div>
    <div class = "h-80 listbody ovflo-y pb-4" >
        <ul class = "list" >
            <li class = "itemlistrow row align-items-center f-12" ng-repeat = "hist in (listbookings.jslist.newItemArray = (listbookings.jslist.values | filter:searchbox.imp))">
                <span class = "text-center paymeth col-1">{{hist.booking_ref}}</span>
                <span class = "text-center paymeth col-1">{{hist.room_number}}</span>
                <span class = "text-center paymeth col-1">{{hist.room_category}}</span>
                <span class = "text-center paymeth col-1">{{hist.room_rate}}</span>
                <span class = "text-center paymeth col-1">{{hist.guest_name}}</span>
                <span class = "text-center items col-1">{{hist.no_of_nights}}</span>
                <span class = "text-center cost col-1">{{hist.guests}}</span>
                <span class = "text-center discost col-2">{{hist.check_in_date}}</span>
                <span class = "text-center discnt col-2">{{hist.check_out_time}}</span>
                <span class = "text-center deposit col-1">{{hist.checked_out}}</span>
            </li>
        </ul>
    </div>
</div>

<!-- ............jslist start ..............-->
<div class = "listcont" ng-if = "<?php echo $_GET['list']   == 'guest'?>">
    <div class = "listhd pr-3 row font-fam-Montserrat-bold">
        <span class="{{hd.width}} f-13 opac-70"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in guest.listhddata">{{hd.name}}</span>
    </div>
    <div class = "hs-40 listbody ovflo-y pb-4" >
        <ul class = "list" >
            <li class = "anim-fast itemlistrow row align-items-center f-12" ng-repeat = "gst in (guest.jslist.newItemArray = (guest.jslist.values | filter:searchbox.imp))" ng-click = "guest.jslist.select($index, gst.guest_id)" ng-class = "{'actparent' :guest.jslist.selected == gst.guest_id}">
                <span class = "username col-3">{{gst.guest_name}}</span>
                <span class = "text-center role col-2">{{gst.guest_type_gender}}</span>
                <span class = "text-center role col-2">{{gst.total_rooms_booked}}</span>
                <span class = "text-center role col-2">{{gst.visit_count}}</span>
                <span class = "text-center role col-3">{{((gst.room_outstanding | intString) + (gst.restaurant_outstanding | intString) | number)}}</span>
            </li>
        </ul>
    </div>
</div>
<!-- ............jslist start ..............-->

<!-- ............jslist start ..............-->
<div class = "listcont" ng-if = "<?php echo $_GET['list']   == 'reservation'?>">
    <div class = "listhd pr-3 row font-fam-Montserrat-bold">
        <span class="{{hd.width}} f-13 opac-70"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in reservation.listhddata">{{hd.name}}</span>
    </div>
    <div class = "hs-60 listbody ovflo-y pb-4" >
        <ul class = "list" >
            <li class = "anim-fast itemlistrow row align-items-center f-12" ng-repeat = "resevtn in (reservation.jslist.newItemArray = (reservation.jslist.values | filter:searchbox.imp))" ng-click = "reservation.jslist.select($index, resevtn.reservation_ref)" ng-class = "{'actparent' :reservation.jslist.selected == resevtn.reservation_ref}">
                <span class = "username col-2">{{resevtn.reservation_ref}}</span>
                <span class = "text-center role col-2">{{resevtn.guest_id}}</span>
                <span class = "text-center logoff col-3">{{resevtn.inquiry_date}}</span>
                <span class = "text-center logoff col-3">{{resevtn.reserved_date}}</span>
                <span class = "text-center logoff col-2">{{resevtn.deposit_confirmed == 'YES' ? (resevtn.booked == 'YES' ? 'booked' : 'confirmed') : 'unconfirmed'}}</span>
            </li>
        </ul>
    </div>
</div>
<!-- ............jslist start ..............-->

<div ng-if = "<?php echo $_GET['list'] == 'resvtn'?>">
    <div class = "row hs-80 {{reservation.jslist.selected ? 'gone' : 'align-items-center'}} relatv ">
        <h4 class=" text-center w-100 "> Select Reservation</h4>
    </div>
    <div class = "listcont {{!reservation.jslist.selected ? 'gone' : 'notgone'}}">
        <div class= "w-100">
            <div class = "w-100 row purp-back wht opac-50 px-1 py-2 bpx-rad font-fam-Montserrat-bold f-14" style = "margin-bottom: 10px !important;">
                <span class = "text-left col-4">Phone No.</span>
                <span class = "text-right col-8">{{reservation.jslist.selectedObj.phone_number}}</span>
            </div>
            <div class = "w-100 row purp-back wht opac-50 px-1 py-2 bpx-rad font-fam-Montserrat-bold f-14" style = "margin-bottom: 10px !important;">
                <span class = "text-left col-4">Email</span>
                <span class = "text-right col-8">{{reservation.jslist.selectedObj.email}}</span>
            </div>
        </div>
        <div class = "row w-100 justify-content-between pb-3">
            <button class="btn btn-outline-success mx-1 font-fam-Montserrat f-12" ng-click="rooms.getallrooms(); settings.modal.active = 'Resvtn'; settings.modal.name = 'Update Single Reservation'; settings.modal.size = 'lg';" data-toggle="modal" data-target="#crud" ng-disabled="!resvtn.jslist.selected">Update</button>
            <input class="form-control w-60 text-center anim" ng-model="searchbox.inp"  placeholder = "Search"/>
            <!-- <button class="btn btn-outline-danger mx-1 font-fam-Montserrat f-12" ng-click="resvtn.deleteResvtn()" ng-disabled="!resvtn.jslist.selected">Cancel</button> -->
        </div>
        <div class = "listhd pr-2 row font-fam-Montserrat-bold">
            <span class="{{hd.width}} f-13 opac-70"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in resvtn.listhddata">{{hd.name}}</span>
        </div>
        <div class = "hs-50 listbody ovflo-y pb-4" >
            <ul class = "list" >
                <li class = "itemlistrow row align-items-center f-12" ng-click = "resvtn.jslist.select($index, rvtn.id)" ng-repeat = "rvtn in (resvtn.jslist.newItemArray = (resvtn.jslist.values | filter:searchbox.inp))" ng-class = "{'actparent' :resvtn.jslist.selected == rvtn.id}">
                    <span class = " login col-2">{{rvtn.room_number}}</span>
                    <span class = "text-center logoff col-2">{{rvtn.room_rate}}</span>
                    <span class = "text-center logoff col-3">{{rvtn.room_total_cost}}</span>
                    <span class = "text-center logoff col-2">{{rvtn.no_of_nights}}</span>
                    <span class = "text-center logoff col-3">{{rvtn.no_of_nights | intervalGetDate: rvtn.reserved_date}}</span>
                </li>
            </ul>
        </div>
    </div>
</div>

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

<div ng-if = "<?php echo $_GET['list']   == 'rooms'?>" class = "listcont">
    <div  class = "listhd pr-2 row font-fam-Montserrat-bold opac-70">
        <span class="{{hd.width}} f-13"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in rooms.listhddata">{{hd.name}}</span>
    </div>
    <div class = "hs-60 listbody ovflo-y pb-4" >
        <ul class = "list" >
            <li class = "anim-fast itemlistrow row align-items-center f-12" ng-repeat = "room in (rooms.jslist.newItemArray = (rooms.jslist.values | filter:searchbox.imp))" ng-click = "rooms.jslist.select($index, room.room_id); details.discount.jslist.createList()" ng-class = "{'actparent' :rooms.jslist.selected == room.room_id}">
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

