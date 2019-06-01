<?php 
class _footer
{
	public $data;

	public function index()
	{
		$out = sprintf(
			"<script src=\"%sjs/web/jquery.min.js?v=%s\" type=\"text/javascript\" charset=\"utf-8\"></script>\n", 
			Config::PUBLIC_FOLDER,
			Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<script src=\"%sjs/web/popper.min.js?v=%s\" type=\"text/javascript\" charset=\"utf-8\"></script>\n", 
			Config::PUBLIC_FOLDER,
			Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<script src=\"%sjs/web/bootstrap.min.js?v=%s\" type=\"text/javascript\" charset=\"utf-8\"></script>\n", 
			Config::PUBLIC_FOLDER,
			Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<script src=\"%sjs/web/script.js?v=%s\" type=\"text/javascript\" charset=\"utf-8\"></script>\n", 
			Config::PUBLIC_FOLDER,
			Config::WEBSITE_VERSION
		);	
		

		return $out;
	}
}