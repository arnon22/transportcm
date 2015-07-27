<?php

$this->load->view('common/header');

?>
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
    <button class="btn btn-info" type="button" onclick="$('#search_list1').click()"><?php echo $this->lang->line('search_data');?></button>
    <button class="btn btn-inverse" type="button" onclick="$('#refresh_list1').click()"><?php echo $this->lang->line('refresh');?></button>
    </div>
    <div class="span5">
    <div style="float: left; padding-bottom: 2px;"> 
    <span class="h2_title"><?php if(isset($h2_title)){ echo $h2_title;};?></span>
    </div>
    </div>
    <div class="span4">
        <div style="float: right; padding-bottom: 2px;">
        <button class="btn btn-success" type="button" onclick="$('#add_list1').click()"><?php echo $this->lang->line('new_data');?></button>
        <button class="btn btn-warning" type="button" onclick="$('#edit_list1').click()"><?php echo $this->lang->line('edit_data');?></button>
        <button class="btn btn-danger" type="button" onclick="$('#del_list1').click()"><?php echo $this->lang->line('del_data');?></button> 
        </div>
    </div>
  
    </div>
    
  
        
    
    <script>
    var opts = {
        'loadComplete': function () {
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
    };
</script>

<script>

function update_vat()
{
    var set_vat = 0.07;
    
    $itemprice = parseFloat($('input[name="total_price"]:visible').val());
    $sum_vat = $itemprice*parseFloat(set_vat);
    
     jQuery('input[name="total_vat"]:visible').val(parseFloat(Math.round($sum_vat*100)/100).toFixed(2));
            
      $total = $itemprice+$sum_vat;      
            
      jQuery('input[name="total_amount"]:visible').val(parseFloat(Math.round($total * 100)/100).toFixed(2));                
                 
            
}


</script>

   
  
    <div class="clear"></div>
    <div class="row-fluid">
    <div class="span12">
    <?php

if (isset($out))
{
    echo $out;

}

?>
    
    </div>
    </div><!--/row-fluid -->
    <script>
     jQuery('#ref_number').focus();
     
     $(function(){
        ('#ref_number').focus();
     });
     
     
    
    </script>
      
</div>
<div class="container-fluid">
		
<!-- //footer -->
<?php

$this->load->view('common/footer');

?>