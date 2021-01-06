<div class="panel panel-default">
    <div class="panel-heading"><strong>Управление e-mail рассылками</strong></div>
    <div class="panel-body">
        % if isset($data['data']) && $data['count'] > 0 %
        <form id="list-email-form" method="post">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="">
                        <i class="glyphicon glyphicon-check"></i>
                    </th>
                    <th class="col-md-12">E-mail</th>
                </tr>
                </thead>
                % loop $data['data'] as $t %
                <tr id="email-%% $t['id'] %%" class="email-list %% $t['status'] == 0 ? 'warning' : 'success' %%">
                    <td><input type="checkbox" name="id[]" value="%% $t['id'] %%"/></td>
                    <td>
                        <div class="info">
                            <i class="glyphicon glyphicon-time" data-toggle="tooltip" data-placement="top" title="Дата подписки"></i><span>%% $t['time'] %%</span>
                        </div>
                        <p>%% $t['email'] %%</p>
                        <div class="email-action action-btn pull-right">
                            % if $t['status'] == 1 %
                            <div class="email-update-status-on" data-toggle="tooltip" data-placement="top" title="Сделать неактивном"><span class="md md-visibility"></span></div>
                            % else %
                            <div class="email-update-status-off" data-toggle="tooltip" data-placement="top" title="Сделать активном"><span class="md md-visibility-off"></span></div>
                            % endif %
                            <div class="email-delete" data-toggle="tooltip" data-placement="top" title="Удалить"><span class="md md-delete"></span></div>
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
                    <option value="enable" data-icon="glyphicon-eye-open">Сделать активном</option>
                    <option value="disable" data-icon="glyphicon-eye-close">Сделать неактивном</option>
                    <option value="delete" data-icon="glyphicon-trash">Удалить</option>
                </select>
                <span class="input-group-btn">
                    <button class="btn btn-default btn-email-checkbox" type="button">Применить</button>
                </span>
            </div>
        </form>
        % elseif isset($data['data']) && $data['count'] == 0 %
        <div class="alert alert-warning" role="alert">Нет ни одного подписчика</div>
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