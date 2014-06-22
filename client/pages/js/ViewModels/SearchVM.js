var SearchVM = kendo.observable({

    school_unit_types_ds: newSchoolUnitTypesDS(),
    education_levels_ds: newEducationLevelsDS(),

    region_edu_admins_ds: newRegionEduAdminsDS(),
    edu_admins_ds: newEduAdminsDS(),
    transfer_areas_ds: newTransferAreasDS(),
    municipalities_ds: newMunicipalitiesDS(),    
    
    lab_types_ds: newLabTypesDS(),
    aquisition_sources_ds : newAquisitionSourcesDS(),
    lab_workers_ds : newWorkersDS(), // περιμένω του κώστα το newWorkersDS(position)
    lab_states_ds: newStatesDS(),
    school_unit_states_ds: newStatesDS(),
    lab_rating_ds: newRatingDS(),
    
    lab_id: "",                 //μονό
    lab_name: "",               //μονό
    lab_special_name: "",       //μονό    
    lab_type: "",               //πολλαπλό
    creation_date: "",      //μονό
    
    aquisition_source: "",      //πολλαπλό
    lab_worker: "",             //πολλαπλό
    operational_rating: "",     //πολλαπλό
    technological_rating: "",   //πολλαπλό
    lab_state: "",              //μονό
    
    school_unit_id: "",         //μονό
    school_unit_name: "",       //μονό
    school_unit_type: "",       //πολλαπλό
    education_level: "",        //πολλαπλό
    school_unit_state: "",      //μονό
    
    region_edu_admin: "",       //πολλαπλό
    edu_admin: "",              //πολλαπλό
    transfer_area: "",          //πολλαπλό
    municipality: "",           //πολλαπλό
    
    
    resetForm: function(e) {

        e.preventDefault();
        console.log("resetform e:", e);
        
        this.set("lab_id", "");
        this.set("lab_name", "");
        this.set("lab_special_name", "");
        this.set("lab_type", "");
        this.set("creation_date", "");
        
        this.set("aquisition_source", "");
        this.set("lab_worker", "");
        this.set("operational_rating", "");
        this.set("technological_rating", "");
        this.set("lab_state", "");        
        
        this.set("school_unit_id", "");
        this.set("school_unit_name", "");
        this.set("school_unit_type", "");
        this.set("education_level", "");
        this.set("school_unit_state", "");
        
        this.set("region_edu_admin", "");
        this.set("edu_admin", "");
        this.set("transfer_area", "");
        this.set("municipality", "");


        var formData = $("#search-form").serializeArray();
        SchoolUnitsViewVM.school_units.filter(normalizeParams(formData));
        LabsViewVM.labs.filter(normalizeParams(formData));
        //repopulate multi select boxes with default datasource values
//        $("#regionEduAdmins").data("kendoMultiSelect").setDataSource(regionEduAdminsDS);
//        $("#eduAdmins").data("kendoMultiSelect").setDataSource(eduAdminsDS);
//        $("#transferAreas").data("kendoMultiSelect").setDataSource(transferAreasDS);
//        $("#municipalities").data("kendoMultiSelect").setDataSource(municipalitiesDS);
//        $("#educationLevels").data("kendoMultiSelect").setDataSource(educationLevelsDS);
//        $("#schoolUnitTypes").data("kendoMultiSelect").setDataSource(schoolUnitTypesDS);   
        
    },
    filterChanged: function(e){
        console.log("filterChanged e :", e);
        var formData = $("#search-form").serializeArray();
        SchoolUnitsViewVM.school_units.filter(normalizeParams(formData));
        LabsViewVM.labs.filter(normalizeParams(formData));
        
        searchParameters = formData;
    },     
    exportToXLSX: function(e){
        e.preventDefault();
        //console.log("exportToXLSX e :", e);
        
        if($('#switch_to_labs_view_btn').is(':checked')){
            var url = baseURL + 'search_labs?export=xlsx&';
        }else{
            var url = baseURL + 'search_school_units?export=xlsx&';
        }   
        
        var parameters = normalizeParams(searchParameters);
        //console.log("parameters:", parameters);

        var normalizedFilter = {};
        $.each(parameters, function(index, value){
            var filter = parameters[index];
            var value = normalizedFilter[filter.field];
            value = (value ? value+"," : "")+ filter.value;
            normalizedFilter[filter.field] = value;                                   
        });
        //console.log("normalizedFilter: ", normalizedFilter);

        $.each(normalizedFilter, function(index){
            var key = index;
            var value = normalizedFilter[index];
            var par= key+"="+value+"&";
            url = url.concat(par);
        });
        //url.slice(0, - 1);
        url = url.substring(0, url.length-1);
        
        console.log("url:", url);
        window.location.href = url;
    }
    
});