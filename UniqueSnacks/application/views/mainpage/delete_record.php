<div id="nav-bar">
<h3 style="line-height: 0px;"> <center> <u> Employee Information </u>  </center></h3>
 <table class="boldtable"> 
    <body>
        <tr>
        <td> ID  </td> <td> <?php echo $record->id; ?> </td>
    </tr>
        <tr>
        <td> Date Of Joining  </td> <td> <?php echo $record->doj; ?> </td>
    </tr>
    <tr>
     <td>Name </td> <td> <?php echo $record->name; ?></td>
      </tr>
    <tr>
        <td> Husband/ Father's Name </td> <td> <?php echo $record->husband_fathername; ?>   </td>
    </tr>
    <tr>
        <td> Sex </td> <td> <?php echo $record->sex; ?> </td>
    </tr>
    <tr> 
        <td> Date Of Birth </td> <td><?php echo $record->dob; ?> </td></tr> 
    <tr>
        <td> Place Of Birth </td> <td> <?php echo $record->place_of_birth; ?>  </td>
    </tr> 
    <tr>
        <td> Marital Status </td> <td> <?php echo $record->marital_status; ?> </td>
    </tr>
    <tr>
        <td> Nationality </td> <td> <?php echo $record->nationality; ?>   </td>
    </tr>
    <tr>
        <td> Pan No </td> <td> <?php echo $record->pan_no; ?> </td>
    </tr>
    <tr>
        <td> Address </td> <td>  <?php echo $record->address; ?> </td>
    </tr>
    <tr>
    <td> City </td> <td> <?php echo $record->city; ?> </td>
    </tr>
    <tr>
        <td> Pincode </td> <td> <?php echo $record->pincode; ?> </td>
    </tr> 
    <tr>
        <td> Phone No  </td> <td> <?php echo $record->phone_no; ?> </td>
    </tr>
    <tr>
        <td> Mobile No </td> <td> <?php echo $record->mobile_no; ?> </td> 
    </tr>
    <tr>
        <td> Nominee Name </td> <td> <?php echo $record->nominee_name; ?> </td>
    </tr>
    <tr>
        <td> Realtionship With Nominee </td> <td> <?php echo $record->relationship_with_nominee; ?>  </td>
    </tr>
    <tr>
    <td> Joining Fee  </td> <td> <?php echo $record->joining_fee; ?> </td> 
    </tr>
    <tr>
    <td> Introducer ID </td> <td> <?php echo $record->introducer_id; ?> </td> 
    </tr>
    <tr>
    <td> Account No </td> <td> <?php echo $record->account_no; ?> </td> 
    </tr>
    <tr>
    <td> Name Of Bank </td> <td> <?php echo $record->name_of_bank; ?> </td> 
    </tr>
    <tr>
    <td> Name of Branch </td> <td> <?php echo $record->name_of_branch; ?> </td> 
    </tr> 
</table><br>
<a href="/UniqueSnacks/index.php/newEntry/delete_callback?id=<?php echo $record->id.'&doj='.$record->doj.'&name='.$record->name ?>">
    <center><button>Delete</button></center>
        
    </a>
</div>