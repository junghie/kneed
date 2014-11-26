<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">New Group</a>
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
                <h2><i class="glyphicon glyphicon-edit"></i> New Group</h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                <form role="form">                    
                    <div class="form-group">
                        <label for="keyword">Group Name</label>
                        <input type="text" class="form-control" id="n_keyword" placeholder="Keyword">
                    </div>

                    <div class="form-group">
                        <label for="members">Members</label>
                        
                        <select name="members" id="n_members" multiple class="form-control" data-rel="chosen">
                                <option value="ALL">ALL</option>
                                 <?php foreach($contacts as $cnt){ ?>
                                        <option value="<?= $cnt->MSISDN ?>"><?= $cnt->FIRSTNAME . ' ' . $cnt->LASTNAME ?></option>
                                <?php } ?>
                        </select>

                          
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
    
        var service_url = "push-group-add";
        
        var params = {keyword:$("#n_keyword").val(),group:$("#n_members").val()};    

        $.post(
           service_url,params,
           function(result,status){
                console.log(result);
                if(status == 'success'){
                   $('#success').show();
                }else{
                   
                }           
        });
}

$(document).ready(function() {
    // Load Datatables and run plugin on tables 
    //LoadDataTablesScripts(AllTables);
    //$('#button-save').attr('disabled','disabled');
    //$("#members").listboxselector({
    //});
    
    var table = $('.table').DataTable({
        tableTools: {
            "sSwfPath": "bower_components/datatables/copy_csv_xls_pdf.swf",
            "aButtons": [
                "csv",
                "xls",
                "pdf",
                "print"
            ]
        },
        "bAutoWidth": false
    });
    
    var tt = new $.fn.dataTable.TableTools( table );
 
    $( tt.fnContainer() ).insertBefore('div.dataTables_wrapper');    
});


</script>
