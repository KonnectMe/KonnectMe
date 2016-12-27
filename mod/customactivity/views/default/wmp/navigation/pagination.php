<?php
$hidden_paginator = elgg_extract('hidden_paginator', $vars);
$time = time();
?>
<div class="wmpPaginatorWrapper">
	<div class="wmpLoadMoreBtn">
		<a class="loadmorelink" href="javascript:void(0)" title="Load more" data-pagination="<?php echo $time ?>">Load more</a>
		<span class="wmpAjaxLoader hidden"><img src="<?php echo $vars['url'] ?>_graphics/ajax_loader_bw.gif" alt="loading"/></span>
	</div>
	<div class="wmpHiddenPaginator" data-pager="<?php echo $time ?>">
		<?php echo $hidden_paginator; ?>
	</div>
</div>