<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">Subscription</a>
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
                <h2><i class="glyphicon glyphicon-edit"></i> Subscriptions</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                <form role="form" method="post">
                    <div class="form-group">
                        <label for="reportname">Keyword</label>
                        <select id="reportname" name="reportname" class="form-control" onchange="show_report(this);">
                                <option value="" disabled selected>Select your option</option>                              
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="datefr">Date From</label>
                        <div class="input-group date">
                          <input class="form-control" id="datefr" type="text" value="<?= date('Y-m-d'); ?>">
                          <span class="input-group-addon addon" id="open-datefr"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dateto">Date To</label>
                        <div class="input-group date">
                          <input class="form-control" id="dateto" type="text" value="<?= date('Y-m-d'); ?>">
                          <span class="input-group-addon addon" id="open-dateto"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                    <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                  
                    <?php if(!empty($keyword->KEYWORD)){ ?>
                    <div class="form-group">
                        <h3>KEYWORD : <?= $keyword->KEYWORD; ?></h3>
                        <h3>SUBSCRIBERS : <?= $subscriptions->count(); ?></h3>
                        <table class="table table-striped table-bordered bootstrap-datatable responsive">
                           <thead>
                                <td>Mobile Number</td>
                                <td>First Name</td>
                                <td>Last Name</td>
                                <td>Location</td>
                                <td>BirthDate</td>
                                <td>Date of Subscription</td>
                           </thead>
                           <?php 
                                $count = 0;
                                foreach($subscriptions as $subs){ 
                                    
                                    $class = ($count%2) ? "odd_gradeX" : "even_gradeC"; 
                                ?>
                                <tr class="<?= $class ?>">
                                    <td align="center"><?= $subs->MSISDN ?></td>
                                    <td align="center"><?= $subs->FIRSTNAME ?></td>
                                    <td align="center"><?= $subs->LASTNAME ?></td>
                                    <td align="center"><?= $subs->LOCATION ?></td>
                                    <td align="center"><?= date_format(date_create($subs->BIRTHDATE),'Y-m-d') ?></td>
                                    <td align="center"><?= date_format(date_create($subs->TIMESTAMP),'Y-m-d H:i:s') ?></td>
                                    
                                </tr>
                            <?php $count++; } ?>    
                        
                           
                        </table>
          
                    </div>
                    <?php } ?>
                   </form>
                </div>

            </div>
        </div>
    </div>
    <!--/span-->

<script type="text/javascript">

var report_data;
var report_name;
function show_report(obj){
    console.log(report_data);
}

$(document).ready(function () {
    $('#datefr').datetimepicker({format:'Y-m-d',timepicker:false});
    $('#dateto').datetimepicker({format:'Y-m-d',timepicker:false});

<?php if(!empty($keyword->KEYWORD)){ ?>
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
<?php } ?>
});

$('#open-datefr').click(function(){
    $('#datefr').datetimepicker('show');
});

$('#open-dateto').click(function(){
    $('#dateto').datetimepicker('show');
});

change();
function change(){
    
        var service_url = "keywords-getlist";
        tinyMCE.triggerSave();
        var params = {group:"0"};

        $.post(
           service_url,params,
           function(result,status){
                console.log(result);
                if(status == 'success'){
                   report_data = JSON.parse(result);
                   var listitem = '<option value="" disabled selected>Select Keyword</option>';                        
                   for (x in report_data) {                     
                    listitem += '<option value="'+ report_data[x].ID +'">' + report_data[x].KEYWORD + '</option>';
                        //apply some effect on change, like blinking the color of modified cell...
                   }

                    $('#reportname').html(listitem);
                }else{
                   
                }           
        });
}

</script>