<?php

$this->load->view('common/header');

?>
<!-- /header-->
    <div class="container-fluid">
    <div class="row-fluid">
    <div class="span12">
    <h2><?php

if (isset($h2_title))
{
    echo $h2_title;
}
;

?></h2>
    
    </div>
    
    </div>
    <div class="clear"></div>
    <div class="row-fluid">
    <div class="span12">
    <div style="text-align: center; margin-bottom: 20px;">
    <?php

if (isset($out_master))
{
    echo $out_master;

}

?>
    </div>
    </div>   
    </div><!--/row-fluid -->
    
    <script>

function update_oilvalue()
{
    //var set_vat = 0.07;
    
    $oil_value = parseFloat($('input[name="sell_oil"]:visible').val());
    $sell_price = parseFloat($('input[name="sell_price"]:visible').val());
    
    $sum_total = parseFloat($oil_value*$sell_price);
    
    // jQuery('input[name="total_vat"]:visible').val(parseFloat(Math.round($sum_vat*100)/100).toFixed(2));
            
     // $total = $itemprice+$sum_vat;      
            
      jQuery('input[name="sell_amount"]:visible').val(parseFloat(Math.round($sum_total * 100)/100).toFixed(2));                
                 
            
}

function update_reciveValue()
{
    //var set_vat = 0.07;
    
    $receive_value = parseFloat($('input[name="receive_oil"]:visible').val());
    $receive_price = parseFloat($('input[name="receive_price"]:visible').val());
    
    $sumreceive_total = parseFloat($receive_value*$receive_price);
    
    // jQuery('input[name="total_vat"]:visible').val(parseFloat(Math.round($sum_vat*100)/100).toFixed(2));
            
     // $total = $itemprice+$sum_vat;      
            
      jQuery('input[name="receive_amount"]:visible').val(parseFloat(Math.round($sumreceive_total * 100)/100).toFixed(2));                
                 
            
}

</script>


    <div class="clear"></div>
    <!--
    <div class="row-fluid">
    <div class="span6">
    
    <?php if(isset($out_list2)){
        echo $out_list2;
    }?>
  
    </div>
    <div class="span6">
   
    <?php echo $out_list3?>
 
    
    </div>
    </div> --><!--/row-fluid-->
    <div class="row-fluid">
    <div class="span12">
    <?php if(isset($curent_factory)){
        echo $curent_factory;
    }?>
    <div class="bs-docs-example-popover">
    <ul id="myTab" class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab"><?php echo $this->lang->line("recived_oil_list");?></a></li>
      <li><a href="#profile" data-toggle="tab"><?php echo $this->lang->line('sell_oil_list');?></a></li>
      
    </ul>
    <div id="myTabContent" class="tab-content">
    
      <div class="tab-pane fade in active" id="home">
        
        <?php if(isset($out_list2)){
        echo $out_list2;
        
    }?>
  
      </div>
      <div class="tab-pane fade" id="profile">
      
       
       <?php if(isset($out_list3)){
        echo $out_list3;
        
    }?>
      
      
      
      
      </div>
      
      
    </div>
</div>
    
    </div><!--/span12-->
    </div>
  <style>
  #home,#profile{
    padding: 10px;
  }
  </style>  
    
    <script>
     jQuery('#ref_number').focus();
     
     $(function(){
        ('#ref_number').focus();
     });
     
     
    
    </script>
      
</div>
<div class="container-fluid">
		
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


<?php

$this->load->view('common/footer');

?>