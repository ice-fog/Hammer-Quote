% function showOption($data, $id, $parent, $level) %
    % loop $data as $t %
        <option value="%% $t['id'] %%" data-icon="glyphicon-folder-close"><span></span>%% str_repeat('-', $level).$t['name'] %%</option>
        % if isset($t['children']) %
            % php showOption($t['children'], $id, $parent, $level + 3) %
        % endif %
    % endloop %
% endfunction %


<div class="row">
    <div class="col-md-12">
        % if isset($data['category']) %
        <form id="content-form-add" action="" method="post">
            <div class="form-group">
                <label for="category">Категория</label>
                <select id="category" name="category" data-live-search="true" class="form-control selectpicker show-tick">
                    % php showOption($data['category'], $data['id'], $data['data']['parent'], 0) %
                </select>
            </div>
            <div class="form-group">
                <label for="status">Статус</label>
                <select id="status" name="status" class="form-control selectpicker show-tick">
                    <option value="1" data-icon="glyphicon-eye-open">Активная</option>
                    <option value="0" data-icon="glyphicon-eye-close">Неактивная</option>
                </select>
            </div>
            <div class="form-group">
                <label for="content" class="control-label">Содержание</label>
                <textarea id="content" name="content" rows="20" class="form-control"></textarea>
                <input type="hidden" name="action" value="add"/>
            </div>
        </form>
        % else %
        <div class="alert alert-danger" role="alert">Ошибка при получении данных</div>
        % endif %
    </div>
</div>
