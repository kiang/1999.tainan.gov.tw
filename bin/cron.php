<?php

$now = date('Y-m-d H:i:s');

exec('/usr/bin/php -q /home/kiang/public_html/tainan_1999/query.php');

exec('cd /home/kiang/public_html/tainan_1999 && /usr/bin/git add -A');

exec("cd /home/kiang/public_html/tainan_1999 && /usr/bin/git commit --author 'auto commit <noreply@localhost>' -m 'update datasets @ {$now}'");

exec('cd /home/kiang/public_html/tainan_1999 && /usr/bin/git push origin master');
