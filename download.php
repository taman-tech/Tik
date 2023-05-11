<?php
	if(isset($_POST['video_url'])){
		$video_url = $_POST['video_url'];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $video_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		preg_match_all('/<video[\s\S]+?src="([\s\S]+?)"[\s\S]+?>/i', $response, $matches);
		$video_url = str_replace('watermark=1', 'watermark=0', $matches[1][0]);
		header('Content-Type: application/octet-stream');
		header('Content-Transfer-Encoding: Binary');
		header('Content-disposition: attachment; filename="' . basename($video_url) . '"');
		readfile($video_url);
	}
?>
