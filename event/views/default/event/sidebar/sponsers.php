<?php

/**
 * Event sponser sidebar
 *
 * @package Event
 *
 */
$limit = elgg_extract('limit', $vars, 3);

$all_link = elgg_view('output/url', array(
    'href' => 'event/sponser/' . $vars['entity']->guid,
    'text' => elgg_echo('See All'),
    'is_trusted' => true,
        ));

$sponsers = elgg_get_entities_from_relationship(array(
    'relationship' => 'event_sponser',
    'relationship_guid' => $vars['entity']->guid,
    'inverse_relationship' => false,
    'limit' => $limit,
        ));
if (!empty($sponsers)):
    $content = '';
//print_r($sponsers);die;
    $content = '<ul>';
    foreach ($sponsers as $sponser) {
        $content .= '<li class="">';
        $icon = elgg_view_entity_icon($sponser, 'small', array('use_hover' => 'true'));
        $body = elgg_view('output/url', array(
            'href' => $sponser->getURL(),
            'text' => $sponser->name,
            'is_trusted' => true,
            'class' => 'partner-name line-one'
        ));

        $body .= '<div class="partner-name line-two">' . substr($sponser->name, 0, 40) . '</div>';
        $content .= elgg_view_image_block($icon, $body, array('image_alt' => $alt, 'class' => 'partner-image'));

        $content .= '<br class="clear"/>';
        $content .= '</li>';
    }
    $content .= '</ul>';

//$content .= "<div class='center mts'>$all_link</div>";
    echo elgg_view_module('', '<div id="non-profit-partners" class="sidebar-header">
    Non-Profit Partners
    <div class="see-all">' . $all_link . '</div>
</div>', $content);
 endif;

