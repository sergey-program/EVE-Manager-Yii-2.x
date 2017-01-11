<?php

use app\models\Corporation;

/**
 * @var app\components\ViewExtended $this
 * @var string                      $signInUrl
 * @var Corporation                 $corporation
 */
?>

<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title">Corporation "<?= $corporation->corporationName; ?>" was installed.</h1>
        </div>

        <div class="panel-body text-center">
            now do your stuff
        </div>
    </div>
</div>
