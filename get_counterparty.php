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
$counterpartys = $agent->getCounterparty('По12');?>
    <div class="input-group mb-3">
        <select class="custom-select" id="inputGroupSelect01">
            <?php if($counterpartys->row):?>
                <?php foreach ($counterpartys->row as $counterparty):?>
                    <option value="<?=$counterparty->id?>"><?=$counterparty->name?></option>
                <?php endforeach;?>
            <?php else:?>
                <option value="<?=$params?>"><?=$params?></option>
            <?php endif;?>
        </select>
    </div>

<?php }?>


