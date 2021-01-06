% function showOption($data, $level) %
    % loop $data as $t %
        <option value="%% $t['id'] %%" data-icon="glyphicon-folder-close">%% str_repeat('-', $level).$t['name'] %%</option>
        % if isset($t['children']) %
            % php showOption($t['children'], $level + 3) %
        % endif %
    % endloop %
% endfunction %

<div class="box-blank-page">
    <div class="content-contact">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-contact">
                    <h3 class="title-form-contact">
                        <span>//</span> Прислать свой материал
                    </h3>
                    <form id="content-add-form" role="form">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <select id="category" name="category" data-live-search="true" class="form-control selectpicker show-tick">
                                    % php showOption($data['category'], 0) %
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="content" class="control-label"></label>
                                <textarea class="form-control" rows="5" placeholder="Ваш материал" name="content" id="content"></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="captcha" class="control-label"></label>
                                <div class="input-group">
                                    <div class="input-group-addon"><img src="/captcha" alt=""></div>
                                    <input class="form-control input-lg" placeholder="Защитный код" name="captcha" id="captcha">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <input type="hidden" name="action" value="add-content"/>
                                <input type="button" class="btn btn-lg btn-default btn-block btn-content-add" value="Отправить"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>