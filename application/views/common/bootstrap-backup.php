
<?php $this->load->view('common/header-bootstrap');?>
<!-- header -->


<!-- container -->
    <div class="container">
    
    
      <h2><?php echo $this->lang->line('orders_title');?></h2>
      
      
      <div class="row">
      <!-- <div class="span3">
      
      <ul class="nav nav-list">
      <li class="active"><a href="javascript:void(0)"><i class="icon-home icon-back"></i>Home</a></li>
      <li><a href="<?php echo site_url()?>Bootstrap/add_oil_jobs"><i class="icon-tint"></i>Add Oil Jobs</a></li>
      <li><a><i class="icon-print"></i>Print</a></li>
      <li><a><i class="icon-print"></i>Print</a></li>
      
      </ul>
      
      </div>-->
      <div class="span4">
      <?php
      
      echo $date;
      
      
      ?></div>
      
   
      
      <div class="span8">
      
      
            <div id="datetimepicker1" class="input-append date">
                <input data-format="dd/MM/yyyy hh:mm:ss" type="text"></input>
                <span class="add-on">
                 <a href="javascript:void(0)"><i data-time-icon="icon-time" data-date-icon="icon-calendar">
                 </i></a>
                </span>
            </div>

<script type="text/javascript">
  $(function() {
    $('#datetimepicker1').datetimepicker({
      language: 'pt-BR'
    });
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
      
      
      <table class="table">
      <caption></caption>
      <thead>
      <tr>
     
      <th><?php echo $this->lang->line('date');?></th>
      <th><?php echo $this->lang->line('time');?></th>
      <th><?php echo $this->lang->line('number_dp');?></th>      
      <th><?php echo $this->lang->line('agencies');?></th>      
      <th><?php echo $this->lang->line('real_distance');?></th>
      <th><?php echo $this->lang->line('distance_code');?></th>
      <th><?php echo $this->lang->line('cubic_number');?></th>
      <th><?php echo $this->lang->line('cubic_number');?></th>
      <th>Save By</th>
      
      </tr>
      
      </thead>
      
      <tbody>
      
      <?php 
      if($results!=null){
        
        foreach($results as $order){ 
          
            
            ?>
        
        <tr>
      <td><?php echo $order->order_id;?></td>
      <td><?php echo $order->created_datetime;?></td>
      <td><?php echo $order->dp_number;?></td>
      <td><?php echo iconv('utf-8','tis-620',$order->factory_name);?></td>
      <td><?php echo $order->real_distance;?></td>
      <td><?php echo $order->distance_code;?></td>
      <td><?php echo $order->cubic_value;?></td>
      <td><?php echo $order->car_number;?></td>
      <td><?php echo iconv('utf-8','tis-620',$order->driver_name);?></td>
      
      </tr>
            
            
      <?php  }
      }
      
      ?>
      
      
      
      
      
      
      
      
      
      
      
      </tbody>
      
      </table>
      
       <?php echo $pagination_links; ?>
      
      <div class="pagination pagination-centered">
      <ul>
      <li class="disabled"><a> << </a></li>
      <li class="active"><a>1</a></li>
      <li><a href="javascript:void(0)">2</a></li>
      <li><a href="javascript:void(0)">3</a></li>
      <li><a href="javascript:void(0)">4</a></li>
      <li><a href="javascript:void(0)">5</a></li>
      <li><a href="javascript:void(0)"> >> </a></li>
      
      </ul>
      
      
      </div>
      
      
      </div>
      
      </div>

    </div> <!-- /container -->

    
<!-- footer-->
<?php $this->load->view('common/footer-bootstap');?>    

