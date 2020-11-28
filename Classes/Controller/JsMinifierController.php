<?php
namespace NeosRulez\JsMinifier\Controller;

/*
 * This file is part of the NeosRulez.JsMinifier package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Neos\Eel\FlowQuery\FlowQuery;
use Neos\Eel\FlowQuery\Operations;

class JsMinifierController extends ActionController
{

    /**
     * @Flow\Inject
     * @var \NeosRulez\JsMinifier\Domain\Factory\JsMinifierFactory
     */
    protected $jsMinifierFactory;

    /**
     * @return void
     * @Flow\SkipCsrfProtection
     */
    public function includeFileAction() {
        $jsFile = $this->request->getInternalArgument('__source');
        $inline = $this->request->getInternalArgument('__inline');
        if($inline == TRUE) {
            $js = $this->jsMinifierFactory->minifieJs($jsFile);
            $this->view->assign('js',$js);
        } else {
            $outputFolder = $this->request->getInternalArgument('__outputFolder');
            $minfile = explode("/", $jsFile);
            $minfile = $minfile[count($minfile) - 1];
            $minfile = explode(".", $minfile);
            $minfile = $minfile[0] . '.min.js';
            $file = $outputFolder . $minfile;
            $sourceFileTs = filemtime($jsFile);
            if (file_exists($file)) {
                $targetFileTs = filemtime($file);
                if ($sourceFileTs > $targetFileTs) {
                    $js = $this->jsMinifierFactory->minifieJs($jsFile);
                    file_put_contents($file, $js);
                }
            } else {
                $js = $this->jsMinifierFactory->minifieJs($jsFile);
                file_put_contents($file, $js);
            }
            $path = explode("/", $file);
            $package = $path[2];
            $filepath = '';
            for ($i = 3; $i < count($path); $i++) {
                if ($i == count($path) - 1) {
                    $filepath .= $path[$i];
                } else {
                    if ($i != 3) {
                        $filepath .= $path[$i] . '/';
                    }
                }
            }
            $this->view->assign('package',$package);
            $this->view->assign('filepath',$filepath);
        }
    }

}
