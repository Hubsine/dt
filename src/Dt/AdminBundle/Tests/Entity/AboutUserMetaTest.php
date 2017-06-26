<?php

namespace Dt\AdminBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Dt\AdminBundle\Entity\AboutUser;
use Symfony\Component\Validator\Validation;
use Dt\AdminBundle\Entity\AboutUserMeta;

class AboutUserMetaTest extends WebTestCase
{
    
    public function testAboutUserExpectedIsRadioCheckbox(){
        
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
        $aboutUser = new AboutUser();
        $aboutUserMeta = new AboutUserMeta();
        
        # - Le About User doit être radio ou checkbox
        # - case radion
        $aboutUser->setExpectedReplyType('radio');
        $aboutUserMeta->setAboutUser($aboutUser);
        $errors = $validator->validate($aboutUser, null, array("TestAboutUserExpectedIsRadioCheckbox"));
        $this->assertEquals(0, $errors->count());
 
        # - case autre
        $aboutUserMeta->getAboutUser()->setExpectedReplyType('textarea');
        $errors = $validator->validate($aboutUserMeta, null, array("TestAboutUserExpectedIsRadioCheckbox"));
        $this->assertGreaterThan(0, $errors->count());
        
        # - case null
        $aboutUserMeta->getAboutUser()->setExpectedReplyType(null);
        $errors = $validator->validate($aboutUserMeta, null, array("TestAboutUserExpectedIsRadioCheckbox"));
        $this->assertGreaterThan(0, $errors->count());
        
    }

}
