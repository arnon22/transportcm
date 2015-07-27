$(function(){
    $('.success').hide();
    
    
    $('.button_cancle').click(function(){
        $('input').val("");
    });
    
    $('#save-customer').click(function(){
        var date = $('#popupDatepicker').val();
        var citizen_1 = $('#num-group1').val();
        var citizen_2 = $('#num-group2').val();
        var citizen_3 = $('#num-group3').val();
        var citizen_4 = $('#num-group4').val();
        var citizen_5 = $('#num-group5').val();
        var citizen_6 = $('#num-group6').val();
        var customer_name = $('#customer_name').val();
        var factory = $('#factory').val();
        var address1 = $('#address1').val();
        var aumpher1 = $('#aumpher1').val();
        var province1 = $('#province1').val();
        var postcode1 = $('#postcode1').val();
        var address2 = $('#address2').val();
        var aumpher2 = $('#aumpher2').val();
        var province2 = $('#province2').val();
        var postcode2 = $('#postcode2').val();
        var contact_person = $('#contact_person').val();
        var fax_number = $('#fax').val();
        var phone_number = $('#area_code').val()+$('#number1').val();
        var mobile_number = $('#mobile1').val()+$('#mobile2').val();
        var remark = $('#remark').val();     
        
        var citizen = (citizen_1+"-"+citizen_2+"-"+citizen_3+"-"+citizen_4+"-"+citizen_5+"-"+citizen_6);
        
        if(customer_name==""){
            //alert('คุณยังไม่ได้ใส่ชื่อหน่วยงาน');
            $('#customer_name').focus();
            return false;
        }
        if(date==""){
            //alert("คุณยังไม่ได้เลือกวันที่");
            $('#popupDatepicker').focus();
            
            return false;
        }
        
        
        
        if(aumpher1=="" || province1=="" || postcode1=="" || address1=="" ||contact_person=="" ||phone_number==""){
            if(address1==""){
            $('#address1').focus();
            return false;
            }
            if(aumpher1==""){
                $('#aumpher1').focus();
                return false;
            }
            if(province1==""){
                $('#province1').focus();
                return false;
            }
            if(postcode1==""){
                
                $('#postcode1').focus();
                return false;
            }
            if(phone_number==""){
                $('#area_code').focus();
                return false;
            }            
            if(contact_person==""){
            $('#contact_person').focus();
            return false;
        }
            
        }        
        
        var dataString = "date="+date+"&citizen="+citizen+"&customer_name="+customer_name+"&factory="+factory+"&address1="+address1;
        dataString += "&aumpher1="+aumpher1+"&province1="+province1+"&postcode1="+postcode1+"&contact_person="+contact_person;
        dataString += "&address2="+address2;
        dataString += "&aumpher2="+aumpher2+"&province2="+province2+"&postcode2="+postcode2;
        dataString += "&phone_number="+phone_number+"&fax_number="+fax_number+"&mobile_number="+mobile_number+"&remark="+remark;
        
        //alert(dataString);
        
       $.ajax({
            type: "POST",
            url: "customers/add_customer",
            data: dataString,
            cache: false,
            success:function(res){
                
                if(res=='insert-ok'){
                    $('.success').show().fadeTo(500);
                }
               //alert(res);
               
       $('#popupDatepicker').val("");
        $('#num-group1').val("");
        $('#num-group2').val("");
        $('#num-group3').val("");
        $('#num-group4').val("");
        $('#num-group5').val("");
        $('#num-group6').val("");
        $('#customer_name').val("");
        $('#factory').val("");
        $('#address1').val("");
        $('#aumpher1').val("");
        $('#province1').val("");
        $('#postcode1').val("");
        $('#address2').val("");
        $('#aumpher2').val("");
        $('#province2').val("");
        $('#postcode2').val("");
        $('#contact_person').val("");
        $('#fax').val("");
        $('#area_code').val("");
        $('#number1').val("");
        $('#mobile1').val("");
        $('#mobile2').val("");
        $('#remark').val("");  
             
                
            },
            error:function(err){
                alert("ERROR");
            } 
        }); /*end Ajax*/
        
     
        
    });
    
    //hide -show form customer
    $('#customer-form-hide').click(function(){
        $('#customer-info').slideToggle();
        //alert("JJJ");
    });
    
});