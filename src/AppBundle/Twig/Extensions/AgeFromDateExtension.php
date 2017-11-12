<?php

namespace AppBundle\Twig\Extensions;


/**
 * Description of FileExists
 *
 * @author Hubsine
 */
class AgeFromDateExtension extends \Twig_Extension 
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('getAge', array($this, 'getAgeFromDateFilter')),
        );
    }

    /**
     * Get age/diff entre deux date 
     * 
     * @param \DateTime $date
     * @return null|integer
     */
    public function getAgeFromDateFilter(\DateTime $date)
    {
        if (!$date instanceof \DateTime) {
            // turn $date into a valid \DateTime object or let return
            return null;
        }

        $currentDate = new \DateTime('now');
        $diff = $date->diff($currentDate);
        
        return $diff->y;
    }
}
