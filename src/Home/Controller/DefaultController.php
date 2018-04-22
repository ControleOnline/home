<?php

namespace Home\Controller;

use Core\Controller\AbstractController;
use User\Model\UserModel;
use Sales\Model\OrderModel;

class DefaultController extends AbstractController {

    public function indexAction() {
        $this->redirect()->toUrl('/home/dashboard/');
        $this->getResponse()->sendHeaders();
        exit;
    }

    public function dashboardAction() {
        $userModel = new UserModel();
        $userModel->initialize($this->serviceLocator);
        if (!$userModel->loggedIn()) {
            return \Core\Helper\View::redirectToLogin($this->_renderer, $this->getResponse(), $this->getRequest(), $this->redirect());
        } else {
            $orderModel = new OrderModel();
            $orderModel->initialize($this->serviceLocator);                                    
            $this->_view->setVariables($orderModel->getOrdersReport($this->params()->fromQuery('start-date'),$this->params()->fromQuery('end-date')));
            return $this->_view;
        }
    }

}
