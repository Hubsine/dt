<?php

namespace Dt\AdminBundle\Doctrine;

use AppBundle\Model\AbstractManager;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of AboutUserInterface
 *
 * @author Hubsine
 */
class AboutUserManager extends AbstractManager{
    
    private $treeOptions = array();
    
    public function __construct(ObjectManager $om, $class) {
        
        $this->objectManager = $om;
        $this->class = $class;
        $this->treeOptions = array(
            'decorate' => true,
            'rootOpen' => '<ul>',
            'rootClose' => '</ul>',
            'childOpen' => '<li>',
            'childClose' => '</li>',
            'html' => true,
            'nodeDecorator' => function($node) {
                return $node['label'];
            }
        );
    }
    
    public function getUsersReplyView($node = null, $direct = false, array $options = array(), $includeNode = false){
        
        $options = array_replace($this->treeOptions, $options);
            
        $aboutUser = $this->getRepository()->childrenHierarchy(
            $node, $direct, $options, $includeNode
        );
            
       return $aboutUser;
    }
    
    public function childrenHierarchyEntity($node = null, $direct = false, array $options = array(), $includeNode = false){
        
        $aboutUser = $this->getRepository()->getNodesHierarchy($node, $direct, $options, $includeNode);
        $nestedTree = array();
        
        $iterator = function($aboutUser){
            
            foreach ($aboutUser as $key => $aboutUser) {
                
            }
        };
        
       
        foreach ($aboutUser as $key => $aboutUser) {
            
            if($aboutUser->getLvl() == 0){
                
            }
        }
        
    }
}
