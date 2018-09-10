<?php

	/*
		trate for working with images
	*/

	trait Image {
		var $imageFile; // image file absolute path (on server)
		var $imageName = 'image'; // image file name
		var $imageDir; // image directory absolute path (on server)
		var $sizes = [ // sizes of image for resizing
			'thumbnail' => [
				'height' => 64, // height number of pixels or NULL of autoscale it
				'width' => 64, // width number of pixels or NULL of autoscale it
				'low_quality' => true, // save image in very low quality
				'prefix' => 'thumb' // prefix of resized file
			],
			'post' => [
				'height' => NULL,
				'width' => 200,
				'low_quality' => false,
				'prefix'=>'p'
			]
		];

		/*
			Load image data
			$imageFile - relative path (on server)
			$imageName -  image name
			$imageDir - absolute path (on server) of directory that contain image with previews
		*/

		public function imageLoad(string $imageFile = '', string $imageName = '', string $imageDir = '') : void{
			/*
				if image directory not set or enpty - set it as current work directory
			*/
			if(!strlen($imageDir)>0){
				$imageDir = getcwd();
			}
			
			/*
				make relative path of file global and set up all input data as common variables
			*/

			$this->imageDir = $imageDir;
			if(strlen($imageFile)>0){
				$this->imageFile = "{$imageDir}/{$imageFile}";
			}
			if(strlen($imageName)>0){
				$this->imageName = $imageName;
			}
		}

		/*
			resizing image
			$sizes - list of sizes (should be exit in $this->sizes array) that must be generated for current files
		*/

		public function imageGen(array $sizes = []) : void{

			/*
				iterating over input sizes array
			*/

			if(count($sizes)>0){
				foreach($sizes as $size){
					if(isset($this->sizes[$size])){

						$size = $this->sizes[$size]; // load data from sizes list
						$imgObj = new Imagick(); // new Imagick instance
						$imgObj->readImage($this->imageFile); // read image from file
						$imgObj->setImageFormat("png"); // set default format of output image
						$originalWidth = $imgObj->getImageGeometry()['width']; // set width of original image
						$originalHeight = $imgObj->getImageGeometry()['height']; // set height of original image
						if($size['width'] == NULL || $size['height'] == NULL){

							/*
								if width or height of output image not set - calculating it
							*/

							if($size['width'] == NULL){

								/*
									calculating width if it not set
								*/

								$size['width'] = ($originalWidth/$originalHeight)*intval($size['height']);
								$size['width'] = (int)$size['width'];
							} else {

								/*
									calculating height if it not set
								*/

								$size['height'] = ($originalHeight/$originalWidth)*intval($size['width']);
								$size['height'] = (int)$size['height'];
							}
						} else {

							/*
								if width or height of output image set - if first we need crop input image for new proportions
							*/

							$newWidth = (int)$originalWidth;

							/*
								calculating height of output image by proportions of input image
							*/

							$newHeight = (intval($size['height'])/intval($size['width']))*$newWidth;
							$newHeight = (int)$newHeight;


							/*
								calculating width of output image by proportions of input image, if the height was bigger than defined
							*/
							if($newHeight>$originalHeight){
								$newHeight = (int)$originalHeight;
								$newWidth = (intval($size['width'])/intval($size['height']))*$newHeight;
								$newWidth = (int)$newWidth;
							}

							/*
								cuting image sizes if it bigger that we need
							*/

							if($newWidth<$originalWidth){
								$x = intval(($originalWidth-$newWidth)/2);
							} else {
								$x = 0;
							}
							if($newHeight<$originalHeight){
								$y = intval(($originalHeight-$newHeight)/2);
							} else {
								$y = 0;
							}

							/*
								also we need reduce height and width by some pixel(s) for fixing false round fload data into integer
							*/

							$x = $x>0?$x+1:0;
							$y = $y>0?$y+1:0;

							/*
								Croping image
							*/

							$imgObj->cropImage($newWidth,$newHeight,$x,$y);
						}
						$imgObj->resizeImage($size['width'],$size['height'],Imagick::FILTER_LANCZOS,1);//resize image
						if($size['low_quality']){

							/*
								if seting low quality - set format as gif and reduce quality to 10%
							*/

							$imgObj->setImageFormat("gif");
							$imgObj->setImageCompression(Imagick::COMPRESSION_ZIP);
							$imgObj->setImageCompressionQuality(10);

							/*
								saving file and set correct rights
							*/

							$imgObj->writeImage("{$this->imageDir}/{$this->imageName}-{$size['prefix']}.gif");
							chmod("{$this->imageDir}/{$this->imageName}-{$size['prefix']}.gif",0755);
						} else {

							/*
								if seting normal quality - reduce quality to 90%
							*/

							$imgObj->setImageCompression(Imagick::COMPRESSION_ZIP);
							$imgObj->setImageCompressionQuality(90);

							/*
								saving file and set correct rights
							*/

							$imgObj->writeImage("{$this->imageDir}/{$this->imageName}-{$size['prefix']}.png");
							chmod("{$this->imageDir}/{$this->imageName}-{$size['prefix']}.png",0755);
						}

						/*
							clear and destroy Imagick instance for memory optimization
						*/

						$imgObj->clear();
						$imgObj->destroy();
					}
				}
			}
		}
	}
?>