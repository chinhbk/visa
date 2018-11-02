<?php

class Admin_NewsController extends Zend_Controller_Action
{

    public function init()
    {
		$auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            // Identity exists; get it
            $identity = $auth->getIdentity();
            if($identity->ROLE == 0 || $identity->ROLE == 3){
            	$this->view->user_name = $identity->USER_NAME;
            	$layout = $this->_helper->layout();
            	$layout->setLayout('admin');
            }else{ // redirect to access denied page
            	$this->redirect('admin/auth/access-denied');
            }
        } else {
           $this->redirect('admin/auth');
        }
      
    }

    public function indexAction()
    {
		$request = $this->getRequest();
		$news_type_id = $request->getParam('news_type_id');
		//die($category_id == null);
		if($news_type_id == null) {
			$news_type_id = 1;
		}
		
		$this->view->news_type_id = $news_type_id;
		
		$newstype_mapper = new Application_Model_NewsTypeMapper();
		$newstypes = $newstype_mapper->getAll();
		$this->view->newstypes = $newstypes;
		
		$news_mapper = new Application_Model_NewsMapper();
		$allNews = $news_mapper->get($news_type_id, 50);
		$this->view->allNews = $allNews;
		
		
    }
	
	public function addAction(){
		$request = $this->getRequest();
		$newstype_mapper = new Application_Model_NewsTypeMapper();
		$newstypes = $newstype_mapper->getAll();
		$this->view->newstypes = $newstypes;
		//Zend_Debug::dump( $allNews);die();
        if ($request->isPost()) {
		//Zend_Debug::dump(  $request->getPost());die();
			$news_title =  $request->getParam('news_title');
			$news_type_id = $request->getParam('news_type_id');
			$news_summary = $request->getParam('news_summary');
			$img_uploaded =  $request->getParam('img_uploaded');
			$editor_contents =  $request->getParam('editor_contents');
			if(strlen($news_title) == 0 || strlen($editor_contents) == 0){
			   $this->view->errorMessage = 'Lỗi nhập thiếu dữ liệu';
			   return;
			}
			$news = new Application_Model_News();
			$news->news_type_id = $news_type_id ;
			$news->title = $news_title;
			$news->summary = $news_summary;
			$news->small_image = $img_uploaded;
			$news->content = $editor_contents;
			
			$news_mapper = new Application_Model_NewsMapper();
			$news_mapper->save($news);
			$this->redirect('admin/news/index');
		}
	}
	public function editAction(){
		$request = $this->getRequest();
		//Zend_Debug::dump( $request);die();
			//	Zend_Debug::dump( $request);die;
			
		$id = $request->getParam('news_id');
		//die($id);
		$news_mapper = new Application_Model_NewsMapper();
		$news = $news_mapper->getNewsById($id);

		$this->view->news = $news ;
	
		$newstype_mapper = new Application_Model_NewsTypeMapper();
		$newstypes = $newstype_mapper->getAll();
		$this->view->newstypes = $newstypes;
	
		if ($request->isPost()) {
			$id =  $request->getParam('news_id');
			$news_title =  $request->getParam('news_title');
			$news_summary = $request->getParam('news_summary');
			$news_type_id = $request->getParam('news_type_id');
			$img_uploaded =  $request->getParam('img_uploaded');
			$editor_contents =  $request->getParam('editor_contents');
			if(strlen($news_title) == 0 || strlen($editor_contents) == 0){
			   $this->view->errorMessage = 'Lỗi nhập thiếu dữ liệu';
			   return;
			}
			
			//echo $id . $product_name . $img_uploaded;
			//die();
			$edit_news = new Application_Model_News();
			$edit_news->id = $id;
			$edit_news->news_type_id = $news_type_id ;
			$edit_news->title = $news_title;
			$edit_news->summary = $news_summary;
			$edit_news->small_image = $img_uploaded;
			$edit_news->content = $editor_contents;
			
			//Zend_Debug::dump( $edit_news);die;
			
		
			$news_mapper = new Application_Model_NewsMapper();
				
			$news_mapper->save($edit_news); //Zend_Debug::dump( $request);die;
			$this->redirect('admin/news/index');		
		}
	}
	
	public function deleteAction(){
		$request = $this->getRequest();
		//Zend_Debug::dump( $request);die();
		$id = $request->getParam('news_id');
		//die($id);
		$news_mapper = new Application_Model_NewsMapper();
		$news = $news_mapper->delete($id);
		$this->redirect('admin/news/index');
	
	}
	protected function _getExtension($str){
		$i=strrpos($str,".");
		if(!$i){
			return"";
		}
		$l=strlen($str)-$i;
		$ext=substr($str,$i+1,$l);
		return $ext;	
	}
	
	//editor upload image 
	public function editorAction(){
		$this->_helper->layout()->disableLayout(); //  shuts off of the layout
		$this->_helper->viewRenderer->setNoRender();// stop automatic rendering
		 // Allowed extentions.
		$allowedExts = array("gif", "jpeg", "jpg", "png");

		// Get filename.
		$temp = explode(".", $_FILES["file"]["name"]);

		// Get extension.
		$extension = end($temp);

		// An image check is being done in the editor but it is best to
		// check that again on the server side.
		if ((($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/jpg")
		|| ($_FILES["file"]["type"] == "image/pjpeg")
		|| ($_FILES["file"]["type"] == "image/x-png")
		|| ($_FILES["file"]["type"] == "image/png"))
		&& in_array($extension, $allowedExts)) {
			// Generate new random name.
			$name = sha1(microtime()) . "." . $extension;

			// Save file in the uploads folder.
			move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $name);

			// Generate response.
			$response = new StdClass;
			$response->link = "/uploads/" . $name;
			echo stripslashes(json_encode($response));
		}	
	}	
	
	public function uploadAction(){
		$this->_helper->layout()->disableLayout(); //  shuts off of the layout
		$this->_helper->viewRenderer->setNoRender();// stop automatic rendering
		 
		$formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
	    
		if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
			$name = $_FILES['file']['name'];
			$size = $_FILES['file']['size'];
			$tmp  = $_FILES['file']['tmp_name'];
			//echo $name .'--'. $size. '--'.$tmp;
			//die();
			if(strlen($name)){
				$ext = $this->_getExtension($name);
				
				//die( is_uploaded_file($tmp));
				if(in_array($ext,$formats)){
					if($size<(1024*1024)){
						$imgn = time().".".$ext;
						if(is_uploaded_file($tmp)){
							if(move_uploaded_file($tmp, "uploads/".$imgn)){
								//echo "File Name: ".$_FILES['file']['name'];
								//echo "<br/>File Temporary Location : ".$_FILES['file']['tmp_name'];
								//echo "<br/>File Location : ". "/uploads/". $imgn."'" ;
								//echo "<br/>File Size : ".$_FILES['file']['size'];
								//echo "<br/>File Type : ".$_FILES['file']['type'];
								echo "<img style='margin-left:10px;' src='/uploads/".$imgn."'>";
								//echo "<br/><input name='img_uploaded' type='hidden' value='/uploads/".$imgn."'/>";
								echo "<script type='text/javascript'> $(document).ready(function() {console.log('aaaaa'); $('#img_uploaded').val('/uploads/".$imgn."'); }  );</script>";
							}else{
							 echo "Uploading Failed.";
							}
						
						}
						
				   } else{
					echo "Image File Size Max 1 MB";
				   }
				} else {
						echo "Invalid Image file format.";
				}
			}else{
			  echo "Please select an image.";
			  exit;
			 }
		}
	}

}

