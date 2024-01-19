<?php

namespace PushpakMods\Popup\Ui\Component\Listing\Column;

use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;


class PopupActions extends Column
{

    private const CMS_URL_PATH_EDIT = 'pushpakmods_popup/popup/edit';
    private const CMS_URL_PATH_DELETE = 'pushpakmods_popup/popup/delete';

    /**
     * @var \Magento\Cms\Block\Adminhtml\Page\Grid\Renderer\Action\UrlBuilder
     */
    protected $actionUrlBuilder;

    /**
     * @var \Magento\Cms\ViewModel\Page\Grid\UrlBuilder
     */
    private $scopeUrlBuilder;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var string
     */
    private $editUrl;

    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     * @param string $editUrl
     * @param \Magento\Cms\ViewModel\Page\Grid\UrlBuilder|null $scopeUrlBuilder
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        Escaper $escaper,
        array $components = [],
        array $data = [],
        string $editUrl = self::CMS_URL_PATH_EDIT,
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        $this->escaper = $escaper;
        parent::__construct($context, $uiComponentFactory, $components, $data);
        
    }

    /**
     * @inheritDoc
     */
    public function prepareDataSource(array $dataSource):array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['popup_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['popup_id' => $item['popup_id']]),
                        'label' => __('Edit'),
                    ];
                    $title = $this->escaper->escapeHtml($item['name']);
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::CMS_URL_PATH_DELETE, ['popup_id' => $item['popup_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete %1', $title),
                            'message' => __('Are you sure you want to delete a %1 record?', $title),
                        ],
                        'post' => true,
                    ];
                }
            }
        }

        return $dataSource;
    }

    
}
