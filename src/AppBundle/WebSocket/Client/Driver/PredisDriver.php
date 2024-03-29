<?php 

namespace AppBundle\WebSocket\Client\Driver;

use Gos\Bundle\WebSocketBundle\Client\DriverInterface;
use Predis\Client;

class PredisDriver implements DriverInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * string $prefix
     */
    protected $prefix;

    /**
     * @param Client $client
     * @param string $prefix
     */
    public function __construct(Client $client, $prefix = '')
    {
        $this->client = $client;
        $this->prefix = ($prefix !== false ? $prefix . ':' : '');
    }

    /**
     * {@inheritdoc}
     */
    public function fetch($id)
    {
        $result = $this->client->get($this->prefix . $id);
        if (null === $result) {
            return false;
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function contains($id)
    {
        return $this->client->exists($this->prefix . $id);
    }

    /**
     * {@inheritdoc}
     */
    public function save($id, $data, $lifeTime = 0)
    {
        if ($lifeTime > 0) {
            $response = $this->client->setex($this->prefix . $id, $lifeTime, $data);
        } else {
            $response = $this->client->set($this->prefix . $id, $data);
        }

        return $response === true || $response == 'OK';
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        return $this->client->del($this->prefix . $id) > 0;
    }
}