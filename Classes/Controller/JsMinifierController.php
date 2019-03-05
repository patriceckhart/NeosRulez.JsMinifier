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
     * @var \NeosRulez\JsMinifier\Domain\Repository\JsMinifierRepository
     */
    protected $jsMinifierRepository;

    /**
     * @return void
     */
    public function includeFileAction() {
        $jsFile = $this->request->getInternalArgument('__source');
        $inline = $this->request->getInternalArgument('__inline');
        $js = $this->jsMinifierRepository->minifieJs($jsFile);
        if($inline == TRUE) {
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
                    file_put_contents($file, $js);
                }
            } else {
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
