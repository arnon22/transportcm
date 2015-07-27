<?php $this->load->view('common/header');?>
<!-- /header-->
    <div class="container-fluid">
    <div class="row-fluid">
    <div class="span12">
    <p><?php #echo $this->session->userdata('user_id');
      //  echo $this->session->userdata('user_name');
      //  echo $this->session->userdata('user_surname');
       // echo $this->session->userdata('user_lastaccess');
        //echo $this->session->userdata('user_cizacl_role_id');
       // var_dump($this->cizacl->check_hasRole(3));
       // var_dump($this->cizacl->check_hasRole('Administrator'));
      //  var_dump($this->cizacl->check_isAllowed($this->session->userdata('user_cizacl_role_id'), 'cizacl'));
        ?>
        
        
        </p>
    </div>
    <hr />
    </div>
    <div class="clear"></div>
    <div class="row-fluid">
    <div class="span12">
  
                
                <?php if(isset($out_index)){
                    echo $out_index;
                    
                }?>
    </div>
    </div>
    <div class="clear"></div>
      <div class="row-fluid">
       <!-- <div class="span2">
			<div class="accordion" id="accordion_menu">
					
			</div>
		  
		  
        </div><!--/span-->
		
        <div class="span12">
          <div class="row-fluid">
            <div class="span3">			
				<?php echo $out;?>
                
                <?php if(isset($out_master)){
                    echo $out_master;
                    
                }?>
                <br />
                
                

            </div><!--/span-->
            <div class="span9">
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
		
<!-- //footer -->
<?php $this->load->view('common/footer');?>