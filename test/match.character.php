<?php

$s = base64_decode('YXN5YW50aTs4MjdjY2IwZWVhOGE3MDZjNGMzNGExNjg5MWY4NGU3YjsxNDE3NDkzMTM0');
preg_match_all('/[\;]/i',$s, $matches);
echo count($matches[0]);

?>