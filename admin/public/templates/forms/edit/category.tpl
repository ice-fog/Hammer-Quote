% function showOption($data, $id, $parent, $level) %
    % loop $data as $t %
        % if $t['id'] == $parent && $parent !== $id %
            <option selected value="%% $t['id'] %%" data-icon="glyphicon-folder-close">%% str_repeat('-', $level).$t['name'] %%</option>
        % elseif $t['id'] !== $id %
            <option value="%% $t['id'] %%" data-icon="glyphicon-folder-close">%% str_repeat('-', $level).$t['name'] %%</option>
        % endif %
        % if isset($t['children']) %
            % php showOption($t['children'], $id, $parent, $level + 3) %
        % endif %
    % endloop %
% endfunction %

<div class="row">
    <div class="col-md-12">
        % if isset($data['data']) && isset($data['category']) %
        <form id="category-form-edit" action="" method="post">
            <div class="form-group">
                <label for="parent">Родительская категория</label>
                <select id="parent" name="parent" data-live-search="true" class="form-control selectpicker show-tick">
                    <option value="0" data-icon="glyphicon-folder-close">Корневая категория</option>
                    % php showOption($data['category'], $data['data']['id'], $data['data']['parent'], 0) %
                </select>
            </div>
            <div class="form-group">
                <label for="name" class="control-label">Название</label>
                <input id="name" name="name" value="%% $data['data']['name'] %%" type="text" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="url" class="control-label">Адрес</label>
                <input id="url" name="url" value="%% $data['data']['url'] %%" type="text" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="description" class="control-label">Описание</label>
                <textarea id="description" name="description" rows="10" class="form-control">%% $data['data']['description'] %%</textarea>
                <input id="id" type="hidden" name="id" value="%% $data['data']['id'] %%"/>
                <input id="status" type="hidden" name="status" value="%% $data['data']['status'] %%"/>
                <input id="old-parent" type="hidden" name="old-parent" value="%% $data['data']['parent'] %%"/>
                <input id="action" type="hidden" name="action" value="edit"/>
            </div>
        </form>
        % else %
        <div class="alert alert-danger" role="alert">Ошибка при получении данных</div>
        % endif %
    </div>
</div>
