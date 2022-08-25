<?php

namespace Magently\ContentSetup\Provider;

use Magento\Framework\Filesystem\Driver\File;

/**
 * Class FileProvider
 * The class responsible for providing content of specific file
 */
class FileProvider
{
    /**
     * @var PathProvider
     */
    private $pathProvider;

    /**
     * @var File
     */
    private $file;

    /**
     * @param PathProvider $pathProvider
     * @param File $file
     */
    public function __construct(PathProvider $pathProvider, File $file)
    {
        $this->pathProvider = $pathProvider;
        $this->file = $file;
    }

    /**
     * Get content of specific HTML file
     * @param string $type
     * @param string $moduleName
     * @param string $identifier
     * @return string
     */
    public function getContent(string $type, string $moduleName, string $identifier)
    {
        $path = $this->pathProvider->get($type, $moduleName)
            . DIRECTORY_SEPARATOR
            . $identifier
            . '.html';

        return $this->file
            ->fileGetContents($path);
    }

    /**
     * Get dataset from the specific file
     * @param string $type
     * @param string $moduleName
     * @param string $identifier
     * @return array|mixed
     */
    public function getDataset(string $type, string $moduleName, string $identifier)
    {
        $path = $this->pathProvider->get($type, $moduleName)
            . DIRECTORY_SEPARATOR
            . $identifier
            . '.php';

        if (!$this->file->isExists($path)) {
            return [];
        }

        try {
            // phpcs:ignore Ecg.Security.IncludeFile.IncludeFileDetected, Magento2.Security.IncludeFile.FoundIncludeFile
            return require $path;
        } catch (\Exception $exception) {
            return [];
        }
    }
}
