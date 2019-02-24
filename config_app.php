<?php
/**
 * Created by PhpStorm.
 * User: iguxa
 * Date: 27.01.19
 * Time: 13:23
 */
//header("Content-Type: text/html; charset=windows-1251");
require_once ('api-itpartners/config.php');
$debug = true;
$api_url = 'https://anna.trade-in-shop.ru/api-transit/api-itpartners/';
$method = ['connect'=>'api-connect.php',
    'code'=>'display.php?codebase=',
    'check'=>'check.php?code=',
];
$coefficient = [
    'always' => 100,
    'percent' => 1.2
];
$moy_sklad_config = ['organization_id'=>'054f6932-338c-11e9-9107-50480011ba9e'];
