<?php

use app\components\EveSSO;

/**
 * @var app\components\ViewExtended $this
 * @var string                      $signInUrl
 */
?>

<div class="col-md-8 col-md-offset-2">
    <p class="alert alert-info text-center">Ask your CEO to sign-in here. Character should have CEO or Directors roles.</p>
</div>

<div class="col-md-6 col-md-offset-3">
    <div class="box box-primary">
        <div class="box-body text-center">
            <a href="<?= EveSSO::createUrl(EveSSO::ACTION_IC); ?>">
                <img src="https://images.contentful.com/idjq7aai9ylm/4fSjj56uD6CYwYyus4KmES/4f6385c91e6de56274d99496e6adebab/EVE_SSO_Login_Buttons_Large_Black.png?w=270&h=45">
            </a>
        </div>
    </div>
</div>
