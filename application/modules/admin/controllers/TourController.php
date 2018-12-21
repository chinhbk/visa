<?php

class Admin_TourController extends Zend_Controller_Action
{
    
    private static $PRICE_GROUP_ID = 10;
    private static $PRICE_PRIVATE_ID = 11;
    private static $HOMESTAY_DORM_ID = 0;
    private static $HOMESTAY_PRIVATE_ID = 1;
    private static $HOTEL_2_STAR_ID = 2;
    private static $HOTEL_3_STAR_ID = 3;
    private static $HOTEL_4_STAR_ID = 4;
    private static $HOTEL_5_STAR_ID = 5;
    private static $CRUISE_3_STAR_ID = 6;
    private static $CRUISE_4_STAR_ID = 7;
    private static $CRUISE_4_PLUS_STAR_ID = 8;
    private static $CRUISE_5_STAR_ID = 9;
    
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
        //Zend_Debug::dump( $tour_type_id);die();
        if(!isset($tour_type_id)){
            $tour_type_id = $tour_type[0]->id;
        }
        $sub_tour_type = $tour_type_mapper->getAllTourType($tour_type_id);
        //Zend_Debug::dump( $sub_tour_type);die();
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
            //Zend_Debug::dump($request->getParam('img_uploaded_images'));die();
/*             foreach($request->getParam('img_uploaded_images') as $val){
                echo $val;
            }
            die; */
            //Zend_Debug::dump($request->getParam('from_pax_type_1'));die();
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
			$tour->image = (strlen($request->getParam('img_uploaded_images')) == 0 ? null : $request->getParam('img_uploaded_images')) ;
			$tour->price = $request->getParam('price');
			$tour->price_type = $request->getParam('price_type');
			$tour->is_hot = $request->getParam('is_hot');
			$tour->is_show_on_home_page = $request->getParam('is_show_on_home_page');
			$tour->color = $request->getParam('color');
			$tour->details = $request->getParam('editor_contents');
			$tour->create_date = $this->_helper->CommonUtils->getVnDateTime();;
			$tour->update_date = $this->_helper->CommonUtils->getVnDateTime();;			
			
			//processing price type
			$this->_savePriceGroup($request, $tour_type->id);			
			
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
	
	protected function _savePriceGroup($request, $tour_type_id){
	    $price_type = $request->getParam('price_type');
	    
	    //$price_pax_type_1_arr = $request->getParam('from_pax_type_1_group'.$price_type);
	    $to_pax_arr = $request->getParam('to_pax_type_'.$price_type);
	    $price_pax_arr = $request->getParam('price_pax_type_'.$price_type);
	    //Zend_Debug::dump($price_pax_arr); die;
	    $tour_price_group_detail_mapper = new Application_Model_TourPriceGroupDetailMapper();
	    //price_pax_type_1_group
	    if($price_type == 1) {
	        $from_pax_type_1_group_arr = $request->getParam('from_pax_type_1_group');
	        $to_pax_type_1_group_arr = $request->getParam('to_pax_type_1_group');
	        $price_pax_type_1_group_arr = $request->getParam('price_pax_type_1_group');
	        
	        //Zend_Debug::dump($to_pax_type_1_group_arr); die;
	        
	        $from_pax_type_1_private_arr = $request->getParam('from_pax_type_1_private');
	        $to_pax_type_1_private_arr = $request->getParam('to_pax_type_1_private');
	        $price_pax_type_1_private_arr = $request->getParam('price_pax_type_1_private');
	        $this->_saveTourPriceGroupDetail(10,  $tour_type_id, $price_pax_type_1_group_arr, $from_pax_type_1_group_arr, $to_pax_type_1_group_arr);
	        if($request->getParam('private_tour') == 1){ //tick checbox private tour
	            $this->_saveTourPriceGroupDetail(11,  $tour_type_id, $price_pax_type_1_private_arr, $from_pax_type_1_private_arr, $to_pax_type_1_private_arr);
	        }
	    } else if($price_type == 2 ||$price_type == 3 ){
	        $groupId = $price_type == 2 ? [0, 1, 2, 3, 4, 5] : [6, 7, 8, 9]; // ~ Homestay/dorm room --> 5* hotel
	        //Zend_Debug::dump($price_pax_arr); die;
	        for($i=0; $i < sizeof($price_pax_arr); $i++ ){
	            if(strlen(trim($price_pax_arr[$i])) > 0){
	                $detail = new Application_Model_TourPriceGroupDetail();
	                $detail->tour_type_id = $tour_type_id;
	                $detail->tour_price_group_id = $groupId[$i];
	                $detail->price = $price_pax_arr[$i];
	                $detail->order = $i;
	                $tour_price_group_detail_mapper->save($detail);
	            }
	        }
	        
	        //addtional prices
	        if($price_type == 2){
	            $price_group_mapper = new Application_Model_TourPriceGroupMapper();
	            $groups = $price_group_mapper->getAll();//Application_Model_TourPriceGroup
	            
	            $additional_price_text_arr =  $request->getParam('additional_price_text');
	            $additional_price =  $request->getParam('additional_price');
	            //Zend_Debug::dump($additional_price); die;
	            for($i=0; $i < sizeof($additional_price); $i++ ){
	                if(strlen(trim($price_pax_arr[$i])) > 0){
	                    //check then add new group price
	                    $group_id = $this->_getByPriceGroupName($groups, $additional_price_text_arr[$i]);
	                    if($group_id == null){
	                        $new_price_group = new Application_Model_TourPriceGroup();
	                        $new_price_group->name = $additional_price_text_arr[$i];
	                        $price_group_mapper->save($new_price_group);
	                        $group_id = $new_price_group->id;
	                    }
	                    
	                    $detail = new Application_Model_TourPriceGroupDetail();
	                    $detail->tour_type_id = $tour_type_id;
	                    $detail->tour_price_group_id = $group_id;
	                    $detail->price = $additional_price[$i];
	                    $detail->is_add_price = 1;
	                    $detail->order =  sizeof($price_pax_arr) + $i + 1; // from order of last price in $price_arr
	                    $tour_price_group_detail_mapper->save($detail);
	                }
	            }
	        }
	    }
	}
	
	
	protected function _getByPriceGroupName($arr, $name){
	    foreach($arr as $group){
	        if($group->name == $name){
	            return $group->id;
	        }
	    }
	    return null;
	}
	
	protected function _saveTourPriceGroupDetail($priceGroupId, $tour_type_id, $price_arr, $from_pax_arr, $to_pax_arr){
	    $mapper = new Application_Model_TourPriceGroupDetailMapper();
	    for($i=0; $i < sizeof($price_arr); $i++ ){
	        $detail = new Application_Model_TourPriceGroupDetail();	        
	        $detail->tour_type_id = $tour_type_id;
	        $detail->tour_price_group_id = $priceGroupId;
	        $detail->from_pax = $from_pax_arr[$i];
	        $detail->to_pax = $to_pax_arr[$i];
	        //to pax can be null or empty
	        if(strlen(trim($to_pax_arr[$i])) == 0){
	            $detail->to_pax = null;
	        }
	        $detail->price = $price_arr[$i];
	        $detail->order = $i;	        
	        $mapper->save($detail);
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
		if(strlen($tour->image) > 0){
    		$str =  str_replace('[', '', $tour->image);
    		$str =  str_replace(']', '', $str);
    		$str =  str_replace('"', '', $str);
    		//$str =  str_replace(',', '', $str);
    		//Zend_Debug::dump(explode(',', $str));die();
    		$tour->image = explode(',', $str);
		} else {
		    $tour->image = array();
		}
		//Zend_Debug::dump($tour);die();
		
		//processing price group
		$tour_price_group_detail_mapper = new Application_Model_TourPriceGroupDetailMapper();
		$price_arr = $tour_price_group_detail_mapper->getByTourIdAndOrGroupIds($tour->tour_type_id);
		
		$type_1_group = array();
		$type_1_private = array();
		$type_2 = array();
		$type_2_add_price = array();
		$type_3 = array();
		//$tour->price_arr = $price_arr;
		if($tour->price_type == 1) {
		    //$groupIds = self::$GROUP_PRIVATE_IDS;
		    //Zend_Debug::dump($price_arr);die;
		    $type_1_group = array();
		    $type_1_private = array();
		    foreach($price_arr as $p){
		        $p->tour_price_group_id == self::$PRICE_GROUP_ID ? array_push($type_1_group, $p) : array_push($type_1_private, $p);
		    }
		    //Zend_Debug::dump($type_1_group);die;
		} else {
		    $groupId = $tour->price_type == 2 ? [0, 1, 2, 3, 4, 5] : [6, 7, 8, 9]; // ~ Homestay/dorm room --> 5* hotel
		    foreach($price_arr as $p){
		        if($p->tour_price_group_id >= 0 && $p->tour_price_group_id <= 5){
		            array_push($type_2, $p);
		        } else if($p->is_add_price == 1){
		            array_push($type_2_add_price, $p);
		        } else {
		            array_push($type_3, $p);
		        }
		    }
		}
		
		$this->view->tour = $tour;
		$this->view->type_1_group= $type_1_group;
		$this->view->type_1_private= $type_1_private;
		$this->view->type_2= $type_2;
		$this->view->type_2_add_price= $type_2_add_price;
		$this->view->type_3= $type_3;
		$this->view->HOMESTAY_DORM_ID = self::$HOMESTAY_DORM_ID;
		$this->view->HOMESTAY_PRIVATE_ID = self::$HOMESTAY_PRIVATE_ID;
		$this->view->HOTEL_2_STAR_ID = self::$HOTEL_2_STAR_ID;
		$this->view->HOTEL_3_STAR_ID = self::$HOTEL_3_STAR_ID;
		$this->view->HOTEL_4_STAR_ID = self::$HOTEL_4_STAR_ID;
		$this->view->HOTEL_5_STAR_ID = self::$HOTEL_5_STAR_ID;
		$this->view->CRUISE_3_STAR_ID = self::$CRUISE_3_STAR_ID;
		$this->view->CRUISE_4_STAR_ID = self::$CRUISE_4_STAR_ID;
		$this->view->CRUISE_4_PLUS_STAR_ID = self::$CRUISE_4_PLUS_STAR_ID;
		$this->view->CRUISE_5_STAR_ID = self::$CRUISE_5_STAR_ID;
		
		$tourType_mapper = new Application_Model_TourTypeMapper();
		$sub_tour_type = $tourType_mapper->getById($id);
		$this->view->sub_tour_type= $sub_tour_type;
		//Zend_Debug::dump( $sub_tour_type);die();
		
		//$this->view->sub_tour_types = $tourType_mapper->getAllTourType($sub_tour_type->parent_id);
		$tour_type = $tourType_mapper->getAllTourType(null);
		$this->view->tour_type= $tour_type;
		
		
		//$selected_tour_type = $tourType_mapper->getById($sub_tour_type->parent_id);
		$selected_sub_tour_type =  $tourType_mapper->getById($sub_tour_type->parent_id);
		$this->view->sub_tour_types = $tourType_mapper->getAllTourType($selected_sub_tour_type->parent_id);
		
		$selected_tour_type =  $tourType_mapper->getById($selected_sub_tour_type->parent_id);
		$this->view->tour_types = $tourType_mapper->getAllTourType($selected_tour_type->parent_id);
		$this->view->selected_tour_type = $selected_tour_type;
		//Zend_Debug::dump(  $tourType_mapper->getAllTourType($selected_tour_type->parent_id));die();
		
		//Application_Model_TourPriceGroupDetail
		if ($request->isPost()) {
			//Zend_Debug::dump(  $request->getPost());die();
			$tour = new Application_Model_Tour();
			$tour->tour_type_id =  $request->getParam('id');
			if(strlen($request->getParam('name')) == 0 || strlen($request->getParam('short_desc')) == 0 || $request->getParam('sub_tour_type_id')  == 0){
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
			$tour_type->parent_id = $request->getParam('sub_tour_type_id');
			$tour_type_mapper = new Application_Model_TourTypeMapper();
			$tour_type_mapper->save($tour_type);
			
			$tour = new Application_Model_Tour();
			$tour->tour_type_id = $id;
			$tour->short_desc = $request->getParam('short_desc');
			$tour->code =  $request->getParam('code');
			$tour->duration =  $request->getParam('duration');
			$tour->image_small =  $request->getParam('img_uploaded');
			$tour->image = (strlen($request->getParam('img_uploaded_images')) == 0 ? null : $request->getParam('img_uploaded_images')) ;
			$tour->price = $request->getParam('price');
			$tour->price_type = $request->getParam('price_type');
			$tour->is_hot = $request->getParam('is_hot');
			$tour->is_show_on_home_page = $request->getParam('is_show_on_home_page');
			$tour->color = $request->getParam('color');
			$tour->details = $request->getParam('editor_contents');
			$tour->create_date = $this->_helper->CommonUtils->getVnDateTime();;
			$tour->update_date = $this->_helper->CommonUtils->getVnDateTime();;
			
			//processing price type; delete all prices linked to tour_id , then add new
			$tour_price_group_detail_mapper = new Application_Model_TourPriceGroupDetailMapper();
			$tour_price_group_detail_mapper->deleteByTourTypeId($tour_type->id);
			$this->_savePriceGroup($request, $tour_type->id);
			
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
	
	public function uploadImagesAction(){
	    $this->_helper->layout()->disableLayout(); //  shuts off of the layout
	    $this->_helper->viewRenderer->setNoRender();// stop automatic rendering
	    
	    $files=array();
	    $errors=array();
	    $formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
	    //Zend_Debug::dump( $request);die();
	    if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
	        // Count # of uploaded files in array
	        $total = count($_FILES['file']['name']);
	        // Loop through each file
	        for( $i=0 ; $i < $total ; $i++ ) {
	            $name = $_FILES['file']['name'][$i];
	            $size = $_FILES['file']['size'][$i];
	            $tmp  = $_FILES['file']['tmp_name'][$i];
    	        //echo $name .'--'. $size. '--'.$tmp;
    	        //die();
    	        if(strlen($name)){
    	            $ext = $this->_getExtension($name);
    	            
    	            //die( is_uploaded_file($tmp));
    	            if(in_array($ext,$formats)){
    	                if($size<(1024*1024*5)){
    	                    $imgn = time().$i.".".$ext;
    	                    if(is_uploaded_file($tmp)){
    	                        if(move_uploaded_file($tmp, "uploads/".$imgn)){
    	                            //echo "File Name: ".$_FILES['file']['name'];
    	                            //echo "<br/>File Temporary Location : ".$_FILES['file']['tmp_name'];
    	                            //echo "<br/>File Location : ". "/uploads/". $imgn."'" ;
    	                            //echo "<br/>File Size : ".$_FILES['file']['size'];
    	                            //echo "<br/>File Type : ".$_FILES['file']['type'];
    	                            array_push($files,'/uploads/' . $imgn);
    	                            //echo "<br/><input name='img_uploaded' type='hidden' value='/uploads/".$imgn."'/>";    	                            
    	                        }else{
    	                            array_push($errors, $name);
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
	        $result = array('files' => $files, 'errors' => $errors);
	        echo json_encode($result);
	    }
	}
	
	public function deleteFileAction(){	    
	    $this->_helper->layout()->disableLayout(); //  shuts off of the layout
	    $this->_helper->viewRenderer->setNoRender();// stop automatic rendering
	    if (array_key_exists('delete_file', $_POST)) {
	        $filename = APPLICATION_PATH.'/..'.$_POST['delete_file'];
	        //echo $filename; die;
	        if (file_exists($filename)) {
	            unlink($filename);
	            echo 'File '.$filename.' has been deleted';
	        } else {
	            echo 'Could not delete '.$filename.', file does not exist';
	        }
	    }
	}
	
	public function upload2Action(){
		$this->_helper->layout()->disableLayout(); //  shuts off of the layout
		$this->_helper->viewRenderer->setNoRender();// stop automatic rendering
			
		$formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
		//Zend_Debug::dump( $request);die();
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

