<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">Script Management</a>
        </li>
        <li>
            <a href="#">Delete</a>
        </li>
    </ul>
</div>

<div id="success" class="alert alert-success" style="display:none;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Well done!</strong> You have successfully Removed the record.
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> Delete Script</h2>

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
                        INTERNCONNECT SETTLEMENT, REVENUE ASSURANCE, FRAUD MANAGEMENT, CUSTOMER LIFECYCLE-->
                         <div class="form-group">
	                        <select id="n_category" class="form-control" onchange="change(this);">
	                        	<option value="" disabled selected>Select your option</option>
	                            <option value="is">Interconnect Settlement</option>
	                            <option value="ra">Revenue Assurance</option>
	                            <option value="fm">Fraud Management</option>
	                            <option value="cc">Customer Lifecycle</option>
	                        </select>
                    	</div>
                    </div>
                    <div class="form-group">
                        <label for="reportname">Report Name</label>
                        <select id="reportname" class="form-control">
                                <option value="" disabled selected>Select your option</option>                              
                        </select>
                    </div>
                    <input type="button" class="btn btn-default" value="Remove" onclick="create(this);" />
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
    
        var service_url = "http://localhost:8000/scriptmanagement/push-delete";
        var params = {category:$("#n_category").val(),reportname:report_name,id:$("#reportname").val()};    

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

</script>

<script type="text/javascript">

var report_data;
var report_name;

function change(obj){
    
        var service_url = "http://localhost:8000/report/getreport";
        tinyMCE.triggerSave();
        var params = {category:$("#n_category").val()};    

        $.post(
           service_url,params,
           function(result,status){
                console.log(result);
                if(status == 'success'){
                   report_data = JSON.parse(result);
                   var listitem = '<option value="" disabled selected>Select your option</option>';                        
                   for (x in report_data) {                     
                    listitem += '<option value="'+ report_data[x].ID +'">' + report_data[x].REPORTNAME + '</option>';
                        //apply some effect on change, like blinking the color of modified cell...
                   }

                    $('#reportname').html(listitem);
                }else{
                   
                }           
        });
}

</script>