<?php
/**
 * Created by PhpStorm.
 * User: tsybykov
 * Date: 18.02.19
 * Time: 21:04
 */
$params = $_POST['counterparty'] ?? null;
require_once ('script.php');
if($params){
$agent = new MoySklad();
$counterpartys = $agent->storeAgent($params);
?>

        <div class="alert alert-success" role="alert">
            <span>добавлен контр агент <b><?=$_POST['counterparty']?></b></span>
        </div>
     <div class="input-group mb-3">
         <select name="counterparty" class="custom-select" id="inputGroupSelect01">
                 <option value="<?=$counterpartys->id?>"><?=$counterpartys->name?></option>
         </select>
    </div>

<?php }?>



