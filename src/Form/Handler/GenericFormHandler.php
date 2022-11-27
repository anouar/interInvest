<?php

namespace App\Form\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Generic Form Handler permet de gérer les forms
 */
class GenericFormHandler
{
    protected $em;

    /**
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * process submission
     *
     * @param Form $form
     * @param Request $request
     * @param bool $doFlush
     *
     * @return boolean
     */
    public function process(Form $form, Request $request)
    {
        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entity = $form->getData();
                if ($entity->getId() == null) {
                    $entity->setCreatedAt(new \DateTime('now') );
                    $this->em->persist($entity);
                }
                $entity->setUpdatedAt(new \DateTime('now') );
                $this->em->flush();

                return true;
            }
        }

        return false;
    }

}
