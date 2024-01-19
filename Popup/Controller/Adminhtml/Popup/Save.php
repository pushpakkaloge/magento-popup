<?php

namespace PushpakMods\Popup\Controller\Adminhtml\Popup;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use PushpakMods\Popup\Api\Data\PopupInterface;
use PushpakMods\Popup\Api\Data\PopupInterfaceFactory;
use Magento\Framework\Controller\ResultInterface;
use Psr\Log\LoggerInterface;
use PushpakMods\Popup\Api\PopupRepositoryInterface;


class Save extends Action implements HttpPostActionInterface
{

    public function __construct(
        Context $context,
        private readonly DataPersistorInterface $dataPersistor,
        private readonly PopupInterfaceFactory $popupFactory,
        private readonly PopupRepositoryInterface $popupRepository,
        private LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->logger=$logger;
    }

    
    public function execute():ResultInterface
    {
        /** @var \Magento\Framework\Controller\Result\ResultRedirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $data = $this->getRequest()->getPostValue();
        if ($data) {

            if (isset($data['timeout']) && $data['is_active'] == true) {
                $data['is_active'] = (int) PopupInterface::STATUS_ENABLED;
            }

            if (empty($data['popup_id'])) {
                $data['popup_id'] = null;
            }

            $model = $this->popupFactory->create();
            $id = (int) $this->getRequest()->getParam('popup_id');
            if ($id) {
                try {
                    $model = $this->popupRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This popup no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            // dump($data);
            

            $model->setData($data);

            try {
                // unset($data['popup_id']);
                $this->popupRepository->save($model); 
                $this->messageManager->addSuccessMessage(__('You saved the popup.'));
                $this->dataPersistor->clear('pushpakmods_popup_popup');
                return $resultRedirect->setPath('*/*/');
             } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the popup.'));
            }

            $this->dataPersistor->set('pushpakmods_popup', $data);
            return $resultRedirect->setPath('*/*/edit', ['popup_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }
 
}
