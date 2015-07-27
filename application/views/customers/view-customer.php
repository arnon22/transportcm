
<?php $this->load->view('common/header-bootstrap');?>
<!-- header -->


<!-- container -->
    <div class="container-fluid">
    
    
      <h2><?php echo $this->lang->line('customers_title');?></h2>
      
      
      <div class="row-fluid">
      
      <div class="span2">
      <?php
      
     
      
      
      ?></div>
      
   
      
      <div class="span10">
      
      
            <!-- <div id="datetimepicker1" class="input-append date">
                <input data-format="dd/MM/yyyy hh:mm:ss" type="text"></input>
                <span class="add-on">
                 <a href="javascript:void(0)"><i data-time-icon="icon-time" data-date-icon="icon-calendar">
                 </i></a>
                </span>
            </div> -->

<script type="text/javascript">
  $(function() {
    $('#datetimepicker1').datetimepicker({
      language: 'pt-BR'
    });
  });
</script>
      
      
          <!-- Button to trigger modal -->
    <a href="#myModal" role="button" class="btn  btn-primary" data-toggle="modal">Add</a>
     
    <!-- Modal -->
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel"><?php echo $this->lang->line('customers_add_menu')?></h3>
    </div>
    <div class="modal-body">
    
    <!-- form Add New customer -->
    <?php $this->load->view('forms/Add-new-customer-form');?>
    
    </div>
    
    <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button id="save-change" class="btn btn-primary">Save changes</button>
    </div>
    </div>
      <script>
      $('#save-change').live("click",function(){
        
        var customer_name = $('#customer_name').val();
        
        alert(customer_name);
        
      });
      
      </script>
      </div><!-- span8-->
      <div class="span12">
      
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
      
      <th><?php echo $this->lang->line('agencies');?></th>
      <th><?php echo $this->lang->line('address1');?></th>      
      <th><?php echo $this->lang->line('aumpher1');?></th>
      <th><?php echo $this->lang->line('province');?></th> 
       <th><?php echo $this->lang->line('postcode');?></th>      
      <th><?php echo $this->lang->line('phone_number');?></th>     
      <th><?php echo $this->lang->line('contact_person');?></th>
      <th><?php echo $this->lang->line('moble_number');?></th>
      <th>Action</th>      
      
      <th>Save By</th>
      
      </tr>
      
      </thead>
      
      <tbody>
      
      <?php 
      if($results!=null){
        
         $i=$this->uri->segment(3)+1;
        
        foreach($results as $customer){ 
          
         
            
            ?>
        
        <tr>
      <td><?php echo $i;?></td>
     
      <td><?php echo iconv('utf-8','tis-620',$customer->customers_name);?></td>
      <td><?php echo iconv('utf-8','tis-620',$customer->address1);?></td>      
      <td><?php echo iconv('utf-8','tis-620',$customer->AMPHUR_NAME);?></td>    
      <td><?php echo iconv('utf-8','tis-620',$customer->PROVINCE_NAME);?></td>
    
      <td><?php echo iconv('utf-8','tis-620',$customer->postcode);?></td>
      <td><?php echo iconv('utf-8','tis-620',$customer->phone_number);?></td>
        
      <td><?php echo iconv('utf-8','tis-620',$customer->contact_person);?></td>
      <td><?php echo iconv('utf-8','tis-620',$customer->mobile_number);?></td>
      <td>Edit | Delete | Print</td>
      <td></td>
      
      </tr>
            
            
      <?php  $i++;}
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
      
      
      </div>
      
      </div>

    </div> <!-- /container -->

    
<!-- footer-->
<?php $this->load->view('common/footer-bootstap');?>    

