<!DOCTYPE html>
<html>
<body> 
   @if(Session::has('message'))
        {{ Session::get('message')}}
    @endif
      
    <br>
    Hi,
    <br>

    Do you wanna <a href="login/fb">Login with Facebook</a>?

</body>
</html>