<?php

namespace App\DataFixtures;

use App\Entity\LegalStatus;
use App\Repository\LegalStatusRepository;
use App\Services\ImportLegalStatusService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use PhpOffice\PhpSpreadsheet\Exception as ExceptionAlias;

class LegalStatusFixtures extends Fixture
{
    public function __construct(protected ImportLegalStatusService $importService, protected LegalStatusRepository $legalStatusRepository)
    {
    }

    /**
     * @param ObjectManager $manager
     * @return void
     * @throws ExceptionAlias
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function load(ObjectManager $manager)
    {
        $fixtures = $this->getFixturesData();

        foreach ($fixtures as $fixture)
        {
            $exist = $this->legalStatusRepository->findOneBy(['name' => $fixture[0]]);
            if ( $exist ) continue;

            $entity = new LegalStatus();
            $entity->setName($fixture[0]);
            $manager->persist($entity);
        }
        $manager->flush();
    }

    /**
     * retourne le contenu du fichier excel sous format Array
     * @throws ExceptionAlias
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    protected function getFixturesData(): bool|array
    {
        if($this->importService->importLegalStatus()) {
            $dataFixtures = $this->importService->importLegalStatus();
            array_shift($dataFixtures); //suppression du premier ligne du fichier excel 'Libellé'
            return $dataFixtures;
        }
        return $this->importService->importLegalStatus();

    }
}
