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
    
    <form class="form-search">
     <div class="input-append">
     <input type="text" class="span2 search-query" placeholder="Keyword Invoive..." />
     <button type="submit" class="btn">Search</button>
     
     </div>
     
     </form>
     
     <table class="table table-hover">
      <caption></caption>
      <thead>
      <tr>
      <th><?php echo $this->lang->line('index');?></th>
      <th><?php echo $this->lang->line('products_code');?></th>
      <th><?php echo $this->lang->line('products_name');?></th>
      <th><?php echo $this->lang->line('note');?></th>
      
      
      <th><?php echo $this->lang->line('status');?></th>      
      <th><?php echo $this->lang->line('action');?></th>
      <th></th>
      
      
      </tr>
      
      </thead>
      
      <tbody>
      <?php
      if($results!=null){
        
        $i=$this->uri->segment(3)+1;
        
        foreach($results as $products)
        
        
        {?>
        
        
        
            
      <tr>
      
      <td><?php echo $i ?></td>
      <td><?php echo iconv('UTF-8','TIS-620',$products->products_code);?></td>      
      <td><?php echo iconv('UTF-8','TIS-620',$products->products_name);?></td>
      <td><?php echo iconv('UTF-8','TIS-620',$products->products_note);?></td>
      <td><?php if(iconv('UTF-8','TIS-620',$products->products_status)=='0'){echo $this->lang->line('item_no_use');}else{ echo $this->lang->line('item_use');}?></td>
      <td>50</td>
      
      <td>Anon</td>
      
      </tr>
            
        
        
        <?php $i++; }//end foreach
        
        
      }
      
      ?>
      
      
      
      
      
      
      </tbody>
      
      </table>
       <?php echo $pagination_links; ?>
      <!--<div class="pagination pagination-centered">
      <ul>
      <li class="disabled"><a> << </a></li>
      <li class="active"><a>1</a></li>
      <li><a href="javascript:void(0)">2</a></li>
      <li><a href="javascript:void(0)">3</a></li>
      <li><a href="javascript:void(0)">4</a></li>
      <li><a href="javascript:void(0)">5</a></li>
      <li><a href="javascript:void(0)"> >> </a></li>
      
      </ul>
      
      
      </div> -->
      
      <!-- -->
      
      
    
    
    
    </div>
    
    <!-- Tab2 -->
    <div class="tab-pane" id="profile">...</div>
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
