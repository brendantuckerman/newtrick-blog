<?php

namespace App\EventListener;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsEntityListener(event: Events::prePersist, entity: Post::class)]
#[AsEntityListener(event: Events::preUpdate, entity: Post::class)]
class PostSlugger
{
    public function __construct(
        private SluggerInterface $slugger,
        private EntityManagerInterface $entityManager
    ) {}

    public function prePersist(Post $post, LifecycleEventArgs $event): void
    {
        $this->updateSlug($post);
    }

    public function preUpdate(Post $post, LifecycleEventArgs $event): void
    {
        $this->updateSlug($post);
    }

    private function updateSlug(Post $post): void
    {
        $slug = $this->slugger->slug($post->getTitle())->lower();
        
        $originalSlug = $slug;
        $count = 1;
        
        while ($this->slugExists($slug, $post->getId())) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $post->setSlug($slug);
    }

    private function slugExists(string $slug, ?int $excludeId = null): bool
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('COUNT(p.id)')
           ->from(Post::class, 'p')
           ->where('p.slug = :slug')
           ->setParameter('slug', $slug);

        if ($excludeId !== null) {
            $qb->andWhere('p.id != :id')
               ->setParameter('id', $excludeId);
        }

        return $qb->getQuery()->getSingleScalarResult() > 0;
    }
}