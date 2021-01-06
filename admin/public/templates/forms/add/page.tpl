<div class="row">
    <div class="col-md-12">
        <form id="page-form-add" action="" method="post">
            <div class="form-group">
                <label for="status">Статус</label>
                <select id="status" name="status" class="form-control selectpicker show-tick">
                    <option value="1" data-icon="glyphicon-eye-open">Активная</option>
                    <option value="0" data-icon="glyphicon-eye-close">Неактивная</option>
                </select>
            </div>
            <div class="form-group">
                <label for="title" class="control-label">Загаловак (Title)</label>
                <input id="title" name="title" value="" type="text" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="url" class="control-label">Адрес (URL)</label>
                <input id="url" name="url" value="" type="text" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="description" class="control-label">Описание (Description)</label>
                <textarea id="description" name="description" rows="2"  class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="content" class="control-label">Содержание</label>
                <textarea id="content" name="content" rows="10" class="form-control"></textarea>
                <input type="hidden" name="action" value="add"/>
            </div>
        </form>
    </div>
</div>
