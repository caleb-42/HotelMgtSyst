
<!-- ............jslist start ..............-->
<div class = "listcont" ng-if = "<?php echo $_GET['list']   == 'guest'?>">
    <div class = "listhd pr-3 row font-fam-Montserrat-bold">
        <span class="{{hd.width}} f-13 opac-70"  ng-class ='{"text-center" : !$first}' ng-repeat = "hd in guest.listhddata">{{hd.name}}</span>
    </div>
    <div class = "hs-45 listbody ovflo-y pb-4" >
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


<!-- ............accordion start ..............-->
<div class = "h-100" ng-if = "<?php echo $_GET['list']  == 'accordion' ?>">
    <div  ng-if = "type == 'guest'" >
        <div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0 pointer p-3 py-2 f-17 collapsed font-fam-Montserrat-bold blac opac-70" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Check In
                    </h5>
                </div>

                <div id="collapseOne" class="collapse show px-1" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body py-3 px-4 hs-55 ovflo-y row align-items-center">
                        <!-- <div class = "row py-3">
                            <label class = "f-13 col-4">Phone No.</label>
                            <input name = "guest_name" class = "form-control col-8"/></div>
                        <div class = "row py-3">
                            <label class = "f-13 col-4">Address</label>
                            <Textarea name = "guest_name" class = "form-control col-8" rows = "4"></Textarea>
                        </div> -->
                        
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header " id="headingTwo">
                    <h5 class="mb-0 pointer p-3 f-17 collapsed font-fam-Montserrat-bold blac opac-70" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Update Guest Info
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse px-2" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body py-3 px-4 hs-55 ovflo-y font-fam-Montserrat">

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingThree">
                    <h5 class="mb-0 pointer p-3 f-17 collapsed font-fam-Montserrat-bold blac opac-70" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Check out
                    </h5>
                </div>
                <div id="collapseThree" class="collapse px-2" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body py-3 px-4 hs-55 ovflo-y font-fam-Montserrat">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div  ng-if = "type == 'rooms'" >
        <div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0 pointer p-3 py-2 f-17 collapsed font-fam-Montserrat-bold blac opac-70" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Check In
                    </h5>
                </div>

                <div id="collapseOne" class="collapse show px-1" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body py-3 px-4 hs-55 ovflo-y row align-items-center">
                        <!-- <div class = "row py-3">
                            <label class = "f-13 col-4">Phone No.</label>
                            <input name = "guest_name" class = "form-control col-8"/></div>
                        <div class = "row py-3">
                            <label class = "f-13 col-4">Address</label>
                            <Textarea name = "guest_name" class = "form-control col-8" rows = "4"></Textarea>
                        </div> -->
                        
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header " id="headingTwo">
                    <h5 class="mb-0 pointer p-3 f-17 collapsed font-fam-Montserrat-bold blac opac-70" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Update Guest Info
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse px-2" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body py-3 px-4 hs-55 ovflo-y font-fam-Montserrat">

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingThree">
                    <h5 class="mb-0 pointer p-3 f-17 collapsed font-fam-Montserrat-bold blac opac-70" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Check out
                    </h5>
                </div>
                <div id="collapseThree" class="collapse px-2" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body py-3 px-4 hs-55 ovflo-y font-fam-Montserrat">
                       
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
        <div class = "itembox btn {{items.booked == 'YES' ? 'sechue' : ''}}" ng-repeat = "items in (rooms.jslist.newItemArray = (rooms.jslist.values | filter:searchbox.imp))"  >
            <h5>{{items.room_number}}</h5>
        </div>
    </div>
</div>
<!-- ............room end ..............-->
