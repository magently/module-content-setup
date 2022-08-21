<?php

namespace Magently\ContentSetup\Service;

use Magently\ContentSetup\Provider\FileProvider;
use Magento\Email\Model\Template;
use Magento\Email\Model\TemplateFactory;
use Magento\Email\Model\ResourceModel\Template as TemplateResource;

/**
 * Class EmailTemplate
 * This class is responsible for adding a new or modifying existing Email Template
 */
class EmailTemplate
{
    const COMPONENT_NAME = 'Email';

    /**
     * @var TemplateFactory
     */
    private $templateFactory;

    /**
     * @var TemplateResource
     */
    private $templateResource;

    /**
     * @var FileProvider
     */
    private $fileProvider;

    /**
     * @var string
     */
    private $moduleName;

    /**
     * @param TemplateFactory $templateFactory
     * @param TemplateResource $templateResource
     * @param FileProvider $fileProvider
     * @param string $moduleName
     */
    public function __construct(
        TemplateFactory $templateFactory,
        TemplateResource $templateResource,
        FileProvider $fileProvider,
        string $moduleName
    ) {
        $this->templateFactory = $templateFactory;
        $this->templateResource = $templateResource;
        $this->fileProvider = $fileProvider;
        $this->moduleName = $moduleName;
    }

    /**
     * Sets up an email template.
     * @param string $emailTemplateCode
     * @return void
     */
    public function setupEmailTemplate(string $emailTemplateCode): void
    {
        $template = $this->getEmailTemplateByCode($emailTemplateCode);

        $templateDataSet = $this->fileProvider->getDataset(self::COMPONENT_NAME, $this->moduleName, $emailTemplateCode);
        $templateContent = $this->fileProvider->getContent(self::COMPONENT_NAME, $this->moduleName, $emailTemplateCode);

        foreach ($templateDataSet as $property => $value) {
            $template->setData($property, $value);
        }

        $template->setTemplateText($templateContent);

        $this->templateResource
            ->save($template);
    }

    /**
     * Returns an instance of Template with given $code.
     * If a template with given $code does not exist,
     * a new one is created.
     * @param string $code
     * @return Template
     */
    private function getEmailTemplateByCode(string $code): Template
    {
        $templateInstance = $this->templateFactory->create();
        $this->templateResource->load($templateInstance, $code, 'template_code');

        if ($templateInstance->getId()) {
            return $templateInstance;
        }

        $templateInstance->setTemplateCode($code);
        return $templateInstance;
    }
}
