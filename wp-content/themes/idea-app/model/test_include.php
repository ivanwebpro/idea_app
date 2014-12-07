<?php

ob_start();
require $_SERVER['DOCUMENT_ROOT'].'/index.php';
ob_clean();

require_once 'loader.php';