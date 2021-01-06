<div id="content">
    <div class="row">
        % if isset($data['content']) && $data['count'] > 0%
        % loop $data['content'] as $t %
        <div class="col-lg-6 col-md-6">
            <div class="gallery-item">
                <a href="/files/images/%% $t['image'] %%" data-lightbox="roadtrip"><img src="/files/images/thumbnail/%% $t['image'] %%" alt=""></a>
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
        <div class="alert alert-warning">Здесь пока ничего нет!</div>
        % endif %
    </div>
</div>