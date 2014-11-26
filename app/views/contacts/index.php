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

<div id="failed" class="alert alert-info" style="display:none;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Well done!</strong> You successfully saved the record.
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
                        <label for="firstname">First Name<span class="required">*</span></label>
                        <input type="text" class="form-control" id="n_firstname" placeholder="Firstname">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name<span class="required">*</span></label>
                        <input type="text" class="form-control" id="n_lastname" placeholder="Lastname">
                    </div>
                    <div class="form-group">
                        <label for="birthdate">Birthdate</label>
                        <div class="input-group date">
                          <input class="form-control" id="dp3" type="text" value="<?= date('Y-m-d'); ?>">
                          <span class="input-group-addon addon" id="open"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mobilenumber">Mobile Number <span class="required">*</span></label>
                        <input type="text" class="form-control" id="n_msisdn" placeholder="Mobile Number">
                    </div>
                        <div class="form-group">
                        <label for="address">Location</label>
                        <input type="text" class="form-control" id="n_location" placeholder="Location">
                    </div>
                        <div class="form-group">
                        <label for="email">Email </label>
                        <input type="text" class="form-control" id="n_email" placeholder="Email">
                    </div>
                        <div class="form-group">
                        <label for="company">Company</label>
                        <input type="text" class="form-control" id="n_company" placeholder="Company">
                    </div>
                   
                    <input type="button" class="btn btn-default" value="Submit" onclick="create(this);" />
                </form>

            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->


<script type="text/javascript">


$(document).ready(function () {
    $('#dp3').datetimepicker({format:'Y-m-d',timepicker:false});
});

$('#open').click(function(){
    $('#dp3').datetimepicker('show');
});

function create(obj){
    
        var service_url = "push-contact-add";
        
        var params = {firstname:$("#n_firstname").val(),
                      lastname:$("#n_lastname").val(),
                      birthdate:$("#dp3").val(),
                      location:$("#location").val(),
                      email:$("#email").val(),
                      company:$("#company").val(),
                      msisdn:$("#n_msisdn").val()
                     };    

        $.post(
           service_url,params,
           function(result,status){
                console.log(result);
                if(result.flash.indexOf("success") > -1){
                   $('#success').show();
                   $("#n_firstname").val('');
                   $("#n_lastname").val('');
                   $("#n_msisdn").val('');
                }else{
                   var errorString = "";
                    $.each( result.data, function( key, value) {
                        errorString += '<li>' + value + '</li>';
                    });

                    $('#failed').html(errorString);
                    $('#failed').show();   
                }           
        });
}

</script>
