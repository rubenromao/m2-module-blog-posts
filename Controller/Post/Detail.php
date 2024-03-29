<?php
declare(strict_types=1);

namespace RubenRomao\BlogPosts\Controller\Post;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Blog post detail controller.
 */
class Detail implements HttpGetActionInterface
{
    /**
     * Constructor.
     *
     * @param PageFactory $pageFactory
     * @param EventManager $eventManager
     * @param RequestInterface $request
     */
    public function __construct(
        private readonly PageFactory      $pageFactory,
        private readonly EventManager     $eventManager,
        private readonly RequestInterface $request,
    ) {
    }

    /**
     * Execute action based on request and return result.
     *
     * @return Page
     */
    public function execute(): Page
    {
        $this->eventManager->dispatch(
            'rubenromao_blog_post_detail_view',
            [
                'request' => $this->request,
            ],
        );

        return $this->pageFactory->create();
    }
}
