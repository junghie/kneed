<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">Polls</a>
        </li>
    </ul>
</div>

<?php if(isset($flash) && $flash == 0){ ?>
<div id="success" class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Well done!</strong> You successfully saved the record.
</div>
<?php }?>


<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> New Poll</h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                <form role="form" enctype="multipart/form-data" action="polls-create" method="post">                    
                    <div class="form-group">
                        <label for="reportname">Description</label>
                        <input type="text" name="n_description" class="form-control" id="n_description" placeholder="Description">
                    </div>
                    <div class="form-group">
                        <label for="schedule">End Date</label>
                        <div class="input-group date">
                          <input class="form-control" id="dp3" name="n_sched" type="text" value="<?= date('Y-m-d H:00'); ?>">
                          <span class="input-group-addon addon" id="open"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                    <label for="notify">Notify Contacts</label>
                    <select id="n_contacts" name="n_contacts[]" multiple class="form-control" data-rel="chosen">
                              
                                 <?php foreach($keywords as $cnt){ ?>
                                        <option value="<?= $cnt->ID ?>"><?= $cnt->KEYWORD ?></option>
                                <?php } ?> 
                    </select>
                    </div>                    
                    <div class="form-group clonedInput" id="entry1">
                        <label class="heading-reference" for="option">Option 1</label>
                        <!--<input type="text" class="form-control" name="n_option[]" id="n_option" placeholder="Option">-->
                        <input type="text" class="form-control" name="n_option_description[]" id="n_option_description" placeholder="Option Description">
                        <input type="file" id="n_file" name="n_file[]" value="Image" style="visibility:hidden;">
                    </div>
                    <div class="form-group">
                    <input type="button" id="btnAdd" value="Add option">
                    <input type="button" id="btnDel" value="Remove last option">
                    </div>
                    <div class="form-group">
                        <input type="button" class="btn btn-default" value="Submit" onclick="form.submit();" />
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->


<script type="text/javascript">

$(function () {
    $('#btnAdd').click(function () {
        var num     = $('.clonedInput').length, 
            newNum  = new Number(num + 1),      
            newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); 
        
        newElem.find('.heading-reference').html('Option ' + newNum);

        $('#entry' + num).after(newElem); 
        $('#btnDel').attr('disabled', false);
    

        if (newNum == 5)
        $('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit");
    });

     $('#btnDel').click(function () {
      
            var num = $('.clonedInput').length;
           
            $('#entry' + num).slideUp('slow', function () {$(this).remove(); 
           
            if (num -1 === 1)
                $('#btnDel').attr('disabled', true);
              
             $('#btnAdd').attr('disabled', false).prop('value', "add section");});
            
        return false;
             // remove the last element
 
    // enable the "add" button
        $('#btnAdd').attr('disabled', false);
    });
     $('#btnDel').attr('disabled', true);
});

$(document).ready(function () {
    $('#dp3').datetimepicker();
});

$('#open').click(function(){
    $('#dp3').datetimepicker('show');
});


change();
function change(){
    
        var service_url = "keywords-getlist";
        var params = {group:2};

        $.post(
           service_url,params,
           function(result,status){
                console.log(result);
                if(status == 'success'){
                   report_data = JSON.parse(result);
                   var listitem = '<option value="" disabled selected>ALL</option>';                        
                   for (x in report_data) {         
                    if(report_data[x].ISGROUP !== 1){            
                        listitem += '<option value="'+ report_data[x].ID +'">' + report_data[x].KEYWORD + '</option>';
                    }
                        //apply some effect on change, like blinking the color of modified cell...
                   }

                    $('#n_members').html(listitem);
                }else{
                   
                }           
        });
}

</script>
