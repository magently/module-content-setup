<?php

namespace Magently\ContentSetup\Model;

use Magently\ContentSetup\Service\CmsPage;
use Magently\ContentSetup\Service\CmsPageFactory;
use Magently\ContentSetup\Service\CmsBlock;
use Magently\ContentSetup\Service\CmsBlockFactory;
use Magently\ContentSetup\Service\EmailTemplate;
use Magently\ContentSetup\Service\EmailTemplateFactory;
use Magently\ContentSetup\Service\Variable;

/**
 * Class ContentSetup
 * This class is the API class to use the module.
 * Build this class with Factory
 */
class ContentSetup
{
    /**
     * @var CmsPageFactory
     */
    private $cmsPageSetupFactory;

    /**
     * @var CmsPage
     */
    private $cmsPageSetup;

    /**
     * @var CmsBlockFactory
     */
    private $cmsBlockSetupFactory;

    /**
     * @var CmsBlock
     */
    private $cmsBlockSetup;

    /**
     * @var EmailTemplateFactory
     */
    private $emailTemplateSetupFactory;

    /**
     * @var EmailTemplate
     */
    private $emailTemplateSetup;

    /**
     * @var Variable
     */
    private $variableSetup;

    /**
     * @var string
     */
    private $moduleName;

    /**
     * @param CmsPageFactory $cmsPageSetupFactory
     * @param CmsBlockFactory $cmsBlockSetupFactory
     * @param EmailTemplateFactory $emailTemplateSetupFactory
     * @param string $moduleName
     */
    public function __construct(
        CmsPageFactory $cmsPageSetupFactory,
        CmsBlockFactory $cmsBlockSetupFactory,
        EmailTemplateFactory $emailTemplateSetupFactory,
        Variable $variableSetup,
        string $moduleName
    ) {
        $this->cmsPageSetupFactory = $cmsPageSetupFactory;
        $this->cmsBlockSetupFactory = $cmsBlockSetupFactory;
        $this->emailTemplateSetupFactory = $emailTemplateSetupFactory;
        $this->variableSetup = $variableSetup;
        $this->moduleName = $moduleName;
    }

    /**
     * @param string $pageIdentifier
     * @return void
     */
    public function setupPage($pageIdentifier)
    {
        if (!$this->cmsPageSetup) {
            $this->cmsPageSetup = $this->cmsPageSetupFactory->create(['moduleName' => $this->moduleName]);
        }
        $this->cmsPageSetup->setupPage($pageIdentifier);
    }

    /**
     * @param string $blockIdentifier
     * @return void
     */
    public function setupBlock(string $blockIdentifier)
    {
        if (!$this->cmsBlockSetup) {
            $this->cmsBlockSetup = $this->cmsBlockSetupFactory->create(['moduleName' => $this->moduleName]);
        }
        $this->cmsBlockSetup->setupBlock($blockIdentifier);
    }

    /**
     * @param string $emailTemplateCode
     * @return void
     */
    public function setupEmailTemplate(string $emailTemplateCode)
    {
        if (!$this->emailTemplateSetup) {
            $this->emailTemplateSetup = $this->emailTemplateSetupFactory->create(['moduleName' => $this->moduleName]);
        }
        $this->emailTemplateSetup->setupEmailTemplate($emailTemplateCode);
    }

    /**
     * @param string $code
     * @param string|null $name
     * @param string|null $plainValue
     * @param string|null $htmlValue
     * @return void
     */
    public function setupVariable(
        string $code,
        string $name = null,
        string $plainValue = null,
        string $htmlValue = null
    ) {
        $this->variableSetup->setupVariable($code, $name, $plainValue, $htmlValue);
    }
}
