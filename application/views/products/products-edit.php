<?php

/**
 * @author Anon
 * @copyright 2013
 */



?>
<div class="grid_7">
<h2>Menu</h2>
<p><a href="<?php echo base_url();?>">Base Url</a></p>
<p>Page Products.php</p>
<p><a href="<?php echo site_url("products/add");?>">Add</a></p>
<p><a href="<?php echo site_url("products/edit") ?>">Edit</a></p>
<p><a href="<?php echo site_url("products/delete")?>">Delete</a></p>
<?php 
$atts = array(
              'width'      => '400',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );

echo anchor_popup('news/local/123', 'Click Me!', $atts);?>

</div>
<div class="grid_17">
<p><a href="<?php echo site_url("products");?>">Producs</a></p>
<h2>Edit Products</h2>
<form>
<div>Lable : <input name="products_name" id="products-name" value="" /></div>
<div>Lable : <input name="products_name" id="products-name" value="" /></div>
<div>Lable : <input name="products_name" id="products-name" value="" /></div>
<div>Lable : <input name="products_name" id="products-name" value="" /></div>
<div>Lable : <input name="products_name" id="products-name" value="" /></div>


</form>
</div>