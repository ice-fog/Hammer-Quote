<div class="panel panel-default">
    <div class="panel-heading"><strong>Управление галереей</strong></div>
    <div class="panel-body">
        <ul class="nav nav-tabs" style="margin-bottom: 10px;">
            <li><a href="/admin/content">Записи</a></li>
            <li><a href="/admin/comments">Комментарии</a></li>
            <li class="active"><a href="/admin/gallery">Галерея</a></li>
        </ul>
        % if isset($data['data']) && $data['count'] > 0 %
            <form id="gallery-form" method="post">
                <div class="row">
                % loop $data['data'] as $t %
                <div class="col-xs-6 col-md-3">
                    <div id="gallery-%% $t['id'] %%" class="gallery-item thumbnail %% $t['status'] == 0 ? 'bg-warning' : 'bg-success' %%">
                        <img src="/files/images/thumbnail/%% $t['image'] %%" alt="">
                        <div class="gallery-action action-btn pull-right">
                            % if $t['status'] == 1 %
                            <div class="gallery-update-status-on" data-toggle="tooltip" data-placement="top" title="Деактивировать"><span class="md md-visibility"></span></div>
                            % else %
                            <div class="gallery-update-status-off" data-toggle="tooltip" data-placement="top" title="Активировать"><span class="md md-visibility-off"></span></div>
                            % endif %
                            <div class="gallery-delete" data-toggle="tooltip" data-placement="top" title="Удалить"><span class="md md-delete"></span></div>
                        </div>
                        <input type="checkbox" name="id[]" value="%% $t['id'] %%"/>
                    </div>
                </div>
                % endloop %
                </div>
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
                    <button class="btn btn-default btn-gallery-checkbox" type="button">Применить</button>
                </span>
            </div>
        </form>
        % elseif isset($data['data']) && $data['count'] == 0 %
        <div class="alert alert-warning" role="alert">Изображения отсутствуют</div>
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