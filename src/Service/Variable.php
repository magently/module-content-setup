<?php

namespace Magently\ContentSetup\Service;

use Magento\Variable\Model\Variable as VariableModel;
use Magento\Variable\Model\VariableFactory as VariableModelFactory;
use Magento\Variable\Model\ResourceModel\Variable as VariableResource;

/**
 * Class Variable
 * This class is responsible for adding a new or modifying existing Variable
 */
class Variable
{
    /**
     * @var VariableModelFactory
     */
    private $variableFactory;

    /**
     * @var VariableResource
     */
    private $variableResource;

    public function __construct(
        VariableModelFactory $variableFactory,
        VariableResource $variableResource
    ) {
        $this->variableFactory = $variableFactory;
        $this->variableResource = $variableResource;
    }

    /**
     * Sets up a Variable.
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
    ): void {
        $variable = $this->getVariable($code);

        if ($name !== null) {
            $variable->setName($name);
        }

        if ($plainValue !== null) {
            $variable->setPlainValue($plainValue);
        }

        if ($htmlValue !== null) {
            $variable->setHtmlValue($htmlValue);
        }

        $this->variableResource
            ->save($variable);
    }

    /**
     * Returns a Variable model for a variable with given code.
     * If a variable with given code does not exist, a new one is created.
     * @param string $code
     * @return VariableModel
     */
    private function getVariable(string $code): VariableModel
    {
        $variable = $this->variableFactory->create();
        $this->variableResource->load($variable, $code, 'code');

        if (!$variable->getId()) {
            $variable->setCode($code);
        }

        return $variable;
    }
}
