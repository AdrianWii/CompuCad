$('#dbType').on('change',function(){
    if( $(this).val()==="1"){
    $("#1").show()
    }
    else{
    $("#1").hide()
    }
    
    if( $(this).val()==="2"){
    $("#2").show()
    }
    else{
    $("#2").hide()
    }
});