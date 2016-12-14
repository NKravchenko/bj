<?php if (!isset($data_val)) {
    $data_val = $data;
}?>
<td>
    <?php print_r($data_val,1) ?>
    <?= $data_val['id'] ?>
</td>
<th scope="row">
    <span class="m-block bold">
        <?= $data_val['name'] ?>
    </span>
    <span class="m-block">
        <?= $data_val['email'] ?>
    </span>
    <?php $date = new DateTime($data_val['date_add'], new DateTimeZone('Europe/Kiev')) ?>
    <span class="m-block small">
        <?= $date->format('d.m.Y'); ?>
    </span>
    <span class="m-block small">
        <?= $date->format(" в " . 'H:i:s'); ?>
    </span>
</th>
<td>
    <?= $data_val['message'] ?>
    <?php if ($data_val['message_changed']): ?>
        <span class="m-changed small">Изменен</span>
    <?php endif ?>
</td>
<td>
    <?php if (!$data_val['message_agreed']): ?>
        <button type="button" class="btn btn-xs btn-danger js-dict-status"
                id="btn-status-<?= $data_val['id'] ?>"
                data-id="<?= $data_val['id'] ?>"
                data-toggle="tooltip" data-placement="top"
                data-new-status="1"
                data-type="txt"
                title="Утвердить">
            Approve
        </button>
    <?php else: ?>
        <button type="button" class="btn btn-xs btn-success js-dict-status"
                id="btn-status-<?= $data_val['id'] ?>"
                data-id="<?= $data_val['id'] ?>"
                data-toggle="tooltip" data-placement="top"
                data-new-status="0"
                data-type="txt"
                title="Отклонить">
            Decline
        </button>
    <?php endif ?>

    <button type="button" class="btn btn-xs btn-primary js-dict-edit"
            id="btn-edit"
            data-id="<?= $data_val['id'] ?>"
            data-container="body"
            data-toggle="tooltip" data-placement="top"
            title="Редактирование">
        Edit
    </button>
</td>
<td>
    <?php //если изображение загружена, показать
    if ($data_val['img']): ?>
        <?php if (!$data_val['img_agreed']): ?>
            <button type="button" class="btn btn-xs btn-danger js-dict-status"
                    id="btn-status-<?= $data_val['id'] ?>"
                    data-id="<?= $data_val['id'] ?>"
                    data-toggle="tooltip" data-placement="top"
                    data-new-status="1"
                    data-type="img"
                    title="Утвердить картинку">
                Approve img
            </button>
        <?php else: ?>
            <button type="button" class="btn btn-xs btn-success js-dict-status"
                    id="btn-status-<?= $data_val['id'] ?>"
                    data-id="<?= $data_val['id'] ?>"
                    data-toggle="tooltip" data-placement="top"
                    data-new-status="0"
                    data-type="img"
                    title="Отклонить картинку">
                Decline img
            </button>
        <?php endif ?>

        <div class="img">
            <a href="#" class="pop">
                <img class="img-responsive img-table img-thumbnail" src="<?=
                IMAGES_PATH . DS . $data_val['img'];
                ?> ">
            </a>
        </div>
    <?php else: ?>
        <div class="img">
            <p class="text-center">Нет изображения</p>
        </div>
    <?php endif ?>
</td>
