<script type="text/javascript">

function validate() //main validation function
{
   //name validation
     if( document.myForm.Name.value == "" || !(document.myForm.Name.value.match(/^[a-zA-Z\s]+$/)) )
    {
     alert( "Please provide valid name (characters only)!" );
     document.myForm.Name.focus() ;
     return false;
    }
    
    //email validation
     if( document.myForm.email.value == "" || !(document.myForm.email.value.match(/^[_A-Za-z0-9-\+]+(\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]+)*(\.[A-Za-z]{2,})$/)) )
    {
     alert( "Please provide email address" );
     document.myForm.Name.focus() ;
     return false;
    }
    
    
    //msg validation
     if( document.myForm.Name.value == "" || document.myForm.message.value.length < 6 || document.myForm.message.value.match(/^\s*$/))
    {
     alert( "Message should contain more than 6 characters" );
     document.myForm.Name.focus() ;
     return false;
    }
    return true;
}

</script>

<html>
    <body>
        
    <h2>  <u>Contact Us  </u></h2>
            <form action="/UniqueSnacks/index.php/contact_us/form_callback" name="myForm"  method = "post" onsubmit="return(validate());">
                
                <table cellpadding="3" cellspacing="2">

                    <tr>
                        <td style="white-space: nowrap;">
                            Name* 
                        </td>
                        <td>
                            <input type="text" name="Name"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Email*
                        </td>
                        <td>
                            <input type="text" name="email" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Message
                        </td>
                        <td>
                            <input type="text" name="message"  />
                        </td>
                    </tr>
                    <tr>
                    <td>
                        <input type="submit" name= "submit">
                    </td>
                    </tr>
                </table>
                </form>
          </body>
          </html>      