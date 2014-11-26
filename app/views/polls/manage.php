<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">Polls</a>
        </li>
        <li>
            <a href="#">Manage</a>
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
                <h2><i class="glyphicon glyphicon-edit"></i> Manage Polls</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                
                <table class="table table-striped table-bordered bootstrap-datatable  responsive">
				   <thead>
                        <td>DESCRIPTION</td>
                        <td>CODE</td>
                        <td>URL</td>
                        <td>RESULT</td>   
                        <td>ENDDATE</td>                     
                        <td>ACTION</td>
                   </thead>
                   <?php 
                        $count = 0;                        
                        foreach($polls as $cnt){ 
                            
                            $class = ($count%2) ? "odd_gradeX" : "even_gradeC"; 
                        ?>
                        <tr class="<?= $class ?>">
                            <td><span class="center-block"><?= $cnt->DESCRIPTION ?></span></td>
                            <td><span class="center-block"><?= $cnt->CODE ?></span></td>                            
                            <td><span class="center-block"><a href="<?= $cnt->URL?>" target="_blank"><?= URL::to($cnt->URL)?></a></td>
                            <td><span>
                                <?php foreach(PollDetails::GetGroup($cnt->ID) as $data){ ?>
                                    DESCRIPTION : <?= $data->DESCRIPTION  ?>  VOTES : <?= $data->VOTES ?><br/>
                                <?php } ?>
                            </td>
                            <td><span class="center-block"><?= $cnt->ENDDATE ?></span></td>
                            <td><span class="center-block">
                                <a class="btn btn-info" href="#"><i class="glyphicon glyphicon-edit icon-white"></i> Update</a>                                
                            </span></td>
                        </tr>
                    <?php $count++; } ?>    
                   
				</table>
				<span id="loaded" data-file-status="report" class="label label-info" style="display:none;"></span> 
				</div>

        </div>
    </div>
    <!--/span-->

</div><!--/row-->

<script type="text/javascript">

function AllTables(){
    //TestTable3();
}

$(document).ready(function() {
    // Load Datatables and run plugin on tables 
    //LoadDataTablesScripts(AllTables);
    //$('#button-save').attr('disabled','disabled');

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