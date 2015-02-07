<?php

return array(
    ''          => 'index/index',
    '/'         => 'index/index',

    'api/add'                   => 'api/add',
    'api/list'                  => 'api/list',
    'api/<sApiID:\d+>/update'   => 'api/update',
    'api/<sApiID:\d+>/delete'   => 'api/delete',

    'character/list'            => 'character/list',


    // market orders
    'character/<sCharacterID:\d+>/market/order'                            => 'market/order/character',
    'character/<sCharacterID:\d+>/market/order/station/<sStationID:\d+>'   => 'market/order/station',
    // market demands
    'character/<sCharacterID:\d+>/market/demand'                            => 'market/demand/character',
    'character/<sCharacterID:\d+>/market/demand/station/<sStationID:\d+>'   => 'market/demand/station',

    'update/static/conquerable-station-list'    => 'cnqStation/update',
    'update/account/market-orders/'             => 'market/order/update',

    'ajax/find-station'     =>'ajax/findStation',
    'ajax/find-item'        =>'ajax/findItem'
);