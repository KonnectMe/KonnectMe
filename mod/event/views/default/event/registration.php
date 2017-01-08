<?php
$typeArray = event_formtype();	  
echo elgg_view_form('event/registration',array('formtype' => $typeArray));
set_input('viewtype',1);
$event = $vars['event'];
$eventguid = $event->guid;
set_input('eventguid',$eventguid);
$user = elgg_get_logged_in_user_entity();	
$table = elgg_get_config('dbprefix')."events_customforms";
$events = get_data("select *from $table where event_guid=$eventguid order by item_order");
$site_url = elgg_get_site_url();

if($events){ ?>
	<link href="<?php echo $site_url . 'mod/event/vendors/sort/styles.css'; ?>" type="text/css" />
	<script type="text/javascript">
		$(document).ready(function() {$("#test-list").sortable({ handle : '.handle', update : function () {  var order = $('#test-list').sortable('serialize');
			var url = "<?php echo $site_url . "ajax/view/event/changeorder"; ?>";
			$.ajax({type: "GET",url: url,dataType: "html",cache: false,	data: {order: order},success: function(htmlData) {$("#info").html(htmlData);}	});
		}});
	 });
	</script>
    <div id="draginfo"><?php echo elgg_echo('event:chnageorder'); ?></div>
<?php } ?>
<form id="cform1" name="cform1">
	<ul id="test-list">
	<?php
	foreach($events as $data){
		$guid = $data->id;
	?>
		<li id="listItem_<?php echo $guid ?>" class="elgg-item">
		<div class="elgg-plugin elgg-state-draggable elgg-state-inactive elgg-plugin-category-bundled elgg-plugin-category-content elgg-plugin-category-widget" id="blog">
			<div class="elgg-image-block">
				<div class="elgg-image-alt">
					<div class="clearfloat float-alt mtm">
						<?php
						$link = "action/event/deleteeventform?guid={$guid}&event={$eventguid}";
						$editlink = "event/editform/{$eventguid}/{$guid}";
						$delete_url = elgg_get_site_url().$link;
						$link =  elgg_view('output/url', array('href' => $editlink,'text' => elgg_echo('event:editlink'),'is_trusted' => true, ));
						$link .= '&nbsp;&nbsp;';
						$link .= elgg_view('output/confirmlink', array('text' => elgg_view_icon('delete'),'href' => $delete_url,'confirm' => elgg_echo('deleteconfirm'),));
						echo $link;
						?>
					</div>
				</div>
				<div class="elgg-body">
					<div class="elgg-head">
						<h3>
							<img src="<?php echo $site_url?>mod/event/vendors/sort/arrow.png" alt="move" width="16" height="16" class="handle" />
							&nbsp;
							<?php echo $data->title; ?>
						</h3>
					</div>
					<div>
						<div class="elgg-output"><p><span>Types & Values </span>: <?php echo $typeArray[$data->type];?> &nbsp; <?php echo elgg_get_excerpt($data->default_values,150);?></p></div>
					</div>
				</div>
			</div>
		</div>
		<div>&nbsp;</div>
	</li>
	<?php }?>
	</ul>