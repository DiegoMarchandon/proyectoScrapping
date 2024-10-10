<?php

$string = "tiene comillas ' ahi ' ";
$strinRepl = str_replace("'","",$string);

echo $strinRepl;