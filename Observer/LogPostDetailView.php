<?php
declare(strict_types=1);

namespace RubenRomao\BlogPosts\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

/**
 * Logs Viewed Posts
 */
class LogPostDetailView implements ObserverInterface
{
    /**
     * LogPostDetailView constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {
    }

    /**
     * Logs Viewed Posts
     *
     * @param  Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $request = $observer->getData('request');
        $this->logger->info(
            'blog post detail viewed',
            [
            'params' => $request->getParams(),
            ]
        );
    }
}
