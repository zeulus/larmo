<?php

namespace FP\Larmo\Plugin\MongoStorage;

use FP\Larmo\Application\Event\IncomingMessageEvent;
use FP\Larmo\Domain\Service\LarmoEvents;
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

    public function onStoreMessages(IncomingMessageEvent $event)
    {
        $result = $this->storage->store($event->getMessages());
        if (false === $result) {
            $event->setError('MongoDB Write failed');
        } elseif (is_array($result) && !empty($result['err'])) {
            $event->setError('MongoDB Write failed: '. $result['err']);
        }
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
            LarmoEvents::INCOMING_MESSAGE => array('onStoreMessages', 0),
            LarmoEvents::RETRIEVE_MESSAGES => array('onRetrieveMessages', 0),
        );
    }
}