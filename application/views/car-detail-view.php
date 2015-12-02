<?php $this->load->view('common/header');?>
<!-- /header-->
    <div class="container-fluid">
    <div class="row-fluid">
    <div class="span12">
    <h2><?php if(isset($h2_title)){ echo $h2_title;};?></h2>
    <form method="POST" action="" class="form-inline">
    <label><b><?php echo $this->lang->line('car_number');?></b> </label>
    <select name="carNumber">       
        <?php if(isset($car)){
            
            foreach($car as $row) { ?>
         <option value="<?php echo $row['car_id']; ?>"><?php echo $row['car_number']; ?></option>   
           
        <?php }//end foreach
         }//endif
          ?>
    
    </select>
    <label><?php echo $this->lang->line('start_date');?> </label>
    <!--<input name="startDate" type="text" id="datepicker-en-startDate" class="datepick" />-->
    <input name="startDate" id="datetimepicker1" type="text" />
    
    
    <label><?php echo $this->lang->line('end_date');?></label>
    <!--<input name="endDate" type="text" id="datepicker-en-endDate" class="datepick" />-->
    <input name="endDate" id="datetimepicker2" type="text" />
    <input class="btn btn-success" name="submit" type="submit" value="<?php echo $this->lang->line('submit');?>" />
    
    
    
    
    </form>   
    
    <?php
    if(isset($mktime)){
        echo "mktime".$mktime;
    }
    ?>
    
    </div>
    
    <hr />
    </div>
    <div class="clear"></div>
    <div class="container-fluid">
      <div class="row-fluid"> 
        <div class="span12">
         <?php if(isset($out_master)){
                    echo $out_master;
                    
      }?>
        
       </div><!--/span-->
        </div>
        </div>
        
        <div class="clear"></div>
        <div class="container-fluid">
        <div class="row-fluid">
        <div class="span12">
        
        <ul class="nav nav-tabs" id="myTab">
  <li class="active"><a href="#home">รายการเดินรถ</a></li>
  <li><a href="#profile">รายการเติมน้ำมัน</a></li>
  <li><a href="#messages">รายการค่าใช้จ่ายต่างๆ</a></li>
  <!--<li><a href="#settings">Summary</a></li>-->
</ul>
 
<div class="tab-content">
  <div class="tab-pane active" id="home">

<div style="padding: 10px;">           
  <?php if(isset($out_order )){
        
        echo $out_order;
    }?>
  </div>    
    
  </div><!-- /home -->
  <div class="tab-pane" id="profile">
  <div style="padding: 10px;"> 
     <?php if(isset($out_oilList)){
    
        echo $out_oilList;
  }?>
  
  </div>
  </div><!-- /profile -->
  <div class="tab-pane" id="messages">
  <!-- Oil-->
  <div> 
  <?php
    if(isset($out_expensecarList)){
        echo $out_expensecarList;
    }
  
  ?>
  </div>
  </div>
  
</div>

<script>
  $('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
})
</script>
        
        </div>
        </div>
        </div>
        </div><!-- /containner -->
        
       <script>
       
function grid2_onload()
{
      var grid = $("#list2");
           sum = grid.jqGrid('getCol', 'total_amount',false,'sum');
       grid.jqGrid('footerData','set', {note: 'รวม: ',total_amount: ''+parseFloat(Math.round(sum*100)/100).toFixed(2) });
}
</script>

<script>
$(function () {
		    var d = new Date();
		    var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543);
            var toDayEng = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear());


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
             
            // $("#datepicker-en-startDate").datepicker({ dateFormat: 'dd/mm/yy'});
           // $("#datepicker-en-endDate").datepicker({ dateFormat: 'dd/mm/yy'});
           
           $("#datepicker-en-startDate").datepicker({ dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDayEng, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
                 monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
            
            
              $("#datepicker-en-endDate").datepicker({ dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDayEng, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
           
             
             $("#datepicker-endDate-th").datepicker({ dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
             
             
             
             
             
             

		    $("#inline").datepicker({ dateFormat: 'dd/mm/yy', inline: true });


			});
</script>

<script>
$(function(){
    $("input[name=submit]").click(function(){
        var st_date = $('input[name=startDate]').val();
        var ed_date = $('input[name=endDate]').val();
        
        if(st_date==""){
            $('input[name=startDate]').focus();
            return false;
        }
        
        if(ed_date==""){
            $('input[name=endDate]').focus();
            return false;
        }
        
        
        
    });
    
});
jQuery('#datetimepicker1').datetimepicker();
jQuery('#datetimepicker2').datetimepicker();
</script>
		
<!-- //footer -->
<?php $this->load->view('common/footer');?>