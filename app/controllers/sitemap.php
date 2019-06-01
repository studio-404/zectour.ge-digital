<?php 
class Sitemap extends Controller
{
	public function __construct()
	{
		
	}

	public function index($name = '')
	{
		header("Content-type: text/xml");

		$Database = new Database('page', array(
			"method"=>"select",
			"cid"=>2, 
			"nav_type"=>0,
			"lang"=>$_SESSION['LANG'],
			"status"=>0 
		));
		$pages = $Database->getter();

		$Database2 = new Database("products", array(
			"method"=>"sitemap_select", 
			"lang"=>$_SESSION['LANG']
		));
		$products = $Database2->getter();
		?>
		<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"> 
		
		<?php foreach ($pages as $v): ?>
		  <url>
		    <loc><?=Config::WEBSITE.$_SESSION['LANG']?>/<?=urlencode($v['slug'])?></loc>
		    <lastmod><?=date("Y-m-d")?></lastmod>
		    <changefreq>daily</changefreq>
		    <priority>0.8</priority>
		  </url>
		<?php endforeach; ?>

		<?php foreach ($products as $v): ?>
		  <url>
		    <loc><?=Config::WEBSITE.$_SESSION['LANG']?>/view/<?=urlencode($v['title'])?>/?id=<?=$v["idx"]?></loc>
		    <lastmod><?=date("Y-m-d")?></lastmod>
		    <changefreq>always</changefreq>
		    <priority>1.0</priority>
		  </url>
		<?php endforeach; ?>

		</urlset>
		<?php
	}
}