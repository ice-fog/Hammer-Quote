% function showCategoryList($data, $active) %
    % loop $data as $t %
    <li class="%% $t['id'] == $active ? 'selected' : '' %%">
        <a href="/admin/content/category/%% $t['id'] %%" data-toggle="tooltip" data-placement="top" title="%% $t['name'] %%">%% $t['name'] %% <span class="count">%% $t['count']%%</span></a>
        % if isset($t['children']) %
        <ul>
            % php showCategoryList($t['children'], $active) %
        </ul>
        % endif %
    </li>
    % endloop %
% endfunction %

% function showOption($data) %
    % loop $data as $t %
        <a class="list-group-item %% $t['class'] %%" href="%% $t['url'] %%">%% $t['name'] %%</a>
    % endloop %
% endfunction %

<div class="panel panel-default">
    <div class="panel-heading">
        <strong>%% $data['title'] %%</strong>
    </div>
    <div class="panel-body">
        % if $data['data'] %
            % php showOption($data['data']) %
            <div class="clear"></div>
        % endif %
        % if $data['category']  %
        <div class="list-group">
            <a href="/admin/content" class="list-group-item%% ($data['active'] == 0) ? ' active' : '' %%">Все записи<span class="badge badge-small">%% $data['count'] %%</span></a>
            <a href="/admin/content/category/without" class="list-group-item%% ($data['active'] == -1) ? ' active' : '' %%">Без категории<span class="badge badge-small">%% $data['without-count'] %%</span></a>
        </div>
        <div class="category-widget-sidebar">
            % if $data['category'] %
            <ul>
                % php showCategoryList($data['category'], $data['active'])%
            </ul>
            % else %
            <div class="alert alert-warning">Категории отсутствуют</div>
            % endif %
        </div>
        % endif %
        % if $data['design-edit'] %
        <div id="editor-file-list"></div>
        % endif %
    </div>
</div>