<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Catalog navigation
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Catalog_Block_Navigation extends Mage_Core_Block_Template
{
    protected $_categoryInstance = null;

    /**
     * Current category key
     *
     * @var string
     */
    protected $_currentCategoryKey;

    /**
     * Array of level position counters
     *
     * @var array
     */
    protected $_itemLevelPositions = array();

    protected function _construct()
    {
        $this->addData(array(
            'cache_lifetime'    => false,
            'cache_tags'        => array(Mage_Catalog_Model_Category::CACHE_TAG, Mage_Core_Model_Store_Group::CACHE_TAG),
        ));
    }

    /**
     * Get Key pieces for caching block content
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        $shortCacheId = array(
            'CATALOG_NAVIGATION',
            Mage::app()->getStore()->getId(),
            Mage::getDesign()->getPackageName(),
            Mage::getDesign()->getTheme('template'),
            Mage::getSingleton('customer/session')->getCustomerGroupId(),
            'template' => $this->getTemplate(),
            'name' => $this->getNameInLayout(),
            $this->getCurrenCategoryKey()
        );
        $cacheId = $shortCacheId;

        $shortCacheId = array_values($shortCacheId);
        $shortCacheId = implode('|', $shortCacheId);
        $shortCacheId = md5($shortCacheId);

        $cacheId['category_path'] = $this->getCurrenCategoryKey();
        $cacheId['short_cache_id'] = $shortCacheId;

        return $cacheId;
    }

    /**
     * Get current category key
     *
     * @return mixed
     */
    public function getCurrenCategoryKey()
    {
        if (!$this->_currentCategoryKey) {
            $category = Mage::registry('current_category');
            if ($category) {
                $this->_currentCategoryKey = $category->getPath();
            } else {
                $this->_currentCategoryKey = Mage::app()->getStore()->getRootCategoryId();
            }
        }

        return $this->_currentCategoryKey;
    }

    /**
     * Get catagories of current store
     *
     * @return Varien_Data_Tree_Node_Collection
     */
    public function getStoreCategories()
    {
        $helper = Mage::helper('catalog/category');
        return $helper->getStoreCategories();
    }

    /**
     * Retrieve child categories of current category
     *
     * @return Varien_Data_Tree_Node_Collection
     */
    public function getCurrentChildCategories()
    {
        $layer = Mage::getSingleton('catalog/layer');
        $category   = $layer->getCurrentCategory();
        /* @var $category Mage_Catalog_Model_Category */
        $categories = $category->getChildrenCategories();
        $productCollection = Mage::getResourceModel('catalog/product_collection');
        $layer->prepareProductCollection($productCollection);
        $productCollection->addCountToCategories($categories);
        return $categories;
    }

    /**
     * Checkin activity of category
     *
     * @param   Varien_Object $category
     * @return  bool
     */
    public function isCategoryActive($category)
    {
        if ($this->getCurrentCategory()) {
            return in_array($category->getId(), $this->getCurrentCategory()->getPathIds());
        }
        return false;
    }

    protected function _getCategoryInstance()
    {
        if (is_null($this->_categoryInstance)) {
            $this->_categoryInstance = Mage::getModel('catalog/category');
        }
        return $this->_categoryInstance;
    }

    /**
     * Get url for category data
     *
     * @param Mage_Catalog_Model_Category $category
     * @return string
     */
    public function getCategoryUrl($category)
    {
        if ($category instanceof Mage_Catalog_Model_Category) {
            $url = $category->getUrl();
        } else {
            $url = $this->_getCategoryInstance()
                ->setData($category->getData())
                ->getUrl();
        }

        return $url;
    }

    /**
     * Return item position representation in menu tree
     *
     * @param int $level
     * @return string
     */
    protected function _getItemPosition($level)
    {
        if ($level == 0) {
            $zeroLevelPosition = isset($this->_itemLevelPositions[$level]) ? $this->_itemLevelPositions[$level] + 1 : 1;
            $this->_itemLevelPositions = array();
            $this->_itemLevelPositions[$level] = $zeroLevelPosition;
        } elseif (isset($this->_itemLevelPositions[$level])) {
            $this->_itemLevelPositions[$level]++;
        } else {
            $this->_itemLevelPositions[$level] = 1;
        }

        $position = array();
        for($i = 0; $i <= $level; $i++) {
            if (isset($this->_itemLevelPositions[$i])) {
                $position[] = $this->_itemLevelPositions[$i];
            }
        }
        return implode('-', $position);
    }

    /**
     * Render category to html
     *
     * @param Mage_Catalog_Model_Category $category
     * @param int Nesting level number
     * @param boolean Whether ot not this item is last, affects list item class
     * @param boolean Whether ot not this item is first, affects list item class
     * @param boolean Whether ot not this item is outermost, affects list item class
     * @param string Extra class of outermost list items
     * @param string If specified wraps children list in div with this class
     * @param boolean Whether ot not to add on* attributes to list item
     * @return string
     */
    protected function _renderCategoryMenuItemHtml($category, $level = 0, $isLast = false, $isFirst = false,
        $isOutermost = false, $outermostItemClass = '', $childrenWrapClass = '', $noEventAttributes = false)
    {
        if (!$category->getIsActive()) {
            return '';
        }
        $html = array();

        // get all children
        if (Mage::helper('catalog/category_flat')->isEnabled()) {
            $children = (array)$category->getChildrenNodes();
            $childrenCount = count($children);
        } else {
            $children = $category->getChildren();
            $childrenCount = $children->count();
        }
        $hasChildren = ($children && $childrenCount);

        // select active children
        $activeChildren = array();
        foreach ($children as $child) {
            if ($child->getIsActive()) {
                $activeChildren[] = $child;
            }
        }
        $activeChildrenCount = count($activeChildren);
        $hasActiveChildren = ($activeChildrenCount > 0);

        // prepare list item html classes
        $classes = array();
        $classes[] = 'level' . $level;
        $classes[] = 'nav-' . $this->_getItemPosition($level);
        if ($this->isCategoryActive($category)) {
            $classes[] = 'active';
        }
        $linkClass = '';
        if ($isOutermost && $outermostItemClass) {
            $classes[] = $outermostItemClass;
            $linkClass = ' class="'.$outermostItemClass.'"';
        }
        if ($isFirst) {
            $classes[] = 'first';
        }
        if ($isLast) {
            $classes[] = 'last';
        }
        if ($hasActiveChildren) {
            $classes[] = 'parent';
        }

        // prepare list item attributes
        $attributes = array();
        if (count($classes) > 0) {
            $attributes['class'] = implode(' ', $classes);
        }
        if ($hasActiveChildren && !$noEventAttributes) {
             $attributes['onmouseover'] = 'toggleMenu(this,1)';
             $attributes['onmouseout'] = 'toggleMenu(this,0)';
        }

        // assemble list item with attributes
        $htmlLi = '<li';
        foreach ($attributes as $attrName => $attrValue) {
            $htmlLi .= ' ' . $attrName . '="' . str_replace('"', '\"', $attrValue) . '"';
        }
        $htmlLi .= '>';
        $html[] = $htmlLi;

        
        // by margshri (27-11-2015)
        $categoryURL = "#";
        //$categoryName = $this->escapeHtml(strtoupper($category->getName()));
        $categoryName = $this->escapeHtml($category->getName());
        
        /*
        if(($level == 0 && $childrenCount == 0) || $level != 0){
        	$categoryURL  = $this->getCategoryUrl($category);
        }
        */
        
        if($childrenCount == 0) {
        	$categoryURL  = $this->getCategoryUrl($category);
        }
        
        
        $html[] = '<a href="'.$categoryURL.'"'.$linkClass.'>';
        $html[] = '<span>' . $categoryName . '</span>';
        $html[] = '</a>';
        // end

        // render children
        $htmlChildren = '';
        $j = 0;
        foreach ($activeChildren as $child) {
            $htmlChildren .= $this->_renderCategoryMenuItemHtml(
                $child,
                ($level + 1),
                ($j == $activeChildrenCount - 1),
                ($j == 0),
                false,
                $outermostItemClass,
                $childrenWrapClass,
                $noEventAttributes
            );
            $j++;
        }
        if (!empty($htmlChildren)) {
            if ($childrenWrapClass) {
                $html[] = '<div class="' . $childrenWrapClass . '">';
            }
            $html[] = '<ul class="level' . $level . '">';
            $html[] = $htmlChildren;
            $html[] = '</ul>';
            if ($childrenWrapClass) {
                $html[] = '</div>';
            }
        }

        $html[] = '</li>';

        $html = implode("\n", $html);
        return $html;
    }

    /**
     * Render category to html
     *
     * @deprecated deprecated after 1.4
     * @param Mage_Catalog_Model_Category $category
     * @param int Nesting level number
     * @param boolean Whether ot not this item is last, affects list item class
     * @return string
     */
    public function drawItem($category, $level = 0, $last = false)
    {
        return $this->_renderCategoryMenuItemHtml($category, $level, $last);
    }

    /**
     * Enter description here...
     *
     * @return Mage_Catalog_Model_Category
     */
    public function getCurrentCategory()
    {
        if (Mage::getSingleton('catalog/layer')) {
            return Mage::getSingleton('catalog/layer')->getCurrentCategory();
        }
        return false;
    }

    /**
     * Enter description here...
     *
     * @return string
     */
    public function getCurrentCategoryPath()
    {
        if ($this->getCurrentCategory()) {
            return explode(',', $this->getCurrentCategory()->getPathInStore());
        }
        return array();
    }

    /**
     * Enter description here...
     *
     * @param Mage_Catalog_Model_Category $category
     * @return string
     */
    public function drawOpenCategoryItem($category) {
        $html = '';
        if (!$category->getIsActive()) {
            return $html;
        }

        $html.= '<li';

        if ($this->isCategoryActive($category)) {
            $html.= ' class="active"';
        }

        $html.= '>'."\n";
        $html.= '<a href="'.$this->getCategoryUrl($category).'"><span>'.$this->htmlEscape($category->getName()).'</span></a>'."\n";

        if (in_array($category->getId(), $this->getCurrentCategoryPath())){
            $children = $category->getChildren();
            $hasChildren = $children && $children->count();

            if ($hasChildren) {
                $htmlChildren = '';
                foreach ($children as $child) {
                    $htmlChildren.= $this->drawOpenCategoryItem($child);
                }

                if (!empty($htmlChildren)) {
                    $html.= '<ul>'."\n"
                            .$htmlChildren
                            .'</ul>';
                }
            }
        }
        $html.= '</li>'."\n";
        return $html;
    }

    /**
     * Render categories menu in HTML
     *
     * @param int Level number for list item class to start from
     * @param string Extra class of outermost list items
     * @param string If specified wraps children list in div with this class
     * @return string
     */
    public function renderCategoriesMenuHtml($level = 0, $outermostItemClass = '', $childrenWrapClass = '')
    {
        $activeCategories = array();
        foreach ($this->getStoreCategories() as $child) {
            if ($child->getIsActive()) {
            	// Add By Margshri
            	if($child->getRequest_path() == 'leftsidebar.html'){
            		continue;
            	}
            	// end
                $activeCategories[] = $child;
            }
        }
        $activeCategoriesCount = count($activeCategories);
        $hasActiveCategoriesCount = ($activeCategoriesCount > 0);

        if (!$hasActiveCategoriesCount) {
            return '';
        }

        $html = '';
        $j = 0;
        foreach ($activeCategories as $category) {
            $html .= $this->_renderCategoryMenuItemHtml(
                $category,
                $level,
                ($j == $activeCategoriesCount - 1),
                ($j == 0),
                true,
                $outermostItemClass,
                $childrenWrapClass,
                true
            );
            $j++;
        }

        return $html;
    }

    
    public function getWishes(){
    	
    	/* @var $locationVO  Margshri_WebPortal_VO_LocationSelector_LocationVO */
    	$locationVO = unserialize(Mage::getSingleton('core/session')->getData('LocationVO'));
    	if(!$locationVO){
    		$locationVO = new Margshri_WebPortal_VO_LocationSelector_LocationVO();
    	}
    	 
    	
    	$dobCollection = Mage::getModel('customer/customer')->getCollection();
		$dobQuery = $dobCollection->getSelect()->reset()->from(array("main_table"=>$dobCollection->getTable("webportal/customerentitydatetime"), array("entity_id", "value" ) ))
		->where('main_table.attribute_id =?', 11);
		
		$domCollection = Mage::getModel('customer/customer')->getCollection();
		$domQuery = $domCollection->getSelect()->reset()->from(array("main_table"=>$domCollection->getTable("webportal/customerentitydatetime"), array("entity_id", "value" ) ))
		->where('main_table.attribute_id =?', 141);
		
		
		$firstNameCollection = Mage::getModel('customer/customer')->getCollection();
		$firstNameQuery = $firstNameCollection->getSelect()->reset()->from(array("main_table"=>$firstNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
		->where('main_table.attribute_id =?', 5);
		
		$lastNameCollection = Mage::getModel('customer/customer')->getCollection();
		$lastNameQuery = $lastNameCollection->getSelect()->reset()->from(array("main_table"=>$lastNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
		->where('main_table.attribute_id =?', 7);
		
		$spouseNameCollection = Mage::getModel('customer/customer')->getCollection();
		$spouseNameQuery = $spouseNameCollection->getSelect()->reset()->from(array("main_table"=>$spouseNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
		->where('main_table.attribute_id =?', 161);
		
		$genderCollection = Mage::getModel('customer/customer')->getCollection();
		$genderQuery = $genderCollection->getSelect()->reset()->from(array("main_table"=>$spouseNameCollection->getTable("webportal/customerentityint"), array("entity_id", "value") ))
		->where('main_table.attribute_id =?', 18);
		
		
		$customerAddressCollection = Mage::getModel('common/Customer_Address')->getCollection();
		$customerAddressQuery = $customerAddressCollection->getSelect()->reset()->from(array("main_table"=>$customerAddressCollection->getTable("common/apctcustomeraddress"), array("CustomerID", "Address", "PinCode") ))
		->joinLeft(array("country"=>$customerAddressCollection->getTable('webportal/apctcountrylist')), 'main_table.CountryID = country.ID', array("CountryName"=>"country.Value"))
		->joinLeft(array("state"=>$customerAddressCollection->getTable('webportal/apctstatelist')), 'main_table.StateID = state.ID', array("StateName"=>"state.Value"))
		->joinLeft(array("district"=>$customerAddressCollection->getTable('webportal/apctdistrictlist')), 'main_table.DistrictID = district.ID', array("DistrictName"=>"district.Value", "DistrictCode"=>"district.Code"))
		->joinLeft(array("city"=>$customerAddressCollection->getTable('webportal/apctcitylist')), 'main_table.CityID = city.ID', array("CityName"=>"city.Value", "CityCode"=>"city.Code"))
		->where('main_table.TypeID =?', Margshri_Common_VO_Customer_AddressTypeVO::$PERMANENT_ADDRESS);
		
		
		$professionCollection = Mage::getModel('customer/customer')->getCollection();
		$professionQuery = $professionCollection->getSelect()->reset()->from(array("main_table"=>$spouseNameCollection->getTable("webportal/apctwebprofessional"), array("ProfessionID","CustomerID") ));
		
		
		/*
		
		$customerPermanentAddressCollection = Mage::getModel('customer/customer')->getCollection();
		$customerPermanentAddressQuery = $customerPermanentAddressCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressCollection->getTable("webportal/customeraddressentity"), array("entity_id", "parent_id") ))
		->joinLeft(array("cei"=>$customerPermanentAddressCollection->getTable("webportal/customerentityint")), "main_table.entity_id=cei.value" ,array("value_id"))
		->where('cei.attribute_id =?', 160);
		
		
		$customerPACityCollection = Mage::getModel('customer/customer')->getCollection();
		$customerPACityQuery = $customerPACityCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressQuery), array("parent_id"))
		->joinLeft(array("caei"=>$customerPACityCollection->getTable("webportal/customeraddressentityint") ), "main_table.entity_id=caei.entity_id", array("value") )
		->where('caei.attribute_id =?', 153);
			
		$customerPADistrictCollection = Mage::getModel('customer/customer')->getCollection();
		$customerPADistrictQuery = $customerPADistrictCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressQuery), array("parent_id"))
		->joinLeft(array("caei"=>$customerPADistrictCollection->getTable("webportal/customeraddressentityint") ), "main_table.entity_id=caei.entity_id", array("value") )
		->where('caei.attribute_id =?', 152);
			
		$customerPAStateCollection = Mage::getModel('customer/customer')->getCollection();
		$customerPAStateQuery = $customerPAStateCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressQuery), array("parent_id"))
		->joinLeft(array("caei"=>$customerPAStateCollection->getTable("webportal/customeraddressentityint") ), "main_table.entity_id=caei.entity_id", array("value") )
		->where('caei.attribute_id =?', 151);
			
		$customerPACountryCollection = Mage::getModel('customer/customer')->getCollection();
		$customerPACountryQuery = $customerPACountryCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressQuery), array("parent_id"))
		->joinLeft(array("caei"=>$customerPACountryCollection->getTable("webportal/customeraddressentityint") ), "main_table.entity_id=caei.entity_id", array("value") )
		->where('caei.attribute_id =?', 154);
		
		
		if($locationVO->getCountryID() != null){
			$customerPACountryCollection->where('caei.value =?', $locationVO->getCountryID());
		}
		*/
		
		
		
		$collection = Mage::getModel('customer/customer')->getCollection();
		$collection->getSelect()->reset()->from(array("main_table"=>$collection->getTable("webportal/customerentity")), array("email") );
		$collection->getSelect()->joinLeft(array("dob"=>$dobQuery), "main_table.entity_id = dob.entity_id", array("DOB"=>"dob.value"));
		$collection->getSelect()->joinLeft(array("dom"=>$domQuery), "main_table.entity_id = dom.entity_id", array("DOM"=>"dom.value"));
		$collection->getSelect()->joinLeft(array("firstname"=>$firstNameQuery), "main_table.entity_id = firstname.entity_id", array("FirstName"=>"firstname.value"));
		$collection->getSelect()->joinLeft(array("lastname"=>$lastNameQuery), "main_table.entity_id = lastname.entity_id", array("LastName"=>"lastname.value"));
		$collection->getSelect()->joinLeft(array("spousename"=>$spouseNameQuery), "main_table.entity_id = spousename.entity_id", array("SpouseName"=>"spousename.value"));
		$collection->getSelect()->joinLeft(array("address"=>$customerAddressQuery), "main_table.entity_id = address.CustomerID", array("Address"=>"address.Address", "CityName"=>"address.CityName", "CityCode"=>"address.CityCode", "DistrictName" => "address.DistrictName", "DistrictCode" => "address.DistrictCode", "StateName"=>"address.StateName", "CountryName"=>"address.CountryName"  ));
		$collection->getSelect()->joinLeft(array("gender"=>$genderQuery), "main_table.entity_id = gender.entity_id", array("Gender"=>"gender.value"));
		$collection->getSelect()->joinLeft(array("profession"=>$professionQuery), "main_table.entity_id = profession.CustomerID", array("ProfessionID"=>"profession.ProfessionID"));
		
		
		/*
		 * 
		$collection->getSelect()->joinLeft(array("city"=>$customerPACityQuery), "main_table.entity_id = city.parent_id", array("CityID"=>"city.value"));
		$collection->getSelect()->joinLeft(array("district"=>$customerPADistrictQuery), "main_table.entity_id = district.parent_id", array("DistrictID"=>"district.value"));
		$collection->getSelect()->joinLeft(array("state"=>$customerPAStateQuery), "main_table.entity_id = state.parent_id", array("StateID"=>"state.value"));
		$collection->getSelect()->joinLeft(array("country"=>$customerPACountryQuery), "main_table.entity_id = country.parent_id", array("CountryID"=>"country.value"));
		
		
		if($locationVO->getStateID() != null){
			$collection->getSelect()->where('main_table.StateID =?', $locationVO->getStateID());
		}
		if($locationVO->getDistrictID() != null){
			$collection->getSelect()->where('main_table.DistrictID =?', $locationVO->getDistrictID());
		}
		if($locationVO->getCityID()){
			$collection->getSelect()->where('main_table.CityID =?', $locationVO->getCityID());
		}
		*/
		
		return $collection;
		
		
		
		
		
		
		
    }
}
