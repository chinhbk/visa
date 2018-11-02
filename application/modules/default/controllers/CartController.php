<?php

class CartController extends Zend_Controller_Action
{

    public function init()
    {
		$product_type_mapper = new Application_Model_ProductTypeMapper();
		$menu_types = $product_type_mapper->getAllProductType2();
		//Zend_Debug::dump( $types);die();
		$this->view->menuTypes = $menu_types;
    }

    public function indexAction()
    {
    	if(isset($_POST['quantity'])){
    		//Zend_Debug::dump( $_POST);die();
    		foreach($_POST['quantity'] as $key => $val) {
    			if($val==0) {
    				unset($_SESSION['userCartSession'][$key]);
    			}else{
    				$_SESSION['userCartSession'][$key]['quantity']=$val;
    			}
    		}    	
    	}    	

    	if(isset($_POST['form_product_order'])){
    		$order = new Application_Model_Order();
    		$order->name =  $_POST['name'];
    		$order->phone =  $_POST['phone'];
    		$order->email =  $_POST['email'];
    		$order->province =  $_POST['province'];
    		$order->address =  $_POST['address'];
    		$order->is_ship =  $_POST['is_ship'];
    		$order->note =  $_POST['note'];
    		$order->create_date = $this->_helper->CommonUtils->getVnDateTime();
    		$order->update_date = $this->_helper->CommonUtils->getVnDateTime();
    		
    		if(strlen($order->name) == 0 || strlen($order->phone) == 0 || strlen($order->province) == 0 || strlen($order->address) == 0){
    			$this->view->errorMessage = 'Lỗi nhập thiếu dữ liệu';
    			return;
    		}
    		
    		$order_mapper = new Application_Model_OrderMapper();
    		$order_id = $order_mapper->save($order);
    		
    		$order_detail_mapper = new Application_Model_OrderDetailMapper();
    		foreach($_SESSION['userCartSession'] as $product_id => $value) {
    			$order_detail = new Application_Model_OrderDetail();
    			$order_detail->order_id = $order_id;
    			$order_detail->product_id = $product_id;
    			$order_detail->quantity = $_SESSION['userCartSession'][$product_id]['quantity'];
    			$order_detail->price = $_SESSION['userCartSession'][$product_id]['price'];
    			$order_detail->discount_price = $_SESSION['userCartSession'][$product_id]['discount_price'];
    			$order_detail_mapper->save($order_detail);
    		}
    		
    		//clear cart's session
    		unset($_SESSION['userCartSession']);
    		
    		$this->_helper->redirector('order-success', 'cart');
    		
    		//Zend_Debug::dump($order_id);die();
    	}
    }		
    
    public function addProductToCartAction(){
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	if (isset($_POST)) {
    		//Zend_Debug::dump( $_POST);die();
    		//$userCartSession = new Zend_Session_Namespace('userCartSession');
    		$product_id = $_POST['product_id'];
    		
    		if(isset($_SESSION['userCartSession'][$product_id])){    		
    			$_SESSION['userCartSession'][$product_id]['quantity']++;    		
    		}else{
    			$product_mapper = new Application_Model_ProductMapper();
    			$product = $product_mapper->getProductById($product_id);
    			
    			$_SESSION['userCartSession'][$product->id]=array(
    					"name" => $product->name,
    					"quantity" => 1,
    					"price" => $product->price,
    					"discount_price" => $product->discount_price,
    			);
    		}
    		echo json_encode('ok');
    	}
    }
    
    public function orderSuccessAction(){
    	
    }
}

