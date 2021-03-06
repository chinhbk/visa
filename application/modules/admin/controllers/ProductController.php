<?php

class Admin_ProductController extends Zend_Controller_Action
{

    public function init()
    {
		$auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            // Identity exists; get it
            $identity = $auth->getIdentity();
            if($identity->ROLE == 0 || $identity->ROLE == 1){
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
    	$product_type_id = $request->getParam('product_type_id');
    	$sub_product_type_id = $request->getParam('sub_product_type_id');
    	//die($category_id == null);    
    	
    	$this->view->product_type_id = $product_type_id;
    	$this->view->sub_product_type_id = $sub_product_type_id;    	
    	
		$product_mapper = new Application_Model_ProductMapper();
		$products = $product_mapper->getAllNameAndImageMainProducts($product_type_id, $sub_product_type_id, 50);
		//Zend_Debug::dump( $products);die();
		$this->view->products = $products;
		
		$productType_mapper = new Application_Model_ProductTypeMapper();
		$product_type = $productType_mapper->getAllProductType(null);
		//Zend_Debug::dump( $product_type);die();
		$this->view->product_type= $product_type;
		
		$sub_product_type = $productType_mapper->getAllProductType($product_type_id);
		$this->view->sub_product_type= $sub_product_type;
    }
	
	public function addAction(){
		
		$productType_mapper = new Application_Model_ProductTypeMapper();
		$product_type = $productType_mapper->getAllProductType(null);
		$this->view->product_type= $product_type;
	
		$request = $this->getRequest();
		//Zend_Debug::dump( $request->getParam('is_hot'));die();
        if ($request->isPost()) {
		//Zend_Debug::dump(  $request->getPost());die();
        	$product = new Application_Model_Product();
			$product->name =  $request->getParam('name');
			$product->code =  $request->getParam('code');
			$product->image_main =  $request->getParam('img_uploaded');
			$product->image_second = (strlen($request->getParam('img_uploaded2')) == 0 ? null : $request->getParam('img_uploaded2')) ;
			$product->image_third =  (strlen($request->getParam('img_uploaded3')) == 0 ? null : $request->getParam('img_uploaded3')) ;;
			$product->price = $request->getParam('price');
			$product->discount_price = (strlen($request->getParam('discount_price')) == 0 ? null : strlen($request->getParam('discount_price')) );
			$product->promotion = $request->getParam('promotion');
			$product->product_type_id = $request->getParam('product_type_id');
			$product->sub_product_type_id = $request->getParam('sub_product_type_id');
			$product->editor_contents =  $request->getParam('editor_contents');
			$product->is_hot = $request->getParam('is_hot');
			$product->is_type_priority = $request->getParam('is_type_priority');
			$product->is_subtype_priority = $request->getParam('is_subtype_priority');
			$product->color = $request->getParam('color');
			$product->material = $request->getParam('material');
			$product->origin = $request->getParam('origin');
			$product->short_desc = $request->getParam('short_desc');
			$product->details = $request->getParam('editor_contents');
			if(strlen($product->name) == 0 || strlen($product->image_main) == 0 || strlen($product->price) == 0 || $product->product_type_id == 0){
			   $this->view->errorMessage = 'Lỗi nhập thiếu dữ liệu';
			   return;
			}
			
			//using htmlspecialchars() on the string to put into the DB, and then, when pulling it back out, use htmlspecialchars_decode().
			//$product->content = htmlspecialchars_decode($editor_contents);

			//Zend_Debug::dump($product);die();
			$product_mapper = new Application_Model_ProductMapper();
			$product_mapper->save($product);
			$this->redirect('admin/product/index');
		}
	}
	
	public function getSubProductTypeAction(){
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		if (isset($_POST)) {
			
			$mapper = new Application_Model_ProductTypeMapper();
			$subProductType = $mapper->getAllProductType($_POST['parent_id']);
			echo json_encode($subProductType);
		}
	}
	public function editAction(){
		$request = $this->getRequest();
		//Zend_Debug::dump( $request);die();
		$id = $request->getParam('id');
		//die($id);
		$product_mapper = new Application_Model_ProductMapper();
		$product = $product_mapper->getProductById($id);
		//Zend_Debug::dump( $product);die();
		//$product->content = htmlspecialchars_decode($product->content);
		//Zend_Debug::dump( $product);die();
		$this->view->product = $product ;
		
		$productType_mapper = new Application_Model_ProductTypeMapper();
		$product_type = $productType_mapper->getAllProductType(null);
		$this->view->product_type= $product_type;
		
		$sub_product_type = $productType_mapper->getAllProductType($product->product_type_id);
		$this->view->sub_product_type= $sub_product_type;		
		
		if ($request->isPost()) {
			//Zend_Debug::dump(  $request->getPost());die();
			$product = new Application_Model_Product();
			$product->id =  $request->getParam('id');
			$product->name =  $request->getParam('name');
			$product->code =  $request->getParam('code');
			$product->image_main =  $request->getParam('img_uploaded');
			$product->image_second = (strlen($request->getParam('img_uploaded2')) == 0 ? null : $request->getParam('img_uploaded2')) ;
			$product->image_third =  (strlen($request->getParam('img_uploaded3')) == 0 ? null : $request->getParam('img_uploaded3')) ;;
			$product->price = $request->getParam('price');
			$product->discount_price = (strlen($request->getParam('discount_price')) == 0 ? null : strlen($request->getParam('discount_price')) );
			$product->promotion = $request->getParam('promotion');
			$product->product_type_id = $request->getParam('product_type_id');
			$product->sub_product_type_id = $request->getParam('sub_product_type_id');
			$product->editor_contents =  $request->getParam('editor_contents');
			$product->is_hot = $request->getParam('is_hot');
			$product->is_type_priority = $request->getParam('is_type_priority');
			$product->is_subtype_priority = $request->getParam('is_subtype_priority');
			$product->color = $request->getParam('color');
			$product->material = $request->getParam('material');
			$product->origin = $request->getParam('origin');
			$product->short_desc = $request->getParam('short_desc');
			$product->details = $request->getParam('editor_contents');
			if(strlen($product->name) == 0 || strlen($product->image_main) == 0 || strlen($product->price) == 0 || $product->product_type_id == 0){
				$this->view->errorMessage = 'Lỗi nhập thiếu dữ liệu';
				return;
			}
				
			//using htmlspecialchars() on the string to put into the DB, and then, when pulling it back out, use htmlspecialchars_decode().
			//$product->content = htmlspecialchars_decode($editor_contents);
			
			//Zend_Debug::dump($product);die();
			$product_mapper = new Application_Model_ProductMapper();
			$product_mapper->save($product);
			$this->redirect('admin/product/index');
		
		}
	}
	
	public function deleteAction(){
		$request = $this->getRequest();
		//Zend_Debug::dump( $request);die();
		$id = $request->getParam('id');
		//die($id);
		$product_mapper = new Application_Model_ProductMapper();
		$product = $product_mapper->delete($id);
		$this->redirect('admin/product/index');
	
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
		 
		$formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP", "webp", "WEBP");
	    
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
								echo "<br/><img style='margin-left:10px;' src='/uploads/".$imgn."'>";
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
	
	
	public function upload2Action(){
		$this->_helper->layout()->disableLayout(); //  shuts off of the layout
		$this->_helper->viewRenderer->setNoRender();// stop automatic rendering
			
		$formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP", "webp", "WEBP");
		 
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
								echo "<br/><img style='margin-left:10px;' src='/uploads/".$imgn."'>";
								//echo "<br/><input name='img_uploaded' type='hidden' value='/uploads/".$imgn."'/>";
								echo "<script type='text/javascript'> $(document).ready(function() {console.log('aaaaa'); $('#img_uploaded2').val('/uploads/".$imgn."'); }  );</script>";
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

	public function upload3Action(){
		$this->_helper->layout()->disableLayout(); //  shuts off of the layout
		$this->_helper->viewRenderer->setNoRender();// stop automatic rendering
			
		$formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP", "webp", "WEBP");
			
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
								echo "<br/><img style='margin-left:10px;' src='/uploads/".$imgn."'>";
								//echo "<br/><input name='img_uploaded' type='hidden' value='/uploads/".$imgn."'/>";
								echo "<script type='text/javascript'> $(document).ready(function() {console.log('aaaaa'); $('#img_uploaded3').val('/uploads/".$imgn."'); }  );</script>";
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

