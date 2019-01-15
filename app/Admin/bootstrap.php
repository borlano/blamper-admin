<?php

// PackageManager::load('admin-default')
//    ->css('extend', public_path('packages/sleepingowl/default/css/extend.css'));
PackageManager::add('favicon')
    ->js(null, 'https://code.jquery.com/jquery-2.1.4.min.js');
Meta::setFavicon("/favicon.png","icon")->render();