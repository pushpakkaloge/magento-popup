<?php

namespace PushpakMods\Popup\Controller\Adminhtml\Popup;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\Page;
use PushpakMods\Popup\Api\PopupRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\EntityManager\Operation\Read;
use PushpakMods\Popup\Api\Data\PopupInterface;

class Edit extends Action{

    public function __construct(
        Context $context,
        private readonly PopupRepositoryInterface $popupRepository,
        private readonly DataPersistorInterface $dataPersistor,
        private  PopupInterface $popup
    )
    {   
        parent::__construct($context);

    }

    public function execute(): ResultInterface{
        /** @var Page $page */
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        
        
        
        $popupId = (int) $this->getRequest()->getParam('popup_id');
        
        try{
            if($popupId>0){
                $this->popup = $this->popupRepository->getById($popupId);
            }
            $this->dataPersistor->set('pushpakmods_popup_popup',$this->popup->getData());
        
        }catch(LocalizedException $e){
            $this->messageManager->addErrorMessage(__('The popup with given id does not exist'));
        }


        $page->setActiveMenu('PushpakMods_Popup::popup');
        $page->addBreadcrumb(__('Popups'), __('Popups'));
        $page->addBreadcrumb(
            $this->popup->getPopupId()?$this->popup->getName():__('New Popup'),
            $this->popup->getPopupId()?$this->popup->getName(): __('New Popup'));
        $page->getConfig()->getTitle()->prepend(
            $this->popup->getPopupId()?$this->popup->getName(): __('New Popup')
        );



        

        return $page;
    }
}