var showFatalError = function () {
    alert('Ошибка выполнения запроса!');
};

//очистка указанного поля
var clearField = function (field) {
    $(field).val('');
};

var doRequest = function (target, type, data, containerId, messageBlockId, sender) {

    $.ajax({
        url: target,
        type: type,
        dataType: 'json',
        data: data,
        cache: false,
        beforeSend: function () {
            //sender && sender.attr('disabled', 'disabled');
        }
    }).done(function (data) {
        //sender && sender.removeAttr('disabled');
        if (data.message) {
            var message = $(messageBlockId);
            message.removeClass("hidden");
            message.empty().html(data.message);
        }
        if (data.content) {
            if (!data.error) {
                switch (data.contentName) {
                    case 'inline':
                        var container = $(containerId);
                        container.append(data.content);
                        break;
                    case 'table':
                        var container = $(containerId);
                        container.html(data.content);
                        break;
                    case 'alert':
                        $(containerId).hide();
                        $(messageBlockId).hide();
                        alert(data.content);
                }
            }
        } else {
            clearField(containerId);
            //alert('Error: ' + data.error);
        }
        clearField("#js-login-password");
        return false;
    })
        .fail(function (jqXHR, textStatus, e) {

            //sender && sender.removeAttr('disabled');
            showFatalError();
        });

};