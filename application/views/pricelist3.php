<?php $this->load->view('common/header');?>
<!-- /header-->
    <div class="container-fluid">
    <div class="row-fluid">
    <div class="row-fluid">
   
    <!--<p><?php echo $this->session->userdata('user_id');
        echo $this->session->userdata('user_name');
        echo $this->session->userdata('user_surname');
        echo $this->session->userdata('user_lastaccess');
        echo $this->session->userdata('user_cizacl_role_id');
        var_dump($this->cizacl->check_hasRole(3));
        var_dump($this->cizacl->check_hasRole('Administrator'));
        ?>
        
        
        </p>-->
        <div class="span12">
       <!--        
        <button class="btn btn-success" type="button" onclick="$('#add_list1').click()"><?php echo $this->lang->line('new_data');?></button>
        <button class="btn btn-warning" type="button" onclick="$('#edit_list1').click()"><?php echo $this->lang->line('edit_data');?></button>
        <button class="btn btn-danger" type="button" onclick="$('#del_list1').click()"><?php echo $this->lang->line('del_data');?></button> 
    -->
    
    <form class="form-inline" action="" method="POST">
        <legend><?php if(isset($title_form)){echo $title_form;}?></legend>
        
      
       
        <label class="control-label"><?php echo $this->lang->line('factory');?> </label>
      
        <select name="factory">       
        <?php if(isset($factory)){
            
            foreach($factory as $row){ $factory_id = $row['factory_id']; $factory_name = $row['factory_name'];  ?>
            
        <option value="<?php echo $factory_id?>" <?php if($select_fatory==$factory_id){ echo "selected"; }?>><?php echo $factory_name?></option>
          
          <?php  }
            
        }?>
       
        </select>
<label class="control-label" for="startdate"><?php echo $this->lang->line('start_date'); ?></label>
<input name="startDate" type="text" id="datepicker-th" class="datepick" />
 <label class="control-label" for="enddate"><?php echo $this->lang->line('end_date');?></label>
<input name="endDate" type="text" id="datepicker-endDate-th" class="datepick" />
<input class="btn btn-success" name="submit" type="submit" value="<?php echo $this->lang->line('submit');?>" />   
        </form>
    
    </div>  
    </div>   
    </div>
    <div class="clear"></div>
    <div class="row-fluid">    
        <div class="span12">
        <?php if(isset($pricetable)){
           echo $pricetable;
        }?>
        <span id="span_extra"></span>
        <br />
      <!--  <button class="btn btn-warning" type="button" onclick="$('#edit_list1').click()"><?php echo $this->lang->line('edit_data');?></button>-->
        <?php if(isset($dispyPrice2)){
            
           //print_r($dispyPrice2);
        }?>
        </div><!--/span12-->
     <div class="span12">
     <div id="example1"></div>
     </div>   
        
    </div><!--/row-fluid-->
    
      
</div>
<style>
.edit-cell input{
    width:10px
}

</style>

<script> 
    function do_onselect(id) 
    { 
        alert('Simulating, on select row event') 
       // var rd = jQuery('#list1').jqGrid('getCell', id, '2'); // where invdate is column name 
       // var rd = jQuery('#list1').jqGrid('getGridParam','selarrrow'); 
       //var rd = jQuery('#list1').jqGrid('getCell', selectedRow, '2');
        var rd = jQuery('#list1').jqGrid('getGridParam','selrow');
        jQuery("#span_extra").html(rd); 
    } 
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
<div class="container-fluid">
		
<!-- //footer -->
<?php $this->load->view('common/footer');?>