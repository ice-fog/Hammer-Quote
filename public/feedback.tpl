<div class="box-blank-page">
    <div class="content-contact">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-contact">
                    <h3 class="title-form-contact">
                        <span>//</span> Обратная связь
                    </h3>
                    <form id="feedback-form" role="form">
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
                                <textarea class="form-control" rows="5" placeholder="Сообщение" name="message" id="message"></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="captcha" class="control-label"></label>
                                <div class="input-group">
                                    <div class="input-group-addon"><img src="/captcha"></div>
                                    <input class="form-control input-lg" placeholder="Защитный код" name="captcha" id="captcha">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <input type="hidden" name="action" value="send-feedback"/>
                                <input type="button" class="btn btn-lg btn-default btn-block btn-feedback-send" value="Отправить"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>