<?php

    $defaults = array(
        'type' => 'email'
    );

    $vars = array_merge($defaults, $vars);

    echo elgg_view('input/text', $vars);