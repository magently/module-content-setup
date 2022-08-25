<?php

namespace Magently\ContentSetup\Provider;

use Magento\Framework\Component\ComponentRegistrar;

/**
 * Class PathProvider
 * The class responsible for providing a path to specific file
 */
class PathProvider
{
    /**
     * @var ComponentRegistrar
     */
    private $componentRegistrar;

    /**
     * @param ComponentRegistrar $componentRegistrar
     */
    public function __construct(ComponentRegistrar $componentRegistrar)
    {
        $this->componentRegistrar = $componentRegistrar;
    }

    /**
     * @param string $type
     * @param string $moduleName
     * @return string
     */
    public function get(string $type, string $moduleName)
    {
        return implode(
            DIRECTORY_SEPARATOR,
            [
                $this->componentRegistrar->getPath(
                    ComponentRegistrar::MODULE,
                    $moduleName
                ),
                'Setup',
                'Content',
                $type
            ]
        );
    }
}
