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
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Magento\Catalog\Model\Indexer\Product\Flat;

/**
 * Class FullTest
 */
class ProcessorTest extends \Magento\TestFramework\Indexer\TestCase
{
    /**
     * @var \Magento\Catalog\Model\Indexer\Product\Flat\State
     */
    protected $_state;

    /**
     * @var \Magento\Catalog\Model\Indexer\Product\Flat\Processor
     */
    protected $_processor;

    protected function setUp()
    {
        $this->_state = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->get(
            'Magento\Catalog\Model\Indexer\Product\Flat\State'
        );
        $this->_processor = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->get(
            'Magento\Catalog\Model\Indexer\Product\Flat\Processor'
        );
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoAppArea adminhtml
     * @magentoConfigFixture current_store catalog/frontend/flat_catalog_product 1
     */
    public function testEnableProductFlat()
    {
        $this->assertTrue($this->_state->isFlatEnabled());
        $this->assertTrue($this->_processor->getIndexer()->isInvalid());
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoAppArea adminhtml
     * @magentoDataFixture Magento/Catalog/_files/multiple_products.php
     * @magentoConfigFixture current_store catalog/frontend/flat_catalog_product 1
     */
    public function testSaveAttribute()
    {
        /** @var $product \Magento\Catalog\Model\Product */
        $product = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Catalog\Model\Product'
        );

        /** @var \Magento\Catalog\Model\Resource\Product $productResource */
        $productResource = $product->getResource();
        $productResource->getAttribute('sku')->setData('used_for_sort_by', 1)->save();

        $this->assertTrue($this->_processor->getIndexer()->isInvalid());
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoAppArea adminhtml
     * @magentoDataFixture Magento/Catalog/_files/multiple_products.php
     * @magentoConfigFixture current_store catalog/frontend/flat_catalog_product 1
     */
    public function testDeleteAttribute()
    {
        /** @var $product \Magento\Catalog\Model\Product */
        $product = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Catalog\Model\Product'
        );

        /** @var \Magento\Catalog\Model\Resource\Product $productResource */
        $productResource = $product->getResource();
        $productResource->getAttribute('media_gallery')->delete();

        $this->assertTrue($this->_processor->getIndexer()->isInvalid());
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoAppArea adminhtml
     * @magentoDataFixture Magento/Core/_files/store.php
     * @magentoConfigFixture current_store catalog/frontend/flat_catalog_product 1
     */
    public function testAddNewStore()
    {
        $this->assertTrue($this->_processor->getIndexer()->isInvalid());
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoAppArea adminhtml
     * @magentoConfigFixture current_store catalog/frontend/flat_catalog_product 1
     */
    public function testAddNewStoreGroup()
    {
        /** @var \Magento\Store\Model\Group $storeGroup */
        $storeGroup = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create('Magento\Store\Model\Group');
        $storeGroup->setData(
            array('website_id' => 1, 'name' => 'New Store Group', 'root_category_id' => 2, 'group_id' => null)
        );
        $storeGroup->save();
        $this->assertTrue($this->_processor->getIndexer()->isInvalid());
    }
}
