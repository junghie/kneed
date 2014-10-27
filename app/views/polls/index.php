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

<div id="success" class="alert alert-success" style="display:none;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Well done!</strong> You successfully save the record.
</div>

<div id="failed" class="alert alert-info" style="display:none;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Well done!</strong> You successfully save the record.
</div>


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
                    
                    <div class="form-group clonedInput" id="entry1">
                        <label class="heading-reference" for="option">Option 1</label>
                        <input type="text" class="form-control" name="n_option[]" id="n_option" placeholder="Option">
                        <input type="text" class="form-control" name="n_option_description[]" id="n_option_description" placeholder="Option Description">
                        <input type="file" id="n_file" name="n_file[]" value="Image">
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

</script>
