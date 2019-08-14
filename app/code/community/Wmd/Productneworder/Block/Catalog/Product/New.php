<?php
/**
 * Wmd_Productneworder_Block_Catalog_Product_New
 *
 * WMD Web-Manufaktur/Digiswiss 
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that you find at http://wmdextensions.com/WMD-License-Community.txt
 *
 * @category  Wmd
 * @package   Wmd_Productneworder
 * @author    Dominik Wyss <info@wmdextensions.com>
 * @copyright 2011 Dominik Wyss | Digiswiss (http://www.digiswiss.ch)
 * @link      http://www.wmdextensions.com/
 * @license   http://wmdextensions.com/WMD-License-Community.txt
*/

class Wmd_Productneworder_Block_Catalog_Product_New extends Mage_Catalog_Block_Product_New
{  

    /**
     * Prepare collection with new products and applied page limits.
     *
     * return Mage_Catalog_Block_Product_New
     */
    protected function _beforeToHtml()
    {
        
        $collection = Mage::getResourceModel('catalog/product_collection');
        $collection->getSelect()
            ->join(
                    array('category_product' => $collection->getTable('catalog/category_product')),
                    'e.entity_id = category_product.product_id',
                    array('category_id', 'position')
                )
            ->where('category_product.category_id = ?', Mage::app()->getStore()->getRootCategoryId())
            ->order('category_product.position', 'desc'); 
            
        $collection->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInCatalogIds());
        
        $collection = $this->_addProductAttributesAndPrices($collection)
            ->setPageSize($this->getProductsCount())
            ->setCurPage(1);
            
        $this->setProductCollection($collection);
        
    }
}