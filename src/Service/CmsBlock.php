<?php

namespace Magently\ContentSetup\Service;

use Magently\ContentSetup\Provider\FileProvider;
use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Model\Block;
use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;

/**
 * Class CmsBlock
 * This class is responsible for adding a new or modifying existing CMS Block
 */
class CmsBlock
{
    const COMPONENT_NAME = 'Block';

    /**
     * @var BlockRepositoryInterface
     */
    private $blockRepository;

    /**
     * @var BlockFactory
     */
    private $blockFactory;

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
     * @param BlockRepositoryInterface $blockRepository
     * @param BlockFactory $blockFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FileProvider $fileProvider
     * @param string $moduleName
     */
    public function __construct(
        BlockRepositoryInterface $blockRepository,
        BlockFactory $blockFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FileProvider $fileProvider,
        string $moduleName
    ) {
        $this->blockRepository = $blockRepository;
        $this->blockFactory = $blockFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->fileProvider = $fileProvider;
        $this->moduleName = $moduleName;
    }

    /**
     * Sets up a CMS block.
     * @param string $blockIdentifier
     * @return void
     */
    public function setupBlock(string $blockIdentifier): void
    {
        $block = $this->getBlockByIdentifier($blockIdentifier);

        $blockDataSet = $this->fileProvider->getDataset(self::COMPONENT_NAME, $this->moduleName, $blockIdentifier);
        $blockContent = $this->fileProvider->getContent(self::COMPONENT_NAME, $this->moduleName, $blockIdentifier);

        foreach ($blockDataSet as $property => $value) {
            $block->setData($property, $value);
        }

        $block->setContent($blockContent);

        $this->blockRepository
            ->save($block);
    }

    /**
     * Returns an instance of CMS block with given $blockIdentifier.
     * If a block with given $blockIdentifier does not exist,
     * a new one is created.
     * @param string $blockIdentifier Identifier of the block.
     * @return Block
     */
    private function getBlockByIdentifier(string $blockIdentifier): Block
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(
                Block::IDENTIFIER,
                $blockIdentifier
            )
            ->setPageSize(1)
            ->create();

        $blockListItems = $this->blockRepository
            ->getList($searchCriteria)
            ->getItems();

        if (!empty($blockListItems)) {
            return array_pop($blockListItems);
        }

        return $this->blockFactory
            ->create()
            ->setIdentifier($blockIdentifier);
    }
}
