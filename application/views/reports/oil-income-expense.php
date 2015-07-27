<?php $this->load->view('common/header');?>
<!-- /header-->
    <div class="container-fluid">
    <div class="row-fluid">
    <div class="span12">
    <h2><?php if(isset($h2_title)){ echo $h2_title;};?></h2>
   
    </div>

    </div>
    <div class="clear"></div>
      <div class="row-fluid">		
        <div class="span12">
        <div class="row-fluid">
        <div class="span3">
        <!--left menu-->
        <?php echo $this->load->view('common/left-menu-report');?>
        
        </div><!--/span2-->
        <div class="span9">
        <div id="form-bg">
        
        <form action="" method="POST" class="form-horizontal">
        
        <legend>รายงาน รับ/จ่ายน้ำมัน</legend>
        
        <div class="control-group">
        <label class="control-label">เลือกประเภทรายงาน</label>
        
        <div class="controls">       
        <input name="oilType" value="receive" type="radio" <?php if($this->session->userdata('oilType')=="receive"){ echo "checked=\"checked\" ";}?>/>รับน้ำมัน
        <input name="oilType" value="pay" type="radio" <?php if($this->session->userdata('oilType')=="pay"){ echo "checked=\"checked\" ";}?> />จ่ายน้ำมัน
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label"><?php echo $this->lang->line('factory');?></label>
        
        <div class="controls">
        <select name="factory">
        <option value="All" selected=""><?php

echo $this->lang->line('All');

?></option>
        <?php

if (isset($factory))
{
    foreach ($factory as $rs)
    {

?>
                <option value="<?php

        echo $rs['factory_id']

?>"><?php

        echo $rs['factory_code'];

?> (<?php

        echo $rs['factory_name']

?>)</option>
            <?php

    }

}

?>
        
        </select>
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label"><?php echo $this->lang->line('start_date');?></label>
        <div class="controls">
        <input name="startDate" type="text" id="datepicker-startDate-th" class="datepick" />
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label"><?php echo $this->lang->line('end_date');?></label>
        <div class="controls">
        <input name="endDate" type="text" id="datepicker-endDate-th" class="datepick" />
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">ลูกค้า</label>
        <div class="controls">
        <select name="customer">
            <option value="All">ทั้งหมด</option>  
            <?php if(isset($customer)){
                foreach($customer as $row){
                    
                    echo "<option value=\"{$row['customer_id']}\">{$row['customers_name']}</option>";
                }
                
            }?>      
        </select>
        
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">ระบุรถ</label>
        <div class="controls">
        <select name="car_number">
            <option value="All">ทั้งหมด</option>
            <?php if(isset($car_number)){
                foreach($car_number as $row){
                    
                    echo "<option value=\"{$row['car_id']}\">{$row['car_number']}</option>";
                }
                
            }?> 
            
        </select>
        </div>
        </div>
        
        <div class="control-group">
        
        <div class="controls">
        <input id="submit-form" type="submit" name="submit" value="สร้างรายงาน" class="btn btn-success" />
     
        </div>          
        </form><!--/form-->
        
        <div>
     
        <?php 
            if(isset($report_status)){
                echo $report_status;
                
            }
        ?>
        </div>
        </div>
               
        </div><!--/span9-->
        </div><!-- row-fluid-->
        </div><!--/span12-->
            

</div><!-- /div.row -->
</div><!--/container--> 



<script>
var opts = {

    'loadComplete': function () {
        var grid = $("#list2");
            sum = grid.jqGrid('getCol', 'total_amount',false,'sum');
        grid.jqGrid('footerData','set', {note: 'Total: ',total_amount: ''+sum});
    },

};
</script>

<script>
$(document).ready(function() {
    $("div.desc").hide();
    $("input[name$='oilType']").click(function() {
        var test = $(this).val();
        $("div.desc").hide();
        $("#div_" + test).show();
    });
    
   $('#submit-form').click(function(){
 
    var startDate = $('input[name=startDate]').val();
    var endDate = $('input[name=endDate]').val();
    if(startDate==''){
        $('input[name=startDate]').focus();
        return false;
    }
    if(endDate==''){
        $('input[name=endDate]').focus();
        return false;
    }
    
    
   });
});
</script>
<script>
$(function () {
		    var d = new Date();
		    var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543);
            var toEnDay = d.getDate() + '-' + (d.getMonth() + 1) + '-' + (d.getFullYear());    

		    // กรณีต้องการใส่ปฏิทินลงไปมากกว่า 1 อันต่อหน้า ก็ให้มาเพิ่ม Code ที่บรรทัดด้านล่างด้วยครับ (1 ชุด = 1 ปฏิทิน)

		    $("#datepicker-th").datepicker({ dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});

		    $("#datepicker-th-2").datepicker({ changeMonth: true, changeYear: true,dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay,dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
              
              $("#datepicker-startDate-th").datepicker({ changeMonth: false, changeYear: false,dateFormat: 'dd-mm-yy', isBuddhist: true, defaultDate: toEnDay,dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
              
              $("#datepicker-endDate-th").datepicker({ changeMonth: false, changeYear: false,dateFormat: 'dd-mm-yy', isBuddhist: true, defaultDate: toEnDay,dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});

            
             $("#datepicker-en").datepicker({ dateFormat: 'dd/mm/yy'});             
             
             $("#datepicker-endDate-th").datepicker({ dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
             

		    $("#inline").datepicker({ dateFormat: 'dd/mm/yy', inline: true });


			});
</script>
		
<!-- //footer -->
<?php $this->load->view('common/footer');?>