<?php

elgg_register_event_handler('init', 'system', 'jquery_ui_init');

function jquery_ui_init() {

    setlocale(LC_ALL, 'pt_BR');

    //JQuery
    elgg_unregister_js('jquery');

    $url = elgg_get_site_url() . 'mod/custom_inputs/js/jquery/jquery-1.9.1.min.js';
    elgg_register_js('jquery', $url, 'head', 1);
    elgg_load_js('jquery');

    $url = elgg_get_site_url() . 'mod/custom_inputs/js/jquery/jquery-migrate-1.1.1.js';
    elgg_register_js('jquery-migrate', $url, 'head', 1);
    elgg_load_js('jquery-migrate');

    //UI
    $url = elgg_get_site_url() . 'mod/custom_inputs/js/jquery-ui-1.10.2/ui/jquery-ui.js';
    elgg_register_js('jquery_ui', $url, 'head', 1);

    //CSS
    $url = elgg_get_site_url() . 'mod/custom_inputs/js/jquery-ui-1.10.2/themes/base/jquery.ui.all.css';
    elgg_register_css('jquery_ui', $url);

    //Components
    $url = elgg_get_site_url() . 'mod/custom_inputs/js/jquery-ui-1.10.2/ui/jquery.ui.datepicker.js';
    elgg_register_js('jquery_ui_datepicker', $url);

    //Addons

    //Time Picker
    $url = elgg_get_site_url() . 'mod/custom_inputs/js/addons/jquery-ui-timepicker-addon.js';
    elgg_register_js('jquery_ui_timepicker', $url, 'head');

    $url = elgg_get_simplecache_url('js', 'initialize_timepicker');
    elgg_register_js('initialize_timepicker', $url);

    $url = elgg_get_site_url() . 'mod/custom_inputs/js/addons/jquery-ui-timepicker-addon.css';
    elgg_register_css('jquery_ui_timepicker', $url);

    //Template
    $url = elgg_get_site_url() . 'mod/custom_inputs/js/addons/jquery-tmpl.js';
    elgg_register_js('jquery_ui_tmpl', $url, 'head');

    //MultiSelect
    $url = elgg_get_site_url() . 'mod/custom_inputs/js/addons/multiselect-master/js/ui.multiselect.js';
    elgg_register_js('jquery_ui_multiselect', $url, 'head');

    $url = elgg_get_site_url() . 'mod/custom_inputs/js/addons/multiselect-master/js/plugins/localisation/jquery.localisation-min.js';
    elgg_register_js('jquery_ui_localisation', $url, 'head');

    $url = elgg_get_site_url() . 'mod/custom_inputs/js/addons/multiselect-master/js/plugins/scrollTo/jquery.scrollTo-min.js';
    elgg_register_js('jquery_ui_scrollTo', $url, 'head');

    $url = elgg_get_site_url() . 'mod/custom_inputs/js/addons/multiselect-master/css/ui.multiselect.css';
    elgg_register_css('jquery_ui_multiselect', $url);

    //Validation
    $url = elgg_get_site_url() . 'mod/custom_inputs/js/addons/jquery.validation/jquery.validate.js';
    elgg_register_js('jquery_ui_validate', $url, 'head');

    $url = elgg_get_site_url() . 'mod/custom_inputs/js/addons/jquery.validation/additional-methods.min.js';
    elgg_register_js('jquery_ui_validate_additional', $url, 'head');
}

function jquery_ui_load(){
    elgg_unregister_js('jquery-ui');
    elgg_load_js('jquery_ui');
    elgg_load_css('jquery_ui');
}

function jquery_ui_load_options(){

    global $CONFIG;

    if(!$CONFIG->jquery_ui_datetime_options){

        $jquery_ui_datetime_options = new stdClass();

        $jquery_ui_datetime_options->currentText = elgg_echo('jquery_ui:now');
        $jquery_ui_datetime_options->closeText = elgg_echo('jquery_ui:close');
        $jquery_ui_datetime_options->timeText = elgg_echo('jquery_ui:time');
        $jquery_ui_datetime_options->hourText = elgg_echo('jquery_ui:hour');
        $jquery_ui_datetime_options->minuteText = elgg_echo('jquery_ui:minute');
        $jquery_ui_datetime_options->secondText = elgg_echo('jquery_ui:second');

        $jquery_ui_datetime_options->nextText = elgg_echo('jquery_ui:next');
        $jquery_ui_datetime_options->prevText = elgg_echo('jquery_ui:prev');

        $jquery_ui_datetime_options->dateFormat = 'dd/mm/yy';

        $jquery_ui_datetime_options->dayNames = array(
            elgg_echo('day:name:seg'),
            elgg_echo('day:name:ter'),
            elgg_echo('day:name:qua'),
            elgg_echo('day:name:qui'),
            elgg_echo('day:name:sex'),
            elgg_echo('day:name:sab'),
            elgg_echo('day:name:dom'),
        );

        $jquery_ui_datetime_options->dayNamesShort = array(
            elgg_echo('day:name:short:seg'),
            elgg_echo('day:name:short:ter'),
            elgg_echo('day:name:short:qua'),
            elgg_echo('day:name:short:qui'),
            elgg_echo('day:name:short:sex'),
            elgg_echo('day:name:short:sab'),
            elgg_echo('day:name:short:dom'),
        );

        $jquery_ui_datetime_options->dayNamesMin = array(
            elgg_echo('day:name:min:seg'),
            elgg_echo('day:name:min:ter'),
            elgg_echo('day:name:min:qua'),
            elgg_echo('day:name:min:qui'),
            elgg_echo('day:name:min:sex'),
            elgg_echo('day:name:min:sab'),
            elgg_echo('day:name:min:dom'),
        );


        $jquery_ui_datetime_options->monthNames = array(
            elgg_echo('month:jan'),
            elgg_echo('month:fev'),
            elgg_echo('month:mar'),
            elgg_echo('month:abr'),
            elgg_echo('month:mai'),
            elgg_echo('month:jun'),
            elgg_echo('month:jul'),
            elgg_echo('month:ago'),
            elgg_echo('month:set'),
            elgg_echo('month:out'),
            elgg_echo('month:nov'),
            elgg_echo('month:dez'),
        );

        $jquery_ui_datetime_options->monthNamesShort = array(
            elgg_echo('month:short:jan'),
            elgg_echo('month:short:fev'),
            elgg_echo('month:short:mar'),
            elgg_echo('month:short:abr'),
            elgg_echo('month:short:mai'),
            elgg_echo('month:short:jun'),
            elgg_echo('month:short:jul'),
            elgg_echo('month:short:ago'),
            elgg_echo('month:short:set'),
            elgg_echo('month:short:out'),
            elgg_echo('month:short:nov'),
            elgg_echo('month:short:dez'),
        );

        $CONFIG->jquery_ui_datetime_options = $jquery_ui_datetime_options;
    }
}


function jquery_ui_load_time_picker(){

    jquery_ui_load();

    elgg_load_js('jquery_ui_timepicker');
    elgg_load_js('initialize_timepicker');
    elgg_load_css('jquery_ui_timepicker');
}

function jquery_ui_load_multiselect(){

    jquery_ui_load();

    elgg_load_css('jquery_ui_multiselect');
    elgg_load_js('jquery_ui_multiselect');
    elgg_load_js('jquery_ui_localisation');
    elgg_load_js('jquery_ui_scrollTo');
}

function jquery_ui_validate(){
    jquery_ui_load();

    elgg_load_js('jquery_ui_validate');
    elgg_load_js('jquery_ui_validate_additional');
}




