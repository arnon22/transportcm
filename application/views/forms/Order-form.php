<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>form-inline</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="date_time_order">Date/Time</label>
  <div class="controls">
    <input class="datepicker" id="date_time_order" name="date_time_order" placeholder="date-time" class="input-medium" required="" type="text">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="dalivery_date_time">Delivery Time</label>
  <div class="controls">
    <input id="dalivery_date_time" name="dalivery_date_time" placeholder="Date Time" class="input-medium" type="text">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="db_number">DP Number</label>
  <div class="controls">
    <input id="db_number" name="db_number" placeholder="DP Number" class="input-medium" required="" type="text">
    
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="factory_site">Plant</label>
  <div class="controls">
  <select id="factory_site" name="factory_site" class="input-xlarge">
  <?php if($factory){
    
    foreach($factory as $rows){
        
        echo "<option value =\"{$rows['factory_id']}\">{$rows['factory_code']}</option>";
    }
    
  }?>
    
      <!--<option value="">Plant one</option>
      <option>Plant two</option> -->
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="Customer">Customer</label>
  <div class="controls">
    <select id="Customer" name="Customer" class="input-medium">
      <option>Customer one</option>
      <option>Customer two</option>
    </select>
  </div>
</div>

<!-- Button -->
<div class="control-group">
  <label class="control-label" for="New_Customer"></label>
  <div class="controls">
    <button id="New_Customer" name="New_Customer" class="btn btn-inverse">New Customer</button>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="real_distance">Real Distance</label>
  <div class="controls">
    <input id="real_distance" name="real_distance" placeholder="Real Distance" class="input-small" required="" type="text">
    
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="Distance_code">Distance Code</label>
  <div class="controls">
    <select id="Distance_code" name="Distance_code" class="input-small">
      <option>0</option>
      <option>1</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="Cubic">Cubic</label>
  <div class="controls">
    <select id="Cubic" name="Cubic" class="input-small">
      <option>Cubic one</option>
      <option>Cubic two</option>
    </select>
  </div>
</div>

<!-- Prepended text-->
<div class="control-group">
  <label class="control-label" for="price"></label>
  <div class="controls">
    <div class="input-prepend">
      <span class="add-on">Price</span>
      <input id="price" name="price" class="input-medium" placeholder="" type="text">
    </div>
    
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="Car_number">Car Number</label>
  <div class="controls">
    <select id="Car_number" name="Car_number" class="input-medium">
      <option>C01</option>
      <option>C02</option>
    </select>
  </div>
</div>

<!-- Button Drop Down -->
<div class="control-group">
  <label class="control-label" for="Driver">Driver</label>
  <div class="controls">
    <div class="input-append">
      <input id="Driver" name="Driver" class="input-medium" placeholder="Driver" required="" type="text">
      <div class="btn-group">
        <button class="btn dropdown-toggle" data-toggle="dropdown">
          Action
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
          <li><a href="#">driver 1</a></li>
          <li><a href="#">driver 2</a></li>
          <li><a href="#">driver 3</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Textarea -->
<div class="control-group">
  <label class="control-label" for="remark">Remark</label>
  <div class="controls">                     
    <textarea id="remark" name="remark">default text</textarea>
  </div>
</div>

<!-- Button (Double) -->
<div class="control-group">
  <label class="control-label" for="create_order_btn"></label>
  <div class="controls">
    <button id="create_order_btn" name="create_order_btn" class="btn btn-success">Create Order</button>
    <button id="cancle_btn" name="cancle_btn" class="btn btn-danger">Cancle</button>
  </div>
</div>

</fieldset>
</form>

<script>

$('.datepicker').datepicker()


</script>
