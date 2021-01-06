<div class="row">
    <div class="col-md-12">
        % if isset($data['data'])%
        <form id="page-form-edit" action="" method="post">
            <div class="form-group">
                <label for="status">Активная</label>
                <select id="status" name="status" class="form-control selectpicker show-tick">
                    % if $data['data']['status'] == 1%
                    <option selected value="1" data-icon="glyphicon-eye-open">Активная</option>
                    <option value="0" data-icon="glyphicon-eye-close">Неактивная</option>
                    % else %
                    <option selected value="0" data-icon="glyphicon-eye-close">Неактивная</option>
                    <option value="1" data-icon="glyphicon-eye-open">Активная</option>
                    % endif %
                </select>
            </div>
            <div class="form-group">
                <label for="title" class="control-label">Загаловак</label>
                <input id="title" name="title" value="%% $data['data']['title'] %%" type="text" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="url" class="control-label">Адрес</label>
                <input id="url" name="url" value="%% $data['data']['url'] %%" type="text" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="description" class="control-label">Описание</label>
                <textarea id="description" name="description" rows="2" class="form-control">%% $data['data']['description'] %%</textarea>
            </div>
            <div class="form-group">
                <label for="content" class="control-label">Содержание</label>
                <textarea id="content" name="content" rows="10" class="form-control">%% $data['data']['content'] %%</textarea>
                <input id="id" type="hidden" name="id" value="%% $data['data']['id'] %%"/>
                <input id="action" type="hidden" name="action" value="edit"/>
            </div>
        </form>
        % else %
        <div class="alert alert-danger">Ошибка при получении данных</div>
        % endif %
    </div>
</div>