<?php
/**
 * List of spam users
 */

echo elgg_view_form('kme_spamtools/bulk_action', array(
	'id' => 'kme_spamtools-form',
	'action' => 'action/kme_spamtools/bulk_action'
));
?>

<style type="text/css">
a.redlink {
	color:red;
}
</style>	

<script language="javascript">
$(document).ready(function(){
	$('#selectall').click(function(event) {   
		$(':checkbox').each(function() {
			this.checked = true;                        
		});
	});
});
</script>