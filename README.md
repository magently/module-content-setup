# Magently Content Setup Module

## Installation

To install the module, run the following commands:

```
composer require magently/module-content-setup
php bin/magento setup:upgrade
```

## Usage

Now you can use the module in your code.
Inject `Magently\ContentSetup\Model\ContentSetupFactory` in your UpgradeData / PatchData class - a Factory is used here so that you can use this module in different modules in the project, for example:

```
  public function __construct(\Magently\ContentSetup\Model\ContentSetupFactory $contentSetupFactory)
  {
      $this->contentSetupFactory = $contentSetupFactory;
  }
```

Then create an object from a Factory passing the name of your module, for example:

```
/** @var \Magently\ContentSetup\Model\ContentSetup $setup */
$setup = $this->contentSetupFactory->create(['moduleName' => 'Magently_TestModule']);
```

From now on, you can use the module to upload your content:

```
$setup->setupPage('test_page');
$setup->setupBlock('test_block');
$setup->setupEmailTemplate('test_email');
$setup->setupVariable('test_variable', 'TEST VARIABLE');
```

Cms Pages, Cms Blocks and Email Templates must be placed in the structure of your module:
`app/code/VendorName/ModuleName/Setup/Content/{COMPONENT_NAME}`, e.g.
`app/code/Magently/TestModule/Setup/Content/Block/test_block.html` and `app/code/Magently/TestModule/Setup/Content/Block/test_block.php`

files will be used to create / update a block with a `test_block` identifier. Put the content of the block in the `.html` file. In the `.php` file, put the data as an array with keys such as `name` or `is_active`:

```
// file: app/code/Magently/TestModule/Setup/Content/Block/test_block.php
<?php

return [
    'title' => 'Magently Test Block',
    'identifier' => 'test_block',
    'is_active' => 1
];
```

Declare Magento Variables as below, without any files:

```
    public function setupVariable(
        string $code,
        string $name = null,
        string $plainValue = null,
        string $htmlValue = null
    )
```

## More information
You can find more about how the module works on our Magently blog: https://magently.com/blog/add-magento-cms-blocks-programmatically

In case of problems or ideas on how to improve the module, don't hestiate to open a pull request.
