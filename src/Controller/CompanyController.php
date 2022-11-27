<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\CompanyHistory;
use App\Form\CompanyType;
use App\Form\Handler\GenericFormHandler;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class CompanyController extends AbstractController
{
    #[Route('/company/new', name: 'new_company')]
    public function newCompany(GenericFormHandler $genericFormHandler, Request $request): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class);

        if($genericFormHandler->process($form, $request)){
            $this->addFlash('success', 'Entreprise ajouté');
            return $this->redirectToRoute('index_company', ['id' => $company->getId()]);
        }

        return  $this->render('company/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/company/edit/{id}', name: 'edit_company')]
    public function editCompany(Company $company, GenericFormHandler $genericFormHandler, Request $request): Response
    {
        $form = $this->createForm(CompanyType::class, $company);

        if($genericFormHandler->process($form, $request)){
            $this->addFlash('success', 'Modification enregistrée');
            return $this->redirectToRoute('index_company', ['id' => $company->getId()]);
        } else {
            $this->addFlash('error', 'Une erreur est survenue');
        }

        return  $this->render('company/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/company/list', name: 'list_company')]
    public function listCompany(EntityManagerInterface $em, Request $request, PaginatorInterface $paginator): Response
    {
        $listOfCompany = $em->getRepository(Company::class)->findAll();
        $companies = $paginator->paginate(
            $listOfCompany,
            $request->query->getInt('page', 1),
            5
        );
        return  $this->render('company/list.html.twig', [
            'companies' => $companies
        ]);
    }


    #[Route('/company/{id}', name: 'index_company')]
    public function showCompany(Company $company, EntityManagerInterface $em, Request $request, SerializerInterface $serializer): Response
    {
        $id = $company->getId();
        $form = $this->createForm(SearchType::class);
        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entity = $form->getData();
                $history = $em->getRepository(CompanyHistory::class)->getHistoryCompanyByDate($entity->getCreatedAt());

                if(!empty($history)){
                    $company = $serializer->deserialize($history[0]->getHistory()[0], Company::class, JsonEncoder::FORMAT);
                } else {
                    $this->addFlash('error', 'Pas d\'historique sauvgardé à cette date');
                }
            }
        }

        return  $this->render('company/show.html.twig', [
            'company' => $company,
            'id' => $id,
            'form' => $form->createView()
        ]);
    }


}
