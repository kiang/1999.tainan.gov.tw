<?php

$path = dirname(__DIR__);
$now = date('Y-m-d H:i:s');

exec("/usr/bin/php -q {$path}/query.php");

exec("cd {$path} && /usr/bin/git pull");

exec("cd {$path} && /usr/bin/git add -A");

exec("cd {$path} && /usr/bin/git commit --author 'auto commit <noreply@localhost>' -m 'update datasets @ {$now}'");

exec("cd {$path} && /usr/bin/git push origin master");