% function showOption($data, $level) %
    % loop $data as $t %
        % if $t['id'] == $current %
            <option selected value="%% $t['id'] %%" data-icon="glyphicon-folder-close">%% str_repeat('-', $level).$t['name'] %%</option>
        % else %
            <option value="%% $t['id'] %%" data-icon="glyphicon-folder-close">%% str_repeat('-', $level).$t['name'] %%</option>
        % endif %
        % if isset($t['children']) %
            % php showOption($t['children'],$level + 3) %
        % endif %
    % endloop %
% endfunction %

<div class="row">
    <div class="col-md-12">
        % if isset($data['category']) %
        <form id="change-category-form" action="" method="post" class="">
            <div class="form-group">
                <label for="category">Новая категория</label>
                <select id="category" name="category" data-live-search="true" class="form-control selectpicker show-tick">
                    % php showOption($data['category'], $data['current-category'], 0) %
                </select>
            </div>
        </form>
        % else %
        <div class="alert alert-danger">Ошибка при получении данных</div>
        % endif %
    </div>
</div>