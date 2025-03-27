<?php
defined('DS') ?: define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ?: define('SITE_ROOT', '/opt/lampp/htdocs/workphp/phprestapi');
defined('INC_PATH') ?: define('INC_PATH', SITE_ROOT.DS.'includes');
defined('CORE_PATH') ?: define('CORE_PATH', SITE_ROOT.DS.'core');

require_once(INC_PATH.DS.'config.php');
require_once(CORE_PATH.DS.'post.php');
require_once(CORE_PATH.DS.'category.php');



