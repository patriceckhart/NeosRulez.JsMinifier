<?php
namespace NeosRulez\JsMinifier\Domain\Factory;

/*
 * This file is part of the NeosRulez.JsMinifier package.
 */

use Neos\Flow\Annotations as Flow;
use MatthiasMullie\Minify;

/**
 * @Flow\Scope("singleton")
 */
class JsMinifierFactory
{

    public function minifieJs($jsFile) {
        $sourcePath = file_get_contents($jsFile);
        $minifier = new Minify\JS($sourcePath);
        $js = $minifier->minify();
        return $js;
    }

}
