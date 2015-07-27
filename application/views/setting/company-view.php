<?php $this->load->view('common/header-bootstrap')?>
<!-- header-->
<!-- container -->
<!-- container -->
    <div class="container-fluid">
    
    
      <h2><?php echo $this->lang->line('products_data')?></h2>
      
      
      <div class="row-fluid">
      <div class="span2">
      <!-- Left menu position -->
      <?php
      
      $this->load->view('left-menu/setting-left-menu');
      
      ?>
      
      </div>
      <div class="span10">
         <ul class="nav nav-tabs">
    <li><a href="#home" data-toggle="tab"><?php echo $this->lang->line('list_show');?></a></li>
    <li><a href="#profile" data-toggle="tab">Add Factory</a></li>
    <li><a href="#messages" data-toggle="tab">Messages</a></li>
    <li><a href="#settings" data-toggle="tab">Settings</a></li>
    </ul>
     
    <div class="tab-content">
    <div class="tab-pane active" id="home">
    
    
     
     <table class="table table-hover">
      <caption></caption>
      <thead>
      <tr>
      <!-- <th><?php echo $this->lang->line('index');?></th>
      <th><?php echo $this->lang->line('products_code');?></th>
      <th><?php echo $this->lang->line('products_name');?></th>
      <th><?php echo $this->lang->line('note');?></th>
      
      
     
      <th></th>
      
      -->
      </tr>
      
      </thead>
      
      <tbody>
      <?php
      if($results!=null){
        
        $i=$this->uri->segment(3)+1;
        
        foreach($results as $company)
        
        
        {?>
        
        
        
            
      <tr>
      
      <td><?php echo $i ?></td>
      <td><?php echo iconv('UTF-8','TIS-620',$company->company_name);?></td>      
      <td><?php echo iconv('UTF-8','TIS-620',$company->company_address1);?></td>
      <td><?php echo iconv('UTF-8','TIS-620',$company->company_address2);?></td>
      
      
      
      </tr>
            
        
        
        <?php $i++; }//end foreach
        
        
      }
      
      ?>
      
      
      
      
      
      
      </tbody>
      
      </table>
      
    
    
    </div>
    
    <!-- Tab2 -->
    <div class="tab-pane" id="profile">
    <h3>Company Profile</h3>
    
    
    <form class="form-horizontal">
    
    <?php 
    
        foreach($company_info as $data){ ?>
        
    <div class="control-group">
            <label class="control-label" for="company_name"><?php echo $this->lang->line('company_name');?></label>
        <div class="controls">
            <input type="text" name="company_name" id="company_name" value="<?=iconv('utf-8','tis-620',$data['company_name']);?>" /> 
        </div>
    </div>
    
    <div class="control-group">
            <label class="control-label" for="company_name"><?php echo $this->lang->line('company_adds1');?></label>
        <div class="controls">
            <input  class="input-xxlarge" type="text" name="company_name" id="company_name" value="<?=iconv('utf-8','tis-620',$data['company_address1']);?>" /> 
        </div>
    </div>
    
    <div class="control-group">
            <label class="control-label" for="company_name"><?php echo $this->lang->line('company_adds2');?></label>
        <div class="controls">
            <input class="input-xxlarge" type="text" name="company_name" id="company_name" value="<?=iconv('utf-8','tis-620',$data['company_address2']);?>" /> 
        </div>
    </div>
    
    <div class="control-group">
            <label class="control-label" for="company_name"><?php echo $this->lang->line('city');?></label>
        <div class="controls">
            <input class="input-medium" type="text" name="company_name" id="company_name" value="<?=iconv('utf-8','tis-620',$data['company_city']);?>" /> 
        </div>
    </div>
    
    <div class="control-group">
            <label class="control-label" for="company_name"><?php echo $this->lang->line('province');?></label>
        <div class="controls">
            <input class="input-medium" type="text" name="company_name" id="company_name" value="<?=iconv('utf-8','tis-620',$data['company_province']);?>" /> 
        </div>
    </div>
    
    <div class="control-group">
            <label class="control-label" for="company_name"><?php echo $this->lang->line('postcode');?></label>
        <div class="controls">
            <input class="input-medium" type="text" name="company_name" id="company_name" value="<?=iconv('utf-8','tis-620',$data['company_postcode']);?>" /> 
        </div>
    </div>
    
    <div class="control-group">
            <label class="control-label" for="company_name"><?php echo $this->lang->line('tel');?></label>
        <div class="controls">
            <input class="input-medium" type="text" name="company_name" id="company_name" value="<?=iconv('utf-8','tis-620',$data['company_tel']);?>" /> 
        </div>
    </div>
    
    
    <div class="control-group">
            <label class="control-label" for="company_name"><?php echo $this->lang->line('fax');?></label>
        <div class="controls">
            <input class="input-medium" type="text" name="company_name" id="company_name" value="<?=iconv('utf-8','tis-620',$data['company_fax']);?>" /> 
        </div>
    </div>
    
    <div class="control-group">
            <label class="control-label" for="company_name"><?php echo $this->lang->line('tax');?></label>
        <div class="controls">
            <input class="input-medium" type="text" name="company_name" id="company_name" value="<?=iconv('utf-8','tis-620',$data['company_tax_id']);?>" /> 
        </div>
    </div>
    
    
    <p>
            <button class="btn btn-large btn-primary" type="button"><?php echo $this->lang->line('save');?></button>
            <button class="btn btn-large" type="button"><?php echo $this->lang->line('cancle');?></button>
</p>
       
        
        
            
     <?php   }
    
    ?>
    
    
    </form>
    
    </div>
    
    
    
    <div class="tab-pane" id="messages">3...</div>
    <div class="tab-pane" id="settings">...</div>
    </div>    
        
     
      
      
      
      
      
      
      
      </div>
      
      </div>

    </div> <!-- /container -->

    
    


<script>
    $('#myTab a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
    })

</script>



<!-- end of contener -->

<?php $this->load->view('common/footer-bootstap');?>
<!-- footer-->
