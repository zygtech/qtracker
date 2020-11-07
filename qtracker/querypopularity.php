<?php
	$stream = stream_context_create(Array('http' => Array('method'  => 'GET','header'  => 'User-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.183 Safari/537.36')));
	$content=file_get_contents('https://www.google.com/search?q=' . urlencode($_GET['q']),false,$stream);
	$id='cwiwob VKx1id';
	echo explode('p',explode(':',substr($content,strpos($content, $id)))[1])[0]*(100/85);
?>
