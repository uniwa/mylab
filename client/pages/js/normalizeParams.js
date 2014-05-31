function normalizeParams(formData) {
    var dsSrcParams = [];
    $.each(formData, function(index, objectEntry) {
        if(objectEntry.value !== ""){
            dsSrcParams.push({'field': objectEntry.name, 'value': objectEntry.value}); 
        }
    });

    return dsSrcParams;
}