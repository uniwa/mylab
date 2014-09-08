<!DOCTYPE html>
<!--navigation bar-->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="background-color:#5E5E5E;">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <img class="psd_icon" alt="ΠΣΔ" src="client/pages/icons/sch_grey_2.jpg">
        <!--<img src="client/img/logo-teia.jpg" alt="ΤΕΙ Αθήνας" style="float:left; padding-left:15px;">-->
        <!--<a class="navbar-brand" href="home.php" style="font-size:30px;font-weight:bold;font-family: 'Crafty Girls', cursive;">Υπηρεσία MyLab</a>-->
        <a href="home.php" style="line-height: 1.60; margin-left:20px; font-size:30px; font-family: 'Crafty Girls', cursive; color: #8EBC00;"> MyLab</a>
            <!--<span style="font-family: 'Calibri'; font-size:32px; font-weight:400;">Υπηρεσία</span> MyLab</a>-->
        <!--<span class="label label-danger" style="position:absolute; margin-top:5px;">BETA</span>-->
    </div>

    <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
            
            <div id="user_menu" class="btn-group" style="margin: 8px 23px 0px 0px;">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-user"></i> <span id="user_button" style="font-size: 13px;"> </span> <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" role="menu" style="cursor:pointer; cursor:hand;">
                <li role="presentation" class="dropdown-header">Έκδοση Αναφορών</li>
                <li><a id="annual_ypaith_report" target="_blank" data-bind="events: {click : exportReport}"><i class="fa fa-file-pdf-o"></i> Ετήσια Αναφορά ΥΠΑΙΘ</a></li>
                <!--<li><a href="#"><i class="fa fa-file-pdf-o"></i> Αναφορά 1</a></li>-->
                <!--<li><a href="#"><i class="fa fa-file-pdf-o"></i> Αναφορά 2</a></li>-->
                <li class="divider"></li>
                <li><a href="#" id="lnkLogout"><i class="fa fa-sign-out"></i> Αποσύνδεση</a></li>
              </ul>
            </div>
        </ul>
    </div>    
</nav>

<script>

    var g_casUrl = "<?php echo $casOptions['Url'] ?>";

    // Build logout link
    $("#lnkLogout").attr("href", config.url + "home.php?logout=true"); //"http://mmsch.teiath.gr/mylab/?logout=true"
    $("#user_button").html(user.uid);
    //$("#annual_ypaith_report").attr("href", config.serverUrl + "report_keplhnet?user=" + user_url);
    
</script>