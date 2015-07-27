<?php

$this->load->view('common/header');

?>
<!-- /header-->
    <div class="container-fluid">
    <div class="row-fluid">
    <div class="span12">
    <h2><?php

if (isset($h2_title))
{
    echo $h2_title;
}
;

?></h2>
   
    </div>

    </div>
    <div class="clear"></div>
      <div class="row-fluid">		
        <div class="span12">
        <div class="row-fluid">
        <div class="span3">
        <!--left menu-->
        <?php

echo $this->load->view('common/left-menu-report');

?>
        
        </div><!--/span2-->
        <div class="span9">
        <style>
        .report-income select{
            background: #ECCA42;
        }
        </style>
        
       <div id="form-bg">      
       <form id="report-income" action="" method="POST" class="form-horizontal" >
       <legend>รายงาน รายจ่ายทั่วไป/รายจ่ายเกี่ยวกับรถ</legend>
        <div class="control-group">
            <label class="control-label">โรงงาน</label>
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
        </div><!--/control-group-->
      <div class="control-group">
        <label class="control-label">เริ่มวันที่</label>
        
         <div class="controls">
             <input name="startDate" type="text" id="datepicker-startDate-th" class="datepick" />
         </div>
        
        
      </div><!--/control-group-->
      
      <div class="control-group">
        <label class="control-label">สิ้นสุดวันที่</label>
      
        <div class="controls">
             <input name="endDate" type="text" id="datepicker-endDate-th" class="datepick" />
            
        </div>
      </div><!--/control-group-->
      
      <div class="controls">
        <label class="radio">
            <input type="radio" name="expenseType" id="optionsRadios1" value="normal"/>รายจ่ายทั่วไป
        </label>
        <label class="radio">
            <input type="radio" name="expenseType" id="optionsRadios2" value="car"  />รายจ่ายเกี่ยวกับรถ
        </label>
      </div>
      
      <div class="control-group">       
        
        <div id="div_normal" class="desc">
         <label class="control-label">**หมายเหตุ</label>
        
            <div class="controls">
                <select name="remark">
                <option value="All">ทั้งหมด</option>
                <?php 
                if(isset($normal_remark)){
                    foreach($normal_remark as $rs){
                        
                        echo "<option value=\"{$rs['note']}\">".$rs['note']."</option>";
                    }
                    
                }
                
                ?>
                
                
                </select>
            </div>
        </div>
        
    <div id="div_car" class="desc">
         <label class="control-label">หมายเลขรถ</label>
         <div class="controls">
           
        <select name="car_number">
        <option value="All" selected="selected">ทั้งหมด</option>
        <?php if(isset($car)){
            foreach($car as $row){
                echo "<option value=\"{$row['car_id']}\">{$row['car_number']}</option>";
            }
        }?>
        </select>
        </div>
        
          <label class="control-label">**หมายเหตุ</label>
        
            <div class="controls">
                <select name="car_remark">
                <option value="All">ทั้งหมด</option>
                <?php 
                if(isset($car_remark)){
                    foreach($car_remark as $rs){
                        
                        echo "<option value=\"{$rs['note']}\">".$rs['note']."</option>";
                    }
                    
                }
                
                ?>
                
                
                </select>
            </div>
        
    </div>
      
      </div><!--/control-group-->      
      <div class="control-group">          
        <div class="controls">
       <input type="submit" value="สร้างรายงาน" name="submit" id="submit" class="btn btn-success"  />
        <input type="hidden" name="action" value="send" />
        <!--<input type="button" name="submit" id="search" class="btn btn-success" value="Search" />-->        
        </div>      
      </div><!--/control-group-->
        </form><!--/form-->
        <div id="status">     
        <?php if(isset($report_status)){
            echo $report_status;
        }?>
        </div>      
        
        </div>
        
        
<script>
$(document).ready(function() {
    $("div.desc").hide();
    $("input[name$='expenseType']").click(function() {
        var test = $(this).val();
        $("div.desc").hide();
        $("#div_" + test).show();
    });
});

</script> 
        
        </div><!--/span9-->
        </div><!-- row-fluid-->
        </div><!--/span12-->
            

</div><!-- /div.row -->
</div><!--/container--> 
<script>
    $(function(){
        
        $('#submit').click(function(){
            
                var startdate =$("input[name=startDate]").val();
            var enddate = $("input[name=endDate]").val();
            var expenseType = $('input[name=expenseType]:checked').val(); 
            
            if(startdate==""){
                $("input[name=startDate]").focus();
                return false;
            }
            if(enddate==""){
                $("input[name=endDate]").focus();
                return false;
            }
            
              var $radios = $('input:radio[name=expenseType]');
                if($radios.is(':checked') === false) {
                   // $radios.filter('[value=Male]').prop('checked', true);
                    alert('Warning! จำเป็นต้องระบุ');
                    return false;
                }
            
            
            
        });
        
        
        $("#search").click(function(){
            
            var startdate =$("input[name=startDate]").val();
            var enddate = $("input[name=endDate]").val();
            var expenseType = $('input[name=expenseType]:checked').val(); 
            
            if(startdate==""){
                $("input[name=startDate]").focus();
                return false;
            }
            if(enddate==""){
                $("input[name=endDate]").focus();
                return false;
            }
            
            var $radios = $('input:radio[name=expenseType]');
                if($radios.is(':checked') === false) {
                   // $radios.filter('[value=Male]').prop('checked', true);
                    alert('Warning! จำเป็นต้องระบุ');
                    return false;
                }
            
            
            
            //var dataString = "startDate="+startdate+"&endDate="+enddate;
            var dataString = $('form#report-income').serialize();
            
  
          
          $.ajax({
  type: "POST",
  url: "<?php echo base_url()?>ireport/gen_expense_report",
  data: dataString.trim(),//$('form#report-income').serialize(), 
  //contentType: "application/octet-stream",                
  dataType: 'json',  
  cache:false,
  success: function(rs) 
        {
            
          
           
            $.each(rs, function(i, val) {
                 var htm = val;
                  window.open(
                            'data:application/pdf,'+encodeURIComponent(htm),
                            'Batch Print',
                            'width=600,height=600,location=_newtab'
                        );
                 alert(rs);
            });
            
            
  }
  });
 
            
           // alert(data);
            
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
<?php

$this->load->view('common/footer');

?>