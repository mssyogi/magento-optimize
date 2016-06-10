<?php

/**
 * Crontab observer.
 *
 * @author Fabrizio Branca
 */
class Mss_MageOptimize_Model_Observer
{
    
    public function beforeLayoutLoad($observer)
    {
        # code...
        # 
        $update = $observer->getLayout()->getUpdate();
        foreach ($update->getHandles() as $_handle) {
            # code...
            if(strpos($_handle, 'CATEGORY_') === 0 || (strpos($_handle, 'PRODUCT_') === 0 
                && strpos($_handle, 'PRODUCT_TYPE_') === false)) {
                $update->removeHandle($_handle);
            }
        }
    }

    # start cacheing the cms block 
    public function OptimizeCMSBlockCache($observer)
    {
        $block = $observer->getBlock();
        if($block instanceof Mage_Cms_Block_Widget_Block
            || $block instanceof Mage_Cms_Block_Block) {

            $cacheKeyData = array(Mage_Cms_Model_Block::CACHE_TAG,
                                    $block->getBlockId(),
                                    Mage::app()->getStore()->getId()
                );
            $block->setCacheKey(implode('_', $cacheKeyData));
            $block->setCacheTags(array(Mage_Cms_Model_Block::CACHE_TAG));
            #  null       not cache
            #  false /0   - forever
            #  > 0          for secs 
            $block->getCacheLifetime(false);   

        }      

        $this->optimizeNavigationCache($block);
    }

    public function optimizeNavigationCache($observer) { 
        $block = $observer;
        if ($block instanceof Mage_Page_Block_Html_Topmenu) 
        { 
                $cacheKeyData = array( Mage_Catalog_Model_Category::CACHE_TAG, 'NAVIGATION', Mage::app()->getStore()->getCode() );
                $block->setCacheKey(implode('_', $cacheKeyData));
                $block->setCacheTags( array(Mage_Catalog_Model_Category::CACHE_TAG) );
                $block->setCacheLifetime(false);
        } 
    }
        
}
