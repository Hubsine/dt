<?php

namespace Dt\AdminBundle\Form\DataTransformer;

use Dt\AdminBundle\Entity\AboutUser;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Description of AboutUserToNumberTransformer
 *
 * @author Hubsine
 */
class AboutUserToNumberTransformer implements DataTransformerInterface {

    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (AboutUser) to a string (number).
     *
     * @param  Issue|null $aboutUser
     * @return string
     */
    public function transform($aboutUser)
    {
        if (null === $aboutUser) {
            return '';
        }

        return $aboutUser->getId();
    }

    /**
     * Transforms a string (number) to an object (AboutUser).
     *
     * @param  string $aboutUserNumber
     * @return Issue|null
     * @throws TransformationFailedException if object (AboutUser) is not found.
     */
    public function reverseTransform($aboutUserNumber)
    {
        // no AboutUser number? It's optional, so that's ok
        if (!$aboutUserNumber) {
            return;
        }

        $aboutUser = $this->manager
            ->getRepository(AboutUser::class)
            // query for the AboutUser with this id
            ->find($aboutUserNumber)
        ;

        if (null === $aboutUser) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An AboutUser with number "%s" does not exist!',
                $aboutUserNumber
            ));
        }

        return $aboutUser;
    }
    
}
