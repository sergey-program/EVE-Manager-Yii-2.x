<?php $this->sTitle = 'Error'; ?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title"><?php echo $aError['message']; ?></h1>
                </div>
                <div class="panel-body">
                    <pre><?php echo var_dump($aError); ?></pre>
                </div>
            </div>
            <!-- panel -->
        </div>
        <!-- col -->
    </div>
    <!-- row -->
</div>
<!-- container -->