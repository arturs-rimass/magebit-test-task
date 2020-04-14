<?php

require_once 'core/init.php';

if (Session::exists('login')) {
    echo '<p>' . Session::flash('login') . '</p>';
}
