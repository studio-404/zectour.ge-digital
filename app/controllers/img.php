<?php 
use Intervention\Image\ImageManager;

class Img extends Controller
{
	public function __construct()
	{
		// phpinfo();
	} 

	public function index()
	{
		// create an image manager instance with favored driver
		$manager = new ImageManager(array('driver' => 'imagick'));

		// to finally create image instances
		echo $manager->make('public/filemanager/slider/image1.jpg')->resize(300, 200)->response();

		// open an image file
		//$img = Image::make('public/foo.jpg');

		// now you are able to resize the instance
		// $image->resize(320, 240);
		// $image->response();

		// and insert a watermark for example
		// $img->insert('public/watermark.png');

		// finally we save the image as a new file
		// $image->save('public/filemanager/slider/320x240.jpg');


	}
}