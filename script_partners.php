<?php
/**
 * Created by PhpStorm.
 * User: iguxa
 * Date: 27.01.19
 * Time: 13:22
 */


class Parnters
{
    public $Withdrawal_Order;

    private $user;
    private $password;
    private $url_agent;
    private $local_id;
    private $organization_id;
    private $store_id;
    private $partner_session;
    private $agent_id;
    private $product_id;
    private $description;
    private $paymentPurpose;
    private $sum;
    private $project_id;
    private $order_id;

    public function __construct(array $params = null)
    {
        $config = include ('config.php');
        $this->url_agent = $config['url_partners'];

        $this->user = $config['user_partner'];
        $this->password = $config['pass_partner'];
        $this->organization_id = $config['organization_id'];
        $this->store_id = $config['store_id'];

        /*$this->local_id = $params['local_id'];
        $this->organization_id = $params['organization_id'];
        $this->agent_id = $params['agent_id'];
        $this->product_id = $params['product_id'];
        $this->description = $params['description'];
        $this->paymentPurpose = $params['paymentPurpose'];
        $this->sum = $params['sum'];

        if($params['project'])
        {
            $this->create_project($params['project']);
        };
        $this->order_id = isset($params['order_id']) ? $params['order_id'] : $this->create_order()->id;
        //$this->order_id = 'bdb1fd2b-222f-11e9-9107-504800123884';
        $this->Withdrawal_Order();*/
        $this->getAuth();

    }
    public function curl(array $params,string $provider,$method = 'POST')
    {
        $result = null;
        try{ $jsonOrderPositions= json_encode($params);
        $ch = curl_init ( $this->url_agent.$provider);
        curl_setopt($ch, CURLOPT_USERPWD, "$this->user:$this->password");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonOrderPositions);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonOrderPositions)
            )
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch));
        if(isset($result->errors)){
            throw new Exception(curl_exec($ch));
        }
        }catch (Exception $e) {
            echo '',  $e->getMessage(), "\n";
            die();
        }
        return $result;
    }
    protected function getAuth():void
    {
        $dataAuth = array
        ("request" => array(
            "method" => "login",
            "module" => "system"
        ),
            "data" => array(
                "login" => $this->user,
                "passwd" => $this->password
            )
        );
        $auth = $this->curl($dataAuth,'api','POST');
        if(!($auth) && !($auth->success) && !($auth->success == 1)){
            die('Ошибка авторизации у Партернс');
         }
        $this->partner_session = $auth->data->session_id;
    }
    public function makeOrder($products)
    {
        $goods = null;
        $update_goods = null;
        $order_id = null;
        $done = null;
        $order = $this->CreateOrder();
        if($order->success){
            $order_id = $order->data->orders[0]->id;
            foreach ($products as $product){
                $item['doc_id'] = $order_id;
                $item['qty'] = $product['quantity'];
                $item['sku'] = $product['code'];
                $item['wish_price'] = 0;
                $item['wish_price_comment'] = 'api';
                $goods[] = $item;
            }
            $update_goods = $this->addGoods($goods);
            if($update_goods->success){
                $done = $update_goods;
            }
            if(!$done){
                die('Ошибка на стороне api partners');
            }
        }
        return $done;
    }
    protected function CreateOrder()
    {
       $data = array (
            'request' =>
                array (
                    'method' => 'create',
                    'model' => 'orders',
                    'module' => 'platform',
                ),
            'session_id' => $this->partner_session,
            'data' =>
                array (
                    0 =>
                        array (
                            'partner_comment' => ' api ',
                        ),
                ),
        );
        $order = $this->curl($data,'api','POST');
        return $order;
    }
    protected function addGoods($goods)
    {
       $update_order =  [

            'request' =>
                [
                    'method' => 'create',
                    'model' => 'order_items',
                    'module' => 'platform',
                ],
            'session_id' => $this->partner_session,
        ];
        $update_order['data'] = $goods;
        $update = $this->curl($update_order,'api');
        return $update;
    }


}
