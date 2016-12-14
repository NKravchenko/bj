<td colspan="5">
    <form class="js-edit-form form-horizontal" data-id="<?= $data['id'] ?>">
        <div class="form-group">
            <div class="col-sm-10">
                <input type="hidden" class="form-control" name="id" id="id" value="<?= $data['id'] ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Имя</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" id="name" value="<?= $data['name'] ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Почта</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="email" id="email" value="<?= $data['email'] ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="message" class="col-sm-2 control-label">Сообщ</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="message" id="message" rows="3"><?= $data['message'] ?></textarea>
<!--                <textarea name="message">--><?//= $data['message'] ?><!--</textarea>-->
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-xs btn-info" value="save">
            </div>
        </div>
    </form>
</td>