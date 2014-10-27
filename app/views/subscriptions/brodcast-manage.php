<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">Broadcast SMS</a>
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
                <h2><i class="glyphicon glyphicon-edit"></i> Manage Broadcast SMS</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                
                <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
				   <thead>
                        <td>KEYWORD</td>
                        <td>MESSAGE</td>
                        <td>SCHEDULE</td>
                        <td>REPEAT</td>
                        <td>STATUS</td>
                        <td>ACTIONS</td>
                   </thead>
                   <?php 
                        $count = 0;
                        $arr_repeat = array("0" => "NONE","1" => "PER DAY","8" => "PER WEEK","31" => "PER MONTH");
                        foreach($brodcastsms as $bs){ 
                            
                            $class = ($count%2) ? "odd_gradeX" : "even_gradeC"; 
                        ?>
                        <tr class="<?= $class ?>">
                            <td><span class="center-block"><?= $bs->KEYWORD ?></span></td>
                            <td><span class="center-block"><?= base64_decode($bs->MESSAGE) ?></span></td>                            
                            <td><span class="center-block"><?= (!empty($bs->SCHEDULE)) ? date_format(date_create($bs->SCHEDULE),'m-d-Y H:i:s') : ""; ?></td>
                            <td><span class="center-block"><?=  $arr_repeat[$bs->REPEAT] ?></span></td>
                            <td><span class="center-block"><?=  $bs->STATUS ?></span></td>
                            <td><span class="center-block">
                                <a class="btn btn-info" href="#"><i class="glyphicon glyphicon-retweet icon-white"></i> Process</a>
                                <a class="btn btn-info" href="#"><i class="glyphicon glyphicon-edit icon-white"></i> Edit</a>
                                <a class="btn btn-danger" href="#"><i class="glyphicon glyphicon-edit icon-white"></i> Delete</a>
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
    
});
</script>