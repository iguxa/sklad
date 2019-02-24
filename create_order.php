<?php
/**
 * Created by PhpStorm.
 * User: iguxa
 * Date: 23.02.19
 * Time: 13:39
 */

include ('script.php');
include ('script_partners.php');
include ('config_app.php');

$site = "https://cos.trade-in-shop.ru";
$resivecx = iconv("windows-1251", "utf-8", file_get_contents($site.'/api-b2b/revise.php?count=1'));

$data = $_POST['order'] ?? null;

if($data):
    $products = null;
    $result = null;
    $order_result = null;
    $print_document = null;
    foreach ($data['product'] as $product){
        unset($product['quantity']);
        unset($product['price']);
        unset($product['price_supplier']);
        $product['name'] =  $product['description'] ? $product['description'] : $product['code'];
        $products[] = $product;
    }
    if($products){
        $agent = new MoySklad();

        //Получаем товары(создаем ,если нет) в моем складе
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
                $result[] = $management;
                $management['price'] = $product['price']*100/$product['quantity'];
                $order_result[] = $management;
            }

        }
        //Делаем Оприходование
        if($result){
            $create_enter = $agent->storeEnter($result);
        }
    }
      //Создаем заказ у партнеров
    $partners = new Parnters;
    $partners_order = $partners->makeOrder($data['product']);
    //Создаем заказ в моем скаде для покупаетля(контрагент)

    if($order_result){
            $create_order = $agent->CreateOrder($data['counterparty'],$order_result);
            if($create_order->id){
                $print_document = $agent->getDocument($create_order);
            }
};?>
    <?= $resivecx;?>
    <a class="btn btn-success" href="<?=$print_document['link'] ?>" role="button">Заказ <?=$print_document['order'] ?></a>
<?php endif;
?>

