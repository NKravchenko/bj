$(function () {

    //показать предварительный просмотр сообщения
    $('div').on('click', '#form-review', function () {
        var message = $(this).closest("#contactForm").find("#message").val();
        message = message.replace(/<[^>]+>/g, '');
        $("#msg-review").removeClass('hidden').find(".panel-body").text(message);
    });

    // Обработка AJAX из формы на листе сообщений
    $('#contactForm').on('submit', function (event) {
        event.preventDefault();
        var form = $("#contactForm");
        var containerId = "#msg-table > tbody:last";

        doRequest(form.attr('action'), 'POST', form.serialize(), '#form-submit', containerId);
    });

    $('#imageForm').on('submit', function (event) {
        event.preventDefault();
        var formData = new FormData();
        formData.append('file', $('#fileToUpload')[0].files[0]);
        $.ajax({
               url : '/messages/addImage',
               type : 'POST',
               data : formData,
               processData: false,  // tell jQuery not to process the data
               contentType: false,  // tell jQuery not to set contentType
               success : function(data) {
                   console.log(data);
//                   alert(data);
                   var container = $("#imgPreview");
                   container.empty().html(data);
               }
        });
    });
});
