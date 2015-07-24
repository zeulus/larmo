<?php

namespace FP\Larmo\Plugin\MongoStorage;

use FP\Larmo\Application\Event\MessagesStoreEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EventSubscriber implements EventSubscriberInterface
{

    /**
     * @var MongoDbStorage
     */
    private $storage;

    public function __construct(MongoDbMessages $storage)
    {
        $this->storage = $storage;
    }

    public function onStoreMessages(MessagesStoreEvent $event)
    {
        $this->storage->store($event->getMessages());
    }

    public function onRetrieveMessages()
    {
        // @todo
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            LarmoEvents::STORE_MESSAGES => array('onStoreMessages', 0),
            LarmoEvents::RETRIEVE_MESSAGES => array('onRetrieveMessages', 0),
        );
    }
}