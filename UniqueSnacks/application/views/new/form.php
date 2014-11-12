<html>
<head>
<title>New Entry</title>
<script type="text/javascript">

//date validation
var dtCh= "-";
var minYear=1900;
var maxYear=2100;

function isInteger(s){
   var i;
    for (i = 0; i < s.length; i++){   
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}

function stripCharsInBag(s, bag){
   var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++){   
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

function daysInFebruary (year){
   // February has 29 days in any year evenly divisible by four,
    // EXCEPT for centurial years which are not also divisible by 400.
    return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}
function DaysArray(n) {
   for (var i = 1; i <= n; i++) {
      this[i] = 31
      if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
      if (i==2) {this[i] = 29}
   } 
   return this
}
//date validation main function
function isDate(dtStr){
   var daysInMonth = DaysArray(12)
   var pos1=dtStr.indexOf(dtCh)
   var pos2=dtStr.indexOf(dtCh,pos1+1)
   var strDay=dtStr.substring(0,pos1)
   var strMonth=dtStr.substring(pos1+1,pos2)
   var strYear=dtStr.substring(pos2+1)
   strYr=strYear
   if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
   if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
   for (var i = 1; i <= 3; i++) {
      if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
   }
   month=parseInt(strMonth)
   day=parseInt(strDay)
   year=parseInt(strYr)
   if (pos1==-1 || pos2==-1){
      alert("The date format should be : dd-mm-yyyy")
      return false
   }
   if (strMonth.length<1 || month<1 || month>12){
      alert("Please enter a valid month")
      return false
   }
   if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
      alert("Please enter a valid day")
      return false
   }
   if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
      alert("Please enter a valid 4 digit year between "+minYear+" and "+maxYear)
      return false
   }
   if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
      alert("Please enter a valid date")
      return false
   }
return true
}
// for character validation

function validate() //main validation function
{
   // doj validation
   if( document.myForm.doj.value == "" )
   {
     alert( "Please provide valid date of joining." );
     document.myForm.doj.focus() ;
     return false;
   }else{
     var dt=document.myForm.doj;
   if (isDate(dt.value)==false){
      dt.focus();
      return false;
   }
   }

   //name validation
     if( document.myForm.Name.value == "" || !(document.myForm.Name.value.match(/^[a-zA-Z\s]+$/)) )
   {
     alert( "Please provide valid name (characters only)!" );
     document.myForm.Name.focus() ;
     return false;
   }

   // husband_fathername validation
   if( document.myForm.husband_fathername.value == "" || !(document.myForm.husband_fathername.value.match(/^[a-zA-Z\s]+$/)) )
   {
     alert( "Please provide husband_fathername " );
     document.myForm.husband_fathername.focus() ;
     return false;
   }

   // dob validation
   if( document.myForm.dob.value == "" )
   {
     alert( "Please provide valid date of birth." );
     document.myForm.dob.focus() ;
     return false;
   }
   else{
     var dt=document.myForm.dob;
   if (isDate(dt.value)==false){
      dt.focus();
      return false;
   }
   }

   //sex validation
    if( document.myForm.sex.value == "-1" )
   {
     alert( "Please provide your sex!" );
     return false;
   }

   //place of birth validation
   if( document.myForm.place_of_birth.value == "" || !(document.myForm.place_of_birth.value.match(/^[a-zA-Z\s]+$/)) )
   {
     alert( "Please provide valid place of birth." );
     document.myForm.place_of_birth.focus() ;
     return false;
   }

   //marital status validation
   if( document.myForm.marital_status.value == "-1" )
   {
     alert( "Please provide marital status" );
     document.myForm.marital_status.focus() ;
     return false;
   }
   //nationality validation
   if( document.myForm.nationality.value == "" || !(document.myForm.nationality.value.match(/^[a-zA-Z\s]+$/)) )
   {
     alert( "Please provide nationality" );
     document.myForm.nationality.focus() ;
     return false;
   }

   // address validation
   if( document.myForm.address.value == "" )
   {
     alert( "Please provide valid address" );
     document.myForm.address.focus() ;
     return false;
   }

   //city validation
   if( document.myForm.city.value == "" || !(document.myForm.city.value.match(/^[a-zA-Z\s]+$/)) )
   {
     alert( "Please provide valid city" );
     document.myForm.city.focus() ;
     return false;
   }

   //pincode validation
   if(  document.myForm.pincode.value == "" ||
           isNaN( document.myForm.pincode.value ) ||
           document.myForm.pincode.value.length != 6 )
   {
     alert( "Please provide valid pincode" );
     document.myForm.pincode.focus() ;
     return false;
   }

   //mobile no validation
   if(  document.myForm.mobile_no.value == "" ||
           isNaN( document.myForm.mobile_no.value ) ||
           document.myForm.mobile_no.value.length != 11 )
   {
     alert( "Please provide valid mobile no." );
     document.myForm.mobile_no.focus() ;
     return false;
   }

   //nominee name validation
   if( document.myForm.nominee_name.value == "" || !(document.myForm.nominee_name.value.match(/^[a-zA-Z\s]+$/)) )
   {
     alert( "Please provide valid nominee name" );
     document.myForm.nominee_name.focus() ;
     return false;
   }

   //relation wid nominee
   if( document.myForm.relationship_with_nominee.value == "" || !(document.myForm.relationship_with_nominee.value.match(/^[a-zA-Z\s]+$/)) )
   {
     alert( "Please provide valid relation" );
     document.myForm.relationship_with_nominee.focus() ;
     return false;
   }

   // joining fee validation
   if( document.myForm.joining_fee.value == "" || isNaN(document.myForm.joining_fee.value) )
   {
     alert( "Please provide valid amount of fee" );
     document.myForm.joining_fee.focus() ;
     return false;
   }

   //introducer name validation
   if( document.myForm.introducer_name.value == "" || !(document.myForm.introducer_name.value.match(/^[a-zA-Z\s]+$/)) )
   {
     alert( "Please provide valid introducer name" );
     document.myForm.introducer_name.focus() ;
     return false;
   }

   // introducer id validation
   if( document.myForm.introducer_id.value == "" || isNaN( document.myForm.introducer_id.value))
   {
     alert( "Please provide valid introducer id" );
     document.myForm.introducer_id.focus() ;
     return false;
   }
   return (true);

}
</script>
</head>
<body>
<div id="nav-bar">
        <h2 >  <u>Entry Of New Record  </u></h2>
            <form action="/UniqueSnacks/index.php/newEntry/callback" name="myForm"  method = "post" onsubmit="return(validate());">
                
                <table cellpadding="3" cellspacing="2">

                    <tr>
                        <td style="white-space: nowrap;">
                            Date Of Joining(DD-MM-YYYY)*
                        </td>
                        <td>
                            <input type="text" name="doj"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Name*
                        </td>
                        <td>
                            <input type="text" name="Name" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Husband/ Father's Name*
                        </td>
                        <td>
                            <input type="text" name="husband_fathername"  />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Date Of Birth (DD-MM-YYYY)*
                        </td>
                        <td>
                            <input type="text" name="dob" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Sex*
                        </td>
                        <td>
                            <select name="sex">
                              <option value="-1" selected>Choose sex</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Place Of Birth*
                        </td>
                        <td>
                            <input type="text" name="place_of_birth" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Marital Status*
                        </td>
                        <td>
                            <select name="marital_status">
                              <option value="-1" selected>Choose status</option>
                              <option value="Single"> Single</option>
                              <option value="Married"> Married</option>
                              <option value="Divorced"> Divorced </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nationality*
                        </td>
                        <td>
                            <input type="text" name="nationality"  />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            PAN NO.
                        </td>
                        <td>
                            <input type="text" name="pan_no"  />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Address*
                        </td>
                        <td>
                            <input type="text" name="address"  />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            City*
                        </td>
                        <td>
                            <input type="text" name="city" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Pincode*
                        </td>
                        <td>
                            <input type="text" name="pincode" />
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Phone No. (with STD code)
                        </td>
                        <td>
                            <input type="text" name="phone_no" />
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Mobile No.* (0XXXXXXXXXX)
                        </td>
                        <td>
                            <input type="text" name="mobile_no" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nominee Name*
                        </td>
                        <td>
                            <input type="text" name="nominee_name" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Relationship with nominee*
                        </td>
                        <td>
                            <input type="text" name="relationship_with_nominee"  />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Joining Fee*
                        </td>
                        <td>
                            <input type="text" name="joining_fee"  />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Introducer Name*
                        </td>
                        <td>
                            <input type="text" name="introducer_name" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Introducer Id*
                        </td>
                        <td>
                            <input type="text" name="introducer_id" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Account No.
                        </td>
                        <td>
                            <input type="text" name="account_no"  />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Name Of Bank
                        </td>
                        <td>
                            <input type="text" name="name_of_bank" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Name Of Branch
                        </td>
                        <td>
                            <input type="text" name="name_of_branch" />
                        </td>
                    </tr>

                    <tr>
                        <td>
                        </td>
                        <td>
                            <input type="submit" value="Submit" />
                        </td>
                    </tr>
                </table>
            </form>
          </div>
 </body>
 </html>