% function showComments($data) %
    % loop $data as $t %
        <li id="comments-%% $t['id'] %%" class="comment-item">
            <img src="/public/img/user.jpg">
            <div class="post-comments">
                <p class="meta"><b>%% $t['name'] %%</b> <i>%% $t['time'] %%</i> <i class="pull-right"><small class="btn btn-xs btn-default btn-reply-comment">Ответить</small></i></p>
                <p>%% $t['message'] %%</p>
            </div>
            % if isset($t['children']) %
                <ul class="comments hidden-xs list-unstyled">
                    % php showComments($t['children']) %
                </ul>
            % endif %
            <div id="form-container-%% $t['id'] %%"></div>
        </li>
    % endloop %
% endfunction %

<div id="content-%% $data['content']['id'] %%" class="content-item content-single">
    <p class="text">%% nl2br($data['content']['content']) %%</p>
    <div class="hr-single"></div>
    <span class="share">
        <span class="facebook" data-toggle="tooltip" data-placement="top" title="Поделиться ссылкой на Фейсбуке"></span>
        <span class="vkontakte" data-toggle="tooltip" data-placement="top" title="Поделиться ссылкой во Вконтакте"></span>
        <span class="odnoklassniki" data-toggle="tooltip" data-placement="top" title="Поделиться ссылкой в Одноклассниках"></span>
        <span class="plusone" data-toggle="tooltip" data-placement="top" title="Поделиться ссылкой в Гугл-плюсе"></span>
    </span>
    <span class="meta">
        <span class="post-date"><i class="fa fa-calendar" data-toggle="tooltip" data-placement="top" title="Дата публикации"></i>%% date('d.m.y', strtotime($data['content']['time'])) %%</span>
        <span class="category-name"><i class="fa fa-folder" data-toggle="tooltip" data-placement="top" title="Категория"></i>%% $data['content']['category'] == 0 ? 'Без категории' : $data['content']['cname'] %%</span>
        <span class="%% $_COOKIE[md5('rating-'.$data['content']['id'])] == 1 ? 'rating-disabled' : 'rating-btn' %% pull-right"><i class="fa fa-heart" data-toggle="tooltip" data-placement="top" title="Понравилось"></i> <span class="rating-count">%% $data['content']['rating'] %%</span></span>
    </span>
    <div class="hr-single"></div>
    <div id="comments-list">
        % if $data['comments-count'] > 0 %
        <div class="comment">
            <h3>Комментарии (%% $data['comments-count'] %%)</h3>
            <ul class="comments">
                % php showComments($data['comments']) %
            </ul>
        </div>
        % endif %
        <div class="form-comment">
            <h3>Добавить комментарий</h3>
            <form id="comment-form-add" role="form">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name" class="control-label"></label>
                        <input class="form-control input-lg" placeholder="Имя" name="name" id="name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email" class="control-label"></label>
                        <input class="form-control input-lg" placeholder="e-mail" name="email" id="email">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="message" class="control-label"></label>
                        <textarea class="form-control" rows="5" placeholder="Комментарий" name="message" id="message"></textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="captcha" class="control-label"></label>
                        <div class="input-group">
                            <div class="input-group-addon"><img src="/captcha" alt="защитный код"></div>
                            <input class="form-control input-lg" placeholder="Защитный код" name="captcha" id="captcha">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <input type="hidden" name="parent" value="0"/>
                        <input type="hidden" name="action" value="add-comment"/>
                        <input type="hidden" name="content" value="%% $data['content']['id'] %%"/>
                        <input type="button" class="btn btn-lg btn-default btn-block btn-comment-send" value="Отправить"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>