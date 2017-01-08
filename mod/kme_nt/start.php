<?php
elgg_register_event_handler('init', 'system', 'kme_nt');

function kme_nt() {
	elgg_extend_view('js/elgg', 'kme_nt/js');
	elgg_extend_view('css/elgg', 'kme_nt/css', 1000);

}
