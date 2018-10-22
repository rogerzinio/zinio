<?php

function autoload($class)
{
    require "Zinio/$class.php";
}

spl_autoload_register('autoload');