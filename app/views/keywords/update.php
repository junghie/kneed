<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">Keyword</a>
        </li>
        <li>
            <a href="#">Update</a>
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
                <h2><i class="glyphicon glyphicon-edit"></i> Update Keyword</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                <form role="form">
                    <div class="form-group">
                        <label for="reportname">Keyword</label>
                        <select id="reportname" class="form-control" onchange="show_report(this);">
                                <option value="" disabled selected>Select your option</option>                              
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="data_src">Welcome Message</label>
                        <textarea id="data_src_new"></textarea>
                    </div>
                    <input type="button" class="btn btn-default" value="Submit" onclick="create(this);" />
                </form>

            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->

<!--<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> Update Script</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                <form role="form">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <!--<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                        INTERNAL, REVENUE ASSURANCE, FRAUD MANAGEMENT, CUSTOMER CARE-->
    <!--                     <div class="form-group">
	                        <select id="category" class="form-control">
	                        	<option value="" disabled selected>Select your option</option>
	                            <option value="internal">Internal</option>
	                            <option value="ra">Revenue Assurance</option>
	                            <option value="fm">Fraud Management</option>
	                            <option value="cc">Customer Care</option>
	                        </select>
                    	</div>
                    </div>
                    <div class="form-group">
                        <label for="reportname">Report Name</label>
                        <input type="text" class="form-control" id="reportname" placeholder="Report Name">
                    </div>
                    <div class="form-group">
                        <label for="data_src">Script</label>
                        <textarea id="data_src_update"></textarea>
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>

            </div>
        </div>
    </div>
    <!--/span-->

<!--</div><!--/row-->

<script type="text/javascript">

function create(obj){
    
        var service_url = "push-keyword-update";
        tinyMCE.triggerSave();
        var params = {id:$("#reportname").val(),datasrc:Base64.encode($("#data_src_new").val())};    

        $.post(
           service_url,params,
           function(result,status){
                console.log(result);
                if(status == 'success'){
                    $('#success').show();
                    change();
                }else{
                   
                }           
        });
}

</script>

<script type="text/javascript">

var report_data;
var report_name;
function show_report(obj){
    console.log(report_data);
    for(x in report_data){
        if(report_data[x].ID == $('#reportname').val()){
            tinyMCE.get('data_src_new').setContent(Base64.decode(report_data[x].MESSAGE));
            report_name = report_data[x].REPORTNAME;
        }
    }  
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
                    if(report_data[x].ISGROUP !== 1){            
                        listitem += '<option value="'+ report_data[x].ID +'">' + report_data[x].KEYWORD + '</option>';
                    }
                        //apply some effect on change, like blinking the color of modified cell...
                   }

                    $('#reportname').html(listitem);
                }else{
                   
                }           
        });
}

</script>