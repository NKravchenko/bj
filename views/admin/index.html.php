<div class="container">
    <div class="row">
        Сортировать по:
    </div>
    <div class="row">
        <a class="btn btn-default btn-xs" href="/admin?filter=all" role="button">Все</a>
        <a class="btn btn-default btn-xs" href="/admin?filter=agreed" role="button">Согласованные</a>
        <a class="btn btn-default btn-xs" href="/admin?filter=rejected" role="button">Отклоненные</a>
    </div>
</div>

<div class="table-responsive">  #1#
    <table id="msg-table" class="table table-striped">
        <colgroup>
            <col class="col-xs-1">
            <col class="col-xs-1">
            <col class="col-xs-6">
            <col class="col-xs-1">
        </colgroup>
        <tbody>

        <?php foreach ($data['messages'] as $data_val): ?>
            <tr id="dict-line-<?= $data_val['id'] ?>">
                <?php include "line.html.php" ?>
            </tr>
        <?php endforeach ?>

        </tbody>
    </table>
</div>

<?php //модальное окно для полного просмотра изображений ?>
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <img src="" class="imagepreview" style="width: 100%;">
            </div>
        </div>
    </div>
</div>