let apiUrl = '/api/v1/client/';
let apiPhp = '/index.php';

$(document).ready(function () {

    function doClientAdd(evt) {
        let form = $('#modalAddClient .needs-validation');
        if (!form[0].checkValidity()) {
            evt.preventDefault();
            evt.stopPropagation();
            form.addClass('was-validated');
            return false;
        }
        $.ajax({
            url: apiUrl + 'add' + apiPhp,
            type: 'POST',
            data: JSON.stringify({
                firstName: $('#inpAddClientFirstName').val(),
                lastName: $('#inpAddClientLastName').val(),
                mobilePhone: $('#inpAddClientMobilePhone').val(),
                comment: $('#inpAddClientComment').val()
            }),
            contentType: 'application/json'
        }).done(function (resp) {
            if (resp && resp['ok']) {
                $('#modalAddClient').modal('hide');
                updateClientTable();
            } else {
                alert(resp['error']);
            }
        }).fail(function (resp) {
            $('#modalAddClient').modal('hide')
            console.error(resp)
            alert('Что то пошло не так, попробуйте повторить операцию,' +
                ' или обратитесь к администратору: \n' +
                resp['error']
            );
        });

    }

    function doCreateList(list) {
        let tb = $('#clientTableList').empty();
        for (let i in list) {
            let client = list[i];
            tb.append('<tr>'+
                '<td>'+i+'</td>'+
                '<td>'+client.firstName+'</td>'+
                '<td>'+client.lastName+'</td>'+
                '<td>'+client.mobilePhone+'</td>'+
                '<td>'+client.comment+'</td>'+
                '<td><button class="btn-sm btn-outline-secondary bg-transparent"><i>!..</i></button>&nbsp;' +
                '<button class="btn-sm btn-outline-danger bg-transparent">X</button></td>'+
                '</tr>');
        }
    }

    function updateClientTable() {
        $.get(apiUrl + 'list' + apiPhp)
            .done(function (resp) {
                doCreateList(resp);
            })
            .fail(function (resp) {
                alert('Возникла проблема, обновите странницу или свяжитесь с администратором...')
            });
    }
    function init() {
        $('#btnClientAdd').click(doClientAdd);
        updateClientTable();
    }

    init();

});
