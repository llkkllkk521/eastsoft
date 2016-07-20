<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of order of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     order 
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class order extends control
{
    /**
     * Order confirm page.
     * 
     * @param  int    $product 
     * @param  int    $count 
     * @access public
     * @return void
     */
    public function confirm($product = 0, $count = 0)
    {
        $this->loadModel('product');
        $this->app->loadLang('cart');
        $referer    = helper::safe64Encode(inlink('confirm', "product={$product}&count={$count}"));
        $mobileURL  = helper::createLink('order', 'confirm', "product=$product&count=$count", '', 'mhtml');
        $desktopURL = helper::createLink('order', 'confirm', "product=$product&count=$count", '', 'html');

        if($_POST) $referer = helper::safe64Encode($this->createLink('cart', "browse"));
        if($this->app->user->account == 'guest') $this->locate($this->createLink('user', 'login', "referer={$referer}"));

        if($_POST) $product = $this->post->product;
        $this->view->products = $this->order->getPostedProducts($product, $count);

        $paymentList = explode(',', $this->config->shop->payment);
        foreach($paymentList as $payment)
        {
            $paymentOptions[$payment] = $this->lang->order->paymentList[$payment];
        }

        $this->view->title          = $this->lang->order->confirm;
        $this->view->paymentList    = $paymentOptions;
        $this->view->addresses      = $this->loadModel('address')->getListByAccount($this->app->user->account);
        $this->view->currencySymbol = $this->config->product->currencySymbol;
        $this->view->mobileURL      = $mobileURL;
        $this->view->desktopURL     = $desktopURL;
        $this->display();
    }

    /**
     * Create an order.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        $return = $this->order->create();
        /* If return is array send it directly. */
        if(is_array($return)) $this->send($return);

        /* IF payment is alipay, goto pay page. */
        if(is_numeric($return) and $return) $orderID = $return;
        $order = $this->order->getByID($orderID);

        if(empty($order)) $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        if($order->payment != 'COD') 
        {
            $this->send(array('result' => 'success', 'payLink' => $this->order->createPayLink($order)));
        }

        $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
    }
 
    /**
     * Admin orders in my order.
     * 
     * @access public
     * @return void
     */
    public function admin($mode = 'status', $value = 'normal', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 0,  $pageID = 1)
    {
        if(!commonModel::isAvailable('shop')) unset($this->lang->order->menu->express);
        $this->app->loadClass('pager', $static = true);
        $this->app->loadLang('product');
        $this->app->loadConfig('product');

        $pager = new pager($recTotal, $recPerPage, $pageID);
        $this->view->orders  = $this->order->getList($mode, $value, $orderBy, $pager);
        $this->view->pager   = $pager;
        $this->view->orderBy = $orderBy;
        $this->view->mode    = $mode;
        $this->view->value   = $value;

        $this->view->title          = $this->lang->order->admin;
        $this->view->currencySymbol = $this->config->product->currencySymbol;
        
        $this->display();
    }

    /**
     * Track order delivery.
     * 
     * @param  int    $ordeID 
     * @access public
     * @return void
     */
    public function track($orderID)
    {
        $order = $this->order->getByID($orderID);
        if($order->account != $this->app->user->account) die();
        $this->view->order       = $order;
        $this->view->title       = $this->lang->order->track;
        $this->view->expressList = $this->loadModel('tree')->getPairs(0, 'express');

        $address = json_decode($order->address);
        $this->view->subtitle    = "<span class='text-important'>{$address->contact} [{$address->phone}] {$address->address} {$address->zipcode}</span>";
        $this->view->fullAddress = $this->view->subtitle;
        $this->view->mobileURL   = helper::createLink('order', 'track', "orderID=$orderID", '', 'mhtml');
        $this->view->desktopURL  = helper::createLink('order', 'track', "orderID=$orderID", '', 'html');

        $this->display();
    
    }

    /**
     * Pay order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function pay($orderID)
    {
        $order = $this->order->getByID($orderID);
        if($order->payStatus == 'paid') die($this->lang->order->statusList['paid']);
 
        if($_POST)
        {
            $result = $this->order->pay($orderID);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
            $this->send(array('result' => 'fail', 'message' => dao::geterror()));
        }

        $this->view->order       = $order;
        $this->view->title       = $this->lang->order->return;
        $this->view->subtitle    = "<span class='text-danger'>$order->account : $order->amount</span>";
        $this->view->expressList = $this->loadModel('tree')->getOptionMenu('express');
        $this->display();
    }

    /**
     * Delivery order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function delivery($orderID)
    {
        $order = $this->order->getByID($orderID);
        if($order->payment != 'COD' and $order->payStatus != 'paid') die($this->lang->order->statusList['not_paid']);
        if($order->payment == 'COD' and $order->deliveryStatus != 'not_send') die($this->lang->order->statusList['send']);

        if($_POST)
        {
            if($order->payment == 'alipaySecured') $this->order->postDeliveryToAlipay($order);
            $result = $this->order->delivery($orderID);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin')));
            $this->send(array('result' => 'fail', 'message' => dao::geterror()));
        }

        $this->view->order       = $order;
        $this->view->title       = $this->lang->order->delivery;
        $this->view->expressList = $this->loadModel('tree')->getOptionMenu('express');

        $address = json_decode($order->address);
        $this->view->subtitle = "<span class='text-important'>{$address->contact} [{$address->phone}] {$address->address} {$address->zipcode}</span>";

        $this->display();
    }

    /**
     * Confirm delivery.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function cancel($orderID)
    {
        $order = $this->order->getByID($orderID);

        if($order->deliveryStatus != 'send' and $order->payStatus != 'paid') 
        {
            $result =  $this->order->cancel($orderID);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->order->cancelSuccess));
            $this->send(array('result' => 'fail', 'message' => dao::geterror()));
        }
        $this->send(array('result' => 'fail', 'message' => $lang->fail));
    }


    /**
     * Confirm delivery.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function confirmDelivery($orderID)
    {
        $result =  $this->order->confirmDelivery($orderID);
        if($result) $this->send(array('result' => 'success', 'message' => $this->lang->order->deliveryConfirmed));
        $this->send(array('result' => 'fail', 'message' => dao::geterror()));
    }

    /**
     * Browse orders in my order.
     * 
     * @access public
     * @return void
     */
    public function browse($recTotal = 0, $recPerPage = 0, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        $this->view->orders = $this->order->getList('account', $this->app->user->account, 'id_desc', $pager);
        $this->view->pager  = $pager;

        $this->app->loadLang('product');
        $this->app->loadConfig('product');
        $this->view->currencySymbol = $this->config->product->currencySymbol;

        $this->view->title      = $this->lang->order->browse;
        $this->view->mobileURL  = helper::createLink('order', 'browse', '', '', 'mhtml');
        $this->view->desktopURL = helper::createLink('order', 'browse', '', '', 'html');
        $this->display();
    }
   
    /**
     * Process order.
     * 
     * @param  string $type
     * @param  string $mode
     * @access public
     * @return object
     */
    public function processOrder($type = 'alipay', $mode = 'return')
    {
        if($type == 'alipay') $this->processAlipayOrder($mode);
    }

    /**
     * Process alipay order.
     * 
     * @param  string $mode 
     * @access public
     * @return void
     */
    public function processAlipayOrder($mode = 'return')
    {
        $this->app->loadClass('alipay', true);
        $alipay = new alipay($this->config->alipay);

        /* Get the orderID from the alipay. */
        $order = $this->order->getOrderFromAlipay($mode);
        if(empty($order)) die('STOP!');

        /* Process the order. */
        $result = $this->order->processOrder($order);

        /* Notify mode. */
        if($mode == 'notify')
        {
            $this->order->saveAlipayLog();
            if($result) die('success');
            die('fail');
        }

        /* Return model. */
        $order = $this->order->getOrderByRawID($order->id);

        $this->view->order  = $order;
        $this->view->result = $result;

        $this->display('order', 'processorder'); 
    }
     
    /**
     * setStatus 
     * 
     * @param  string    $orderID 
     * @access public
     * @return void
     */
    public function finish($orderID)
    {
        $order = $this->order->getByID($orderID);
        if($order->status == 'finished') die($this->lang->order->statusList[$order->status]);
        if($order->payStatus != 'paid') die($this->lang->order->statusList[$order->payStatus]);
        if($order->deliveryStatus == 'not_send') die($this->lang->order->statusList[$order->deliveryStatus]);
        $result = $this->order->finish($orderID);
        if($result) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
        $this->send(array('result' => 'fail', 'message' => dao::geterror()));
    }

    /**
     * setting function.
     * 
     * @access public
     * @return void
     */
    public function setting()
    {
        if(!commonModel::isAvailable('shop'))
        {
            unset($this->lang->order->menu->express);
            unset($this->lang->order->paymentList['COD']);
        }

        if($_POST)
        {
            $return = $this->order->saveSetting();
            $this->send($return);
        }
        $this->display();
    }

    /**
     * Redirect to payLink.
     * 
     * @access public
     * @return void
     */
    public function redirect()
    {
        die(js::locate($this->post->payLink));
    }
}
