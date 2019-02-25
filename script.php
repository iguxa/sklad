<?php
/**
 * Created by PhpStorm.
 * User: iguxa
 * Date: 27.01.19
 * Time: 13:22
 */


class MoySklad
{
    public $Withdrawal_Order;

    private $user;
    private $password;
    private $url_agent;
    private $local_id;
    private $organization_id;
    private $store_id;
    private $agent_id;
    private $product_id;
    private $description;
    private $paymentPurpose;
    private $sum;
    private $project_id;
    private $order_id;
    private $document_link;
    private $customer_template;

    public function __construct(array $params = null)
    {
        $config = include ('config.php');
        $this->url_agent = $config['url_agent'];

        $this->user = $config['user'];
        $this->password = $config['password'];
        $this->organization_id = $config['organization_id'];
        $this->store_id = $config['store_id'];
        $this->customer_template = $config['customer_template'];

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

    }
    public function curl(array $params,string $provider,$method = 'POST',$location = null)
    {
        $result = null;
        try{
        $jsonOrderPositions= json_encode($params);
        $ch = curl_init ( $this->url_agent.$provider);

        curl_setopt($ch, CURLOPT_HEADER, $location ?? 0);

        curl_setopt($ch, CURLOPT_USERPWD, "$this->user:$this->password");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonOrderPositions);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonOrderPositions)
            )
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($response, 0, $header_size);
        preg_match("!\r\n(?:Location|URI): *(.*?) *\r\n!", $headers, $matches);
        $this->document_link = $matches[1];
        $result = json_decode($response);
        if(isset($result->errors)){
            throw new Exception(curl_exec($ch));
        }
        if(isset($result) and is_array($result)){
            foreach ($result as $check){
                if(isset($check->errors)){
                    throw new Exception($check->errors);
                }
            }
        }
        }catch (Exception $e) {
            echo '',  $e->getMessage(), "\n";
            die();
        }
        return $result;
    }
    public function Withdrawal_Order() :void
    {
        $this->Withdrawal_Order = $this->edit_order();
    }
    private function create_project($project) :void
    {
        $project = ['name'=>$project];
        $this->project_id = $this->curl($project,'project')->id;
    }
    private function create_order() :?object
    {
        $order = null;
        $orderPositions = array (
            'name' => $this->local_id,
            'organization' =>
                array (
                    'meta' =>
                        array (
                            'href' => 'https://online.moysklad.ru/api/remap/1.1/entity/organization/'.$this->organization_id,
                            'metadataHref' => 'https://online.moysklad.ru/api/remap/1.1/entity/organization/metadata',
                            'type' => 'organization',
                            'mediaType' => 'application/json',
                        ),
                ),
            'agent' =>
                array (
                    'meta' =>
                        array (
                            'href' => 'https://online.moysklad.ru/api/remap/1.1/entity/counterparty/'.$this->agent_id,
                            'metadataHref' => 'https://online.moysklad.ru/api/remap/1.1/entity/counterparty/metadata',
                            'type' => 'counterparty',
                            'mediaType' => 'application/json',
                        ),
                ),
            'expenseItem' =>
                array (
                    'meta' =>
                        array (
                            'href' => 'https://online.moysklad.ru/api/remap/1.1/entity/expenseitem/'.$this->product_id,
                            'metadataHref' => 'https://online.moysklad.ru/api/remap/1.1/entity/expenseitem/metadata',
                            'type' => 'expenseitem',
                            'mediaType' => 'application/json',
                        ),
                ),
        );
        $order = $this->curl($orderPositions,'cashout');
        return $order;

    }
    private function edit_order() :?object
    {
        $adedd = array (

            'description' => $this->description,
            'sum' => $this->sum,
            'paymentPurpose' => $this->paymentPurpose,

        );
        if($this->project_id){
            $adedd['project'] =   array (
                'meta' =>
                    array (
                        'href' => 'https://online.moysklad.ru/api/remap/1.1/entity/project/'.$this->project_id,
                        'type' => 'project',
                        'mediaType' => 'application/json',
                    ),
            );
        }
        return $this->curl($adedd,'cashout/'.$this->order_id,'PUT');
    }

    public function getCounterparty($name)
    {
        $agents = $this->curl([],'entity/counterparty/?search='.urlencode($name),'GET');
       /* foreach ($agents->rows as $agent){
            var_dump($agent->name);
            var_dump($agent->id);
        }*/
        //$this->storeAgent($name);
        return $agents;
    }
    public function storeAgent($name)
    {
        $counterpartys = $this->getCounterparty($name);
        if($counterpartys->rows){
            foreach ($counterpartys->rows as $counterparty) {
                if($counterparty->name == $name){
                    return $counterparty;
                };
            }
        }

        $params =['name' => $name,];
        return $this->curl($params,'entity/counterparty/','POST');
    }
    public function FindOrCreateProduct($products)
    {
        $products_data = [];
        foreach ($products as $product){
            $products_updated = $this->curl([],'entity/product?search='.$product['code'],'GET');
            foreach ($products_updated->rows as $item){
                if($item->code == $product['code']){
                    $products_data[$item->code] = $item->id;;
                }
            }
        }
        return $products_data;
    }
    public function storeEnter($data)
    {
        $opr = array (
            'name' => (string) date('d-m-Y').'_'.time().'_'.rand(1,500),
            'organization' =>
                array (
                    'meta' =>
                        array (
                            'href' => 'https://online.moysklad.ru/api/remap/1.1/entity/organization/'.$this->organization_id,
                            'metadataHref' => 'https://online.moysklad.ru/api/remap/1.1/entity/organization/metadata',
                            'type' => 'organization',
                            'mediaType' => 'application/json',
                        ),
                ),
            'store' =>
                array (
                    'meta' =>
                        array (
                            'href' => 'https://online.moysklad.ru/api/remap/1.1/entity/store/'.$this->store_id,
                            'metadataHref' => 'https://online.moysklad.ru/api/remap/1.1/entity/store/metadata',
                            'type' => 'store',
                            'mediaType' => 'application/json',
                        ),
                ),
        );
        $opr['positions'] = $data;
        return $this->curl($opr,'entity/enter','POST');
    }
    public function CreateOrder($agent_id,$order_result)
    {
        $order = array (
            'name' => (string) date('d-m-Y').'_'.time().'_'.rand(1,500),
            'organization' =>
                array (
                    'meta' =>
                        array (
                            'href' => 'https://online.moysklad.ru/api/remap/1.1/entity/organization/'.$this->organization_id,
                            'type' => 'organization',
                            'mediaType' => 'application/json',
                        ),
                ),
            'agent' =>
                array (
                    'meta' =>
                        array (
                            'href' => 'https://online.moysklad.ru/api/remap/1.1/entity/counterparty/'.$agent_id,
                            'type' => 'counterparty',
                            'mediaType' => 'application/json',
                        ),
                ),
        );
        $order['positions'] = $order_result;
        $create_order = $this->curl($order,'entity/customerorder');
        return $create_order;
    }
    public function getDocument($order)
    {
        $document = array (
            'template' =>
                array (
                    'meta' =>
                        array (
                            'href' => 'https://online.moysklad.ru/api/remap/1.1/entity/customerorder/metadata/embeddedtemplate/'.$this->customer_template,
                            'type' => 'embeddedtemplate',
                            'mediaType' => 'application/json',
                        ),
                ),
            'extension' => 'xls',
        );
        $this->curl($document,'entity/customerorder/'.$order->id.'/export/','POST',1);
        $link = ['order'=>$order->name,'link'=>$this->document_link];
        return $link;
    }

}
