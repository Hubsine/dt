<?php

namespace Dt\AdminBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Dt\AdminBundle\Entity\AboutUser;
use Symfony\Component\Validator\Validation;
use Dt\AdminBundle\Entity\AboutUserMeta;

class AboutUserTest extends WebTestCase
{
    
    public function testAboutUserMetas(){
        
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
        $aboutUser = new AboutUser();
        $aboutUserMeta = new AboutUserMeta();
        
        # - Un AboutUser qui a un expected type radio ou checkbox doit avoir un aboutUserMetas ou plus. 
        # - with radio
        $aboutUser->setExpectedReplyType('radio');
        $aboutUser->addAboutUserMeta($aboutUserMeta);
        $errors = $validator->validate($aboutUser, null, array("TestAboutUserMetas"));
        $this->assertEquals(0, $errors->count());
 
        # - with checkbox
        $aboutUser->setExpectedReplyType('checkbox');
        $errors = $validator->validate($aboutUser, null, array("TestAboutUserMetas"));
        $this->assertEquals(0, $errors->count());
        
        # - Un AboutUser qui a un expected type radio ou checkbox ne peut avoir un aboutUserMetas null.
        $aboutUser->removeAboutUserMeta($aboutUserMeta);
        $errors = $validator->validate($aboutUser, null, array("TestAboutUserMetas"));
        $this->assertGreaterThan(0, $errors->count());
    }

    public function testAboutUserExpectedNotNull(){
        
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
        $aboutUserParent = new AboutUser();
        $aboutUserChild = new AboutUser();
        
        # - Un About User dont le parent a un expectedReplyType response ne peut avoir d'enfant.
        
        # -- Pas de parent 
        $errors = $validator->validate($aboutUserChild, null, array('TestAboutUserExpectedNotNull'));
        var_dump($errors->count());
        $this->assertEquals(0, $errors->count());
        
        # -- Avec parent mais le parent n'a pas de expected
        $aboutUserChild->setParent($aboutUserParent);
        $errors = $validator->validate($aboutUserChild, null, array('TestAboutUserExpectedNotNull'));
        $this->assertEquals(0, $errors->count());
        
        # -- Avec parent qui a un expected
        $aboutUserChild->getParent()->setExpectedReplyType('textarea');
        $errors = $validator->validate($aboutUserChild, null, array('TestAboutUserExpectedNotNull'));
        $this->assertGreaterThan(0, $errors->count());
    }
    

//    public function testIndex()
//    {
//        $client = static::createClient();
//
//        $crawler = $client->request('GET', '/index');
//    }

    /*
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/aboutusermeta/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /aboutusermeta/");
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'dt_adminbundle_aboutusermeta[field_name]'  => 'Test',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'dt_adminbundle_aboutusermeta[field_name]'  => 'Foo',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }

    */
}
