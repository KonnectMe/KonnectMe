<?php
/**
 * Layout for main column with one sidebar
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['content'] Content HTML for the main column
 * @uses $vars['sidebar'] Optional content that is displayed in the sidebar
 * @uses $vars['title']   Optional title for main content area
 * @uses $vars['class']   Additional class to apply to layout
 * @uses $vars['nav']     HTML of the page nav (override) (default: breadcrumbs)
 */
$class = 'elgg-layout elgg-layout-one-sidebar clearfix';
if (isset($vars['class'])) {
    $class = "$class {$vars['class']}";
}

$guid = get_input('eventid');
$event = get_events("guid=$guid");

// navigation defaults to breadcrumbs
//$nav = elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));
?>
<div class="event_full">
    <div id="event-header">
        <div id="event-title-and-description">
            <div class="part1">

                <?php $url = eventCoverartURL($event[0]->guid, 'medium', true);
                echo $icon = "<img src='{$url}' alt='{$event[0]->title}' title='{$event[0]->title}'/>";
                ?>		
            </div>
            <div class="part2">
                <h2 class="elgg-heading-main"><?php
//echo $nav;

                    if (isset($vars['title'])) {
                        echo $vars['title'];
                    }
// @todo deprecated so remove in Elgg 2.0
                    if (isset($vars['area1'])) {
                        //echo $vars['area1'];
                    }
                    ?></h2>

            <div class="elgg-event-description">

                <?php
                $options = array('value' => $event[0]->brief_description);
                echo elgg_view("output/longtext", $options);
                
                $event_start_date =  event_start_date(date('Y-m-d',$event[0]->start_date), 'day');
                $event_start_date_suffix =  event_start_date(date('Y-m-d',$event[0]->start_date), 'suffix');
                $event_start_date_month =  event_start_date(date('Y-m-d',$event[0]->start_date), 'month');
                
                ?></div>
            </div>

        </div>
        <div id="date-time-location">
            <div class="start-date"><?php echo $event_start_date ?></div>
            <div class="start-month-and-end-date-wrapper">
                <div><?php echo $event_start_date_suffix ?> <span class="start-month"><?php echo $event_start_date_month ?></span></div>

<?php /* ?><div>to <span class="end-date"><?php echo date('d',$data[0]->start_date)?></span>th <span class="end-month"><?php echo date('M',$data[0]->start_date)?></span></div><?php */ ?>
            </div>
            <div class="start-time-and-location-wrapper">
                <div class="start-time"><?php if($event[0]->time!=''){echo date('h:i a',strtotime($event[0]->time));}else echo '';?></div>
                <div class="location"><?php echo elgg_view("output/text", array('value' => $event[0]->{'location'})); ?></div>
            </div>
        </div>
        <div id="sponsor-buttons">
            <a class="sponsor-button" href="#">Sponsor details</a>
            <a class="sponsor-button" href="#">Sponsor event</a>
        </div>
        <br class="clear">
        <br/>
    </div>
    <div class="<?php echo $class; ?>">
        <div class="elgg-sidebar">
            <?php
            echo elgg_view('page/elements/sidebar', $vars);
            ?>
        </div>

        <div class="elgg-main elgg-body">
            <?php
//echo $nav;

            if (isset($vars['title'])) {
                //	echo elgg_view_title($vars['title']);
            }
// @todo deprecated so remove in Elgg 2.0
            if (isset($vars['area1'])) {
                //	echo $vars['area1'];
            }
            if (isset($vars['content'])) {
                echo $vars['content'];
            }
            ?>
        </div>
    </div>
</div>
