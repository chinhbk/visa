<?php

class Admin_ImageController extends Zend_Controller_Action
{

    public function init()
    {
		$auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            // Identity exists; get it
            $identity = $auth->getIdentity();
			$this->view->user_name = $identity->USER_NAME;
            $layout = $this->_helper->layout();
            $layout->setLayout('admin');
        } else {
           $this->redirect('admin/auth');
        }
      
    }

    public function indexAction()
    {
		$image_mapper = new Application_Model_ImageMapper();
		$images = $image_mapper->getAll();
		//Zend_Debug::dump( $products);die();
		$this->view->images = $images;
		
		if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
			$request = $this->getRequest();
			
			//Zend_Debug::dump( $request->getParam('img_uploaded1'));die();		
			for ($id = 1; $id <= sizeof($images); $id++) {
				$image = new Application_Model_Image();
				$image->id = $id;
				$image->image = $request->getParam('img_uploaded'.$id);
				$image->status = $request->getParam('status'.$id);
				//Zend_Debug::dump( $image);die();
				$image_mapper->save($image);
			}
			//as changing images' path in db , server needs to reload images' datasource 
			$images = $image_mapper->getAll();
			//Zend_Debug::dump( $products);die();
			$this->view->images = $images;
			
		}
    }
	
	public function upload1Action(){
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
					if($size<(1024*1024*50)){
						$imgn = time().".".$ext;
						if(is_uploaded_file($tmp)){
							if(move_uploaded_file($tmp, "uploads/".$imgn)){
								//echo "File Name: ".$_FILES['file']['name'];
								//echo "<br/>File Temporary Location : ".$_FILES['file']['tmp_name'];
								//echo "<br/>File Location : ". "/uploads/". $imgn."'" ;
								//echo "<br/>File Size : ".$_FILES['file']['size'];
								//echo "<br/>File Type : ".$_FILES['file']['type'];
								echo "<br/><img style='margin-left:10px;' src='/uploads/".$imgn."'>";
								//echo "<br/><input name='img_uploaded' type='hidden' value='/uploads/".$imgn."'/>";
								echo "<script type='text/javascript'> $(document).ready(function() {console.log('aaaaa'); $('#img_uploaded1').val('/uploads/".$imgn."'); }  );</script>";
							}else{
							 echo "Uploading Failed.";
							}
						
						}
						
				   } else{
					echo "Image File Size Max 50 MB";
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
	
	
	public function upload2Action(){
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
					if($size<(1024*1024*50)){
						$imgn = time().".".$ext;
						if(is_uploaded_file($tmp)){
							if(move_uploaded_file($tmp, "uploads/".$imgn)){
								//echo "File Name: ".$_FILES['file']['name'];
								//echo "<br/>File Temporary Location : ".$_FILES['file']['tmp_name'];
								//echo "<br/>File Location : ". "/uploads/". $imgn."'" ;
								//echo "<br/>File Size : ".$_FILES['file']['size'];
								//echo "<br/>File Type : ".$_FILES['file']['type'];
								echo "<br/><img style='margin-left:10px;' src='/uploads/".$imgn."'>";
								//echo "<br/><input name='img_uploaded' type='hidden' value='/uploads/".$imgn."'/>";
								echo "<script type='text/javascript'> $(document).ready(function() {console.log('aaaaa'); $('#img_uploaded2').val('/uploads/".$imgn."'); }  );</script>";
							}else{
								echo "Uploading Failed.";
							}
	
						}
	
					} else{
						echo "Image File Size Max 50 MB";
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

	public function upload3Action(){
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
					if($size<(1024*1024*50)){
						$imgn = time().".".$ext;
						if(is_uploaded_file($tmp)){
							if(move_uploaded_file($tmp, "uploads/".$imgn)){
								//echo "File Name: ".$_FILES['file']['name'];
								//echo "<br/>File Temporary Location : ".$_FILES['file']['tmp_name'];
								//echo "<br/>File Location : ". "/uploads/". $imgn."'" ;
								//echo "<br/>File Size : ".$_FILES['file']['size'];
								//echo "<br/>File Type : ".$_FILES['file']['type'];
								echo "<br/><img style='margin-left:10px;' src='/uploads/".$imgn."'>";
								//echo "<br/><input name='img_uploaded' type='hidden' value='/uploads/".$imgn."'/>";
								echo "<script type='text/javascript'> $(document).ready(function() {console.log('aaaaa'); $('#img_uploaded3').val('/uploads/".$imgn."'); }  );</script>";
							}else{
								echo "Uploading Failed.";
							}
	
						}
	
					} else{
						echo "Image File Size Max 50 MB";
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
	
	public function upload4Action(){
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
					if($size<(1024*1024*50)){
						$imgn = time().".".$ext;
						if(is_uploaded_file($tmp)){
							if(move_uploaded_file($tmp, "uploads/".$imgn)){
								//echo "File Name: ".$_FILES['file']['name'];
								//echo "<br/>File Temporary Location : ".$_FILES['file']['tmp_name'];
								//echo "<br/>File Location : ". "/uploads/". $imgn."'" ;
								//echo "<br/>File Size : ".$_FILES['file']['size'];
								//echo "<br/>File Type : ".$_FILES['file']['type'];
								echo "<br/><img style='margin-left:10px;' src='/uploads/".$imgn."'>";
								//echo "<br/><input name='img_uploaded' type='hidden' value='/uploads/".$imgn."'/>";
								echo "<script type='text/javascript'> $(document).ready(function() {console.log('aaaaa'); $('#img_uploaded4').val('/uploads/".$imgn."'); }  );</script>";
							}else{
								echo "Uploading Failed.";
							}
	
						}
	
					} else{
						echo "Image File Size Max 50 MB";
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
	
	protected function _getExtension($str){
		$i=strrpos($str,".");
		if(!$i){
			return"";
		}
		$l=strlen($str)-$i;
		$ext=substr($str,$i+1,$l);
		return $ext;
	}
    
}

