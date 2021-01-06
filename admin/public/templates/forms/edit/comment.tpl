<div class="row">
    <div class="col-md-12">
        % if isset($data['data']) %
        <form id="comment-form-edit" action="" method="post">
            <div class="form-group">
                <label for="name" class="control-label">Имя</label>
                <input id="name" name="name" value="%% $data['data']['name'] %%" type="text" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="email" class="control-label">E-Mail</label>
                <input id="email" name="email" value="%% $data['data']['email'] %%" type="text" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="message" class="control-label">Комментарий</label>
                <textarea id="message" name="message" rows="5" class="form-control">%% $data['data']['message'] %%</textarea>
                <input type="hidden" name="action" value="edit"/>
                <input type="hidden" name="status" value="%% $data['data']['status'] %%"/>
                <input type="hidden" name="id" value="%% $data['data']['id'] %%"/>
            </div>
        </form>
        % else %
        <div class="alert alert-danger">Ошибка при получении данных</div>
        % endif %
    </div>
</div>