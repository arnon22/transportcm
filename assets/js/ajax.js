$(function(){
    
    $('.top-menu').hide();
    
});

//start of cubic
$(function(){
    
    var update_status = false;
    var cubic_id = "";
    //add cubic
    $('#add-cubic').live("click",function(){
        var cubic_code = $('#cubic_code').val();
        var cubic_value = $('#cubic_value').val();
        var cubic_status = $('#cubic_status').val();
        var cubic_note = $('#cubic_note').val();
        
      if(cubic_code == "" || cubic_value == "" || cubic_note == "" || cubic_status ==""){
            
            if(cubic_code==""){               
                $('#cubic_code').focus();
                
                return false;
                
            }
            if(cubic_value == ""){               
                $('#cubic_value').focus();
                
                return false;
                
            }
            
            
      }// end of if  
        var data_cubic = "cubic_code="+cubic_code+"&cubic_value="+cubic_value+"&cubic_note="+cubic_note+"&cubic_status="+cubic_status;
        alert(data_cubic);
        
        
        if(update_status == false){
            
            $.ajax({
                type: "POST",
                url: "cubiccode/add_cubic",
                data: data_cubic,
                dataType: "JSON",
                cache: false,
                success:function(res){
                    $('.cruises tbody').html("");
                    
                    $.each(res,function(key,vals){                       
                        
                        var opt = "<tr><td class=\"name\"><div>"+vals['cubic_code']+"</div></td>";
                            opt += "<td class=\"operator\"><div>"+vals['cubic_value']+"</div></td>";
                            opt += "<td class=\"began\"><div>"+vals['cubic_note']+"</div></td>";
                           opt += "<td class=\"tonnage\"><div>ใช้งาน</div></td>";
                           opt += "<td class=\"status\"><div><a href=\"javascript:void(0)\" class=\"pro_edit\" id=\""+vals['cubic_id']+"\">แก้ไข</a>| <a onclick=\"del_cubic('"+vals['cubic_id']+"',this)\" href=\"javascript:void(0)\">ลบ</a></div></td></tr>";
                        
                            $(opt).appendTo('.cruises tbody');
                                                    
                        
                    });
                    
                    
                         $('#cubic_code').val("");
                         $('#cubic_value').val("");                         
                         $('#cubic_note').val("");
                    
                    
                }// end of success
                
                
                
            });
            
            
            
            
            
        }// end of if
        if(update_status == true){
            
        }//end of if
        
        
        
        
        
    }); //end of $('#add-cubic')
    
    
    
});

function del_cubic(id,obj){
    var conf = confirm("Do you want Delete? ");
    
    if(conf){
        
        $.ajax({
            url:"cubiccode/del_cubic/"+id,
            type:"POST",
            success:function(res){
                if(res==1){
                  //$(obj).parent().parent().remove(); 
                  $(obj).parents('tr').remove(); 
                }
            },
            error:function(eer){
                console.log("Error:" +err);
            }
        });
        
       // $(obj).parent().parent().remove();
        
        
    }else{
        return false;
    }
    
}



//end of cubic

$(function(){
        var editsatus =false;
    $('#btsubmit').live('click',function(e){
        var factory_code = $('#factory_code').val();
        var factory_name =$('#factory_name').val();
        var factory_note = $('#factory_note').val();
        var factory_status = $('select[name=factory_status]').val();
        var fcreate = $('input[name=factory_create]').val();
        var modified_date = $('input[name=factory_create]').val();
         var factory_id = $('input[name=factory_id]').val();
        
        var i = $('#factory tbody tr').length;
        
        //alert(i);
        
        if(factory_code.length<1){
            //$('.error').show();
            //e.prevenDedault();
            $('#factory_code').focus();
            $('#fcode_error').show('slow');
            e.preventDefault();
            return false;
        }else{
            $('.error').hide();
        }
        if(factory_name.length<1){
            //$('.error').show();
            //e.prevenDedault();
            $('#factory_name').focus();
            $('#fname_error').show('slow');
            e.preventDefault();
            return false;
        }else{
            $('.error').hide();
        }
        
        var factdata = "factory_code="+factory_code+"&factory_name="+factory_name+"&factory_note="+factory_note+"&factory_status="+factory_status+"&fcreate="+fcreate;
        
        if(factory_status =='0'){
            var txtStatus ="ไม่ใช้งาน";
        }else{
            var txtStatus ="ใช้งาน";
        }
        
        if(editsatus==true){
            
           var html = "";
            var updatedata = "factory_id="+factory_id+"&factory_code="+factory_code+"&factory_name="+factory_name+"&factory_note="+factory_note+"&factory_status="+factory_status+"&modufied_date="+modified_date;
            
            $.ajax({
                type:"POST",
                global: false,
                url: "update_factory/"+factory_id,
                data: updatedata,
                dataType: "JSON",
                async:false,
                success: function(jd) { //แสดงข้อมูลเมื่อทำงานเสร็จ โดยใช้ each ของ jQuery             
                            
                            $('#factory tbody').html('<tr><td colspan="5"><img src="../images/ajax-loader.gif"/></td></tr>');                          
							$('#factory tbody').html("");
						$.each(jd, function(key, val){
							 
                             var product_status = val['fac_status'];
							  if(product_status =='0'){
            var txtStatus ="ไม่ใช้งาน";
        }else{
            var txtStatus ="ใช้งาน";
        }
                             
								//var opt ="<tr><td id=\"res_faccode\">"+val['fac_code']+"</td><td id=\"res_facname\">"+val['fac_name']+"</td><td>"+val['fac_note']+"</td><td>"+val['fac_status']+"</td></tr>";
                                
                                var html = "<tr><td>"+val['fac_code']+"</td><td>"+val['fac_name']+"</td><td>"+val['fac_note']+"</td><td>"+txtStatus+"</td><td><a id="+val['fac_id']+" class=\"f_edit\" href=\"javascript:void(0)\">Edit<a/> | <a href=\"javascript:void(0)\" onclick=\"delfactory("+val['fac_id']+",this)\">Delete</a></td></tr>";
                                $(html).appendTo('#factory tbody');
                                
    						});
					
		   	  }
                           
                
            });
            
        $('#factory_code').val("");
        $('#factory_name').val("");
        $('#factory_note').val("");
        $('input[name=factory_id]').val("");
        $('#btsubmit').val("INSERT");
            
            editsatus = false;
        }else{   
       
        
        //alert(factdata);
        $.ajax({           
            type: "POST",
            url: "add_data",
            data: factdata,
            cache: false,
            success:function(res){            
                if(res!=""){  
                    var fid = res; 
                     i++;
                   alert("Save Data OK" + fid);
                   
                   var html = "<tr><td>"+$('input[name=factory_code]').val()+"</td><td>"+$('input[name=factory_name]').val()+"</td><td>"+$('textarea[name=factory_note]').val()+"</td><td>"+txtStatus+"</td><td><a id="+fid+" class=\"f_edit\" href=\"javascript:void(0)\">Edit<a/> | <a href=\"javascript:void(0)\" onclick=\"delfactory("+fid+",this)\">Delete</a></td></tr>";
                    $(html).appendTo('#factory tbody');
                   
                   var factory_code = $('#factory_code').val("");
                   var factory_name =$('#factory_name').val("");
                   var factory_note = $('#factory_note').val("");
                  
                   
                   
                }
                
            },
            error:function(err){
                alert("ERROR");
            } 
            
            
        });
        
        } //end if
        
    });
    
// factory Edit
$('.f_edit').live('click',function(){
    editsatus = true;
    $('#btsubmit').val("UPDATE");
    
    var fid = $(this).attr('id');
    //var factory_code = $('#factory tbody').parent().parent([function(){$('#res_faccode').text();}]);
        //$('input[name=btsubmit]').hide();
     //$('input[name=btupdate]').show();
    //alert(fid + editsatus);
    
    $.ajax({
        type:"POST",
        url: "get_factory/"+fid,
        dataType: "json",
        success:function(res){
            $('input[name=factory_id]').val(res.factory_id);
            $('input[name=factory_code]').val(res.factory_code);
            $('input[name=factory_name]').val(res.factory_name);
            $('textarea[name=factory_note]').val(res.factory_note);
            $('select[name=factory_status]').val(res.factory_status);
            
            //alert("Select OK");
        },
        error:function(err){
            console.log("error" + err);
        }
    });
    
});
    
    
    
});

$(function(){    
    
    $('#add_tbl').live('click',function(){
        
        if($('input[name=products_code]').val()==""){
            $('#products_code').focus();
            return false;
        }
        
        if($('input[name=products_name]').val()==""){
            $('#products_name').focus();
            return false;
        }
         var i = $('#customer tbody tr').length;
        
        var product_code = $('input[name=products_code]').val();
        var product_name = $('input[name=products_name]').val();
        var product_note = $('textarea[name=products_note]').val();
        var product_status = $('select[name=products_status]').val();
        
        
        var dataString = "products_code="+product_code+"&products_name="+product_name+"&products_note="+product_note+"&products_status="+product_status;
        //alert(data_add);
        
        if(product_status =='0'){
            var txtStatus ="ไม่ใช้งาน";
        }else{
            var txtStatus ="ใช้งาน";
        }
       
        
        $.ajax({
            type: "POST",
            url: "add_product",
            data: dataString,
            cache: false,
            success:function(res){            
                if(res=="ok"){                    
                    i++;
                var html = "<tr><td>"+$('input[name=products_code]').val()+"</td><td>"+$('input[name=products_name]').val()+"</td><td>"+$('textarea[name=products_note]').val()+"</td><td>"+txtStatus+"</td></tr>";
                    $(html).appendTo('#customer tbody');
                    
                    $('input[name=products_code]').val("");
                     $('input[name=products_name]').val("");
                     $('textarea[name=products_note]').val("");
                     $('select[name=products_status]').val("");
                }
                
            },
            error:function(err){
                alert("ERROR");
            }            
            
       
        
            
            
            
        });
        
        
        //var i = $('#customer tbody tr').length;
        //i++
        //var html = "<tr><td>"+i+"</td><td> Data @"+i+"</td><td>"+i+"</td></tr>";
        
        //$(html).appendTo('#customer tbody');
        
        //alert("Click Ok"+i);
    });
   
    
    $('#cancle-product').live('click',function(){
        $('input[name=products_code]').val("");
                     $('input[name=products_name]').val("");
                     $('textarea[name=products_note]').val("");
                     $('select[name=products_status]').val("");
                     $('#products_code').focus();
        
    });
    
    $('#edit-pd').live('click',function(){
        alert("Edit");
    });
    
    $('#del-pd').live('click',function(){
        alert("Delete Product");
    });
    
    



});

$(function(){
    var editsatus = false;
    var pro_id = "";
     $('#add-product').live('click',function(e){
                
        
        if($('input[name=products_code]').val()==""){
            $('#products_code').focus();
            return false;
        }
        
        if($('input[name=products_name]').val()==""){
            $('#products_name').focus();
            return false;
        }
         var i = $('#customer tbody tr').length;
        
        var product_code = $('input[name=products_code]').val();
        var product_name = $('input[name=products_name]').val();
        var product_note = $('textarea[name=products_note]').val();
        var product_status = $('select[name=products_status]').val();
        
        
        var dataString = "products_code="+product_code+"&products_name="+product_name+"&products_note="+product_note+"&products_status="+product_status+"&pro_id="+pro_id;
        //alert(data_add);
        
        if(product_status =='0'){
            var txtStatus ="ไม่ใช้งาน";
        }else{
            var txtStatus ="ใช้งาน";
        }
        
         
        
        if(editsatus==true){
            
            //alert(editsatus+"="+pro_id );  
            //alert(editsatus);
            $.ajax({
                type: "POST",
                url: "update_product",
                data: dataString,
                cache: false,
                dataType: "JSON",
                success:function(res){
                    //alert("res="+res+"This Edit");
                    if(res!=""){
                     $('#customer tbody').html('<tr><td colspan="5"><img src="../images/ajax-loader.gif"/></td></tr>').delay(40000);
                     $('#customer tbody').html(''); 
                        
                     $.each(res,function(key,val){
                        
                        product_status = val['products_status'];
                        
                        if(product_status =='0'){
                                var txtStatus ="ไม่ใช้งาน";
                        }else{
                        var txtStatus ="ใช้งาน";
                        }
                        
                        
                        var opt = "<tr><td>"+val['products_code']+"</td><td>"+val['products_name']+"</td><td>"+val['products_note']+"</td><td>"+txtStatus+"</td><td><a href=\"javascript:void(0)\" class=\"pro_edit\" id=\""+val['products_id']+"\">Edit</a>| <a onclick=\"del('"+val['products_id']+"',this)\" href=\"javascript:void(0)\">Delete</a></td></tr>";
                        //var html2 ="<tr><td>"+val['products_code']+"</td></tr>";
                        $(opt).appendTo('#customer tbody');
                    
                     });
                     
                     
                        $('input[name=products_code]').val("");
                        $('input[name=products_name]').val("");
                        $('textarea[name=products_note]').val("");
                        $('select[name=products_status]').val("");
                         $('#add-product').val("Add");
                        
                                                
                    }
                editsatus =  false;
                 return false;
                }
            });
            
            //editsatus = false;
             //alert(editsatus);
        }     
        
       
       if(editsatus==false){ 
        /*alert(editsatus);*/
        $.ajax({
            type: "POST",
            url: "add_product",
            data: dataString,
            cache: false,
            success:function(res){            
                if(res!=""){                    
                    i++;
                    //var prod_id_id = res;
                var html = "<tr><td>"+$('input[name=products_code]').val()+"</td><td>"+$('input[name=products_name]').val()+"</td><td>"+$('textarea[name=products_note]').val()+"</td><td>"+txtStatus+"</td><td><a href=\"javascript:void(0)\" class=\"pro_edit\" id=\""+res+"\">Edit</a> | <a onclick=\"del('"+res+"',this)\" href=\"javascript:void(0)\">Delete</a></td></tr>";
                    $(html).appendTo('#customer tbody');
                    
                    $('input[name=products_code]').val("");
                     $('input[name=products_name]').val("");
                     $('textarea[name=products_note]').val("");
                     $('select[name=products_status]').val("");
                     $('#products_code').focus();
                }
                
            },
            error:function(err){
                alert("ERROR");
            }            
            
       
        
            
            
            
        });/*End of Ajax for edit false*/
        
        
      } //end of if  
        
    });
    
    
     $('.pro_edit').live('click',function(){
        pro_id = $(this).attr('id');
         editsatus = true;
       // alert(pro_id);
        
        if(pro_id!==""){
            
         var data_products_id = "products_id="+pro_id;
         
         $.ajax({
            type:"POST",
            url: "../setting/get_product",
            data: data_products_id,
            dataType: "JSON",
            cache: false,
            success:function(res){
                
                if(res!==""){
                   // alert("Select Edit OK");
                $.each(res,function(key,vals){
                    
                    $('#products_code').val(vals['products_code']);
                    $('#products_name').val(vals['products_name']);
                    $('#products_note').val(vals['products_note']);
                    $('select[name=products_status]').val(vals['products_status']);
                    
                    
                });
                
                $('#add-product').val("Update");
                //alert("Edit Status ="+editsatus);
                }
                
            }
            
            
         });   
            
            
        }
        
        
    });
    
    
    
});





function edit(id){
        alert(id);
        
    }
function del(id,obj){
    var conf = confirm("Do you want Del " +id);
    
    if(conf){
        
        $.ajax({
            url:"del_product/"+id,
            type:"POST",
            success:function(res){
                if(res=="ok"){
                  $(obj).parent().parent().remove();  
                }
            },
            error:function(eer){
                console.log("Error:" +err);
            }
        });
        
       // $(obj).parent().parent().remove();
        
        
    }else{
        return false;
    }
    
}
// del distance
function deldistance(id,obj){
    var conf = confirm("Do you want to Delete?");
    
    if(conf){
        
        $.ajax({
            url:"del_distance/"+id,
            type:"POST",
            success:function(res){
                if(res=="ok"){
                  $(obj).parent().parent().remove();  
                }
            },
            error:function(eer){
                console.log("Error:" +err);
            }
        });
        
       // $(obj).parent().parent().remove();
        
        
    }else{
        return false;
    }
    
}

//end del distance


function delfactory(id,obj){
    var conf = confirm("Do you want Del " +id);
    
    if(conf){
        
        $.ajax({
            url:"del_factory/"+id,
            type:"POST",
            success:function(res){
                if(res=="ok"){
                  $(obj).parent().parent().remove();  
                }
            },
            error:function(eer){
                console.log("Error:" +err);
            }
        });
        
       // $(obj).parent().parent().remove();
        
        
    }else{
        return false;
    }
    
}

$(function(){
    $('#menu-action').click(function(){
        
        $('.top-menu').slideToggle('fast',"swing",function(){
            
            
            
        });
        //$('#menu-action').text("Down");
    });
    
    $('#showorder-hide').click(function(){
        $('#contents').slideToggle('fast');
    });
});


//pagenation

$(function() {
	//call the function onload
	getdata( 1 );
});

function getdata( pageno ){                     
	var targetURL = 'search_results.php?page=' + pageno;   

	$('#retrieved-data').html('<p><img src="images/ajax-loader.gif" /></p>');        
	$('#retrieved-data').load( targetURL ).hide().fadeIn('slow');
}

$(function(){
    $('#company-info input:text').keypress(function(){
        $(this).css({"background-color":'#BDCC72'});
    });
});

$(function() {
	$('#popupDatepicker').datepick({showTrigger: '#calImg'});
    //$('#getSetSinglePicker').datepick({rangeSelect: true, showTrigger: '#calImg'});
	
});

//comapny
$(function(){
    $('#update-company').click(function(){
        var company_id = $('#company_id').val();
        var company_name =$('#company_name').val();    
        var company_address1 = $('#address1').val();
        var company_address2 = $('#address2').val();
        var company_city = $('#city').val();
        var company_province = $('#province').val();
        var company_postcode = $('#postcode').val();
        var company_tel = $('#tel').val();
        var company_fax = $('#fax').val();
        var company_tax_id = $('#tax_id').val();
        var modified_date = $('#modified_date').val();    
        var update_status = "update"
        var datastr = "update_status="+update_status+"&company_id="+company_id+"&company_name="+$.trim(company_name)+"&company_address1="+company_address1+"&company_address2="+company_address2+"&company_city="+company_city+"&company_province="+company_province+"&company_postcode="+company_postcode+"&company_tel="+company_tel+"&company_fax="+company_fax+"&company_tax_id="+company_tax_id+"&modified_date="+modified_date;
        //alert(datastr);
        
        if(datastr!=""){
            $.ajax({
            url:"update_company/"+company_id,
            type:"POST",
            data: datastr,
            success:function(res){
                if(res=="update-ok"){
                    alert("บันทักข้อมูลสำเร็จแล้ว");
                }
            },
            error:function(eer){
                console.log("Error:" +err);
            }
        });
        }
     
        
    });
});


//filter customer tab

$(function(){
    $('#area_code, #number1, #number2').autotab_magic().autotab_filter('numeric');
    $('.distance_number').autotab_magic().autotab_filter('numeric');
    //customer
    $('#num-group1, #num-group2, #num-group3, #num-group4, #num-group5, #num-group6, #popupDatepicker').autotab_magic().autotab_filter('numeric');
    $('#postcode1, #area_code, #number1, #mobile1, #mobile2').autotab_magic().autotab_filter('numeric');
    //$('#postcode1, #postcode2').autotab_magic().autotab_filter('numeric');
    
    //cubicode
    $('#cubic_value').autotab_filter({ format: 'custom', pattern: '[^0-9\.]' });
    //$('#cubic_value').autotab_magic().autotab_filter('numeric');
    
    
    var timecurent = $.now();
    $('#text-time').text(timecurent);
});

//distance
$(function(){
     var distance_id  =""    
    var status_update = false;
    $('#add_distance').live("click",function(){
       var distance_code = $('#distance_code').val();
       var distance_name = $('#distance_name').val();
       var distance_start = $('#distance_start').val();
       var distance_end = $('#distance_end').val();
       var distance_status = $('#distance_status').val();
         //alert("ยังไม่ได้ใส่รหัสระยะทาง");
       
       if(distance_code =="" || distance_name =="" || distance_start=="" || distance_end==""){
            if(distance_code == ""){
                alert("ยังไม่ได้ใส่รหัสระยะทาง");
                $('#distance_code').focus();
                return false;
            }
          
            if(distance_start == ""){
                alert("ยังไม่ได้ใส่รหัสระยะทางเริ่มต้น");
                $('#distance_start').focus();
                return false;
            }
            if(distance_end == ""){
                alert("ยังไม่ได้ใส่ระยะทางสิ้นสุด");
                $('#distance_end').focus();
                return false;
            }
              if(distance_name == ""){
                alert("ยังไม่ได้ใส่รายละเอียดระยะทาง");
                $('#distance_name').focus();
                return false;
            }           
        
        
       } // end if
       
       var data_distance = "distance_code="+distance_code+"&distance_name="+distance_name+"&distance_start="+distance_start+"&distance_end="+distance_end+"&distance_status="+distance_status+"&distance_id="+distance_id;
         //var data_distance =    
            //alert(data_distance);
        //alert(status_update);
       if(status_update == false){
        
        $.ajax({
            url: "../setting/add_distance",
            type: "POST",
            data: data_distance,
            dataType: "JSON",
            cache:false,
            success:function(rs){
                if(rs!==""){
                    $('#customer tbody').html('<tr><td colspan="5"><img src="../images/ajax-loader.gif" /></td></tr>');
                    $('#customer tbody').html('');
                    $.each(rs,function(key,vals){
                        
                        var status = vals['distance_status'];
                        
                        if(status==0){
                            var txt_status = "ไม่ใช้งาน";
                        }else{
                            var txt_status = "ใช้งาน";
                            
                        }
                        
                        var html ="<tr><td>"+vals['distance_code']+"</td><td>"+vals['range_min']+"</td><td>"+vals['range_max']+"</td><td>"+vals['distance_name']+"</td>";
                            html +="<td>"+txt_status+"</td><td><a class=\"edit_distance\" id=\""+vals['distance_id']+"\" href=\"javascript:void(0)\">แก้ไข</a> | <a onclick=\"deldistance('"+vals['distance_id']+"',this)\" href=\"javascript:void(0)\">ลบ</a></td></tr>";
                        
                        $(html).appendTo('#customer tbody');
                        
                    });
                    
                   
                }
                
                $('#distance_code').val("");
                    $('#distance_start').val("");
                    $('#distance_end').val("");
                    $('#distance_name').val("");
                    $('#distance_status').val("");
                
                
            } // end of success
        });
        
        
       }
       
       if(status_update == true){
        
          $.ajax({
            url: "../distance/update_distance",
            type: "POST",
            data: data_distance,
            dataType: "JSON",
            cache:false,
            success:function(rs){
                
                
                if(rs=="Insert Seccess"){
                    
                    alert("คุณไม่ได้เปลี่ยนข้อมูล");

                    
                }
       
                
                if(rs!=="Insert Seccess"){
                    $('#customer tbody').html('<tr><td colspan="5"><img src="../images/ajax-loader.gif" /></td></tr>');
                    $('#customer tbody').html('');
                    $.each(rs,function(key,vals){
                        
                        var status = vals['distance_status'];
                        
                        if(status==0){
                            var txt_status = "ไม่ใช้งาน";
                        }else{
                            var txt_status = "ใช้งาน";
                            
                        }
                        
                        //var html = "<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                        
                        var html ="<tr><td>"+vals['distance_code']+"</td><td>"+vals['range_min']+"</td><td>"+vals['range_max']+"</td><td>"+vals['distance_name']+"</td>";
                            html +="<td>"+txt_status+"</td><td><a class=\"edit_distance\" id=\""+vals['distance_id']+"\" href=\"javascript:void(0)\">แก้ไข</a> | <a onclick=\"deldistance('"+vals['distance_id']+"',this)\" href=\"javascript:void(0)\">ลบ</a></td></tr>";
                        
                        $(html).appendTo('#customer tbody');
                        
                    });
                    
                    //alert("Save Data Successfull");
                    //$('#customer tbody').html('<tr><td colspan="5"><img src="../images/ajax-loader.gif" /></td></tr>');
                }
                
                $('#distance_code').val("");
                    $('#distance_start').val("");
                    $('#distance_end').val("");
                    $('#distance_name').val("");
                    $('#distance_status').val("");
                    
                status_update = false;
            
            
            }//end of success
        });
        
        
        
        
        
       }
       
       
       
       
       
       
       
       
    }); //end #adddistance
    
    //distanc clear
    $('#cancle_distance').live("click",function(){
        $(':input').val("");
    });
    
    //distance select Edit
    $('.edit_distance').live("click",function(){
      
       status_update = true;
        
        distance_id = $(this).attr('id');
        
        var data_distance_id = "distance_id="+distance_id;
        
        if(distance_id!=""){
            
            $.ajax({
                type: "POST",
                url: "../distance/get_json_distance",
                data: data_distance_id,
                dataType: "JSON",
                success:function(res){
                        
                    if(res!==""){
                   // alert("Select Edit OK");
                $.each(res,function(key,vals){
                    
                   $('#distance_code').val(vals['distance_code']);
                    $('#distance_start').val(vals['range_min']);
                    $('#distance_end').val(vals['range_max']);
                    $('#distance_name').val(vals['distance_name']);
                    $('#distance_status').val(vals['distance_status']);
                 
                });
            
                }     
                    
                    
                }// end of success
                
                
            });
            
            
            
        }//end of if
        
        
        
    });// end of function edit_distance
    
    
});//end of edit

