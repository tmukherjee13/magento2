<?php
/**
 *
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
namespace Magento\Backend\Controller\Adminhtml\System\Variable;

class Edit extends \Magento\Backend\Controller\Adminhtml\System\Variable
{
    /**
     * Edit Action
     *
     * @return void
     */
    public function execute()
    {
        $variable = $this->_initVariable();

        $this->_title->add($variable->getId() ? $variable->getCode() : __('New Custom Variable'));

        $this->_initLayout()->_addContent(
            $this->_view->getLayout()->createBlock('Magento\Backend\Block\System\Variable\Edit')
        )->_addJs(
            $this->_view->getLayout()->createBlock(
                'Magento\Framework\View\Element\Template',
                '',
                array('data' => array('template' => 'Magento_Backend::system/variable/js.phtml'))
            )
        );
        $this->_view->renderLayout();
    }
}
