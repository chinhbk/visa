<?php

class Admin_TourController extends Zend_Controller_Action
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
    	
    	$keyword = $request->getParam('keyword');
    	$tourType_mapper = new Application_Model_TourTypeMapper();
    	$tour_type = $tourType_mapper->searchByName($keyword);
    	$this->view->keyword = $keyword;
    	//Zend_Debug::dump( $tour_type);die();
    	
    	
    	$tour_type_ids = array();
    	$tour_type_parent_ids = array();
    	$tour = array();
    	if(sizeof($tour_type) != 0){
    	    foreach ($tour_type as $row){
    	        //Zend_Debug::dump( $tour_object);die();
    	        array_push($tour_type_ids, $row->id);
    	        array_push($tour_type_parent_ids, $row->parent_id);
    	    }
    	    
    	    $tour_mapper = new Application_Model_TourMapper();
    	    $tour = $tour_mapper->getByIds($tour_type_ids);
    	    $tour_type_parent = $tourType_mapper->getByIds($tour_type_parent_ids);
    	    //echo 'aaaaaaaaaaaaaaaaaaaaaaa';die;
    	    //Zend_Debug::dump( $tour_type);die();
    	    foreach ($tour as $row){
    	        // $row->name = 'aaaaa';
    	        //fill name of tour
    	        foreach($tour_type as $type){
    	                if($row->tour_type_id == $type->id){
    	                    $row->name = $type->name;
    	                }
    	        }
    	        //fill name of parent tour
    	        foreach($tour_type_parent as $type){
    	            if($row->parent_id == $type->id){
    	                $row->parent_name = $type->name;
    	            }
    	        }
    	    }
    	}
    	
    	$this->view->tour = $tour;
    	//Zend_Debug::dump( $tour);die();
    }
    
    public function menuAction()
    {
        $request = $this->getRequest();
        $tour_type_id = $request->getParam('tour_type_id');        
        $tour_type_mapper = new Application_Model_TourTypeMapper();
        $tour_type = $tour_type_mapper->getAllTourType(null);
        //Zend_Debug::dump( $product_type);die();
        $sub_tour_type = $tour_type_mapper->getAllTourType($tour_type[0]->id);
        //Zend_Debug::dump( $tour_type_id);die();
        if(is_null($tour_type_id)){
            $tour_type_id = $tour_type[0]->id;
            //$request->setParam('tour_type_id', $tour_type_id);    
        }
        $this->view->tour_type_id = $tour_type_id;
        $this->view->tour_type = $tour_type;
        $this->view->sub_tour_type = $sub_tour_type;
        //Zend_Debug::dump($sub_tour_type);die();        
    }
    
    //level 1
    public function saveSubTourTypeAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if (isset($_POST)) {
           // echo json_encode($_POST['name']);die;
            $tour_type = new Application_Model_TourType();
            $tour_type->name = $_POST['name'];
            //edit case
            if(isset($_POST['parent_id'])){
                $tour_type->parent_id = $_POST['parent_id'];
            }           
            if(isset($_POST['id'])){
                $tour_type->id = $_POST['id'];
            }
            $tour_type_mapper = new Application_Model_TourTypeMapper();
            $tour_type_mapper->save($tour_type);
            echo json_encode($tour_type);
        }
    }
    
    public function deleteSubTourTypeAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if (isset($_POST)) {
            // echo json_encode($_POST['name']);die;
            $id = $_POST['id'];
            //check if have any sub tour type            
            $tour_type_mapper = new Application_Model_TourTypeMapper();
            $tour_type = $tour_type_mapper->getAllTourType($id);
            if(sizeof($tour_type) > 0){
                echo json_encode($tour_type); die;
            } else {
                $tour_type_mapper->delete($id);
            }
        }
    }
	
	public function addAction(){
		
		$tourType_mapper = new Application_Model_TourTypeMapper();
		$tour_type = $tourType_mapper->getAllTourType(null);		
		$this->view->tour_type= $tour_type;
		//Zend_Debug::dump( $tour_type);die();
	
		$request = $this->getRequest();
		//Zend_Debug::dump( $request->getParam('is_hot'));die();
        if ($request->isPost()) {
		//Zend_Debug::dump(  $request->getPost());die();
		    if(strlen($request->getParam('name')) == 0 || strlen($request->getParam('short_desc')) == 0 || $request->getParam('sub_tour_type_id')  == 0){
    		    $this->view->errorMessage = 'Please fill data into (*) fields';
    		    return;
    		}
    		if($request->getParam('is_hot') == 1 && strlen($request->getParam('img_uploaded')) == 0){
    		    $this->view->errorMessage = 'A hot tour must have a small image to display on the home page';
    		    return;
    		}
            $tour_type = new Application_Model_TourType();
            $tour_type->name = $request->getParam('name');
            $tour_type->parent_id = $request->getParam('sub_tour_type_id');
            $tour_type_mapper = new Application_Model_TourTypeMapper();
            $tour_type_mapper->save($tour_type);
            
        	$tour = new Application_Model_Tour();
        	$tour->tour_type_id = $tour_type->id;
			$tour->short_desc = $request->getParam('short_desc');
			$tour->code =  $request->getParam('code');
			$tour->duration =  $request->getParam('duration');
			$tour->image_small =  $request->getParam('img_uploaded');
			$tour->image = (strlen($request->getParam('img_uploaded2')) == 0 ? null : $request->getParam('img_uploaded2')) ;
			$tour->price = $request->getParam('price');
			$tour->is_hot = $request->getParam('is_hot');					
			$tour->color = $request->getParam('color');
			$tour->details = $request->getParam('editor_contents');
			$tour->create_date = $this->_helper->CommonUtils->getVnDateTime();;
			$tour->update_date = $this->_helper->CommonUtils->getVnDateTime();;

			
			//using htmlspecialchars() on the string to put into the DB, and then, when pulling it back out, use htmlspecialchars_decode().
			//$tour->content = htmlspecialchars_decode($editor_contents);

			//Zend_Debug::dump($tour);die();
			
			$tour_mapper = new Application_Model_TourMapper();
			$tour_mapper->save($tour, false);
			if($tour->is_hot == 1){
			    //switch is_hot = 0 for all tour have same parent_id
			    //Zend_Debug::dump($tour_type->parent_id);die();
			    $tours = $tour_type_mapper->getAllTourType($tour_type->parent_id);
			    //Zend_Debug::dump($tours);die();
			    foreach ($tours as $t){
			        if($t->id != $tour->tour_type_id){
			            $tour_mapper->changeHot($t->id , 0);
			        }
			    }
			}
			$this->redirect('admin/tour/index');
		}
	}
	
	public function getSubTourTypeAction(){
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		if (isset($_POST)) {
			
			$mapper = new Application_Model_TourTypeMapper();
			$subTourType = $mapper->getAllTourType($_POST['parent_id']);
			echo json_encode($subTourType);
		}
	}
	public function editAction(){
		$request = $this->getRequest();
		//Zend_Debug::dump( $request);die();
		$id = $request->getParam('id');
		//die($id);
		$tour_mapper = new Application_Model_TourMapper();
		$tour = $tour_mapper->getById($id);
		//Zend_Debug::dump( $tour);die();
		//$tour->content = htmlspecialchars_decode($tour->content);
		//Zend_Debug::dump( $tour);die();
		$this->view->tour = $tour;
		
		$tourType_mapper = new Application_Model_TourTypeMapper();
		$sub_tour_type = $tourType_mapper->getById($id);
		$this->view->sub_tour_type= $sub_tour_type;
		//Zend_Debug::dump( $sub_tour_type);die();
		
		
		if ($request->isPost()) {
			//Zend_Debug::dump(  $request->getPost());die();
			$tour = new Application_Model_Tour();
			$tour->tour_type_id =  $request->getParam('id');
		    if(strlen($request->getParam('name')) == 0 || strlen($request->getParam('short_desc')) == 0){
			    $this->view->errorMessage = 'Please fill data into (*) fields';
			    return;
			}
			if($request->getParam('is_hot') == 1 && strlen($request->getParam('img_uploaded')) == 0){
			    $this->view->errorMessage = 'Hot tour must have a small image to display on home page';
			    return;
			}
			$tour_type = new Application_Model_TourType();
			$tour_type->id = $request->getParam('id');
			$tour_type->name = $request->getParam('name');
			$tour_type->parent_id = $request->getParam('tour_type_parent_id');
			$tour_type_mapper = new Application_Model_TourTypeMapper();
			$tour_type_mapper->save($tour_type);
			
			$tour = new Application_Model_Tour();
			$tour->tour_type_id = $id;
			$tour->short_desc = $request->getParam('short_desc');
			$tour->code =  $request->getParam('code');
			$tour->duration =  $request->getParam('duration');
			$tour->image_small =  $request->getParam('img_uploaded');
			$tour->image = (strlen($request->getParam('img_uploaded2')) == 0 ? null : $request->getParam('img_uploaded2')) ;
			$tour->price = $request->getParam('price');
			$tour->is_hot = $request->getParam('is_hot');
			$tour->color = $request->getParam('color');
			$tour->details = $request->getParam('editor_contents');
			$tour->create_date = $this->_helper->CommonUtils->getVnDateTime();;
			$tour->update_date = $this->_helper->CommonUtils->getVnDateTime();;
			
			
			//using htmlspecialchars() on the string to put into the DB, and then, when pulling it back out, use htmlspecialchars_decode().
			//$tour->content = htmlspecialchars_decode($editor_contents);
			
			//Zend_Debug::dump($tour);die();
			
			$tour_mapper = new Application_Model_TourMapper();
			$tour_mapper->save($tour , true);
			if($tour->is_hot == 1){
			    //switch is_hot = 0 for all tour have same parent_id
			    //Zend_Debug::dump($tour_type->parent_id);die();
			    $tours = $tour_type_mapper->getAllTourType($tour_type->parent_id);
			    //Zend_Debug::dump($tours);die();
			    foreach ($tours as $t){
			        if($t->id != $tour->tour_type_id){
			            $tour_mapper->changeHot($t->id , 0);
			        }
			    }
			}
			$this->redirect('admin/tour/index');
		
		}
	}
	
	public function deleteAction(){
		$request = $this->getRequest();
		//Zend_Debug::dump( $request);die();
		$id = $request->getParam('id');
		//die($id);
		$tour_mapper = new Application_Model_TourMapper();
		$tour_mapper->delete($id);
		
		$tour_type_mapper = new Application_Model_TourTypeMapper();
		$tour_type_mapper->delete($id);
		
		$this->redirect('admin/tour/index');
	
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
					if($size<(1024*1024*5)){
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
					echo "Image File Size Max 5 MB";
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
					if($size<(1024*1024*5)){
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
						echo "Image File Size Max 5 MB";
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
					if($size<(1024*1024*5)){
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
						echo "Image File Size Max 5 MB";
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

