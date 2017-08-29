<?php

namespace AppBundle\Twig\Extensions;

use Symfony\Component\Intl\Intl;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Description of FileExists
 *
 * @author Hubsine
 */
class FileExistsExtension extends \Twig_Extension 
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('fileExists', array($this, 'fileExistsFilter')),
        );
    }

    public function FileExistsFilter($filePath)
    {
        $fs = new Filesystem();
        
        return $fs->exists($filePath);
    }
}
