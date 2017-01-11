<?php

use app\components\EveSSO;

/**
 * @var app\components\ViewExtended $this
 * @var string                      $signInUrl
 */
?>

<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title">This link for director or ceo.</h1>
        </div>

        <div class="panel-body text-center">
            <a href="<?= EveSSO::createUrl(EveSSO::ACTION_IC); ?>">
                <img src="https://images.contentful.com/idjq7aai9ylm/4fSjj56uD6CYwYyus4KmES/4f6385c91e6de56274d99496e6adebab/EVE_SSO_Login_Buttons_Large_Black.png?w=270&h=45">
            </a>
        </div>
    </div>
</div>
