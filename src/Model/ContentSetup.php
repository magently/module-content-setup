<?php

namespace Magently\ContentSetup\Model;

use Magently\ContentSetup\Service\CmsPage;
use Magently\ContentSetup\Service\CmsPageFactory;

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
     * @var string
     */
    private $moduleName;

    /**
     * @param CmsPageFactory $cmsPageSetupFactory
     * @param string $moduleName
     */
    public function __construct(CmsPageFactory $cmsPageSetupFactory, string $moduleName)
    {
        $this->cmsPageSetupFactory = $cmsPageSetupFactory;
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
}
