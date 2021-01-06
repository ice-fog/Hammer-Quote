% function showCategoryList($data, $active) %
    % loop $data as $t %
        <li class="%% $t['id'] == $active ? 'selected' : '' %%">
            <a href="/category/%% $t['url'] %%" data-toggle="tooltip" data-placement="top" title="%% $t['name'] %%">%% $t['name'] %% <span class="count">%% $t['count']%%</span></a>
            % if isset($t['children']) %
            <ul>
                % php showCategoryList($t['children'], $active) %
            </ul>
            % endif %
        </li>
    % endloop %
% endfunction %

<div id="sidebar">
    <div class="widget-sidebar">
        <h3 class="title-widget-sidebar">Категории</h3>
        <div class="category-widget-sidebar">
            % if $data['category'] %
            <ul>
            % php showCategoryList($data['category'], $data['active'])%
            </ul>
            % else %
            <div class="alert alert-warning">Категории отсутствуют</div>
            % endif %
        </div>
    </div>
    <div class="widget-sidebar">
        <h3 class="title-widget-sidebar">Подписаться на обновления</h3>
        <div class="content-widget-sidebar">
            <p class="content-footer">Сообщения будут приходить не чаще одного-двух раз в месяц. В каждом из них будет ссылка на отключение рассылки.</p>
            <form id="subscribe-form" role="form">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="text" class="form-control" placeholder="email" name="semail" id="semail">
                    </div>
                </div>
                <div class="form-group">
                    <input type="button" class="btn btn-warning btn-subscribe" value="Подписаться"/>
                </div>
            </form>
        </div>
    </div>
</div>