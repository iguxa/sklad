<?php
/**
 * Created by PhpStorm.
 * User: iguxa
 * Date: 23.02.19
 * Time: 13:39
 */

require_once ('script.php');
require_once ('script_partners.php');
require_once ('config_app.php');

$data = $_POST['order'] ?? null;
if($data){
    $products = null;
    $result = null;
    foreach ($data['product'] as $product){
        unset($product['quantity']);
        unset($product['price']);
        unset($product['price_supplier']);
        $product['name'] =  $product['description'] ? $product['description'] : $product['code'];
        $products[] = $product;
    }
    /*if($products){
        $agent = new MoySklad();
        $products_id_sklad = $agent->FindOrCreateProduct($products);

        foreach ($data['product'] as $product){
            if(array_key_exists($product['code'],$products_id_sklad)){
                $management['quantity'] =  (integer) $product['quantity'];
                $management['price'] =  $product['price_supplier']*100;
                $management['assortment']['meta'] =
                        [
                            'href' => 'https://online.moysklad.ru/api/remap/1.1/entity/product/'.$products_id_sklad[$product['code']],
                            'metadataHref' => 'https://online.moysklad.ru/api/remap/1.1/entity/product/metadata',
                            'type' => 'product',
                            'mediaType' => 'application/json',
                        ];
               // $management['overhead'] = 0;
                $result[] = $management;
            }

        }
        if($result){
            $data = $agent->storeEnter($result);
        }

    }*/
    $partners = new Parnters;
    $auth = $partners->makeOrder($data['product']);
    var_dump($auth);

}


//var_dump($data);
