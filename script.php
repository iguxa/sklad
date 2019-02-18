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
    private $agent_id;
    private $product_id;
    private $description;
    private $paymentPurpose;
    private $sum;
    private $project_id;
    private $order_id;

    public function __construct(array $params = null)
    {
        $config = require_once ('config.php');
        $this->url_agent = $config['url_agent'];

        $this->user = $config['user'];
        $this->password = $config['password'];
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
    public function curl(array $params,string $provider,$method = 'POST') :?object
    {
        $result = null;
        try{$jsonOrderPositions= json_encode($params);
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

}
