function newLabRelationsDS(labID, detailRow){

    return {
        serverFiltering: true,
        transport: {
            read: {
                url: "api/lab_relations",
                type: "GET",
                dataType: "json"
            },
            create: {
                url: "api/lab_relations?user=" + user_url,
                type: "POST",
                dataType: "json"
            },
            update: {  //δεν χρησιμοποιείται
                url: "api/lab_relations?user=" + user_url,
                type: "PUT",
                dataType: "json"
            },
            destroy: {
                url: "api/lab_relations?user=" + user_url,
                type: "DELETE",
                dataType: "json"
            },
            parameterMap: function(data, type) {
                if (type === 'read') {
                    data['lab_id'] = labID;
                    return data;
                }else if (type === 'create') {
                    
                    data['relation_type'] = data['relation_type_name'];
                    
                    if (data['relation_type'] === "ΕΞΥΠΗΡΕΤΕΙΤΑΙ ΔΙΑΔΙΚΤΥΑΚΑ"){
                        data['circuit_id'] = data['circuit_phone_number'];
                    }else{
                        delete data.circuit_id;
                    }
                    
                    data['school_unit_id'] = data['school_unit_name'];
                    return data;
                    
                }else if (type === 'destroy'){
                    return data;
                }else if (type === 'update'){
                    //δεν χρησιμοποιείται
                    return data;
                }
            }
        },
        schema:{
            data: "data",
            total: "total",
            model:{
                id:"lab_relation_id",
                fields:{
                    lab_relation_id:{editable: false},
                    relation_type:{},
                    circuit_id:{},
                    circuit_phone_number:{},
                    school_unit_id: {},
                    school_unit_name: {},                            
                    lab_id:{editable: false, defaultValue: labID},
                    lab_name:{editable: false},
                    
                    //custom fields
                    relation_type_name:{},
                    relation_type_id: {},
                    school_unit: {}
                    
                }
            }
        },
        //change: function(e){console.log("newLabRelationsDS CHANGE event", e);},
        requestEnd: function(e){
            /*εδώ θα μπουν και τα μηνύματα επιτυχίας/αποτυχίας */
            //console.log("newLabRelationsDS REQUESTEND event", e);
            
            if (e.type==="create" || e.type==="update" || e.type==="destroy"){
                
                var message;
                if (typeof e.response.message !== 'undefined'){
                    message= e.response.message;
                }else if (typeof e.response.message_internal !== 'undefined'){
                    message= e.response.message_internal;
                }else if (typeof e.response.message_external !== 'undefined'){
                    message= e.response.message_external;
                }
                
                if (e.response.status == "200"){
                    
                    notification.show("Επιτυχής ενημέρωση Διάταξης Η/Υ. ", "success");               
                    
                }else{
                    
                    notification.show("Η ενημέρωση της Διάταξης Η/Υ απέτυχε. " + message.substr(message.indexOf(":") + 1), "error");
                    
                }                
                
                detailRow.find("#lab_relations_details").data("kendoGrid").dataSource.read();            
            }
        }
    };
    
}