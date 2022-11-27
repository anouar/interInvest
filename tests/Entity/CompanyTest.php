<?php


namespace App\Tests\Entity;

use App\Entity\Adress;
use App\Entity\Company;
use App\Entity\LegalStatus;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validation;

class CompanyTest extends KernelTestCase
{
    private const NOT_BLANK_CONSTRAINT_MESSAGE = 'Veuillez saisir une valeur.';


    public function getEntity(): Company
    {
        $company = new Company();
        $adress = new Adress();
        $legalStatus = new LegalStatus();
        $legalStatus->setName('');
        $adress->setNumber(2)
            ->setStreet('Victor Hugo')
            ->setType(1)
            ->setCodePostal(75000);
        $company
            ->setName('INTER INVEST')
            ->setCapital(30628)
            ->setCityRegistration('Paris')
            ->setCodeSiren('383 848 660')
            ->setDateRegistration(new \DateTime('now'))
            ->setLegalStatus($legalStatus)
            ->addAdress($adress);
        return $company;
    }

    public function assertHasErrors(Company $company, int $number = 0)
    {

        $validator = Validation::createValidator();
        $errors = $validator->validate($company);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }
        $this->assertCount($number, $errors, implode(', ', $messages));
    }


    /**
     * Test if Company is a valid entity
     */
    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }


}
