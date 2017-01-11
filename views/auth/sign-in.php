<?php

use app\components\EveSSO;

/**
 * @var $this      app\components\ViewExtended
 * @var $signInUrl string
 */
?>

<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">Authentication</h1>
            </div>

            <div class="panel-body">
                <a href="<?= EveSSO::createUrl(EveSSO::ACTION_SI); ?>">
                    <img src="https://images.contentful.com/idjq7aai9ylm/4fSjj56uD6CYwYyus4KmES/4f6385c91e6de56274d99496e6adebab/EVE_SSO_Login_Buttons_Large_Black.png?w=270&h=45">
                </a>
            </div>
        </div>
    </div>
</div>
