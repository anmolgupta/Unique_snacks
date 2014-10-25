  <script>  
  function OpenWindow(){  
    for(i=0;i<document.FormName["sal_cal"].length;i++){  
      if(document.FormName["sal_cal"][i].checked){  
    window.open(document.FormName["sal_cal"][i].value,"_self");  
    break;  
  }  
}  
  }  
</script> 