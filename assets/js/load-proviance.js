$(function(){
    $('#province1').change(function(){
       $('#PostID').text("");
       var ID = "";
       
       //ID = $(this).val();
       
       //var data_qampur = "ID="+ID+"&TYPE=Amphur";
        
        $.ajax({
			  url: "customers/getamphur",//ที่อยู่ของไฟล์เป้าหมาย
			  global: false,
			  type: "POST",//รูปแบบข้อมูลที่จะส่ง
			  data:  "ID="+$(this).val()+"&TYPE=Amphur", //data_qampur, //ข้อมูลที่ส่ง  { ชื่อตัวแปร : ค่าตัวแปร }
			  dataType: "JSON", //รูปแบบข้อมูลที่ส่งกลับ xml,script,json,jsonp,text
			  async:false,
			  success: function(jd) { //แสดงข้อมูลเมื่อทำงานเสร็จ โดยใช้ each ของ jQuery             
                            
							var opt="<option value=\"0\" selected=\"selected\">---เลือกอำเภอ---</option>";
							$.each(jd, function(key, val){
								opt +="<option value='"+ val['amphur_id']+"'>"+val['amphur_name']+"</option>"
    						});
							$("#aumpher1").html( opt );//เพิ่มค่าลงใน Select ของอำเภอ */
		   	  }
		});	
        
        
        $('#PostID').text($(this).val());
        
               
        
    });
});
