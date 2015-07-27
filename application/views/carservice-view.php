<?php $this->load->view('common/header');?>
<!-- /header-->
    <div class="container-fluid">
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
   
    <div class="span3">
    <span class="h2_title"><?php if(isset($h2_title)){ echo $h2_title;};?></span>
    </div>
    <div class="span5">
    <div style="float: left; padding-bottom: 2px;"> 
    <button class="btn btn-info" type="button" onclick="$('#search_list2').click()"><?php echo $this->lang->line('search_data');?></button>
    </div>
    </div>
    <div class="span4">
        <div style="float: right; padding-bottom: 2px;">
        <button class="btn btn-success" type="button" onclick="$('#add_list2').click()"><?php echo $this->lang->line('new_data');?></button>
        <button class="btn btn-warning" type="button" onclick="$('#edit_list2').click()"><?php echo $this->lang->line('edit_data');?></button>
        <button class="btn btn-danger" type="button" onclick="$('#del_list2').click()"><?php echo $this->lang->line('del_data');?></button> 
        </div>
    </div>
  
    </div>
    <div class="clear"></div>
      <div class="row-fluid">
      
		
        <div class="span12">
          <div class="row-fluid">
            <div class="span2">			
				<?php echo $out;?>
                
                <?php if(isset($out_master)){
                    echo $out_master;
                    
                }?>
                <br />
                
                

            </div><!--/span-->
            <div class="span10">
            <div class="row-fluid">
            <div class="span12">
            <?php if(isset($out_detail)){
                    echo $out_detail;
                    
                }?>
            
            </div>
             
            </div>
           
            </div>
          </div><!--/row-->
        </div><!--/span-->
        </div>
        </div><!-- /containner -->
        
       <script>
function grid2_onload()
{
      var grid = $("#list2");
           sum = grid.jqGrid('getCol', 'total_amount',false,'sum');
       grid.jqGrid('footerData','set', {expense_details: 'รวม: ',total_amount: ''+parseFloat(Math.round(sum*100)/100).toFixed(2) });
       
       /*Auto Tap*/
       $('body').on('keydown', 'input, select, textarea', function(e) {
                var self = $(this)
                  , form = self.parents('form:eq(0)')
                  , focusable
                  , next
                  ;
                if (e.keyCode == 13) {
                    focusable = form.find('input,a,select,button,textarea').filter(':visible');
                    next = focusable.eq(focusable.index(this)+1);
                    if (next.length) {
                        next.focus();
                    } else {
                        form.submit();
                    }
                    return false;
                }
            });
}
</script>
		
<!-- //footer -->
<?php $this->load->view('common/footer');?>