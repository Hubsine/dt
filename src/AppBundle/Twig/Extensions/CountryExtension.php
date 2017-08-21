<?php

namespace AppBundle\Twig\Extensions;

use Symfony\Component\Intl\Intl;

/**
 * Description of Country
 *
 * @author Hubsine
 */
class CountryExtension extends \Twig_Extension 
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('countryName', array($this, 'countryNameFilter')),
        );
    }

    public function countryNameFilter($countryISOCode)
    {
        return Intl::getRegionBundle()->getCountryName($countryISOCode);
    }
}
