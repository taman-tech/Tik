<?php

if(isset($_POST['url'])) {

  $url = $_POST['url'];

  // Remove watermark from Tiktok video
  $no_watermark_url = str_replace('watermark=1', 'watermark=0', $url);

  // Get video ID from Tiktok video URL
  $url_parts = parse_url($no_watermark_url);
  parse_str($url_parts['query'], $query);
  $video_id = $query['video_id'];

  // Download Tiktok video
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://www.tiktok.com/node/share/video/{$video_id}");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $output = curl_exec($ch);
  curl_close($ch);

  $json = json_decode($output);

  $video_url = $json->itemInfo->itemStruct->video->urls[0];

  header("Content-Type: application/octet-stream");
  header("Content-Transfer-Encoding: Binary"); 
  header("Content-disposition: attachment; filename=\"" . basename($video_url) . "\""); 
  readfile($video_url);
}

?>
