<?php
namespace NeosRulez\JsMinifier\Domain\Repository;

/*
 * This file is part of the NeosRulez.JsMinifier package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Repository;
use MatthiasMullie\Minify;

/**
 * @Flow\Scope("singleton")
 */
class JsMinifierRepository extends Repository
{

    public function minifieJs($jsFile) {
        $sourcePath = file_get_contents($jsFile);
        $minifier = new Minify\JS($sourcePath);
        $js = $minifier->minify();
        return $js;
    }

}
