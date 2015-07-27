<!--- Pricelist View -->
<!--
<div class="container_16">
<div class="grid_16">
<h2>Auto Pricelist</h2>

</div>
<div class="clear"></div>

<div class="grid_16">

<table class="mytable TF">
<thead>
<tr>
<th>ระยะทาง/คิว</th>

<?php 
if($cubic){
    
    foreach($cubic as $row_cubic){ ?>
        <th><?php echo $row_cubic['cubic_value']?></th>
        
<?    }
    
}


?>


</tr>

</thead>
<tbody>

<?php 
if($price){
    echo "<tr>";
    echo "<th>0-5 กม.</th>";
    foreach($price as $row_price) {
        
        echo "<td>{$row_price['price']}</td>";
    
        
    }
    
    echo '</tr>';
}

?>

</tbody>
</table>




</div>

<div class="clear"></div>
</div>
<div class="container_16">
<div class="grid_16">

<h2><?php echo $num_distance?></h2>

<?php
echo "<table class=\"mytable TF\">"; ?>

   <tr>

  <?  foreach($dc_title as $dc){ ?>
  
<th><?php echo iconv('utf-8','TIS-620',$dc->distance_name);?></th>
<? }?>
</tr>
<?php
for ($i = 1; $i <=$num_distance /*10*/; $i++) {        
      echo "<tr>";
      echo "<th>จำนวนคิว</th>";
    
    for($k = 1; $k<=19 /*28*/; $k++){
    
    echo "<td>".$i."+".$k."</td>";
     
        
    }
    echo "</tr>";
    
    echo "<tr>";
    echo $i;
     echo "</tr>";
}


echo "</table>";
?>

<table class="mytable TF">
<thead>
<tr>

  <?  foreach($dc_title as $dc){ ?>
  
<th><?php echo iconv('utf-8','TIS-620',$dc->distance_name);?></th>
<? }?>
</tr>

</thead>
</table>





</div>
<div class="clear"></div>
</div>

-->
<div class="container_16">
<div class="grid_16">

        <table id="dg" class="easyui-datagrid" title="<?php echo $this->lang->line('auto_pricelist_title');?>" style="width:950px;height:450px" toolbar="#toolbar" idField="id" rownumbers="true" fitColumns="true" singleSelect="true">  
        <thead>  
            <tr>  
               
                <!-- <th field="pricelist_id" width="12" editor="{type:'validatebox',options:{required:true}}"><?php echo $this->lang->line('pricelist_code');?></th>-->  
                <th field="price" width="20" id="price" editor="{type:'validatebox',options:{required:true}}"><?php echo $this->lang->line('price');?></th>  
                <th field="site_id" width="20" editor="text"><?php echo $this->lang->line('site_id');?></th>  
                <th field="distance_id" width="20" editor="{type:'validatebox'}"><?php echo $this->lang->line('distance_id');?></th>  
                <th field="distance_name" width="40" editor="{type:'validatebox'}"><?php echo $this->lang->line('distance_id');?></th>  
                <th field="cubic_id" width="20" editor="{type:'validatebox'}"><?php echo $this->lang->line('cubic_id');?></th>
                <th field="cubic_value" width="20" editor="{type:'validatebox'}"><?php echo $this->lang->line('cubic_id');?></th>
                <th field="start_date" width="30" editor="{type:'validatebox'}"><?php echo $this->lang->line('start_date');?></th>
                <th field="end_date" width="30" editor="{type:'validatebox'}"><?php echo $this->lang->line('end_date');?></th>
            </tr>  
        </thead>  
    </table>  
    <div id="toolbar">  
       <!-- <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:$('#dg').edatagrid('addRow')">New</a>  
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:$('#dg').edatagrid('destroyRow')">Destroy</a>  
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:$('#dg').edatagrid('saveRow')">Save</a>  
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg').edatagrid('cancelRow')">Cancel</a>  
    -->
    <div id="tb" style="padding:3px">
        <span><?php echo $this->lang->line('site_id');?></span>  
        
        <select id="factory_id">
        <!-- <option value="0"> <== Select Factory ==> </option> -->
        
        <?php if($factory){
            
            foreach($factory as $data){
                
                echo "<option value=\"{$data['factory_id']}\">{$data['factory_code']}</option>";
                
            }
            
        }    ?>
        
        </select>
       <!--  <input id="factory_id" style="line-height:26px;border:1px solid #ccc"> -->    
        <span><?php echo $this->lang->line('start_date');?></span>  
        <input id="start_date" style="line-height:26px;border:1px solid #ccc" />  
        <span><?php echo $this->lang->line('end_date');?></span>  
        <input id="end_date"  style="line-height:26px;border:1px solid #ccc" />  
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" onclick="doSearch()">Search</a>  
    </div>
     

</div>

</div>


    
 <script>   
    $('#dg').datagrid({  
    url: '<?php echo site_url()?>pricelist/getJson_pricelist',  
    saveUrl: 'save_user.php',  
    updateUrl: 'update_user.php',  
    destroyUrl: 'destroy_user.php'  
});

    function doSearch(){  
        $('#dg').datagrid('load',{  
            start_date: $('#start_date').val(),  
            end_date: $('#end_date').val(), 
            factory_id: $('#factory_id').val() 
        });  
    }
    
    $('#price').numberbox({  
    min:0,  
    precision:2  
});

$('#start_date,#end_date').datepick({ 
    onSelect: customRange, showTrigger: '#calImg'}); 
     
function customRange(dates) { 
    if (this.id == 'start_date') { 
        $('#end_date').datepick('option', 'minDate', dates[0] || null); 
    } 
    else { 
        $('#start_date').datepick('option', 'maxDate', dates[0] || null); 
    } 
}  


    

</script>