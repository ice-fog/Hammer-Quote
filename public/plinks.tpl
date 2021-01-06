% if count($data) > 0 %
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
        <ul class="dropdown-menu">
        % loop $data as $t %
            <li><a href="%% $t['url'] %%">%% $t['title'] %%</a></li>
        % endloop %
        </ul>
    </li>
% endif %