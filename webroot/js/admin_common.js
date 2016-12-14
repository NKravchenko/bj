$(function () {

    // AJAX кнопки изм статуса
    $("body").on('click', "button[data-txt], button[data-img]", function () {
        var messageBlockId = "#msgInfo",
            containerId = $(this).closest("tr"),
            target = "./admin/editMessageStatus";
        //определяем чем управляет кнопка
        var msgType = (typeof $(this).data("txt") != "undefined") ?
            "txt" :
            "img";
        var msgToggle = $(this).data(msgType);
        //id сообщения
        var msgId = $(this).data("id");

        doRequest(target, 'post', {'msgType': msgType, 'msgToggle': msgToggle, 'msgId': msgId}, containerId, messageBlockId, self);
        //console.log( msgType + " " + "Toggle " + msgToggle + " id=" + msgId );
    });

    //показать форму редактирования сообщения
    $("body").on('click', "button[data-edit-id]", function () {
        var selfTr = $(this).closest("tr").find("td[data-msg-id]");
        var msg = $(selfTr).find("p").text();
        $(selfTr).find("form").toggleClass("hidden");
        $(selfTr).find("textarea").text(msg);
    });

    // AJAX редактирование сообщения
    $("body").on('click', "button[data-btn-editmsg]", function () {
        var messageBlockId = "#msgInfo",
            containerId = $(this).closest("tr"),
            target = "./admin/editMessageText";
        var msgId = $(this).data("btnEditmsg");
        var msgTest = $(this).closest("form").find("textarea").text();
        console.log(msgId, msgTest);
    });

    $(document).on('click', '.js-dict-status', function () {
        var self = $(this), //кнопка
            dictId = self.attr('data-id'),
            type = self.attr('data-type'),
            newStatus = self.attr('data-new-status'),
            containerId = "#dict-line-" + dictId,
            target = "/admin/editMessageStatus"
            ;

        doRequest(target, 'POST', { dict_id: dictId, 'type': type, 'status': newStatus}, containerId, null, self);
    });

    $(document).on('click', '.js-dict-edit', function () {
        var self = $(this), //кнопка
            dictId = self.attr('data-id'),
            containerId = "#dict-line-" + dictId,
            target = "/admin/editMessageForm"
            ;

        doRequest(target, 'GET', { dict_id: dictId}, containerId, null, self);
    });

    $(document).on('submit', '.js-edit-form', function (event) {
        event.preventDefault();
        var self = $(this); //форма
        var containerId = "#dict-line-" + self.attr("data-id");
        var target = "/admin/editMessage";

        doRequest(target, 'POST', self.serialize(), containerId, null, self);
    });
});