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
        <form class="form-horizontal" method="post" action="">
        <legend>รายงานสรุปการใช้รถโม่</legend>
        
        <div class="control-group">
    <label class="control-label" for="inputEmail"><?php echo $this->lang->line('factory'); ?></label>
    <div class="controls">
      <select name="factory">
        <option value="All" selected=""><?php echo $this->lang->line('All');?></option>
        <?php if(isset($factory)){
            foreach($factory as $rs){ ?>
                <option value="<?php echo $rs['factory_id']?>"><?php echo $rs['factory_code'];?> (<?php echo $rs['factory_name']?>)</option>
            <?php }
            
        }?>
        
        </select>
    </div>
  </div>
  
  <div class="control-group">
  <label class="control-label" for="startdate"><?php echo $this->lang->line('start_date'); ?></label>
  <div class="controls">
   <input name="startDate" type="text" id="datepicker-th" class="datepick" />
  </div>
  
  </div>
  
  <div class="control-group">
  <label class="control-label" for="enddate"><?php echo $this->lang->line('end_date');?></label>
  <div class="controls">
  <input name="endDate" type="text" id="datepicker-endDate-th" class="datepick" />
  </div>
  </div>
  
  <div class="control-group">

  <div class="controls">
  <label class="radio">
            <input type="radio" name="carType" id="optionsRadios1" value="CarTruck"/>รถโม่
        </label>
      <!--  
        <label class="radio">
            <input type="radio" name="carType" id="optionsRadios2" value="CarCustom"  />ระบุรถ
        </label>
        -->
  </div>  
  </div>
  
  <div class="control-group">
   <div id="div_CarTruck" class="desc">
  <label class="control-label" for="carNumber">หมายเลขรถ</label>
  <div class="controls">
  <select name="carNumber">
        <option value="All">ทั้งหมด</option>
        <?php 
        if(isset($car)){
            foreach ($car as $rs_car){ ?>
        
        <option value="<?php echo $rs_car['car_id']?>"><?php echo $rs_car['car_number']?></option>
        
        <?php                
                
            }
        }
        
        ?>
        
        </select>
  </div>
   </div>
  
   <div id="div_CarCustom" class="desc">
  <label class="control-label" for="carLicense">ระบุทะเบียนรถ</label>
  <div class="controls">
  <input type="text" name="carLicense" value="" />
  </div>
  </div>
  </div>
  
  <div class="control-group">  
  <div class="controls">
  

        <button name="submit" id="submit" type="submit" class="btn btn-primary">ออกรายงาน</button>
        <button type="burron" class="btn">ล้างฟอร์ม</button>
  
  </div>
  
  </div>
  
        
        </form><!-- and /form-->
        
        <div>
     
        <?php 
            if(isset($report_status)){
                echo $report_status;
                
            }
        ?>
        </div>
</div><!--#form-bg-->        
        
<script>
$(document).ready(function() {
    $("div.desc").hide();
    $("input[name$='carType']").click(function() {
        var test = $(this).val();
        $("div.desc").hide();
        $("#div_" + test).show();
    });
});

</script>        
        
        
        <script>
        $(function(){
            $('#submit').click(function(){
                
               var dateStart = $('input[name=startDate]').val();
               var dateEnd = $('input[name=endDate]').val();
               
               if(dateStart==""){
                $('input[name=startDate]').focus();
                return false;
               }
                if(dateEnd==""){
                $('input[name=endDate]').focus();
                return false;
               }
               
                 var $radios = $('input:radio[name=carType]');
                if($radios.is(':checked') === false) {
                   // $radios.filter('[value=Male]').prop('checked', true);
                    alert('Warning! จำเป็นต้องระบุรถ');
                    return false;
                }
               /*
                if (!$("input[@name='carType']:checked").val()) {
                     alert('Nothing is checked!');
                    return false;
                }
                 else {
                alert('One of the radio buttons is checked!');
                 }
                */              
               
               
                
            });
        });
        
        
        </script>
    
        </div><!--/span10-->
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
$(function () {
		    var d = new Date();
		    var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543);


		    // กรณีต้องการใส่ปฏิทินลงไปมากกว่า 1 อันต่อหน้า ก็ให้มาเพิ่ม Code ที่บรรทัดด้านล่างด้วยครับ (1 ชุด = 1 ปฏิทิน)

		    $("#datepicker-th").datepicker({ dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});

		    $("#datepicker-th-2").datepicker({ changeMonth: true, changeYear: true,dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay,dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
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