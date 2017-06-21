<?php

namespace Dt\AdminBundle\Doctrine;

use AppBundle\Model\AbstractManager;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of AboutUserInterface
 *
 * @author Hubsine
 */
class AboutUsersManager extends AbstractManager{
    
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
            
        $aboutUsers = $this->getRepository()->childrenHierarchy(
            $node, $direct, $options, $includeNode
        );
            
       return $aboutUsers;
    }
    
    public function childrenHierarchyEntity($node = null, $direct = false, array $options = array(), $includeNode = false){
        
        $aboutUsers = $this->getRepository()->getNodesHierarchy($node, $direct, $options, $includeNode);
        $nestedTree = array();
        
        $iterator = function($aboutUsers){
            
            foreach ($aboutUsers as $key => $aboutUser) {
                
            }
        };
        
       
        foreach ($aboutUsers as $key => $aboutUser) {
            
            if($aboutUser->getLvl() == 0){
                
            }
        }
        
    }
}
