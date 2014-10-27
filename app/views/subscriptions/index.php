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
                    <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                  
                    <?php if(!empty($keyword->KEYWORD)){ ?>
                    <div class="form-group">
                        <h3>KEYWORD : <?= $keyword->KEYWORD; ?></h3>
                        <h3>SUBSCRIBERS : <?= $subscriptions->count(); ?></h3>
                        <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                           <thead>
                                <td>MSISDN</td>
                                <td>TIMESTAMP</td>
                           </thead>
                           <?php 
                                $count = 0;
                                foreach($subscriptions as $subs){ 
                                    
                                    $class = ($count%2) ? "odd_gradeX" : "even_gradeC"; 
                                ?>
                                <tr class="<?= $class ?>">
                                    <td align="center"><?= $subs->MSISDN ?></td>
                                    <td align="center"><?= date_format(date_create($subs->TIMESTAMP),'m-d-Y') ?></td>
                                    
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

change();
function change(){
    
        var service_url = "keywords-getlist";
        tinyMCE.triggerSave();
        var params = [];

        $.post(
           service_url,params,
           function(result,status){
                console.log(result);
                if(status == 'success'){
                   report_data = JSON.parse(result);
                   var listitem = '<option value="" disabled selected>Select your option</option>';                        
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