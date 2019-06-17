// src.: https://stackoverflow.com/a/11339012/3514658
function getFormData($form){
    var unindexedArray = $form.serializeArray();
    var indexedArray = {};

    $.map(unindexedArray, function(n, i){
        indexedArray[n['name']] = n['value'];
    });

    return indexedArray;
}

function getFormFields($form){
    var unindexedArray = $form.serializeArray();
    var indexedArray = [];

    $.map(unindexedArray, function(n, i){
        indexedArray.push(n['name']);
    });

    return indexedArray;
}
