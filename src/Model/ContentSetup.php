<?php

namespace Magently\ContentSetup\Model;

use Magently\ContentSetup\Service\CmsPage;
use Magently\ContentSetup\Service\CmsPageFactory;
use Magently\ContentSetup\Service\CmsBlock;
use Magently\ContentSetup\Service\CmsBlockFactory;

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
     * @var string
     */
    private $moduleName;

    /**
     * @param CmsPageFactory $cmsPageSetupFactory
     * @param CmsBlockFactory $cmsBlockSetupFactory
     * @param string $moduleName
     */
    public function __construct(
        CmsPageFactory $cmsPageSetupFactory,
        CmsBlockFactory $cmsBlockSetupFactory,
        string $moduleName
    ) {
        $this->cmsPageSetupFactory = $cmsPageSetupFactory;
        $this->cmsBlockSetupFactory = $cmsBlockSetupFactory;
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
}
