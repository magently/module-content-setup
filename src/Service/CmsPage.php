<?php

namespace Magently\ContentSetup\Service;

use Magently\ContentSetup\Provider\FileProvider;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Cms\Model\Page;
use Magento\Cms\Model\PageFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;

/**
 * Class CmsPage
 * This class is responsible for adding a new or modifying existing CMS Page
 */
class CmsPage
{
    const COMPONENT_NAME = 'Page';

    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var FileProvider
     */
    private $fileProvider;

    /**
     * @var string
     */
    private $moduleName;

    /**
     * @param PageRepositoryInterface $pageRepository
     * @param PageFactory $pageFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FileProvider $fileProvider
     * @param string $moduleName
     */
    public function __construct(
        PageRepositoryInterface $pageRepository,
        PageFactory $pageFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FileProvider $fileProvider,
        string $moduleName
    ) {
        $this->pageRepository = $pageRepository;
        $this->pageFactory = $pageFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->fileProvider = $fileProvider;
        $this->moduleName = $moduleName;
    }

    /**
     * Sets up a CMS page.
     * @param string $pageIdentifier
     * @return void
     */
    public function setupPage(string $pageIdentifier): void
    {
        $page = $this->getPageByIdentifier($pageIdentifier);

        $pageDataSet = $this->fileProvider->getDataset(self::COMPONENT_NAME, $this->moduleName, $pageIdentifier);
        $pageContent = $this->fileProvider->getContent(self::COMPONENT_NAME, $this->moduleName, $pageIdentifier);

        foreach ($pageDataSet as $property => $value) {
            $page->setData($property, $value);
        }

        $page->setContent($pageContent);

        $this->pageRepository
            ->save($page);
    }

    /**
     * Returns an instance of CMS page with given $pageIdentifier.
     * If a page with given $pageIdentifier does not exist,
     * a new one is created.
     * @param string $pageIdentifier Identifier of the page.
     * @return Page
     */
    private function getPageByIdentifier(string $pageIdentifier): Page
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(
                Page::IDENTIFIER,
                $pageIdentifier
            )
            ->setPageSize(1)
            ->create();

        $pageListItems = $this->pageRepository
            ->getList($searchCriteria)
            ->getItems();

        if (!empty($pageListItems)) {
            return array_pop($pageListItems);
        }

        return $this->pageFactory
            ->create()
            ->setIdentifier($pageIdentifier);
    }
}
