<!DOCTYPE html>
<html>
<style type="text/css">

</style>

<script type="text/javascript">


function checkboxlimit(checkgroup, limit){

	var checkgroup=checkgroup

	var limit=limit

	for (var i=0; i<checkgroup.length; i++){

		checkgroup[i].onclick=function(){

		var checkedcount=0

		for (var i=0; i<checkgroup.length; i++)

			checkedcount+=(checkgroup[i].checked)? 1 : 0

		if (checkedcount>limit){

			alert("You can only select a maximum of "+limit+" checkboxes")

			this.checked=false

			}

		}

	}

}
</script>

<body>

		<div style="background-color:red;border: 2px solid darkblue;margin-left: auto; margin-right: auto; width: 50%; height: 500px;text-align:center;">
			<div style="background-color: white;border: 2px solid darkblue; margin-left: 2cm;  height: 400px;width:80%;margin-top: 2cm; text-align:centre;">
				<table name = "table1">
				
					@foreach($friends as $friend)
					<tr style="padding:5px">
						<td style="padding:5px;width:30%;">
            				<input type="checkbox" name="myTextEditBox" value="{{$friend['id']}}" /> {{$friend['name']}}
            			</td>
            			<td style="padding:5px;width:10%;">
            				<?php
            					$picture = $friend['picture'];
            					$data = $picture['data']; 
            					if(!$data['is_silhouette']) 
            					{ ?>
            						<img src="{{$data['url']}}" alt="no image" border=3 height=100 width=100 />
      	      				<?php } ?>
      	      			
      	      			</td>	
        			</tr>
        			@endforeach

        		<script type="text/javascript">

					checkboxlimit(document.table1.myTextEditBox, 2)
				</script>
        		</table>
        	</div>
       	</div>    



    <div class='footer'>
        <a href="logout">Logout?</a>
    </div>
</body>
</html>