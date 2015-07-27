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
    <div class="clear"></div>
       <div class="row-fluid">
        <div class="span12">
          <div style="margin:2px"> </div>
          <?php if(isset($out)){
                echo $out;
            
          }?>
          
          
        </div><!--/span12-->
        <div class="clear"></div>
		</div><!-- /row-fluid-->
        
<!-- //footer -->

 
    
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
<?php $this->load->view('common/footer');?>