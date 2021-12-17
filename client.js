var apiUrl = '/api/v1/client/';

$(document).ready(function () {

    function doClientAdd(evt) {
        var form = $('.needs-validation');
        if (!form.checkValidity()) {
            evt.preventDefault();
            evt.stopPropagation();
            return false;
        }
        $.ajax({
            url: apiUrl + 'add',
            type: 'POST',
            data: JSON.stringify({
                firstName: $('#clientFirstName').val(),
                lastName: $('#clientLastName').val(),
                clientMobilePhone: $('#clientMobilePhone').val(),
                clientDesc: $('#clientDesc').val()
            }),
            contentType: 'application/json'
        }).done(function (resp) {
            //console.log(resp)
        }).fail(function (resp) {
            //console.log(resp)
        });

    }

    function doCreateList(list) {

        for (var i in list) {
            var client = list[i];
            $('#clientTableList').append('<tr>'+
                '<td>'+i+'</td>'+
                '<td>'+client.firstName+'</td>'+
                '<td>'+client.lastName+'</td>'+
                '<td>'+client.mobilePhone+'</td>'+
                '<td>'+client.desc+'</td>'+
                '</tr>');
        }
    }

    function init() {

        $('#btnClientAdd').click(doClientAdd);

        $.get(apiUrl + 'list')
            .done(function (resp) {
                resp = [
                    {firstName: 'firstname1', lastName: 'lastName1', mobilePhone: '+79123456789', desc: 'Some comment 1'},
                    {firstName: 'firstname2', lastName: 'lastName2', mobilePhone: '+79123456789', desc: 'Some comment 2'},
                    {firstName: 'firstname3', lastName: 'lastName3', mobilePhone: '+79123456789', desc: 'Some comment 3'}
                ];
                doCreateList(resp);
            })
            .fail(function (resp) {
                alert('Возникла проблема, обновите странницу или свяжитесь с администратором...')
            });
    }

    init();

});
