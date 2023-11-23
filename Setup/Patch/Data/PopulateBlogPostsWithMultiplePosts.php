<?php
declare(strict_types=1);

namespace Rubenromao\BlogPosts\Setup\Patch\Data;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Psr\Log\LoggerInterface;
use Rubenromao\BlogPosts\Api\PostRepositoryInterface;
use Rubenromao\BlogPosts\Model\PostFactory;

/**
 * Class PopulateBlogPostsWithMultiplePosts
 *
 * @package Rubenromao\BlogPosts\Setup\Patch\Data
 */
class PopulateBlogPostsWithMultiplePosts implements DataPatchInterface
{
    /**
     * Constructor.
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param PostFactory $postFactory
     * @param PostRepositoryInterface $postRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly ModuleDataSetupInterface $moduleDataSetup,
        private readonly PostFactory              $postFactory,
        private readonly PostRepositoryInterface  $postRepository,
        private readonly LoggerInterface          $logger,
    ) {}

    /**
     * @return array|string[]
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @return array|string[]
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * @return void
     * @throws LocalizedException
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        $posts = [
            [
                'title'   => 'Today is sunny',
                'content' => 'The weather has been great all week.',
            ],
            [
                'title'   => 'My movie review',
                'content' => 'I give this movie 5 out of 5 stars!',
            ],
        ];

        foreach ($posts as $postData) {
            $post = $this->postFactory->create();
            $post->setData($postData);

            try {
                $this->postRepository->save($post);
            } catch (LocalizedException $e) {
                $logMessage = 'Could not save post: ' . $e->getMessage();
                $this->logger->critical($logMessage);
            }
        }

        $this->moduleDataSetup->endSetup();
    }
}