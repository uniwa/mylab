<!DOCTYPE html>
<div id="school_units_container" >

    <?php
    
        /* grid column templates */
        require_once('client/pages/js/Templates/grid_column_template/schoolUnitsViewSchoolUnitStateColumnTemplate.html');
        /* grid toolbar templates */
        require_once('client/pages/js/Templates/grid_toolbar_template/labToolbarTemplate_school_units_view.html');
        require_once('client/pages/js/Templates/grid_toolbar_template/labToolbarTemplate_school_unit_labs.html');
        /* grid detail templates */
        require_once('client/pages/js/Templates/grid_detail_template/schoolUnitDetailsTemplate.html');
        /* grid toolbar command popup dialog templates */
        require_once('client/pages/js/Templates/grid_toolbar_command_popup_dialog_template/schoolUnitsColumnSelectionTemplate.html');
        /* grid column command popup dialog templates */
        require_once('client/pages/js/Templates/grid_column_command_popup_dialog_template/schoolUnitContactDetailsTemplate.html');
        
//        require_once('client/pages/js/Templates/list_view_template/generalInfoTemplate.html');
//        require_once('client/pages/js/Templates/list_view_template/ratingTemplate.html');
//        require_once('client/pages/js/Templates/list_view_template/editGeneralInfoTemplate.html');
//        require_once('client/pages/js/Templates/list_view_template/editRatingTemplate.html');
//        require_once('client/pages/js/Templates/grid_toolbar_command_popup_dialog_template/labCreateTemplate.html');
//        require_once('client/pages/js/Templates/grid_detail_template/labDetailsTemplate.html');
//        require_once('client/pages/js/Templates/grid_column_command_popup_dialog_template/labTransitTemplate.html');
//        require_once('client/pages/js/Templates/notification_template/errorNotificationTemplate.html');
//        require_once('client/pages/js/Templates/notification_template/successNotificationTemplate.html');
        
?> 

    <!--contact details dialog-->
    <div id="contact_details_dialog"></div>

    <!--column selection dialog-->
    <div id="school_units_column_selection_dialog"></div>

    <!--transition dialog-->
    <!--<div id="transition_dialog"></div>-->    
    
    <!--transition notification-->
    <!--<span id="notification" style="display:none;"></span>-->
    
    <!-- grid element -->
    <div class="container">        
        <div class="row">          
            <div class="col-md-12">        
                <div    id="school_units_view"
                        data-role="grid"
                        data-bind="source: school_units, visible: isVisible"
                        data-detail-init="SchoolUnitsViewVM.detailInit"
                        data-detail-template= 'school_unit_details_template'
                        data-selectable="row"
                        data-scrollable= "true"
                        data-resizable= "true"
                        data-sortable= "{'allowUnsort': false}"
                        data-pageable="{ 'pageSizes': [5, 10, 15, 20, 25, 30, 50], 
                                         'messages':  { 'display': '{0}-{1} από {2} Σχολικές Μονάδες', 
                                                        'empty': 'Δεν βρέθηκαν Σχολικές Μονάδες',
                                                        'itemsPerPage': 'Σχολικές Μονάδες ανά σελίδα', 
                                                        'first': 'μετάβαση στην πρώτη σελίδα',
                                                        'previous': 'μετάβαση στην προηγούμενη σελίδα',
                                                        'next': 'μετάβαση στην επόμενη σελίδα',
                                                        'last': 'μετάβαση στην τελευταία σελίδα' }}"
                        data-toolbar="[{ 'template' : $('#lab_toolbar_template_school_units_view').html()  }]"
                        data-columns="[{ 'field': 'school_unit_id', 'title':'Κωδικός ΜΜ', 'width':'90px'},
                                       { 'field': 'school_unit_name', 'title':'Ονομασία', 'width':'350px'},
                                       { 'field': 'school_unit_special_name', 'title':'Ειδική Ονομασία', 'width':'250px', 'hidden': true},
                                       { 'field': 'school_unit_type', 'title':'Τύπος', 'width':'115px', 'hidden': true},
                                       { 'field': 'education_level', 'title':'Βαθμίδα', 'width':'115px', 'hidden': true},
                                       { 'field': 'school_unit_state', 'title':'Λειτουργική Κατάσταση', 'template' : $('#school_units_view_school_unit_state_column_template').html(), 'width':'150px'},
                                       { 'field': 'region_edu_admin', 'title':'Περιφερειακή Διεύθυνση Εκπαίδευσης', 'width':'250px', 'hidden': true},
                                       { 'field': 'edu_admin', 'title':'Διεύθυνση Εκπαίδευσης', 'width':'250px'},
                                       { 'field': 'transfer_area', 'title':'Περιοχή Μετάθεσης', 'width':'200px', 'hidden': true},
                                       { 'field': 'prefecture', 'title':'Περιφερειακή Ενότητα', 'width':'200px', 'hidden': true},
                                       { 'field': 'municipality', 'title':'Δήμος', 'width':'200px', 'hidden': true},
                                       { 'field': 'phone_number', 'title':'Τηλέφωνο', 'sortable': false, 'width':'150px', 'hidden': true},
                                       { 'field': 'fax_number', 'title':'Φαξ', 'sortable': false, 'width':'150px', 'hidden': true},
                                       { 'field': 'email', 'title':'E-mail', 'sortable': false, 'width':'250px', 'hidden': true},
                                       { 'field': 'street_address', 'title':'Διεύθυνση', 'sortable': false, 'width':'350px', 'hidden': true},
                                       { 'field': 'postal_code', 'title':'ΤΚ', 'sortable': false, 'width':'100px', 'hidden': true},
                                       { 'field': 'last_update', 'title':'Τελευταία Ανανέωση', 'sortable': false, 'width':'150px'},
                                       { 'command': [{'text':'', 'className': 'fa fa-info', 'click':SchoolUnitsViewVM.showContactDetails, 'name':'contactDetails'}],'title':'', 'width':'40px'}]">
                </div>
            </div>
        </div>
    </div>

</div>