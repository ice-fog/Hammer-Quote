% function showOption($data, $id, $level) %
    % loop $data as $t %
        % if $t['id'] == $id %
            <option selected value="%% $t['id'] %%" data-icon="glyphicon-folder-close">%% str_repeat('-', $level).$t['name'] %%</option>
        % else %
            <option value="%% $t['id'] %%" data-icon="glyphicon-folder-close">%% str_repeat('-', $level).$t['name'] %%</option>
        % endif %
        % if isset($t['children']) %
            % php showOption($t['children'], $id, $level + 3) %
        % endif %
    % endloop %
% endfunction %

<div class="row">
    <div class="col-md-12">
        % if isset($data['data'], $data['category']) %
        <form id="content-form-edit" action="" method="post">
            <div class="form-group">
                <label for="category">Категория</label>
                <select id="category" name="category" data-live-search="true" class="form-control selectpicker show-tick">
                    % php showOption($data['category'], $data['data']['category'], 0) %
                </select>
            </div>
            <div class="form-group">
                <label for="status">Активная</label>
                <select id="status" name="status" class="form-control selectpicker show-tick">
                    % if $data['data']['status'] == 1%
                    <option selected value="1" data-icon="glyphicon-eye-open">Активная</option>
                    <option value="0" data-icon="glyphicon-eye-close">Неактивная</option>
                    % else %
                    <option value="1" data-icon="glyphicon-eye-open">Активная</option>
                    <option selected value="0" data-icon="glyphicon-eye-close">Неактивная</option>
                    % endif %
                </select>
            </div>
            <div class="form-group">
                <label for="content" class="control-label">Содержание</label>
                <textarea id="content" name="content" rows="20" class="form-control">%% $data['data']['content'] %%</textarea>
                <input type="hidden" name="action" value="edit"/>
                <input type="hidden" name="id" value="%% $data['data']['id'] %%"/>
            </div>
        </form>
        % else %
        <div class="alert alert-danger">Ошибка при получении данных</div>
        % endif %
    </div>
</div>
