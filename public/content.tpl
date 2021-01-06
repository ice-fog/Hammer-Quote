<div id="content">
    <div class="row">
        % if $data['search-result'] %
        <div class="alert alert-success">Найдено %% $data['count'] %% записей по запросу "%% $data['search-string'] %%"</div>
        % elseif $data['search-string'] != null %
        <div class="alert alert-warning">По вашему запросу "%% $data['search-string'] %%" ничего не найдено</div>
        % endif %
        % if $data['content'] %
        % loop $data['content'] as $t %
        <div class="col-lg-12 col-md-12">
            <div id="content-%% $t['id'] %%" class="content-item">
                <article>
                    <div class="content-content">
                        <p>%% $t['content'] %%</p>
                    </div>
                </article>
                <aside>
                    <div class="content-footer">
                    <span class="share">
                        <span class="facebook" data-toggle="tooltip" data-placement="top" title="Поделиться ссылкой на Фейсбуке"></span>
                        <span class="vkontakte" data-toggle="tooltip" data-placement="top" title="Поделиться ссылкой во Вконтакте"></span>
                        <span class="odnoklassniki" data-toggle="tooltip" data-placement="top" title="Поделиться ссылкой в Одноклассниках"></span>
                        <span class="plusone" data-toggle="tooltip" data-placement="top" title="Поделиться ссылкой в Гугл-плюсе"></span>
                    </span>
					<span class="pull-right">
					    <span class="category-name"><i class="fa fa-folder" data-toggle="tooltip" data-placement="top" title="Категория"></i> %% $t['category'] == 0 ? 'Без категории' : $t['cname'] %%</span>
					    <span class="comments-count"><i class="fa fa-comments" data-toggle="tooltip" data-placement="top" title="Комментариев"></i> %% $t['comments'] %%</span>
                        <span class="%% $_COOKIE[md5('rating-'.$t['id'])] == 1 ? 'rating-disabled' : 'rating-btn' %%"><i class="fa fa-heart" data-toggle="tooltip" data-placement="top" title="Понравилось"></i> <span class="rating-count">%% $t['rating'] %%</span></span>
                    </span>
                    </div>
                </aside>
            </div>
        </div>
        % endloop %
        % if $data['count'] > $data['limit'] %
        <div class="col-lg-12 col-md-12">
            <div class="text-center">
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
                    <li><a href="%% $data['url'].($data['page-count']) %%">&rarr;</a></li>
                    % endif %
                </ul>
            </div>
        </div>
        % endif %
        % else %
        <div class="alert alert-warning">Контент отсутствует</div>
        % endif %
    </div>
</div>