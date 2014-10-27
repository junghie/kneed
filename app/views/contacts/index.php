<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">New Contact</a>
        </li>
    </ul>
</div>

<div id="success" class="alert alert-success" style="display:none;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Well done!</strong> You successfully save the record.
</div>


<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> New Contact</h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                <form role="form">                    
                    <div class="form-group">
                        <label for="firstname">FIRSTNAME</label>
                        <input type="text" class="form-control" id="n_firstname" placeholder="Firstname">
                    </div>
                    <div class="form-group">
                        <label for="lastname">LASTNAME</label>
                        <input type="text" class="form-control" id="n_lastname" placeholder="Lastname">
                    </div>
                    <div class="form-group">
                        <label for="mobilenumber">Mobile Number</label>
                        <input type="text" class="form-control" id="n_msisdn" placeholder="Mobile Number">
                    </div>
                   
                    <input type="button" class="btn btn-default" value="Submit" onclick="create(this);" />
                </form>

            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->


<script type="text/javascript">

function create(obj){
    
        var service_url = "push-contact-add";
        
        var params = {firstname:$("#n_firstname").val(),lastname:$("#n_lastname").val(),msisdn:$("#n_msisdn").val()};    

        $.post(
           service_url,params,
           function(result,status){
                console.log(result);
                if(status == 'success'){
                   $('#success').show();
                   $("#n_firstname").val('');
                   $("#n_lastname").val('');
                   $("#n_msisdn").val('');
                }else{
                   
                }           
        });
}

</script>
