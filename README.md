# Learning Strauss

This are just personal instructions on how to work with Strauss <https://github.com/BrianHenryIE/strauss> and what it changes when working with it.

## Create the project

- I'll be using the namespace `MyNamespace`
- Create a model class in `src/Model/Mario.php`
- Create a file in `public/index.php` file that uses that class

```bash
mkdir learning-strauss
cd $_
composer init
```

- Set the `PSR-4` class path.

```bash {8}
{
    "name": "marioy47/learn-strauss",
    "description": "A test of composer with strauss",
    "type": "project",
    "license": "MIT",
    "autoload": {
        "psr-4": {
            "MyNamespace\\": "src/"
        }
    },
    "authors": [
        {
            "name": "Mario Yepes",
            "email": "marioy47@gmail.com"
        }
    ],
    "require": {},
}
```

## Creating the working files

- Include an external library for testing

```bash
composer require splitbrain/php-cli
```

- Use some classes of the package in the `Mario` class

```php
<?php // src/Model;

namespace MyNamespace\Model;

use splitbrain\phpcli\CLI;
use splitbrain\phpcli\Options;

class Mario extends CLI
{
    public function setup(Options $options)
    {
        $options->setHelp('A test for strauss');
    }

    public function main(Options $options ): void
    {
        echo $options->help();
    }
}
```

- A script that uses the `Mario` class

```php
<?php // public/index.php

require_once dirname( __DIR__ ) . '/vendor/autoload.php';

use Model\Mario;

$marioModel = new Mario();

$marioModel->run();
```

- Create a script for easier execution

```json {20-22}
{
  "name": "marioy47/learn-strauss",
  "description": "A test of composer with strauss",
  "type": "project",
  "license": "MIT",
  "autoload": {
    "psr-4": {
      "MyNamespace\\": "src/"
    }
  },
  "authors": [
    {
      "name": "Mario Yepes",
      "email": "marioy47@gmail.com"
    }
  ],
  "require": {
    "splitbrain/php-cli": "^1.2"
  },
  "scripts": {
    "speak": ["@php public/index.php"]
  }
}
```

- Test that it works:

```bash
composer dump-autoload
composer speak
```

## Adding strauss

- Only showing the changes on the Json file

```json
{
    "...",
    "scripts": {
        "speak": [
            "@php public/index.php"
        ],
        "strauss": [
            "mkdir -p ./bin/",
            "test -f ./bin/strauss.phar || curl -o bin/strauss.phar -L -C - https://github.com/BrianHenryIE/strauss/releases/download/0.13.0/strauss.phar",
            "@php bin/strauss.phar"
        ],
        "scripts": {
            "post-install-cmd": [
                    "@strauss"
            ],
            "post-update-cmd": [
                    "@strauss"
            ]
        }
    },
    "extra": {
        "strauss": {
            "namespace_prefix": "MyNamespace\\",
            "classmap_prefix": "MyNamespace_",
            "constant_prefix": "MY_NAMESPACE_",
            "delete_vendor_files": true,
            "packages": [
                "splitbrain/php-cli"
            ],
            "excluded_from_prefix": {
                "file_patterns": []
            }
        }
    }
}
```

- Use strauss to move the files to `vendor-prefix` and change the classname

```bash
composer strauss
```

- Add the strauss autoloader

```php {4}
<?php // public/index.php

require_once dirname( __DIR__ ) . '/vendor-prefixed/autoload.php';
require_once dirname( __DIR__ ) . '/vendor/autoload.php';

use MyNamespace\Model\Mario;

$marioModel = new Mario();

$marioModel->run();
```

- Change the namespace for the CLI and Options classes

```php {5-6}
<?php // src/Model/Mario.php

namespace MyNamespace\Model;

use MyNamespace\splitbrain\phpcli\CLI;
use MyNamespace\splitbrain\phpcli\Options;

class Mario extends CLI
{
    public function setup(Options $options)
    {
        $options->setHelp('A test for strauss');
    }

    public function main(Options $options ): void
    {
        echo $options->help();
    }
}
```

- Test that it still works

```bash
composer speak
```

## Notes

- The php-cli files are gone from `vendor/splitbrain/php-cli/src`
- The files where copied to `vendor-prefixed/splitbrain/php-cli/src/`
- The _Namespaces_ of all the files in `vendor-prefixed` now start with `MyNamespace\`

```head
head vendor-prefixed/splitbrain/php-cli/src/CLI.php
```

## Resources

- <https://github.com/BrianHenryIE/strauss>
- <https://github.com/stellarwp/global-docs/blob/main/docs/strauss-setup.md>
