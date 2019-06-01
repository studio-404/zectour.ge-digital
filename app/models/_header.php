<?php 
class _header
{
	public $public;
	public $lang;
	public $pagedata;
	public $imageSrc;
	public $product;

	public function index(){ 
		require_once("app/functions/l.php");
		$l = new functions\l();

		$getter = $this->pagedata->getter(); 

		if(isset($getter['title'])){
			$title = strip_tags($getter['title']);
			$description = strip_tags($getter['description']);
		}else if(isset($getter[0]['title'])){
			$title = strip_tags($getter[0]['title']); 
			$description = strip_tags($getter[0]['description']);
		}else{
			$title = "";
			$description = "";
		}

		if(isset($this->product)){
			$title = strip_tags($this->product['title']);
			$description = strip_tags($this->product['short_description']);
		}

		$out = "<!DOCTYPE html>\n";
		$out .= "<html>\n";
		$out .= "<head>\n";
		$out .= "<script async src=\"https://www.googletagmanager.com/gtag/js?id=UA-115503643-1\"></script>\n<script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'UA-115503643-1'); </script>\n";
		$out .= "<meta charset=\"utf-8\">\n";
		$out .= "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n";
				
		$out .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no\" />\n";
		$out .= "<meta name=\"format-detection\" content=\"telephone=no\"/>\n";
		$out .= sprintf(
			"<title>%s - %s</title>\n", 
			strip_tags($title), 
			Config::NAME
		);
		
		$out .= "<meta property=\"fb:app_id\" content=\"570019476840637\" />\n";
		$out .= sprintf(
			"<meta property=\"og:title\" content=\"%s\" />\n",
			strip_tags($title)
		);

		$out .= sprintf(
			"<meta name=\"yandex-verification\" content=\"f2e3328c6ff0624a\" />\n"
		);

		$out .= sprintf(
			"<meta name=\"keywords\" content=\"%s\">\n",
			$l->translate("keywords")
		);

		$out .= sprintf(
			"<link rel=\"sitemap\" href=\"/%s/sitemap\" type=\"application/xml\" />\n",
			$_SESSION["LANG"]
		);

		$out .= "<meta property=\"og:type\" content=\"website\" />\n";
		$out .= sprintf(
			"<meta property=\"og:url\" content=\"http://%s%s\"/>\n",
			$_SERVER["HTTP_HOST"],
			htmlentities($_SERVER["REQUEST_URI"])
		);
		
		if(isset($this->imageSrc)){
			$image = $this->imageSrc;
		}else{
			$image = sprintf(
				"%simg/share.jpg",
				$this->public
			);
		}
		$out .= sprintf(
			"<meta property=\"og:image\" content=\"%s\" />\n", 
			$image
		);
		$out .= sprintf(
			"<link rel=\"image_src\" type=\"image/jpeg\" href=\"%s\" />\n", 
			$image
		);


		$out .= "<meta property=\"og:image:width\" content=\"600\" />\n";
		$out .= "<meta property=\"og:image:height\" content=\"315\" />\n";
		$out .= sprintf(
			"<meta property=\"og:site_name\" content=\"%s\" />\n",
			Config::NAME
		);
		$out .= sprintf(
			"<meta property=\"og:description\" content=\"%s\"/>\n",
			htmlentities($description)
		);


		$out .= sprintf(
			"<link rel=\"icon\" type=\"image/ico\" href=\"%simg/favicon.png?v=%s\" />\n", 
			$this->public,
			Config::WEBSITE_VERSION
		);
		
		$out .= sprintf(
			"<link rel=\"stylesheet\" type=\"text/css\" href=\"%scss/web/bootstrap.min.css?v=%s\" />\n", 
			$this->public,
			Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.2.0/flexslider-min.css\" type=\"text/css\" />\n"
		);

		$out .= sprintf(
			"<link rel=\"stylesheet\" type=\"text/css\" href=\"%scss/web/full-slider.css?v=%s\" />\n", 
			$this->public,
			Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<link rel=\"stylesheet\" type=\"text/css\" href=\"%scss/web/bootstrap.datepicker.css?v=%s\" />\n", 
			$this->public,
			Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<link rel=\"stylesheet\" type=\"text/css\" href=\"%scss/web/font-awesome.css?v=%s\" />\n", 
			$this->public,
			Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<link rel=\"stylesheet\" type=\"text/css\" href=\"%scss/web/style.css?v=%s\" />\n", 
			$this->public,
			Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<script async src=\"https://www.googletagmanager.com/gtag/js?id=UA-109222021-1\"></script>\n" 
		);

		$out .= sprintf(
			"<script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'UA-109222021-1');</script>\n"
		);
		$out .= "<!-- Global site tag (gtag.js) - Google AdWords: 811432461 -->
		<script async src=\"https://www.googletagmanager.com/gtag/js?id=AW-811432461\"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'AW-811432461');
		</script>\n";
		
		$out .= "</head>\n";
		
		$out .= "</body>\n";

		
		
		return $out;
	}
}