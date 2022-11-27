<?php
namespace App\EventSubscriber;

use App\Entity\Adress;
use App\Entity\Company;
use App\Entity\Companyhistory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;


class HistorySubscriber  implements EventSubscriberInterface
{

    public function getSubscribedEvents(): array
    {
        return [
            Events::preUpdate,
            Events::postUpdate
        ];
    }

    public function __construct(protected EntityManagerInterface $entityManager, protected SerializerInterface $serializer)
    {
    }

    /**
     * @param PreUpdateEventArgs $event
     * @return void
     */
    public function preUpdate(PreUpdateEventArgs $event)
    {
        $entity = $event->getObject();
        if ($entity instanceof Company) {
            $company = $this->entityManager->getRepository(Company::class)->find($entity->getId());
            $companyHistory = new CompanyHistory();
            $companyHistory->setCompany($company);
            $companyHistory->setCreatedAt(new \DateTime('now'));
            $jsonCompany = $this->serializer->serialize($company, JsonEncoder::FORMAT, [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }]);

            $companyHistory->setHistory([$jsonCompany]);
            $this->entityManager->persist($companyHistory);
        }
    }

    /**
     * @return void
     */
    public function postUpdate()
    {
        $this->entityManager->flush();
    }
}
