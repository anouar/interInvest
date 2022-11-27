<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PageControllerTest extends WebTestCase
{
    public function testHomePage()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bienvenue - Welcome - Welkom - Bonvenon - Benvenuto');
    }

    public function CompanyCreatePage()
    {
        $client = static::createClient();
        $client->request('GET', '/company/new');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', '/company/new');
    }

    public function listCompanyPage()
    {
        $client = static::createClient();
        $client->request('GET', '/company/list');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Liste des entreprises');
    }

}
