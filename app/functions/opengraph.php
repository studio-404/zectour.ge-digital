<?php 
namespace functions;
class opengraph
{
	public function clear_cache($url) {
		$graph = 'https://graph.facebook.com/';
		$post = 'id='.urlencode($url).'&scrape=true';
		return $this->send_post($graph, $post);
	}

	private function send_post($url, $post)
	{
		$r = curl_init();
		curl_setopt($r, CURLOPT_URL, $url);
		curl_setopt($r, CURLOPT_POST, 1);
		curl_setopt($r, CURLOPT_POSTFIELDS, $post);
		curl_setopt($r, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($r, CURLOPT_CONNECTTIMEOUT, 5);
		$data = curl_exec($r);
		curl_close($r);
		return $data;
	}
}