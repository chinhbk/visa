<?php

class Admin_OrderController extends Zend_Controller_Action
{

    public function init()
    {
		$auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            // Identity exists; get it
            $identity = $auth->getIdentity();
            if($identity->ROLE == 0 || $identity->ROLE == 2){
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
    	$status = (empty($_REQUEST['status']) ? 0 : $_REQUEST['status']);// default
    	$sort_update_date = (empty($_REQUEST['sort_update_date']) ? 'DESC' : $_REQUEST['sort_update_date']);
    	
    	$name = $request->getParam('name');
    	//echo $status; die;
    	//die($category_id == null);    
    	
    	$this->view->status = $status;
    	$this->view->name = $name;
    	$this->view->sort_update_date = $sort_update_date;
    
    	
		$order_mapper = new Application_Model_OrderMapper();
		$orders = $order_mapper->search($status, $name, $sort_update_date);
		//Zend_Debug::dump( $orders);die();
		$this->view->orders = $orders;
    }
	
	
	public function editAction(){
		$request = $this->getRequest();
		//Zend_Debug::dump( $request);die();
		$id = $request->getParam('id');
		//die($id);
		$order_mapper = new Application_Model_OrderMapper();
		$order = $order_mapper->getOrderById($id);
		//Zend_Debug::dump( $product);die();
		//$product->content = htmlspecialchars_decode($product->content);
		//Zend_Debug::dump( $product);die();
		$this->view->order = $order ;
				
		$order_detai_mapper = new Application_Model_OrderDetailMapper();
		$order_detail_list = $order_detai_mapper->get($order->id);
		$this->view->order_detail_list = $order_detail_list;
		//echo Zend_Registry::getInstance()->constants->shipping_cost;die;
		//Zend_Debug::dump( $order_detail_list);die();
		
		if ($request->isPost()) {
			//Zend_Debug::dump(  $request->getPost());die();
			$order = new Application_Model_Order();
			$order->id =  $request->getParam('id');
			$order->status =  $request->getParam('status');
			$order->is_ship =  $request->getParam('is_ship');
			$order->ship_code = null;
			$order->update_date = $this->_helper->CommonUtils->getVnDateTime();
			if($order->status == 6 && $order->is_ship == 1){
				$order->ship_code = $request->getParam('ship_code');;
			}
					
			//Zend_Debug::dump($product);die();
			$order_mapper = new Application_Model_OrderMapper();
			$order_mapper->change($order);
			$this->redirect('admin/order/index');		
		}
	}

}

