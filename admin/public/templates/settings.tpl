<div class="panel panel-default">
    <div class="panel-heading"><strong>Настройки скрипта</strong></div>
    <div class="panel-body">
        % if isset($data['data']) %

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#main" aria-controls="main" role="tab" data-toggle="tab">Основные</a></li>
            <li role="presentation"><a href="#gallery" aria-controls="gallery" role="tab" data-toggle="tab">Галерея</a></li>
            <li role="presentation"><a href="#robots" aria-controls="robots" role="tab" data-toggle="tab">Файл robots.txt</a></li>
        </ul>

        <form id="settings-form" action="" method="post">

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="main">
                <table class="table">
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="site-title" class="control-label">Название сайта:</label>
                            <p class="help-block">Например: "Мой Сайт"</p>
                        </td>
                        <td class="col-md-6">
                            <input id="site-title" name="site-title" value="%% $data['data']['site-title'] %%" type="text" class="form-control"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="site-description" class="control-label">Описание (Description) сайта:</label>
                            <p class="help-block">Краткое описание, не более 200 символов</p>
                        </td>
                        <td class="col-md-6">
                            <textarea id="site-description" name="site-description" rows="3" class="form-control">%% $data['data']['site-description'] %%</textarea>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="email" class="control-label">E-Mail адрес администратора:</label>
                            <p class="help-block">На этот адрес будут отправляться уведомления например о новых комментариях и т.д.</p>
                        </td>
                        <td class="col-md-6">
                            <input id="email" name="email" value="%% $data['data']['email'] %%" type="email" class="form-control"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="records-page" class="control-label">Количество записей на странице</label>
                            <p class="help-block">Количество записей которое будет выводиться на странице</p>
                        </td>
                        <td class="col-md-6">
                            <input id="records-page" name="records-page" value="%% $data['data']['records-page'] %%" type="number" class="form-control"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="home-content">Информация выводимая на главной странице:</label>
                            <p class="help-block">Выберите тип контента который будет выводится на главной странице сайта.</p>
                        </td>
                        <td class="col-md-6" style="overflow: auto;">
                            <select id="home-content" name="home-content" class="form-control selectpicker show-tick">
                                <option %% $data['data']['home-content'] == 'home-page' ? 'selected ' : '' %% value="home-page" data-icon="glyphicon-home">Главная страница</option>
                                <option %% $data['data']['home-content'] == 'random' ? 'selected ' : '' %% value="random" data-icon="glyphicon-random">Случайные записи</option>
                                <option %% $data['data']['home-content'] == 'new' ? 'selected ' : '' %% value="new" data-icon="glyphicon-asterisk">Новые записи</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="notifications-enable">Отсылать E-mail уведомление</label>
                            <p class="help-block">Разрешить или запретить E-mail уведомления.</p>
                        </td>
                        <td class="col-md-6">
                            <input id="notifications-enable" type="checkbox" name="notifications-enable" value="1" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" %% $data['data']['notifications-enable'] ? 'checked' : '' %%>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="comments-enable">Разрешить комментировать записи</label>
                            <p class="help-block">Включение или отключение комментариев для всех записей</p>
                        </td>
                        <td class="col-md-6">
                            <input id="comments-enable" type="checkbox" name="comments-enable" value="1" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" %% $data['data']['comments-enable']  ? 'checked' : '' %%>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="rss-enable">Включить RSS экспорт записей</label>
                            <p class="help-block">Разрешить или запретить RSS экспорт ваших записей на сайте.</p>
                        </td>
                        <td class="col-md-6">
                            <input id="rss-enable" type="checkbox" name="rss-enable" value="1" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" %% $data['data']['rss-enable'] ? 'checked' : '' %%>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="sitemap-enable">Включить sitemap.xml</label>
                            <p class="help-block">Включение или отключение xml карты сайта.</p>
                        </td>
                        <td class="col-md-6">
                            <input id="sitemap-enable" type="checkbox" name="sitemap-enable" value="1" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" %% $data['data']['sitemap-enable'] ? 'checked' : '' %%>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="api-enable">Включить XML API</label>
                            <p class="help-block">Включение или отключение XML API.</p>
                        </td>
                        <td class="col-md-6">
                            <input id="api-enable" type="checkbox" name="api-enable" value="1" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" %% $data['data']['api-enable'] ? 'checked' : '' %%>
                        </td>
                    </tr>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="gallery">
                <table class="table">
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="gallery-title" class="gallery-title">Заголовок галереи:</label>
                            <p class="help-block">Например: "Мая галерея"</p>
                        </td>
                        <td class="col-md-6">
                            <input id="gallery-title" name="gallery-title" value="%% $data['data']['gallery-title'] %%" type="text" class="form-control"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="gallery-url" class="control-label">Адрес галереи:</label>
                            <p class="help-block">URL по которому будет доступна галерея.</p>
                        </td>
                        <td class="col-md-6">
                            <input id="gallery-url" name="gallery-url" value="%% $data['data']['gallery-url'] %%" type="text" class="form-control"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="gallery-description" class="control-label">Описание (Description) галереи:</label>
                            <p class="help-block">Краткое описание, не более 200 символов</p>
                        </td>
                        <td class="col-md-6">
                            <textarea id="gallery-description" name="gallery-description" rows="3" class="form-control">%% $data['data']['gallery-description'] %%</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-md-6">
                            <label for="gallery-enable">Включить галерею</label>
                            <p class="help-block">Включение или отключение галереи</p>
                        </td>
                        <td class="col-md-6">
                            <input id="gallery-enable" type="checkbox" name="gallery-enable" value="1" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" %% $data['data']['gallery-enable'] ? 'checked' : '' %%>
                        </td>
                    </tr>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="robots">
                <table class="table">
                    <tr class="form-group">
                        <td class="col-md-4">
                            <label for="robots-content" class="robots-content">Файл robots.txt</label>
                            <p class="help-block">Содержимое файла robots.txt</p>
                        </td>
                        <td class="col-md-8">
                            <textarea id="robots-content" name="robots-content" rows="10" class="form-control">%% $data['data']['robots-content'] %%</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-md-4">
                            <label for="robots-enable">Включить robots.txt</label>
                            <p class="help-block">Включение или отключение robots.txt</p>
                        </td>
                        <td class="col-md-8">
                            <input id="robots-enable" type="checkbox" name="robots-enable" value="1" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" %% $data['data']['robots-enable'] ? 'checked' : '' %%>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
            <div class="form-group">
                <input type="hidden" name="action" value="update"/>
                <input type="button" value="Сохранить" class="btn btn-success btn-settings-save"/>
            </div>
        </form>
        % else %
        <div class="alert alert-danger">Ошибка при получении данных</div>
        % endif %
    </div>
</div>