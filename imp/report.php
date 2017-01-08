<?php
/**
 * Start the Elgg engine
 */
die;
$time = time();
$default = ini_get('max_execution_time');
set_time_limit(100000000);

require_once(dirname(dirname(__FILE__)) . "/engine/start.php");
elgg_load_library('elgg:event');
admin_gatekeeper();
$ia = elgg_set_ignore_access(true);
global $CONFIG;

$guid_one = 4148;
$guid_two = 44334;

function event_join($guid){
        $table = elgg_get_config('dbprefix').'entity_relationships';
        $sql = "select distinct guid_two from $table where relationship =
'event_join' and guid_one=4148 and
        guid_two not in( select guid_two from $table where relationship =
'event_join' and guid_one=44334)  ";
        $data = get_data($sql);
        return $data;

}

echo "<ol>";
$users = event_join($guid_two);
foreach($users as $user){
        $user_guid = $user->guid_two;

        $param['type' ] = 'object';
        $param['subtype' ] = 'event_join';
        $param['limit' ] = 1;
        $param['container_guid' ] = $guid_one;
        $param['owner_guid' ] = $user_guid;
        $param['metadata_name_value_pairs' ] = array('status' => 1);
        $param['order_by' ] = 'guid asc';
        $purchased = elgg_get_entities_from_metadata($param);

        //4164
        //4155
        //4156
        //4165

        $guid1 = 4164;
        $guid2 = 4155;
        $guid3 = 4156;
        $guid4 = 4165;

        $table = elgg_get_config('dbprefix').'groups_entity';

        foreach($purchased as $purchase){
                $guid = $purchase->guid;
                $html = $purchase->$guid1;
                $html .= '&nbsp;-&nbsp;'.$purchase->$guid2;
                $html .= '&nbsp;-&nbsp;'.$purchase->$guid3;
                $html .= '&nbsp;-&nbsp;'.$purchase->$guid4;
                $sql = "select name from $table where guid = (select guid_two from
elgg_entity_relationships where guid_one=$guid and
relationship='event_nonprofit_4148' limit 1)";
                $data = get_data($sql);
                if($data){
                        $html .= '&nbsp;-&nbsp;'.$data[0]->name;
                }else{
                        $html .= '&nbsp;-&nbsp; Empty';
                }
                echo "<li style='padding-bottom:10px;'>".$html."</li>";

        }
}
echo "</ol>";
elgg_set_ignore_access($ia);

?>