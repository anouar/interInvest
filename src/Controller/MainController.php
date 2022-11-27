<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\SearchComapnyType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(Request $request, PaginatorInterface $paginator, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(SearchComapnyType::class);
        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entity = $form->getData();
                $companies = $em->getRepository(Company::class)->findCompany($entity['search']);
                return  $this->render('company/list.html.twig', [
                    'companies' =>  $paginator->paginate(
                        $companies,
                        $request->query->getInt('page', 1),
                        5
                    )
                ]);
            }
        }
        return  $this->render('main/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
