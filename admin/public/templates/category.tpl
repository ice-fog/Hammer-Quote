<div class="panel panel-default">
    <div class="panel-heading"><strong>Управление категориями</strong></div>
    <div class="panel-body">
        % if $data['data'] %
        <div class="well well-sm">
                <div class="input-group">
                    <label class="control-label"></label>
                    <input type="text" value="" id="category-search" placeholder="Поиск" class="form-control"/>
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
        </div>
        <div class="btn-group btn-group-justified">
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-category-descendant" data-toggle="tooltip" data-placement="top" title="Создать потомка" disabled><i class="glyphicon glyphicon glyphicon-plus"></i></button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-category-enable" data-toggle="tooltip" data-placement="top" title="Активировать" disabled><i class="glyphicon glyphicon-eye-open"></i></button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-category-disable" data-toggle="tooltip" data-placement="top" title="Деактивировать" disabled><i class="glyphicon glyphicon-eye-close"></i></button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-category-edit" data-toggle="tooltip" data-placement="top" title="Редактировать"  disabled><i class="glyphicon glyphicon-pencil"></i></button>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-category-delete" data-toggle="tooltip" data-placement="top" title="Удалить" disabled><i class="glyphicon glyphicon-trash"></i></button>
            </div>
        </div>
        <div id="category-list"></div>
        % else %
        <div class="alert alert-warning">Категории отсутствуют</div>
        % endif %
    </div>
</div>