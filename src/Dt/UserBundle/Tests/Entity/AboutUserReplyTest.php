<?php

namespace Dt\UserBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Dt\UserBundle\Entity\AboutUserReply;
use Dt\AdminBundle\Entity\AboutUser;
use Dt\UserBundle\Entity\User;

/**
 * Description of AboutUserReplyTest
 *
 * @author Hubsine
 */
class AboutUserReplyTest extends WebTestCase {

    public function testUniqueEntity()
    {
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
        
        $aboutUserReply = new AboutUserReply();
        $aboutUser = new AboutUser();
        $user = new User();
        
        // Is unique
        $aboutUserReply->setUser($user);
        $aboutUserReply->setAboutUser($aboutUser);
    }
}
