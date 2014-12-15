#How to make a gallery with phpFlickr in CakePHP
---
##Introduction

Flickr was created by Ludicorp in 2004 and was acquired by Yahoo. Flickr is an image and video hosting website. Besides being a popular website for users to share personal photographs, and effectively an online community, Flickr is also widely used by photo researchers and by bloggers to host images that they embed in blogs and websites.

phpFlickr is a class written by Dan Coulter in PHP4 to act as a wrapper for Flickr's API. Methods process the response and return a friendly array of data to make development simple and intuitive. We are also using Flickr Component, which is a CakePHP component developed by Miguel Ros that ties the php Flickr class into the controller and view of the application.

###Incorporating phpFlickr to CakePHP
---
Global configuration is useful. You can put the following code in app/config/bootstrap.php or app/config/core.php
```php
Configure::write('Flickr.posting_url', 'http://api.flickr.com/services/rest/');
Configure::write(
    'Flickr.defaults', array(
        'api_key' => '111122223333aaaabbbbccccdddd',
        'user_id' => '1234567@N66',
        'method' => 'flickr.photos.search',
        'format' => 'php_serial',
        'extras' => 'description, date_taken'
    )
);
```
You could create a phpflickr folder at /app/vendors/phpflickr/ and dorp phpFlickr into it. Next, place the Flickr Component into the /app/controllers/components/ folder. In the flickr.php component file, you’ll need to specify your API key in the $_api_key variable
```php
var $_api_key='PLACEKEYHERE';
```
If you want to use a file cache, you’ll need to make sure the Flickr cache folder has been created and has write permissions and it can cache the data it receives from the Flickr API to speed up subsequent calls.  To set or change the cache folder, change the constant declared at the top of the Flickr:
```php
define('FLICKR_CACHE_DIR', CACHE . 'flickr/');
```
You have to write a controller class GalleryController to handle the gallery and save it to /app/controllers/gallery_controller.php :
```php
class GalleryController extends AppController{ 

  var $name = 'Gallery'; 

  var $components = array('Flickr'); 

  var $uses = null; 

}
```
To modify our routes to handle the gallery calls, add the following code to your /app/config/routes.php
```php
$Route->connect('/gallery/*',  

    array('controller' => 'gallery', 'action'=>'index'));
```

---
##Functionaility
---
###Controller

Add a function index to GalleryController.php
```php
function index($id = null) 

{ 

  $photosets = $this->flickr->photosets_getList('USER_ID'); 

  $this->set('sets', $photosets); 

  $currset = $id == null ? $photosets['photoset'][0]['id'] : $id; 

  $this->set('currset', $this->flickr->photosets_getInfo($currset)); 

  $this->set('thumbs', $this->flickr->photosets_getPhotos($currset)); 

}
```
 For the line ```php $photosets = $this->flickr->photosets_getList('USER_ID'); ```
 If you are not sure about the USER_ID, you could use flickr.people.findByEmail or .findByUsername to replace USER_ID.

If you want to add a search parameter for the function, you could use the following function in GalleryController and you could perform search by author or keyword

```php
function admin_flickrbrowser($opener_instance, $page = 1, $per_page = 10, $id = null) {
	$this->_clean_params();
	// get the query parameters
	if(isset($this->data['Asset'])) {
	if (isset($this->data['Asset']['keyword']) && $this->data['Asset']['keyword'] != '')    $keyword  = $this->data['Asset']['keyword']; else $keyword = 'volontariato';
	if (isset($this->data['Asset']['author']) && $this->data['Asset']['author'] != '')	    $author   = $this->data['Asset']['author'];
  }
	if(isset($author) && !empty($author)) {
	$username = $this->flickr->people_findByUsername($author);
	$photosets = $this->flickr->photosets_getList($username['id']);
	$this->set('photosets', $photosets['photoset']);
		} else
	if(isset($keyword) && !empty($keyword)) {
	$thumbs  = $this->flickr->photos_search(array(
		'text' => $keyword,
		'page' => $page,
		'per_page' => $per_page,
		'sort' => 'interestingness-desc',
		'extras' => 'license,date_upload,owner_name,icon_server,original_format,tags,o_dims,views,media,path_alias'
		));
	}
	if(isset($thumbs)) {
	if($page == 1) $this->Session->write('total_pages', $thumbs['pages']);
		} else {
	$this->Session->write('total_pages', 1);
	}
	if($page < $this->Session->read('total_pages')) {
		$next_index = $page + 1;
		$url = array('controller' => 'assets', 'action' => 'flickrbrowser',
		$opener_instance,
		$next_index,
		$per_page
	);
	if	(isset($keyword)) $url['keyword'] = $keyword;
	if	(isset($author)) $url['author'] = $author;
	$this->set('next_url', $url);
	}
	if($page > 1) {
	$previous_index = $page - 1;
	$url = array('controller' => 'assets', 'action' => 'flickrbrowser',
	$opener_instance,
	$previous_index,
	$per_page
	);
	if	(isset($keyword)) $url['keyword'] = $keyword;
	if	(isset($author)) $url['author'] = $author;
		$this->set('previous_url', $url);
	}
	if(isset($thumbs)) $this->set('thumbs', $thumbs);
		$this->set('opener_instance', $opener_instance);
		$this->render('admin_flickrbrowser', 'basic');
		}
	}
```

### View

You will need create a folder gallery in  /app/views/ and create an index.html in that folder.

If you want to show the title and description for the current photoset, you could use $currset variable declared in the gallery controller:
```php
<div class="post"> 

  <h2><?php echo $currset['title']?></h2> 

  <p><?php echo $currset['description']?></p> 

</div>
```

To iterate though each photoset in the $set variable, you could create a link to the gallery controller and using the photoset ID as the parameter:
```php
<ul> 

  <?php foreach($sets['photoset'] AS $item): ?> 

  <li><?php echo $html->link($item['title'], '/gallery/' . $item['id']);?></li>  

  <?php endforeach; ?> 

</ul>
``` 
For the images, you could choose different size by setting the tags:

*square, which has dimensions of 75x75px
*thumbnail, which is 100px on longest side
*small, which is 240px on longest side
*medium, which is 500px on its longest side
*large, which is 1024px on longest side
*original, which is the original image file
 
 Here is an example if you want to loop through each of the photos in the $thumbs array to build the thumbnail display. 
 You could request the thumbnail-sized images by using buildPhotoURL method for the image source URLs and link each thumbnail to its medium version on the Flickr server:
 
 ```php
 <ul id="thumbs"> 

  <?php foreach($thumbs['photo'] as $item): ?> 

  <li><a href="<?php echo $flickr->buildPhotoURL($item, "medium")?>" title="<?php echo $item['title']?>"><img  

        src="<?php echo $flickr->buildPhotoURL($item, "thumbnail")?>"  

        alt="<?php echo $item['title']?>" /></a></li> 

  <? endforeach; ?> 

</ul>
```
###Special Flickr Values
These values could act as variables returned from Flickr. And here are these special values:

*'flickr_id',
*'flickr_secret',
*'flickr_title',
*'flickr_datetaken',
*'flickr_description'

---
Resources:
http://www.sitepoint.com/photo-gallery-cakephp-flickr/  
http://forums.phpfreaks.com/topic/268657-build-a-photo-gallery-using-cakephp-and-flickr/  
http://stefanomanfredini.info/2010/08/your-own-cakephp-file-browser-for-ckeditor-part-4-%E2%80%93-flickr-photos-and-slideshow/#codesyntax_1  
https://github.com/chronon/flickr  

