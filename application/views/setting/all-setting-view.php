<!-- container -->
    <div class="container-fluid">
    
    
      <h2><?php echo $this->lang->line('seting_menu')?></h2>
      
      
      <div class="row-fluid">
      <div class="span2">
      
      <!-- Left menu position -->
      <?php
      
     $this->load->view('left-menu/setting-left-menu');
      
      ?>
      
      </div>
      <div class="span10">
      
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
      <th>Index</th>
      <th>Invoice</th>
      <th>Pumb</th>      
      <th>Car Diver</th>      
      <th>Oil Income</th>
      <th>Oil Use</th>
      <th>Date/Time</th>
      <th>Total</th>
      <th>Save By</th>
      
      </tr>
      
      </thead>
      
      <tbody>
      <tr>
      <td>1</td>
      <td>IN-06001</td>
      <td></td>
      <td></td>
      <td>100</td>
      <td>50</td>
      <td>16-06-2013 08:30</td>
      <td>50</td>
      <td>Anon</td>
      
      </tr>
      
      <tr>
      <td>2</td>
      <td>IN-06002</td>
      <td></td>
      <td></td>
      <td>100</td>
      <td>0</td>
      <td>16-06-2013 08:30</td>
      <td>150</td>
      <td>Anon</td>
      
      </tr>
      
      <tr>
      <td>3</td>
      <td>IN-06003</td>
      <td></td>
      <td></td>
      <td>200</td>
      <td>0</td>
      <td>16-06-2013 08:30</td>
      <td>350</td>
      <td>Anon</td>
      
      </tr>
      
      <tr>
      <td>4</td>
      <td>In004</td>
      <td></td>
      <td></td>
      <td>100</td>
      <td>0</td>
      <td>16-06-2013 08:30</td>
      <td>100</td>
      <td>Anon</td>
      
      </tr>
      
      <tr>
      <td>5</td>
      <td>In005</td>
      <td></td>
      <td></td>
      <td>100</td>
      <td>0</td>
      <td>16-06-2013 08:30</td>
      <td>100</td>
      <td>Anon</td>
      
      </tr>
      
      
      </tbody>
      
      </table>
      
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

    
    

