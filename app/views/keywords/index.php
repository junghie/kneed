<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">Keywords</a>
        </li>
    </ul>
</div>

<div id="success" class="alert alert-success" style="display:none;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Well done!</strong> You successfully save the record.
</div>

<div id="failed" class="alert alert-info" style="display:none;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Well done!</strong> You successfully save the record.
</div>


<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> New Keyword</h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                <form role="form">                    
                    <div class="form-group">
                        <label for="reportname">Keyword</label>
                        <input type="text" class="form-control" id="n_reportname" placeholder="Keyword">
                    </div>
                    <div class="form-group">
                        <label for="data_src">Welcome Message</label>
                        <textarea id="data_src_new" maxlength="160"></textarea>
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
    
        var service_url = "push-keyword-add";
        tinyMCE.triggerSave();
        var params = {reportname:$("#n_reportname").val(),datasrc:Base64.encode($("#data_src_new").val())};    

        $.post(
           service_url,params,
           function(result,status){
                console.log(result);
                if(result.flash.indexOf("success") > -1){
                   $('#success').show();
                }else{
                    $('#failed').html(result.data);
                    $('#failed').show();                   
                }           
        });
}

</script>
