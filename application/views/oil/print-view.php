<!-- header-->
<?php $this->load->view('common/header-bootstrap');?>

<!-- container -->
<div class="container">

 <h2>Oil Stock</h2>
 
<div class="row">

<div class="span3">


</div>

<div class="span9">

    <!-- Button to trigger modal -->
    <a href="#myModal" role="button" class="btn" data-toggle="modal">Launch demo modal</a>
     
    <!-- Modal -->
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
    <h3 id="myModalLabel">Modal header</h3>
    </div>
    <div class="modal-body">
    <p>One fine body...</p>
    </div>
    <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary">Save changes</button>
    </div>
    </div>
    
        <ul class="nav nav-tabs" id="myTab">
    <li class="active"><a href="#home">Home</a></li>
    <li><a href="#profile">Profile</a></li>
    <li><a href="#messages">Messages</a></li>
    <li><a href="#settings">Settings</a></li>
    </ul>
     
    <div class="tab-content">
    <div class="tab-pane active" id="home">.1</div>
    <div class="tab-pane" id="profile">.2</div>
    <div class="tab-pane" id="messages">.2</div>
    <div class="tab-pane" id="settings">.4</div>
    </div>
     
    <script>
         $(function () {
            $('#myTab a:last').tab('show');
            
            
            
            });
    </script>




</div>




</div>


</div>




<!-- footer-->
<?php $this->load->view('common/footer-bootstap')?>