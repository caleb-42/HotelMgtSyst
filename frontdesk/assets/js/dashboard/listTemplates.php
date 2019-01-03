
<!-- ............jslist start ..............-->
<div class = "listcont" ng-if = "<?php echo $_GET['list']   == 'guest'?>">
    <div class = "listhd pr-2 row font-fam-Montserrat-bold">
        <span class="{{hd.width}} f-13 opac-70"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in guest.listhddata">{{hd.name}}</span>
    </div>
    <div class = "hs-40 listbody ovflo-y pb-4" >
        <ul class = "list" >
            <li class = "anim-fast itemlistrow row align-items-center f-12" ng-repeat = "gst in (guest.jslist.newItemArray = (guest.jslist.values | filter:searchbox.imp))" ng-click = "guest.jslist.select($index, gst.guest_id)" ng-class = "{'actparent' :guest.jslist.selected == gst.guest_id}">
                <span class = "username col-2">{{gst.guest_name}}</span>
                <span class = "text-center role col-2">{{gst.guest_type_gender}}</span>
                <span class = "text-center role col-2">{{gst.phone_number}}</span>
                <span class = "text-center role col-1">{{gst.total_rooms_booked}}</span>
                <span class = "text-center role col-2">{{gst.visit_count}}</span>
                <span class = "text-center role col-1">{{gst.checked_in}}</span>
                <span class = "text-center role col-2">{{((gst.room_outstanding | intString) + (gst.restaurant_outstanding | intString) | number)}}</span>
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
                <span class = "text-center role col-2">{{resevtn.guest_name}}</span>
                <span class = "text-center logoff col-3">{{resevtn.inquiry_date | limitTo: 10}}</span>
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
        <div class = "row w-100 justify-content-between">
            <button class="btn btn-outline-success mx-1 mt-3 mb-4 font-fam-Montserrat f-12" ng-click="reservation.resvtn.getallrooms(); settings.modal.active = 'Resvtn'; settings.modal.name = 'Update Single Reservation'; settings.modal.size = 'lg';" data-toggle="modal" data-target="#crud" ng-disabled="!reservation.resvtn.jslist.selected">Update</button>
            <input class="form-control mt-3 mb-4 w-40 text-center anim" ng-model="searchbox.inp"  placeholder = "Search"/>
            <button class="btn btn-outline-danger mx-1 mt-3 mb-4 font-fam-Montserrat f-12" ng-click="reservation.resvtn.deleteResvtn()" ng-disabled="!reservation.resvtn.jslist.selected">Cancel</button>
        </div>
        <div class = "listhd pr-2 row font-fam-Montserrat-bold">
            <span class="{{hd.width}} f-13 opac-70"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in reservation.resvtn.listhddata">{{hd.name}}</span>
        </div>
        <div class = "hs-50 listbody ovflo-y pb-4" >
            <ul class = "list" >
                <li class = "itemlistrow row align-items-center f-12" ng-click = "reservation.resvtn.jslist.select($index, rvtn.id)" ng-repeat = "rvtn in (reservation.resvtn.jslist.newItemArray = (reservation.resvtn.jslist.values | filter:searchbox.inp))" ng-class = "{'actparent' :reservation.resvtn.jslist.selected == rvtn.id}">
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

<!-- ............accordion start ..............-->
<div class = "h-100" ng-if = "<?php echo $_GET['list']  == 'accordion' ?>">
      <div  ng-if = "type == 'rooms'" >
        <div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0 pointer p-3 py-2 f-17 collapsed font-fam-Montserrat-bold blac opac-70" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Reservations
                    </h5>
                </div>

                <div id="collapseOne" class="row collapse show px-1" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body py-3 px-4 hs-55 row align-items-start relatv">
                        <div class = "font-fam-Montserrat row w-100 h-80 {{rooms.jslist.selected ? 'gone' : 'align-items-center'}} relatv ">
                            <h6 class="blu-clr font-weight-bold opac-70 text-center w-100 "> Select A Room</h6>
                        </div>
                        <div class = "listcont w-100 {{!rooms.jslist.selected ? 'gone' : 'notgone'}}">
                            <div class = "row w-100 justify-content-between pb-3">
                            <button class="btn btn-success mx-1 font-fam-Montserrat f-12" ng-click=" settings.modal.active = 'Resvtn'; settings.modal.name = 'Update Room Reservation'; settings.modal.size = 'lg';" data-toggle="modal" data-target="#crud" ng-disabled="!rooms.resvtn.selected">Update</button>
                            <input class="form-control w-40 text-center anim" ng-model="searchbox.inp"  placeholder = "Search"/>
                            <button class="btn btn-danger mx-1 font-fam-Montserrat f-12" ng-click="rooms.resvtn.deleteResvtn()" ng-disabled="!rooms.resvtn.selected">Cancel</button>
                            </div>
                            <div class = "listhd row font-fam-Montserrat-bold w-100 pl-2 pr-1">
                                <span class="{{hd.width}} f-13 opac-70 p-0"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in rooms.resvtn.listhddata">{{hd.name}}</span>
                            </div>
                            <div class = "hs-30 listbody ovflo-y pb-1 mb-2" >
                                <ul class = "list" >
                                    <li ng-click = "rooms.resvtn.select($index, reservation.reservation_ref)" class = "itemlistrow row align-items-center pl-2 f-12" ng-repeat = "reservation in rooms.resvtn.newItemArray = ( 
                        rooms.resvtn.list | filter:searchbox.inp)" ng-class = "{'actparent' :rooms.resvtn.selected == reservation.reservation_ref}">
                                        <span class = " login col-2 p-0">{{reservation.guest_name}}</span>
                                        <span class = "text-center logoff col-3 p-0">{{reservation.reserved_date}}</span>
                                        <span class = "text-center logoff col-1 p-0">{{reservation.no_of_nights}}</span>
                                        <span class = "text-center logoff col-3 p-0">{{reservation.no_of_nights | intervalGetDate: reservation.reserved_date}}</span>
                                        <span class = "text-center logoff col-3 p-0">{{reservation.room_total_cost}}</span>
                                    </li>
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingThree">
                    <h5 class="mb-0 pointer p-3 f-17 collapsed font-fam-Montserrat-bold blac opac-70" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Features
                    </h5>
                </div>
                <div id="collapseThree" class="collapse px-2" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body py-3 px-4 hs-55 ovflo-y font-fam-Montserrat">
                        <div class = "row w-100 h-100 {{rooms.jslist.selected ? 'gone' : 'align-items-center'}} relatv ">
                            <h6 class="blu-clr font-weight-bold opac-70 text-center w-100 "> Select A Room</h6>
                        </div>
                        <div class = "listcont w-100 {{!rooms.jslist.selected ? 'gone' : 'notgone'}}">
                        
                            <div ng-repeat = "feat in (rooms.jslist.selectedObj.features | explodeToList : '/')" class="row pb-2"><span class = "text-left col-2" ng-if = "feat">{{$index + 1}}. </span><span class = "text-left col-10">{{feat}}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ............accordion end ..............-->

<!-- ............room start ..............-->
<div class = "h-100 w-100 p-4" ng-if = "<?php echo $_GET['list']  == 'roomgrid' ?>">
    <div class = "itemboxhd ovflo-y h-100 w-100">
        <div class = "anim itembox {{items.booked == 'YES' ? 'lytpurp-back1' : ''}} b-rad" ng-repeat = "items in (rooms.jslist.newItemArray = (rooms.jslist.values | filter:searchbox.imp))" ng-click = "rooms.jslist.select($index, items.room_id); rooms.resvtn.getReservation()" ng-class = "{'orange' :rooms.jslist.selected == items.room_id}" >
            <h5>{{items.room_number}}</h5>
            
        </div>
    </div>
</div>
<!-- ............room end ..............-->
