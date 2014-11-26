<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CONTEXTO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
    <meta name="author" content="Muhammad Usman">

    <!-- The styles -->
    <link id="bs-css" href="css/bootstrap-cerulean.min.css" rel="stylesheet">
    
    <link href="css/charisma-app.css" rel="stylesheet">
    <link href='bower_components/fullcalendar/dist/fullcalendar.css' rel='stylesheet'>
    <link href='bower_components/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print'>
    <link href='bower_components/chosen/chosen.min.css' rel='stylesheet'>
    <link href='bower_components/colorbox/example3/colorbox.css' rel='stylesheet'>
    <link href='bower_components/responsive-tables/responsive-tables.css' rel='stylesheet'>
    <link href='bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css' rel='stylesheet'>
    <link href='bower_components/bootstrap-table/dist/bootstrap-table.min.css' rel='stylesheet'>
    <link href='bower_components/jquery-datetime/jquery.datetimepicker.css' rel='stylesheet'>
    <link href='css/jquery.noty.css' rel='stylesheet'>
    <link href='css/noty_theme_default.css' rel='stylesheet'>
    <link href='css/datepicker.css' rel='stylesheet'>
    <link href='css/elfinder.min.css' rel='stylesheet'>
    <link href='css/elfinder.theme.css' rel='stylesheet'>
    <link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
    <link href='css/uploadify.css' rel='stylesheet'>
    <link href='css/animate.min.css' rel='stylesheet'>
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>


    <!-- jQuery -->
    <script src="bower_components/jquery/jquery.min.js"></script>
    <script src="bower_components/tinymce/tinymce.min.js"></script>
    <script src="bower_components/tinymce/jquery.tinymce.min.js"></script>


    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->
    <link rel="shortcut icon" href="#">

</head>

<body>
<?php if (!isset($no_visible_elements) || !$no_visible_elements) { ?>
    <!-- topbar starts -->
    <div class="navbar navbar-default" role="navigation">

        <div class="navbar-inner">
            <button type="button" class="navbar-toggle pull-left animated flip">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"> <!--<img alt="Charisma Logo" src="img/logo20.png" class="hidden-xs"/>-->
                <span class="navbar-brand-name">CONTEXTO</span>                
                <span class="navbar-brand-description">Smart way to inform</span>
            </a>

            <!-- user dropdown starts -->
            <div class="btn-group pull-right">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i><span class="hidden-sm hidden-xs"> 
                    <?php echo Session::get('user')->MSISDN; ?></span>

                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="#">Change Password</a></li>
                    <li><a href="#">Account Settings</a></li>
                    <li><a href="#">Withdraw</a></li>
                    <li class="divider"></li>
                    <li><a href="logout">Logout</a></li>
                </ul>
                <span>&nbsp</span>
                
            </div>
            <!-- user dropdown ends -->
           

            <div class="btn-group pull-right animated tada">
                        <ul class="collapse navbar-collapse nav navbar-nav top-menu label-header">
                        <li><i class="glyphicon glyphicon-envelope"></i> <span class="hidden-md">Keyword : <?= Session::get('user')->ADDITIONALKEYWORD + Session::get('accounttypes')[Session::get('user')->ACCOUNTTYPEID]->KEYWORDLIMIT;; ?></span></li>
                        <ul>
             </div> 

            <div class="btn-group pull-right animated tada">
                        <ul class="collapse navbar-collapse nav navbar-nav top-menu label-header">
                        <li><i class="glyphicon glyphicon-envelope"></i> <span class="hidden-md">Profit : <?= number_format(Session::get('user')->COMMISSION,2); ?></span></li>
                        <ul>
             </div>  

            <div class="btn-group pull-right animated tada">
                        <ul class="collapse navbar-collapse nav navbar-nav top-menu label-header">
                        <li><i class="glyphicon glyphicon-envelope"></i> <span class="hidden-md">Credits : <?= number_format(Session::get('user')->CREDIT,2); ?></span></li>
                        <ul>
            </div>  


        </div>
    </div>
    <!-- topbar ends -->
<?php } ?>
<div class="ch-container">
    <div class="row">
        <?php if (!isset($no_visible_elements) || !$no_visible_elements) { ?>

        <!-- left menu starts -->
        <div class="col-sm-2 col-lg-2">
            <div class="sidebar-nav">
                <div class="nav-canvas">
                    <div class="nav-sm nav nav-stacked">

                    </div>
                    <ul class="nav nav-pills nav-stacked main-menu">
                        <li class="nav-header">Home</li>
                        <li><a class="ajax-link" href="home"><i class="glyphicon glyphicon-home"></i><span> Dashboard</span></a>
                        </li>
                         <li><a class="ajax-link" href="subscriptions"><i class="glyphicon glyphicon glyphicon-user"></i><span> Subscription</span></a>
                        </li>
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span> Contacts</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="contacts">New</a></li>
                                <li><a href="contacts-manage">Update</a></li>
                                <li><a href="contacts-group">Group</a></li>
                            </ul>
                            <li>
                        </li>
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span> Keywords</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="keywords">New</a></li>
                                <li><a href="keywords-update">Update</a></li>
                                <li><a href="keywords-buy">Purchase</a></li>
                            </ul>
                            <li>
                        </li>
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span> Broadcast SMS</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="brodcastsms">New</a></li>
                                <li><a href="brodcastsms-manage">Manage</a></li>                                
                            </ul>
                        </li>
                        <!--<li><a class="ajax-link" href="/scriptmanagement"><i class="glyphicon glyphicon-eye-open"></i><span> Scripts Management</span></a>   
                        </li>-->
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span> Reports</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="report-transactions">Transactions</a></li>
                                <li><a href="report-keyword">Keywords</a></li>
                                <li><a href="report-mt">Sent</a></li>
                                <li><a href="report-mo">Inbox</a></li>
                            </ul>
                        </li>
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span> Polls</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="polls-create">Create</a></li>
                                <li><a href="polls-manage">Manage</a></li>                                
                            </ul>
                        </li>
                        <li><a class="ajax-link" href="packages"><i class="glyphicon glyphicon-shopping-cart"></i><span> Purchase Credits</span></a>
                    </ul>
                    <br/>

                    <!--<label id="for-is-ajax" for="is-ajax"><input id="is-ajax" type="checkbox"> Ajax on menu</label>-->
                </div>
            </div>
        </div>
        <!--/span-->
        <!-- left menu ends -->

        <noscript>
            <div class="alert alert-block col-md-12">
                <h4 class="alert-heading">Warning!</h4>

                <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a>
                    enabled to use this site.</p>
            </div>
        </noscript>

        <div id="content" class="col-lg-10 col-sm-10">


            <?php } ?>

            <!-- content starts -->
            <?php echo $content ?>


        <?php if (!isset($no_visible_elements) || !$no_visible_elements) { ?>
    <!-- content ends -->
    </div><!--/#content.col-md-0-->
<?php } ?>
</div><!--/fluid-row-->
<?php if (!isset($no_visible_elements) || !$no_visible_elements) { ?>

    
    <hr>

    <footer class="row">
        <p class="col-md-9 col-sm-9 col-xs-12 copyright">&copy; <a href="#" target="_blank">
                JAPS Inc</a> <?php echo date('Y') ?></p>
    </footer>
<?php } ?>

</div><!--/.fluid-container-->

<!-- external javascript -->

<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- library for cookie management -->
<script src="js/jquery.cookie.js"></script>
<!-- calender plugin -->
<script src='bower_components/moment/min/moment.min.js'></script>
<script src='bower_components/fullcalendar/dist/fullcalendar.min.js'></script>
<!-- data table plugin -->
<script src='js/jquery.dataTables.min.js'></script>
<script src="js/bootstrap-datepicker.js"></script>

<!-- select or dropdown enhancer -->
<script src="bower_components/chosen/chosen.jquery.min.js"></script>
<!-- plugin for gallery image view -->
<script src="bower_components/colorbox/jquery.colorbox-min.js"></script>
<!-- notification plugin -->
<script src="js/jquery.noty.js"></script>
<!-- library for making tables responsive -->
<script src="bower_components/responsive-tables/responsive-tables.js"></script>
<!-- tour plugin -->
<script src="bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js"></script>
<!-- table plugin -->
<script src="bower_components/bootstrap-table/dist/bootstrap-table.min.js"></script>
<!-- star rating plugin -->
<script src="js/jquery.raty.min.js"></script>
<!-- for iOS style toggle switch -->
<script src="js/jquery.iphone.toggle.js"></script>
<!-- autogrowing textarea plugin -->
<script src="js/jquery.autogrow-textarea.js"></script>
<!-- multiple file upload plugin -->
<script src="js/jquery.uploadify-3.1.min.js"></script>
<!-- history.js for cross-browser state change on ajax -->
<script src="js/jquery.history.js"></script>
<!-- application script for Charisma demo -->
<script src="js/charisma.js"></script>
<script src="js/Base64.js"></script>
<script src="bower_components/jquery-datetime/jquery.datetimepicker.js"></script>
</body>
</html>

