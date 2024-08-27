class Filters {
    getDistandSupp(prefix,base_url) {
        var brandId = $(`#${prefix}-brandId`).val();
        $.ajax({
            'url':`${base_url}/product/getdistandsup`,
            'method': "POST",
            'data' : {'id' : brandId.join(',')},
        }).done(function(data){
            let response = JSON.parse(data);
            let distributorLists = $(`#${prefix}-distributorId`).val();
            let availabeldistributorId = 0;
            //$(`#${prefix}-distributorId').empty();
            
            if (response.distributorList != null) {
                $.each(response.distributorList.distributor_list, function(key, value) {
                    availabeldistributorId = value.id.toString();
                    if (jQuery.inArray(availabeldistributorId, distributorLists) == -1) {
                        $(`#${prefix}-distributorId`)
                        .append($("<option></option>")
                        .attr("value", value.id)
                        .text(value.name));
                    }
                });
                $(`#${prefix}s-distributorId`).trigger('change');
            }
        });
    }

    getSalesPerson(prefix,base_url) {
        var distributorId = $(`#${prefix}-distributorId`).val();

        $.ajax({
            'url':`${base_url}/product/getsalesperson`,
            'method': "POST",
            'data' : {'id' : distributorId.join(',')},
        }).done(function(data){
            let response = JSON.parse(data);

            $(`#${prefix}-salesPersonName`).empty();

            $.each(response, function(responseKey, responseValue) { 
                $.each(JSON.parse(responseValue), function(key, value) { 
                    $(`#${prefix}-salesPersonName`)
                    .append($("<option></option>")
                    .attr("value", value.name)
                    .text(value.name)); 
                });
            });
        });
    }

    getCategory(prefix,base_url) {
        var departmentId = $(`#${prefix}-departmentId`).val();
        $.ajax({
            'url':`${base_url}/product/getcategory`,
            'method': "POST",
        }).done(function(data){
            let response = JSON.parse(data);
            let categoryList = $(`#${prefix}-categoryList`).val();
            $(`#${prefix}-categoryList`).empty();
            let selectedDepartmentId = 0;
            let availabelCategoryId = 0;
            $.each(response, function(key, value) {
                selectedDepartmentId = value.parentId.toString();
                if (jQuery.inArray(selectedDepartmentId, departmentId) != -1) {
                    availabelCategoryId = value.id.toString();
                    if(jQuery.inArray(availabelCategoryId,categoryList) == -1){
                        $(`#${prefix}-categoryList`)
                        .append($("<option></option>")
                        .attr("value", value.id)
                        .text(value.name));
                    }
                }
            });
        });
    }

    getVarietal(prefix,base_url) {
        var categoryId = $(`#${prefix}-categoryList`).val();
        $.ajax({
            'url':`${base_url}/product/getvarietal`,
            'method': "POST",
        }).done(function(data){
            let response = JSON.parse(data);
            let varietalList = $(`#${prefix}-varietalList`).val();
            $(`#${prefix}-varietalList`).empty();
            let selectedcategoryId = 0;
            let availabelVarietalId = 0;
            $.each(response, function(key, value) {
                selectedcategoryId = value.parentId.toString();
                if (jQuery.inArray(selectedcategoryId, categoryId) != -1) { 
                    availabelVarietalId = value.id.toString();
                    if(jQuery.inArray(availabelVarietalId,varietalList) == -1){
                        $(`#${prefix}-varietalList`)
                        .append($("<option></option>")
                        .attr("value", value.id)
                        .text(value.name));
                    }
                }
            });
            $(`#${prefix}-varietalList`).trigger('change');
        });
    }

    clearAllFiler(prefix) {
        $(`#${prefix}-brandId`).val('').trigger('change');
        $(`#${prefix}-distributorId`).val('').trigger('change');
        $(`#${prefix}-salesPersonName`).val('').trigger('change');
        $(`#${prefix}-departmentId`).val('').trigger('change');
        $(`#${prefix}-categoryList`).val('').trigger('change');
        $(`#${prefix}-varietalList`).val('').trigger('change');
        $(`#${prefix}-productTagId`).val('').trigger('change');
        $(`#${prefix}-productBodyId`).val('').trigger('change');
        $(`#${prefix}-productSizeId`).val('').trigger('change');
        $(`#${prefix}-productPackListId`).val('').trigger('change');
        $(`#${prefix}-productTypeId`).val('').trigger('change');
    }
}
