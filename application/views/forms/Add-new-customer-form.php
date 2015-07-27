<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Add new customer</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="customer_name">Customer Name</label>
  <div class="controls">
    <input id="customer_name" name="customer_name" type="text" placeholder="Name" class="input-xlarge" required="">
    
  </div>
</div>

<!-- Select Multiple -->
<div class="control-group">
  <label class="control-label" for="plant_site">plant</label>
  <div class="controls">
    <select id="plant_site" name="plant_site" class="input-xlarge" multiple="multiple">
    <?php if($factory){
        
        foreach($factory as $row){
            
            echo "<option value=\"{$row['factory_id']}\">{$row['factory_code']}</option>";
        }
        
        
        
    }?>
     
    </select>
  </div>
</div>

</fieldset>
</form>
