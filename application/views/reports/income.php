<?php

$this->load->view('common/header');

?>

  <style>
        .report-income select{
            background: #ECCA42;
        }
        </style>
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
      
        <div id="form-bg">
        <!--<form id="report-income" action="gen_income_report" method="POST" class="form-horizontal" >-->
        <form id="report-income" action="" method="POST" class="form-horizontal" >
        <legend>รายงานรายรับ</legend>
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
      
      <div class="control-group">
        <label class="control-label">**หมายเหตุ</label>
        
        <div class="controls">
            <select name="income_remark">
            <option value="All" selected=""><?php

echo $this->lang->line('All');

?></option>
            <?php
            if(isset($remark)){
                foreach($remark as $r_note){ ?>
                    
                 <option value="<?php echo $r_note['note']?>"><?php echo $r_note['note']?></option>   
                    
            <?php    }
                
            }
            ?>
               
            </select>
        </div>
      
      </div><!--/control-group-->
      
      <div class="control-group">        
        
        <div class="controls">
        <input type="submit" value="ออกรายงาน" name="submit" id="search" class="btn btn-success" />
        <input type="button" name="clear" id="clear" class="btn btn-danger" value="ล้างฟอร์ม" />
        
        </div>
      
      </div><!--/control-group-->

      
        
                
        </form><!--/form-->
        <div id="status">
        
        <?php if(isset($report_status)){
            echo $report_status;
        }?>
        
        </div>
        </div>
      
      
        </div><!--/span9-->
        </div><!-- row-fluid-->
        </div><!--/span12-->
            

</div><!-- /div.row -->
</div><!--/container--> 
<script>
    $(function(){
        $("#search").click(function(){
            
            var startdate =$("input[name=startDate]").val();
            var enddate = $("input[name=endDate]").val();
            if(startdate==""){
                $("input[name=startDate]").focus();
                return false;
            }
            if(enddate==""){
                $("input[name=endDate]").focus();
                return false;
            }
            
            var dataString = "startDate="+startdate+"&endDate="+enddate;
            //dataString.trim();
            
  
          /*
          $.ajax({
  type: "POST",
  url: "gen_income_report",
  data: dataString.trim(),//$('form#report-income').serialize(),  
  success: function() 
        {
          // Load
          window.open('gen_income_report', '_newtab2');
  }
  });
 
    */        
           // alert(data);
            
        });
        
      $('#clear').click(function(){
         $('input[type=text]').each(function() {
        $(this).val('');
    });
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