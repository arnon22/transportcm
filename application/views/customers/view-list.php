<div class="container_16">
<div class="grid_16">

<!-- <div id="inf_table6" class="inf"><div id="ldiv_table6" class="ldiv"><div id="counter_table6" class="tot"><span id="totRowsTextSpan_table6">Rows:</span><span id="totrows_span_table6">4-6 / 7</span></div></div><div id="rdiv_table6" class="rdiv"><span id="helpSpan_table6"><div id="helpDiv_table6" class="helpCont">Use the filters above each column to filter and limit table data. Avanced searches can be performed by using the following operators: <br><b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>=</b>, <b>*</b>, <b>!</b>, <b>{</b>, <b>}</b>, <b>||</b>, <b>&amp;&amp;</b>, <b>[empty]</b>, <b>[nonempty]</b>, <b>rgx:</b><br> These operators are described here:<br><a target="_blank" href="http://tablefilter.free.fr/#operators">http://tablefilter.free.fr/#operators</a><hr><div class="helpFooter"><h4>HTML Table Filter Generator v. 2.5</h4><a target="_blank" href="http://tablefilter.free.fr">http://tablefilter.free.fr</a><br><span>&copy;2009-2013 Max Guglielmi.</span><div align="center" style="margin-top:8px;"><a onclick="window['tf_table6']._ToggleHelp();" href="javascript:;">Close</a></div></div></div><a href="javascript:void(0);" class="helpBtn">?</a></span><span id="resetspan_table6"><input type="button" title="Clear filters" class="reset" value=""></span></div><div id="mdiv_table6" class="mdiv" style="visibility: visible;"><span id="btnFirstSpan_table6"><input type="button" title="First page" class="pgInp firstPage" value=""></span><span id="btnPrevSpan_table6"><input type="button" title="Previous page" class="pgInp previousPage" value=""></span><span id="pgbeforespan_table6" class="nbpg"> Page </span><select id="slcPages_table6" class="pgSlc"><option value="0">1</option><option value="3">2</option><option value="6">3</option></select><span id="pgafterspan_table6" class="nbpg"> of </span><span id="pgspan_table6" class="nbpg">3</span><span id="btnNextSpan_table6"><input type="button" title="Next page" class="pgInp nextPage" value=""></span><span id="btnLastSpan_table6"><input type="button" title="Last page" class="pgInp lastPage" value=""></span></div></div>>
-->
<table cellspacing="0" cellpadding="0" class="mytable TF" id="table6">
<tbody>

<tr> 
            <th><?php echo $this->lang->line('customer_agency');?></th>
            <th><?php echo $this->lang->line('contact_person');?></th>
            <th><?php echo $this->lang->line('company_adds1');?></th>
            <th><?php echo $this->lang->line('tel');?></th>
            <th><?php echo $this->lang->line('fax');?></th>
          </tr>
         <?php

if($customers){
    
    foreach($customers as $rows){
 ?>       
   <tr>
   <td><?php echo iconv('UTF-8','TIS-620',$rows['customers_name']);?></td>
   <td><?php echo iconv('UTF-8','TIS-620',$rows['contact_person']);?></td>
   <td><?php echo iconv('UTF-8','TIS-620',$rows['address1']);?></td>
   <td><?php echo $rows['phone_number'];?></td>
   <td><?php echo $rows['fax_number'];?></td>
   
   
   
   </tr>     
        
<?php        
        
    }
    
}


?>
          
        </tbody></table>
        <script language="javascript" type="text/javascript">
//<![CDATA[
	var table6_Props = 	{
					paging: true,
					paging_length: 5,
                    results_per_page: ['# rows per page',[2,4,6]],
					rows_counter: true,
					rows_counter_text: "Rows:",
					btn_reset: true,
					loader: true,
					loader_text: "Filtering data..."
				};
	var tf6 = setFilterGrid( "table6",table6_Props );
//]]>
</script>

<script language="javascript" type="text/javascript">
//<![CDATA[
	var table6_Props = 	{
					paging: true,
					paging_length: 5,
                     results_per_page: ['# rows per page',[2,4,6]],
					rows_counter: true,
					rows_counter_text: "Rows:",
					btn_reset: true,
					loader: true,
					loader_text: "Filtering data..."
				};
	var tf7 = setFilterGrid( "table_customer1",table6_Props );
//]]>
</script>



</div>


</div>