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
   
    <div class="span4">
    <button class="btn btn-info" type="button" onclick="$('#search_list1').click()"><?php echo $this->lang->line('search_data');?></button>
    
    </div>
    <div class="span4"></div>
    <div class="span4">
        <button class="btn btn-success" type="button" onclick="$('#add_list1').click()"><?php echo $this->lang->line('new_data');?></button>
        <button class="btn btn-warning" type="button" onclick="$('#edit_list1').click()"><?php echo $this->lang->line('edit_data');?></button>
        <button class="btn btn-danger" type="button" onclick="$('#del_list1').click()"><?php echo $this->lang->line('del_data');?></button> 
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
        <button class="btn btn-warning" type="button" onclick="$('#edit_list1').click()"><?php echo $this->lang->line('edit_data');?></button>
        <?php if(isset($dispyPrice)){
           #print_r($dispyPrice);
        }?>
        </div><!--/span12-->
        
        
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
$('#example').handsontable({
  data: <?php echo $data;?>,
  minSpareRows: 1,
  colHeaders: true,
  contextMenu: true
});

</script>
<div class="container-fluid">
		
<!-- //footer -->
<?php $this->load->view('common/footer');?>