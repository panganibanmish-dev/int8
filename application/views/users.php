
<section class="container content02">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/jQueryUI/jquery-ui.min.css" type="text/css" />
    <style>
        .wrapper {
            margin: 20px auto;
            width: 400px;
        }
        .main-div{
            margin: 0px auto;
        }
        .main-div h2{
            text-align: center;
        }
  
        .modal {
        display: none; /* Hidden by default */
        position: absolute !important; /* Stay in place */
        justify-content: center;
        align-items: center;
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .ui-autocomplete{
            position:absolute;
            top:0;
            left:0;
            cursor:default;
            background: #ffffff;
            z-index:1000
        }

        /* Modal Content/Box */
        .modal-content {
        background-color: #fefefe;
        padding: 20px;
        border: 1px solid #888;
        height: 700px;
        overflow: auto;
        width: 80%; /* Could be more or less, depending on screen size */
        }

        /* Modal Content/Box */
        .modal-content-user {
        background-color: #fefefe;
        padding: 20px;
        border: 1px solid #888;
        height: 700px;
        overflow: auto;
        min-width: 30%; /* Could be more or less, depending on screen size */
        }

        /* The Close Button */
        .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        }

        .close:hover,
        .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
        }

        .modal-header {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .user-list{
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 5px;
            margin-bottom: 5px;
            cursor: pointer;
            border-radius: 15px;

        }
        
        .user-list:hover {
            background-color: #b3d1ff;
        }

    </style>
    <div class="row">
        <div class="Head01 col-11 m-auto">            
            <h1>User Management</h1>
        </div>
    </div>

    <div class='row'>
        <div class = 'col-md-12'>
            <?php
                $this->load->helper('form');
                $error = $this->session->flashdata('error');
                if($error)
                {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('error'); ?>                    
            </div>
            <?php } ?>
            <?php  
                $success = $this->session->flashdata('success');
                if($success)
                {
            ?>
            <div class="alert alert-success alert-dismissable" id="successMessage">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('success'); ?>
            </div>
            <?php } ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-12">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addNew"><i class="fa fa-plus"></i> Add New</a>
                    <a class="btn btn-primary" id="assignLots" href="#"><i class="fa fa-plus"></i> Assign Lots</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="box">

                <div class="col-12">
                    <div class="box-header">
                        <h3 class="box-title">Users</h3>
                        
                    </div><!-- /.box-header -->
                </div><!-- /.box-header -->

                <div class="clearfix"></div>

                <div class="col-12">
                    <div class="Table01 user_table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Role</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?php
                        if(!empty($userRecords))
                        {
                            foreach($userRecords as $record)
                            {
                        ?>
                        
                            <tr>
                                <td><?php echo $record->userId ?></td>
                                <td><?php echo $record->name ?></td>
                                <td><?php echo $record->email ?></td>
                                <td><?php echo $record->mobile ?></td>
                                <td><?php echo $record->role ?></td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-primary" href="<?php echo base_url().'editOld/'.$record->userId; ?>">UPDATE<i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-sm btn-danger deleteUser" href="#" data-userid="<?php echo $record->userId; ?>">DELETE<i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php
                            }
                        }
                        ?>
                        </tbody>
                        </table>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div><!-- /.box -->
        </div>
    </div>


    <!-- Assign Lots Modal -->
    <div id="assignLotModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span id="assignClose" class="close">&times;</span> 
                <h4 style="margin:0">Assign Lots</h4>
            </div>
            <div class="users_list_table">
            <label for="user_lists_1">Users</label>
            <input type="hidden" id="dataLists-1-id">
            <input type="hidden" id="dataLists-1-email">
            <input type="text" class="form-control-sm" id="dataLists-1">
            &nbsp;
            <h4>User's Information</h4>
            Full Name: <span id="dataLists-1-outputName" style="color:dimgray;"></span>
            <br/>
            ID: <span id="dataLists-1-outputId" style="color:dimgray;"></span>
            <br/>
            Email: <span id="dataLists-1-outputEmail" style="color:dimgray;"></span><br><br>
        
            <label for="estate_lists_1">Estates</label>
            <select id="estateLists-1" class="form-control-sm">       
            <option value="#" class="form-control-sm">Choose One</option> 
            </select>
            &nbsp;
            <label for="lot_lists_1">Lots</label>
            <input type="hidden" id="lotLists-1-id">
            <input type="text" class="form-control-sm" id="lotLists-1">
           
            <br/>
            <br/>

                <div class="Table01 lots_table">
                    <label><b style="color:blue;">LOT RESULT</b></label>
                        <table>
                        <thead>
                                <tr>
                                    <th>Lot Number</th>
                                    <th>Estate</th>
                                    <th>Stage</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                    
                            </tbody>
                        </table>
                </div>
                <div class="Table01 existing_lots_table">
                    <label><b style="color:blue;">ALL ASSIGNED LOTS</b></label>
                        <table>
                        <thead>
                                <tr>
                                    <th>List No.</th>
                                    <th>Lot Number</th>
                                    <th>Estate</th>
                                    <th>Stage</th>
                                </tr>
                            </thead>
                            <tbody>
                    
                            </tbody>
                        </table>

                        
                </div>
                     
                </div> 
            </div> 

    </div>

    <!-- Assign User Modal -->
    <div id="assignUserModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content-user">
            <div class="modal-header">
                <span id="assignUserClose" class="close">&times;</span> 
                <h2 style="margin:0">Search User</h2>
            </div>
            
            
            <div id="select_user_table">
                  
            </div>
        </div>

    </div>
  

    <script type="text/javascript">
    function check(){
        console.log(document.getElementById('estateLists-1').value);

    }

    function recall(){
        runLotSearch();
    }

    

    function saveUserSelect(){
        
            document.getElementById('dataLists-1-outputName').innerHTML = document.getElementById('dataLists-1').value;
            document.getElementById('dataLists-1-outputId').innerHTML = document.getElementById('dataLists-1-id').value;
            document.getElementById('dataLists-1-outputEmail').innerHTML = document.getElementById('dataLists-1-email').value;

    }


    function runLotSearch(){
           
        var searchedUser =  document.getElementById('dataLists-1-id').value;
        var result = document.getElementById('lotLists-1').value;
        var selectedEstate = document.getElementById('estateLists-1').value;
        console.log("User: " + searchedUser + "<br/>Lot: " + result + "<br/>Estate: " + selectedEstate);
        // var saveUserData = document.getElementById('dataLists-1-id').value;
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url();?>user/getSelectedLotData?lot_no=' + result + '&estId=' + selectedEstate + '&userId=' + searchedUser,
                    success: function (data) {
                     console.log('Run Lot Search Result: ' + data);    
                       var returnedMatch = JSON.parse(data);
                      // var lotList = returnedMatch[0].Lot_No;
                      
                       console.log('Run Lot Search Result Match: ' + returnedMatch[0].Lot_No);
                        $(".lots_table tbody").html('');
                        
                            var elements = `<tr>`;
                            elements += `<td>${returnedMatch[0].Lot_No}</td>`;
                            elements += `<td>${returnedMatch[0].Estate}</td>`;
                            elements += `<td>${returnedMatch[0].Lot_Stage}</td>`;
                                
                            elements += `<td>`;

                            if(returnedMatch[0].Available_Lot == 0){
                            elements += `<a class="btn btn-primary" style="cursor:pointer;" onclick="assignUser(${returnedMatch[0].User_ID}, ${returnedMatch[0].Lot_No}, '${encodeURIComponent(returnedMatch[0].Estate)}', '${encodeURIComponent(returnedMatch[0].Lot_Stage)}')">Assign</a>`;
                            } else if(returnedMatch[0].Available_Lot == 1){
                            elements += `<a class="btn btn-danger" style="cursor:pointer" onclick="unassignUser(${returnedMatch[0].Unassign_Id})">Unassign</a>`;
                            }
                            
                            
                            elements += `</td>`;
                            elements += `</tr>`;

                            $(".lots_table tbody").append(elements);
                    
                    },
                    error: function (data) {
                        console.log('error');
                    }

                });


                $.ajax({
                type: 'GET',
                url: '<?php echo base_url();?>user/getAllMyLots?userId=' + searchedUser,
                success: function (data) {
                 
                    console.log('Run Lot sasas Result: ' + data);    
                       const returnedMatch = JSON.parse(data);
                       //console.log('Parsed: ' + returnedMatch);
                      // var lotList = returnedMatch[0].Lot_No;
                   

                        $(".existing_lots_table tbody").html('');
                        returnedMatch.forEach((value, index) => {
                            var elements = `<tr>`;
                            elements += `<td>${index + 1}.</td>`
                            elements += `<td>${value.Lot_No}</td>`;
                            elements += `<td>${value.Estate}</td>`;
                            elements += `<td>${value.Lot_Stage}</td>`;

                            elements += `</tr>`;

                            $(".existing_lots_table tbody").append(elements);

                        });
                    
                    },
                    error: function (data) {
                        console.log('error');
                    }
            });
                //var searchedUser = document.getElementById('dataLists-1-id').value;
           
    }

    

    function assignUser(val1, val2, val3, val4){
      // var saveUserData = document.getElementById('dataLists-1-id').value;
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url();?>user/assignLotToUser',
                data: {
                    //id: saveUserData
                    lot_id: val1,
                    lot_no: val2,
                    lot_estate: val3,
                    lot_stage: val4
                },
                    success: function (data) {
                        alert("User successfully assigned to Lot");
                        recall();
                    },
                    error: function (data) {
                        alert("Assigned lot already exists!");
                    }

                });
    }

    function unassignUser(val1){
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>user/deleteLotFromUser',
            data: {
                lot_id: val1

            },
                success: function (data) {
                    alert("User successfully unassigned to Lot");
                    recall();
                },
                error: function (data) {
                    alert("Assigned lot delete failed!");
                }

        });
    }

   

    jQuery(document).ready(function(){
            $("#assignLots").on('click', () => {  

                $('#dataLists-1').on("input", function(){
                    $('#dataLists-1-id').val('');
                    $('#dataLists-1-email').val('');
                    $('#dataLists-1-outputId').html('');
                    $('#dataLists-1-outputName').html('');
                    $('#dataLists-1-outputEmail').html('');
                    $('#estateLists-1').val('');
                    $('#estateLists-1-id').val('');
                    $('#lotLists-1').val('');
                    $('#lotLists-1-id').val('');
                });

                $('#assignLotModal').on('keypress', function(e){
                    if(e.which == 13) {
                        if($('#dataLists-1-id').val() && $('#estateLists-1').val() && $('#lotLists-1-id').val())
                        {
                            runLotSearch();
                        } else {
                            alert('Incomplete form submission! Please fill all fields to continue.');
                        }
                    }
                });

                $("#assignLotModal").css('display', 'flex');
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url();?>user/getUsersData',
                    success: function (data) {
                     var list = JSON.parse(data);
                        $("#dataLists-1").autocomplete({
                            source: list,
                            select: function( event , ui ) {    
                                $("#dataLists-1").val( ui.item.label); // return user's full name
                                $("#dataLists-1-id").val( ui.item.theValue); //returns user's id
                                $("#dataLists-1-email").val(ui.item.theEmail); //return user's email
                                console.log('USER NAME: ' + ui.item.label);
                                console.log('USER ID: ' + ui.item.theValue);
                                console.log('USER EMAIL: ' + ui.item.theEmail);
                                saveUserSelect();
                            }
                        });
                    }        
                });

                $('#estateLists-1').on('change', function(){
                    var est = document.getElementById('estateLists-1').value;
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url();?>user/getLotsData?est=' + est,
                    success: function (data) {
                     var list = JSON.parse(data);
                    // console.log('Lot ID: ' + ..)
                        $("#lotLists-1").autocomplete({
                            source: list,
                            select: function( event , ui ) {    
                                $("#lotLists-1").val( ui.item.label); 
                                $("#lotLists-1-id").val( ui.item.theValue); 
                                console.log('LOT LABEL: ' + ui.item.label);
                                console.log('LOT ID: ' + ui.item.theValue);
                            }
                        });
                    }        
                });
                });

                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url();?>user/getEstatesData',
                    success: function (data) {
                      var response = JSON.parse(data);
                        //console.log('Estates: ' + response[i].id);
                        var estateData = document.getElementById("estateLists-1");
           
                        //Add the Options to the DropDownList.
                        for (var i = 0; i < response.length; i++) {
                            var option = document.createElement("OPTION");

                            //Set Customer Name in Text part.
                            option.innerHTML = response[i].estate_name;

                            //Set CustomerId in Value part.
                            option.value = response[i].id;

                            //Add the Option element to DropDownList.
                            estateData.options.add(option);
                        }
                    }
                });

             

            });

            jQuery('ul.pagination li a').click(function (e) {
                e.preventDefault();            
                var link = jQuery(this).get(0).href;            
                var value = link.substring(link.lastIndexOf('/') + 1);
                jQuery("#searchList").attr("action", baseURL + "userListing/" + value);
                jQuery("#searchList").submit();
            });
    
            // Close Assign Lots Modal
            $("#assignClose").on('click', () => {
                $("#assignLotModal").css('display', 'none');
            })

            // Close Assign User Modal
            $("#assignUserClose").on('click', () => {
                $("#assignUserModal").css('display', 'none');
                $("#assignLotModal").css('display', 'flex');
            })
    });

       

        // Close Assign Lots Modal when clicked outside modal content
        window.onclick = function(event) {
            if (event.target == document.getElementById("assignLotModal")) {
                $("#assignLotModal").css('display', 'none');
            } else if (event.target == document.getElementById("assignUserModal")) {
                $("#assignUserModal").css('display', 'none');
                $("#assignLotModal").css('display', 'flex');
            }
        }   
    </script>
    <script>
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 5000);
    </script>
   
    <script src="<?php echo base_url() ?>assets/jQueryUI/jquery-ui-1.12.4.js"></script>
    <script src="<?php echo base_url() ?>assets/jQueryUI/jquery-ui.js"></script>
</section>
