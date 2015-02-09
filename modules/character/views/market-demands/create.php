<?php
use app\assets\Select2Asset;
use app\models\MarketDemand;
use yii\bootstrap\ActiveForm;

?>
<?php use yii\helpers\Html; ?>

<?php Select2Asset::register($this); ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="pull-right"><?= $mCharacter->characterName; ?></div>
        <h1 class="panel-title">Create new demand for character</h1>
    </div>

    <?php $oForm = ActiveForm::begin(); ?>

    <div class="panel-body">
        <?= $oForm->field($mMarketDemand, 'stationID'); ?>
        <?= $oForm->field($mMarketDemand, 'typeID'); ?>
        <?= $oForm->field($mMarketDemand, 'characterID')->hiddenInput(); ?>

        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-2">
                <?= $oForm->field($mMarketDemand, 'quantity')->textInput(['class' => 'form-control text-center', 'placeholder' => 'quantity']); ?>
            </div>

            <div class="col-sm-4">
                <?= $oForm->field($mMarketDemand, 'type')->dropDownList([MarketDemand::TYPE_SELL => MarketDemand::TYPE_SELL, MarketDemand::TYPE_BUY => MarketDemand::TYPE_BUY], ['class' => 'form-control text-center']); ?>
            </div>
        </div>
    </div>

    <div class="panel-footer text-center">
        <?= Html::submitButton('Add new Demand', ['class' => 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#marketdemand-stationid").select2({
            placeholder: "Station name",
            minimumInputLength: 3,
            multiple: false,
            quietMillis: 500,
            id: function (entry) {
                return entry.stationID;
            },
            ajax: {

                dataType: 'json',
                cache: false,
                data: function (term, page) {
                    return {sType: 'station', q: term, page_limit: 0, page: page};
                },
                results: function (data, page) {
                    var more = (page * 10) < data.length;
                    return {results: data, more: more};// more: more};
                }
            },
            formatResult: function (entry) {
                var sMarkUp = '';
                sMarkUp += '<img class="img-thumbnail margin-right-15" src="http://image.eveonline.com/Type/' + entry.stationTypeID + '_32.png" style="float:left">';
                sMarkUp += '<p style="padding-top: 12px;">' + entry.stationName + '</p>';
                sMarkUp += '<div class="clearfix"></div>';

                return sMarkUp;
            },
            formatSelection: function (entry) {
                return entry.stationName;
            }
        });

        $("#marketdemand-type").select2({
            minimumResultsForSearch: -1
        });
        $("#marketdemand-typeid").select2({
            placeholder: "Item name",
            minimumInputLength: 3,
            multiple: false,
            quietMillis: 750,
            id: function (entry) {
                return entry.typeID;
            },
            ajax: {
                dataType: 'json',
                cache: false,
                data: function (term, page) {
                    return {sType: 'item', q: term, sLimit: 0, sPageNumber: page};
                },
                results: function (data, page) {
                    var more = (page * 10) < data.total;
                    return {results: data, more: more};
                }
            },
            formatResult: function (entry) {
                var sMarkUp = '' +
                    '<img class="img-thumbnail margin-right-15" src="http://image.eveonline.com/Type/' + entry.typeID + '_32.png" style="float:left">' +
                    '<p style="padding-top: 12px;">' + entry.typeName + '</p>' +
                    '<div class="clearfix"></div>';

                return sMarkUp;
            },
            formatSelection: function (entry) {
                return entry.typeName;
            }
        });

    });
</script>