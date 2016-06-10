<?php
class Mss_MageOptimize_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("MageOptimize"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("mageoptimize", array(
                "label" => $this->__("MageOptimize"),
                "title" => $this->__("MageOptimize")
		   ));

      $this->renderLayout(); 
	  
    }
}