% function showComments($data) %
    % loop $data as $t %
        <tr id="comment-%% $t['id'] %%" class="comments-list %% ($t['status'] == 0) ? 'warning' : 'success' %%">
            <td><input type="checkbox" name="id[]" value="%% $t['id'] %%"/></td>
            <td>
                <div class="info">
                    <i class="text-bold" data-toggle="tooltip" data-placement="top" title="Номер">#</i><span>%% $t['id'] %%</span>
                    <i class="glyphicon glyphicon glyphicon-user" data-toggle="tooltip" data-placement="top" title="Автор"></i><span>%% $t['name'] %%</span>
                    <i class="glyphicon glyphicon glyphicon-globe" data-toggle="tooltip" data-placement="top" title="IP-адрес"></i><span>%% $t['ip'] %%</span>
                    <i class="glyphicon  glyphicon glyphicon-envelope" data-toggle="tooltip" data-placement="top" title="E-Mail"></i><span>%% $t['email'] %%</span>
                    % if $t['parent'] != 0 %
                    <i class="glyphicon  glyphicon glyphicon-share-alt" data-toggle="tooltip" data-placement="top" title="Ответ на комментарий #"></i><span>%% $t['parent'] %%</span>
                    % endif %
                    <i class="glyphicon  glyphicon glyphicon-list-alt" data-toggle="tooltip" data-placement="top" title="Перейти к записи"></i><span><a href="/admin/content/one/%% $t['content'] %%">%% $t['content'] %%</a></span>
                </div>
                <p>%% nl2br($t['message']) %%</p>
                <div class="time">
                    <span class="md md-schedule"></span> %% $t['time'] %%
                </div>
                <div class="comment-action action-btn pull-right">
                    <div class="comment-edit" data-toggle="tooltip" data-placement="top" title="Редактировать"><span class="md md-edit"></span></div>
                    % if $t['status'] == 1 %
                    <div class="comment-update-status-on" data-toggle="tooltip" data-placement="top" title="Сделать неактивным"><span class="md md-visibility"></span></div>
                    % else %
                    <div class="comment-update-status-off" data-toggle="tooltip" data-placement="top" title="Сделать активным"><span class="md md-visibility-off"></span></div>
                    % endif %
                    <div class="comment-delete" data-toggle="tooltip" data-placement="top" title="Удалить"><span class="md md-delete"></span></div>
                </div>
            </td>
        </tr>
        % if isset($t['children']) %
            % php showComments($t['children']) %
        % endif %
    % endloop %
% endfunction %

<div class="panel panel-default">
    <div class="panel-heading"><strong>Управление комментариями</strong></div>
    <div class="panel-body">
        <ul class="nav nav-tabs" style="margin-bottom: 10px;">
            <li><a href="/admin/content">Записи</a></li>
            <li class="active"><a href="/admin/comments">Комментарии</a></li>
            <li><a href="/admin/gallery">Галерея</a></li>
        </ul>
        % if isset($data['data']) && $data['count'] > 0 %
        <div class="well well-sm">
            <form id="search-form" class="form-group" role="search" action="/admin/comments/search/"
                  method="get">
                <div class="input-group">
                    <label class="control-label"></label>
                    <input type="text" class="form-control" placeholder="Поиск записей" name="search" id="search">

                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        % if $data['search-result'] %
        <div class="alert alert-success">Найден %% $data['count'] %% комментарий по запросу "%% $data['search-string'] %%"</div>
        % elseif $data['search-string'] != null %
        <div class="alert alert-warning">По вашему запросу "%% $data['search-string'] %%" ничего не найдено</div>
        % endif %
        <form id="list-comments-form" method="post">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>
                        <i class="glyphicon glyphicon-check"></i>
                    </th>
                    <th class="col-md-12">Комментарий</th>
                </tr>
                </thead>
                    % php showComments($data['data']) %
                </table>
            <div class="input-group">
                <span class="input-group-addon">
                    <input type="checkbox" id="selectAll">
                    <input type="hidden" name="action" value="checkbox-handler"/>
                </span>
                <select name="select-action" class="form-control selectpicker show-tick">
                    <option value="enable" data-icon="glyphicon-eye-open">Сделать видимыми</option>
                    <option value="disable" data-icon="glyphicon-eye-close">Сделать невидимыми</option>
                    <option value="delete" data-icon="glyphicon-trash">Удалить</option>
                </select>
                <span class="input-group-btn">
                    <button class="btn btn-default btn-comments-checkbox" type="button">Применить</button>
                </span>
            </div>
        </form>
        % elseif isset($data['data']) && $data['count'] == 0 %
        <div class="alert alert-warning" role="alert">Комментарии отсутствуют</div>
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