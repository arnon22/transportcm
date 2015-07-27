<?php $this->load->view('common/header-bootstrap');?>
	
    
 <div class="container-fluid">
 <div class="row-fluid">
 <div class="span2">
 
 <?php $this->load->view('common/side-menu');?>
 
 
 </div>
 <!-- center -->
 <div class="span10">
 <!--<div>
		<a href='<?php echo site_url('bootstrap/customers_management')?>'>Customers</a> |
		<a href='<?php echo site_url('bootstrap/orders_management')?>'>Orders</a> |
		<a href='<?php echo site_url('bootstrap/products_management')?>'>Products</a> |
		<a href='<?php echo site_url('bootstrap/offices_management')?>'>Offices</a> | 
		<a href='<?php echo site_url('bootstrap/employees_management')?>'>Driver</a> |	
        <a href='<?php echo site_url('bootstrap/cars_management')?>'>Cars</a> |	 
		<a href='<?php echo site_url('bootstrap/income_management')?>'>Income</a> | 
		<a href='<?php echo site_url('bootstrap/film_management_twitter_bootstrap')?>'>Twitter Bootstrap Theme [BETA]</a> | 
		<a href='<?php echo site_url('bootstrap/multigrids')?>'>Multigrid [BETA]</a>
		
	</div>
  -->  
    <div style='height:10px;'></div>
    <div id="dataTable"></div>
<script>

var obj = <?php echo $price3;?>;  
  
$.each( obj, function( key, value ) { 
  console.log( "key", key, "value", value );
  
  var worldsCutestCouple = []
  worldsCutestCouple.push("["+key+"");
  
  $.each(value,function(key2,value2){   
      
    console.log( "key2", key2, "value2", value2['c_price'] );
    
    worldsCutestCouple.push(value2['c_price']);
    
    
    //var data
    
  });
  
       //var arr_a = (value,v2);
  //var xa =array(key,myCars);
  
 worldsCutestCouple.push("]");
  
  alert (worldsCutestCouple);
  
 

});



    var data = <?php echo $price3;?>
    //var data_rrs = new objToString(data);
    
    
   
        
  
  $("#dataTable").handsontable({
    rowHeaders:['Manufacturer', 'Year', 'Price'],
    colHeaders: ['Manufacturer', 'Year', 'Price'],
    data:data,
   
    
    startRows: 6,
    startCols: 10
  });
  
  
  function objToString (obj) {
    var tabjson=[];
    for (var p in obj) {
        if (obj.hasOwnProperty(p)) {
            tabjson.push('"'+p +'"'+ ':' + obj[p]);
        }
    }  tabjson.push()
    return '{'+tabjson.join(',')+'}';
}
  
  
  
  
</script>

<script>
$(function(){
    var $container = $("#example1");    


    
    
    $('#load').click(function(){
        
         $.ajax({
    url: "action_price/listprice",
    dataType: 'json',
    type: 'GET',
    success: function (res) {
        
        $.each(res,function(key,value){
            var data_d =[];
            
            $.each(value,function(key2,value2){
                data_d.push(value2['c_price']);
                
                   //handsontable.loadData(value2['c_price']);
                    
            });
            var data=[];
            data=data_d;
            console.log("data:",data);
        });
        
        
        var data_z=[];
        
        data_z=data;
        console.log("dataZ:",data_z);
        
        
        
      //handsontable.loadData(res.data);
      //$console.text('Data loaded');
    }
  });
        
    });
    
});

</script>






 
 <div>
 <?php echo $out;?>
 <div id="#example1">
 
 </div>
 
 <?php 
 if(isset($output)){
    
    echo $output;
 }else{
    echo "No output";
 }
 
 if(isset($pricelist)){
    print_r($pricelist);
    //echo json_decode($pricelist);
 
 }
 
 //echo $output; 
 
 echo "<br/>";
 if(isset($price3)){
     print_r($price3);
 }

 
 
 
 
 ?>
 
 
 </div>
 
 </div>
 
 <!-- right -->
 <!--<div class="span1">
 <p>Login</p>
 
 
 </div>
 -->
 
 
 </div>
 
 </div>
		
   
    
    
   
    
    


    


</div> <!-- container-fluid -->

</div><!-- <div class="row-fluid"> -->
<?php $this->load->view('common/footer-bootstap');?> 