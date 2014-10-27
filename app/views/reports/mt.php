<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">Report</a>
        </li>
        <li>
            <a href="#">Sent</a>
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
                <h2><i class="glyphicon glyphicon-edit"></i> Sent Report</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                   <thead>
                        <td>MSISDN</td>
                        <td>MESSAGE</td>
                        <td>REFERENCEID</td>
                        <td>TIMSTAMP</td>
                        <td>TYPE</td>
                        <td>SMSCOST</td>
                        <td>STATUS</td>
                   </thead>
                   <?php 
                        $count = 0;
                        foreach($mts as $mt){ 
                            $class = ($count%2) ? "odd_gradeX" : "even_gradeC"; 
                        ?>
                        <tr class="<?= $class ?>">
                            <td><span class="center-block"><?= $mt->MSISDN ?></span></td>
                            <td><span class="center-block"><?= $mt->MESSAGE ?></span></td>
                            <td><span class="center-block"><?= $mt->REFERENCEID ?></span></td>
                            <td><span class="center-block"><?= date_format(date_create($mt->TIMESTAMP),'m-d-Y H:i:s') ?></span></td>
                            <td><span class="center-block"><?= $mt->TYPE ?></span></td>
                            <td><span class="pull-right"><?= number_format((!is_numeric($mt->TOTALCOST)) ? 0: $mt->TOTALCOST,2) ?></span></td>
                            <td><span class="center-block"><?= $mt->STATUS ?></span></td>
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
    
});
</script>