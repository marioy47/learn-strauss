<?php

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
