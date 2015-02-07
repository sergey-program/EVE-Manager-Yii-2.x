$(document).ready(function () {
    $("#MarketDemand_stationID").select2({
        placeholder: "Station name",
        minimumInputLength: 3,
        multiple: false,
        quietMillis: 500,
        id: function (entry) {
            return entry.stationID;
        },
        ajax: {
            url: "/ajax/find-station",
            dataType: 'json',
            cache: false,
            data: function (term, page) {
                return {q: term, page_limit: 0, page: page};
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

    $("#MarketDemand_demandType").select2({
        minimumResultsForSearch: -1
    });
    $("#MarketDemand_typeID").select2({
        placeholder: "Item name",
        minimumInputLength: 3,
        multiple: false,
        quietMillis: 750,
        id: function (entry) {
            return entry.typeID;
        },
        ajax: {
            url: "/ajax/find-item",
            dataType: 'json',
            cache: false,
            type: 'POST',
            data: function (term, page) {
                return {queryString: term, sLimit: 0, sPageNumber: page};
            },
            results: function (data, page) {
                var more = (page * 10) < data.total;
                return {results: data, more: more};
            }
        },
        formatResult: function (entry) {
            var sMarkUp = '';
            sMarkUp += '<img class="img-thumbnail margin-right-15" src="http://image.eveonline.com/Type/' + entry.typeID + '_32.png" style="float:left">';
            sMarkUp += '<p style="padding-top: 12px;">' + entry.typeName + '</p>';
            sMarkUp += '<div class="clearfix"></div>';
            return sMarkUp;
        },
        formatSelection: function (entry) {
            return entry.typeName;
        }
    });

});