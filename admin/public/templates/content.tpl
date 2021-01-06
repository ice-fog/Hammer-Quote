<div class="panel panel-default">
    <div class="panel-heading"><strong>Управление записями</strong></div>
    <div class="panel-body">
        <ul class="nav nav-tabs" style="margin-bottom: 10px;">
            <li class="active"><a href="/admin/content">Записи</a></li>
            <li><a href="/admin/comments">Комментарии</a></li>
            <li><a href="/admin/gallery">Галерея</a></li>
        </ul>
        % if isset($data['data']) && $data['count'] > 0 %
        <div class="well well-sm">
            <form id="search-form" class="form-group" role="search" action="/admin/content/search/" method="get">
                <div class="input-group">
                    <label class="control-label"></label>
                    <input type="text" class="form-control" placeholder="Поиск записей" name="search" id="search">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
        % if $data['search-result'] %
        <div class="alert alert-success">Найдено %% $data['count'] %% записей по запросу "%% $data['search-string'] %%"</div>
        % elseif $data['search-string'] != null %
        <div class="alert alert-warning">По вашему запросу "%% $data['search-string'] %%" ничего не найдено</div>
        % endif %
        <form id="list-content-form" method="post">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="">
                        <i class="glyphicon glyphicon-check"></i>
                    </th>
                    <th class="col-md-12">Контент</th>
                </tr>
                </thead>
                % loop $data['data'] as $t %
                <tr id="content-%% $t['id'] %%" class="content-list %% $t['status'] == 0 ? 'warning' : 'success' %%">
                    <td><input type="checkbox" name="id[]" value="%% $t['id'] %%"/></td>
                    <td>
                        <div class="info">
                            <i class="glyphicon glyphicon-folder-close" data-toggle="tooltip" data-placement="top" title="Категория"></i><span>%% $t['category'] == 0 ? 'Без категории' : $t['cname'] %%</span>
                            <i class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="top" title="Просмотров"></i><span>%% $t['views'] %%</span>
                            <i class="glyphicon glyphicon-comment" data-toggle="tooltip" data-placement="top" title="комментарий"></i><span><a href="/admin/comments/content/%% $t['id'] %%">%% $t['comments'] %%</a></span>
                        </div>
                        <p>%% nl2br($t['content']) %%</p>
                        <div class="content-action action-btn pull-right">
                            <div class="content-edit" data-toggle="tooltip" data-placement="top" title="Редактировать"><span class="md md-edit"></span></div>
                            % if $t['status'] == 1 %
                            <div class="content-update-status-on" data-toggle="tooltip" data-placement="top" title="Сделать неактивной"><span class="md md-visibility"></span></div>
                            % else %
                            <div class="content-update-status-off" data-toggle="tooltip" data-placement="top" title="Сделать активной"><span class="md md-visibility-off"></span></div>
                            % endif %
                            <div class="content-delete" data-toggle="tooltip" data-placement="top" title="Удалить"><span class="md md-delete"></span></div>
                        </div>
                    </td>
                </tr>
                % endloop %
            </table>
            <div class="input-group">
                <span class="input-group-addon">
                    <input type="checkbox" id="selectAll">
                    <input type="hidden" name="action" value="checkbox-handler"/>
                </span>
                <select name="select-action" class="form-control selectpicker show-tick">
                    <option value="change-category" data-icon="glyphicon-folder-close">Переместить в другую категорию</option>
                    <option value="enable" data-icon="glyphicon-eye-open">Сделать видимыми</option>
                    <option value="disable" data-icon="glyphicon-eye-close">Сделать невидимыми</option>
                    <option value="delete" data-icon="glyphicon-trash">Удалить</option>
                </select>
                <span class="input-group-btn">
                    <button class="btn btn-default btn-content-checkbox" type="button">Применить</button>
                </span>
            </div>
        </form>
        % elseif isset($data['data']) && $data['count'] == 0 %
        <div class="alert alert-warning" role="alert">Записи отсутствуют</div>
        % else %
        <div class="alert alert-danger" role="alert">Ошибка при получении данных</div>
        % endif %
        % if $data['count'] > $data['limit'] %
        <nav>
            <ul class="pagination">
                % if $data['page'] > 1 %
                <li><a href="%% $data['url'] %%1">&larr;</a></li>
                % endif %
                % if $data['page'] > 1 %
                <li><a href="%% $data['url'].($data['page'] - 1) %%">‹</a></li>
                % endif %
                % if $data['page'] - 2 > 1 %
                <li><a href="%% $data['url'].($data['page'] - 2) %%">%% $data['page'] - 2 %%</a></li>
                % endif %
                % if $data['page'] - 1 > 1 %
                <li><a href="%% $data['url'].($data['page'] - 1) %%">%% $data['page'] - 1 %%</a></li>
                % endif %
                <li class="active"><a href="#">%% $data['page'] %%</a></li>
                % if $data['page'] + 1 < $data['page-count'] %
                <li><a href="%% $data['url'].($data['page'] + 1) %%">%% $data['page'] + 1 %%</a></li>
                % endif %
                % if $data['page'] + 2 < $data['page-count'] %
                <li><a href="%% $data['url'].($data['page'] + 2) %%">%% $data['page'] + 2 %%</a></li>
                % endif %
                % if $data['page'] < $data['page-count'] %
                <li><a href="%% $data['url'].($data['page'] + 1) %%">›</a></li>
                % endif %
                % if $data['page'] < $data['page-count'] %
                <li><a href="%% $data['url'].$data['page-count'] %%">&rarr;</a></li>
                % endif %
            </ul>
        </nav>
        % endif %
    </div>
</div>