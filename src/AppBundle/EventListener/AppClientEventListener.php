<?php

namespace AppBundle\EventListener;

use Gos\Bundle\WebSocketBundle\Event\ClientEvent;
use Gos\Bundle\WebSocketBundle\Event\ClientErrorEvent;
use Gos\Bundle\WebSocketBundle\Event\ServerEvent;
use Gos\Bundle\WebSocketBundle\Event\ClientRejectedEvent;
use Gos\Bundle\WebSocketBundle\Client\ClientManipulatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use React\Socket\ConnectionInterface;

/**
 * Description of AppClientEventListener
 *
 * @author Hubsine
 */
class AppClientEventListener
{
    
    /** private $connections Ratchet\ConnectionInterface */
    private $connections = array();
    
    /** protected $clientManipulator */
    protected $clientManipulator;

    /**
     * @param ClientManipulatorInterface $clientManipulator
     */
    public function __construct(ClientManipulatorInterface $clientManipulator)
    { 
        $this->clientManipulator = $clientManipulator;
    }
    
    /**
     * Called whenever a client connects
     *
     * @param ClientEvent $event
     */
    public function onClientConnect(ClientEvent $event)
    {
        $conn = $event->getConnection();
        $user = $this->clientManipulator->getClient($conn);
        
        if( $user instanceof UserInterface )
        {
            $this->connections[$user->getId()] = $conn;
        }
        
        echo $conn->resourceId . " connected" . PHP_EOL;
    }

    /**
     * Called whenever a client disconnects
     *
     * @param ClientEvent $event
     */
    public function onClientDisconnect(ClientEvent $event)
    {
        $conn = $event->getConnection();
        
        unset($this->connections[$this->clientManipulator->getClient($conn)]);
        
        echo $conn->resourceId . " disconnected" . PHP_EOL;
    }

    /**
     * Called whenever a client errors
     *
     * @param ClientErrorEvent $event
     */
    public function onClientError(ClientErrorEvent $event)
    {
        $conn = $event->getConnection();
        $e = $event->getException();

        echo "connection error occurred: " . $e->getMessage() . PHP_EOL;
    }

    /**
     * Called whenever server start
     *
     * @param ServentEvent $event
     */
    public function onServerStart(ServerEvent $event)
    {
    	$event = $event->getEventLoop();

        echo 'Server was successfully started ! Good !'. PHP_EOL;
    }

    /**
     * Called whenever client is rejected by application
     *
     * @param ClientRejectedEvent $event
     */
    public function onClientRejected(ClientRejectedEvent $event)
    {
    	$origin = $event->getOrigin();

	echo 'connection rejected from '. $origin . PHP_EOL;
    }
    
    /**
     * Check if user is online or not
     * 
     * @param UserInterface $user
     * @return boolean
     */
    public function userIsOnline(UserInterface $user)
    {
        $userId = $user->getId();
        $connection = ( isset($this->connections[$userId]) ) ? $this->connections[$userId] : null;
        
        if( $connection instanceof ConnectionInterface)
        {
            return true;
        }
        
        return false;
        
    }
}