let apiUrl = '/api/v1/contacts/';
let apiPhp = '/index.php';

$(document).ready(function () {

    $('#btnSearchByPhone').click(function () {
        $.ajax({
            url: apiUrl + apiPhp + '?phone=' + $('#inpSearchByPhone').val(),
            type: 'GET',
            contentType: 'application/json'
        }).done(function (resp) {
            if (resp && resp['ok']) {
                doCreateList(resp);
            } else {
                alert(resp['error']);
            }
        }).fail(function (resp) {
            console.error(resp)
            alert('Что то пошло не так, попробуйте повторить операцию,' +
                ' или обратитесь к администратору: \n' +
                resp['error']
            );
        });
    });


    function doContactAdd(evt) {
        let form = $('#modalAddContact .needs-validation');
        if (!form[0].checkValidity()) {
            evt.preventDefault();
            evt.stopPropagation();
            form.addClass('was-validated');
            return false;
        }
        $.ajax({
            url: apiUrl + apiPhp,
            type: 'POST',
            data: JSON.stringify({
                name: $('#inpAddContactName').val(),
                sourceID: $('#inpAddContactSourceID').val(),
                phone: $('#inpAddContactPhone').val(),
                email: $('#inpAddContactEmail').val()
            }),
            contentType: 'application/json'
        }).done(function (resp) {
            if (resp && resp['ok']) {
                $('#modalAddContact').modal('hide');
                updateContactTable();
            } else {
                alert(resp['error']);
            }
        }).fail(function (resp) {
            $('#modalAddContact').modal('hide')
            console.error(resp)
            alert('Что то пошло не так, попробуйте повторить операцию,' +
                ' или обратитесь к администратору: \n' +
                resp['error']
            );
        });

    }

    function doCreateList(list) {
        let tb = $('#contactTableList').empty();
        for (let i in list) {
            let client = list[i];
            tb.append('<tr>'+
                '<td>'+i+'</td>'+
                '<td>'+client.sourceID+'</td>'+
                '<td>'+client.name+'</td>'+
                '<td>'+client.phone+'</td>'+
                '<td>'+client.email+'</td>'+
                '<td><button class="btn-sm btn-outline-secondary bg-transparent"><i>!..</i></button>&nbsp;' +
                '<button class="btn-sm btn-outline-danger bg-transparent">X</button></td>'+
                '</tr>');
        }
    }

    function updateContactTable() {
        $.get(apiUrl + 'list' + apiPhp)
            .done(function (resp) {
                doCreateList(resp);
            })
            .fail(function (resp) {
                alert('Возникла проблема, обновите странницу или свяжитесь с администратором...')
            });
    }
    function init() {
        $('#btnContactAdd').click(doContactAdd);
        updateContactTable();
    }

    init();

});
