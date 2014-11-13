<?php 
    //psd user authentication to front-end

    require_once ('server/system/config.php');
    require_once ('server/libs/phpCAS/CAS.php');


    if(!isset($casOptions["NoAuth"]) || $casOptions["NoAuth"] != true) {
        //echo("eimai mesa stou index to if");
        // initialize phpCAS using SAML
        phpCAS::client(SAML_VERSION_1_1,$casOptions["Url"],$casOptions["Port"],'', false);
        // no SSL validation for the CAS server, only for testing environments
        phpCAS::setNoCasServerValidation();
        // handle backend logout requests from CAS server
        phpCAS::handleLogoutRequests(array($casOptions["Url"]));
        if(isset($_GET['logout']) && $_GET['logout'] == 'true') {
            phpCAS::logoutWithRedirectService($casOptions["LogoutURL"]);
            exit();
        } else {
            // force CAS authentication
            if (!phpCAS::checkAuthentication())
              phpCAS::forceAuthentication();
        }
        // at this step, the user has been authenticated by the CAS server and the user's login name can be read with //phpCAS::getUser(). for this test, simply print who is the authenticated user and his attributes.
        $user = phpCAS::getAttributes();

        //var_dump($user['title']);//die();
    }

    //$user['backendAuthorizationHash'] = base64_encode($frontendOptions['backendUsername'].':'.$frontendOptions['backendPassword']);
    $user['backendAuthorizationHash'] = base64_encode($frontendOptions['frontendUsername'].':'.$frontendOptions['frontendPassword']);
    
    
?>

<!DOCTYPE html>
<html>
    <head>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        
        <script>
            
            var user = JSON.parse(atob("<?php echo base64_encode(json_encode($user));?>"));
            var user_url = encodeURIComponent(JSON.stringify(user));
            var authorized_user;
            
        </script>
            
        <?php require_once('includes.html'); ?> 
        
        <script>
            
            baseURL = config.serverUrl;//"http://mmsch.teiath.gr/mylab/api/";
            
            $(document).ready(function() {
                
                $.ajaxSetup({
                    data: { user: user },
                    beforeSend: function(req) {
                        req.setRequestHeader('Authorization', "Basic " + user.backendAuthorizationHash);
                    }
                });
                
                
                /*
                 * H user_permits καλείται με παράμετρο τη user και επιστρέφει
                 * 1)user_role
                 * 2)user_permissions(permit_labs, permit_school_units)
                 * 3)user_infos (με τα οποία πληθυσμώνεται η καρτέλα 'Σχετικά')
                 */
                $.ajax({
                        type: 'GET',
                        url: baseURL + 'user_permits',
                        dataType: "json",
                        success: function(data){
                            if(data.status === 200){
                                
                                authorized_user = data.data[0].user_role;
                                
                                if(data.data[0].user_role === "ΣΕΠΕΗΥ" && data.data[0].user_permissions.permit_labs.length === 0 ){
                                    $("#mylab_authentication_message_pane").html("Εχετε συνδεθεί επιτυχώς στην Υπηρεσία myLab. <br><br> <span style='color:red'>Προσοχή: Δεν έχετε οριστεί Υπεύθυνος σε καμία Διάταξη Η/Υ, από τον αρμόδιο Διευθυντή της Σχολικής σας Μονάδας (ή των Σχολικών σας Μονάδων). Ως εκ τούτου η Διάταξη (ή οι Διατάξεις) σας δεν θα εμφανίζονται στην Υπηρεσία myLab κάτω από το λογαριασμό σας.</span> <br><br> Αν δεν επιθυμείτε να παραμείνετε στην Υπηρεσία πατήστε Αποσύνδεση. Ανακατεύθυνση σε <span id='countdown'> </span>... <i class='fa fa-spinner fa-spin'></i>");
                                    countDown(10); //in sec
                                }else{
                                    $("#mylab_authentication_message_pane").html("Εχετε συνδεθεί επιτυχώς στην Υπηρεσία myLab. Ανακατεύθυνση σε <span id='countdown'> </span>... <i class='fa fa-spinner fa-spin'></i>");
                                    countDown(3); //in sec
                                }
                                
                            }else if(data.status === 601){
                                $("#mylab_authentication_message_pane").html("[Σφάλμα " + data.status + "] Η Υπηρεσιακή Ιδιότητα του χρήστη δεν ικανοποιεί τα κριτήρια εισόδου στην Υπηρεσία myLab.");                                                               
                            }
                        },
                        error: function(data){ console.log("user_permits in toHome.php failed : ", data);}
                });
                                               
            });
            
            function countDown(endTime) {
                if (endTime > 0) {
                    $("#countdown").text(Math.floor(endTime));
                    setTimeout(function () { countDown(endTime - 1); }, 1000);
                }else{
                    window.open(config.url + "home.php?authorized_user=" + authorized_user , "_self");
                    
                }
            } 
            
            
        </script>
     
    </head>
   
    <body>

        <div class="container">

            <div style="clear: both;" >&nbsp;</div>

            <div class="header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="pull-left"><img src="client/pages/icons/sch_logo.png" />&nbsp;&nbsp;&nbsp;</p>			
                            <p class="pull-left" style="padding-top:5px;"><strong><a href="http://www.sch.gr" style="color: #1d73a3;font: bold 20px Tahoma,sans-serif;">Πανελλήνιο Σχολικό Δίκτυο</a></strong><br>
                                <span class="sch_logo_text2">Το Δίκτυο στην Υπηρεσία της Εκπαίδευσης</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="jumbotron" style="background-color: #D7E4BD;"> <!--7EA700-->

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <h2 style="color:#699360; font-weight:bold;">Υπηρεσία MyLab <br/>Πανελλήνιου Σχολικού Δικτύου</h2>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p id="mylab_authentication_message_pane"></p>
                                    <br>
                                </div>				
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="text-align: center;padding-bottom:20px;">
                                        <a id="logoutbtn" type="button" class="btn btn-default">Αποσύνδεση</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="text-align: center;">
                                        <strong>Υποστηρίζεται από το ΤΕΙ Αθήνας<br/>
                                                Επικοινωνία: mm@sch.gr
                                        </strong>
                                    </div>
                                </div>
                            </div>
                                    

                        </div>

                    </div>
                </div>

            </div>

            <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4"><p><img class="img-responsive" src="client/pages/icons/mainlogo_p8.png" /></p></div>
                        <div class="col-md-4"><p><img class="img-responsive" src="client/pages/icons/logo_stirizo.png" /></p></div>
                        <div class="col-md-4"><p><img class="img-responsive" src="client/pages/icons/logo.png" /></p></div>
                    </div>
                </div>
            </div>

        </div>

    </body>
</html>

<script>
    $("#logoutbtn").attr("href", config.url + "home.php?logout=true");
</script>