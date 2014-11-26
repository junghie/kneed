<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">Contacts</a>
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
                <h2><i class="glyphicon glyphicon-edit"></i> Manage Contacts</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                
                <table class="table table-striped table-bordered bootstrap-datatable responsive">
				   <thead>
                        <td>MOBILE NUMBER</td>
                        <td>FIRSTNAME</td>
                        <td>LASTNAME</td>
                        <td>GROUPS</td>
                        <td>ACTION</td>
                   </thead>
                   <?php 
                        $count = 0;                        
                        foreach($contacts as $cnt){ 
                            
                            $class = ($count%2) ? "odd_gradeX" : "even_gradeC"; 
                        ?>
                        <tr class="<?= $class ?>">
                            <td><span class="center-block"><?= $cnt->MSISDN ?></span></td>
                            <td><span class="center-block"><?= $cnt->FIRSTNAME ?></span></td>                            
                            <td><span class="center-block"><?= $cnt->LASTNAME ?></td>
                            <td><span class="center-block">
                                <?php foreach(Subscription::GetGroup($cnt->MSISDN) as $data){ ?>
                                    <?= $data->KEYWORD ?> <br/>
                                <?php } ?>
                            </td>
                            <td><span class="center-block">
                                <a class="btn btn-info" href="contacts-update/<?= $cnt->ID . '/' . Session::token() ?>"><i class="glyphicon glyphicon-edit icon-white"></i> View</a>                                
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