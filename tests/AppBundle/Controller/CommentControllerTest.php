<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/comment');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testEditGet()
    {
        $client = static::createClient();

        $gitMock = $this->getMockBuilder(\Github\Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $apiMock = $this->getMockBuilder(\Github\Api\User::class)
            ->disableOriginalConstructor()
            ->getMock();

        $apiMock
            ->expects($this->at(0))
            ->method('show')
            ->with('aricci')
            ->willReturn(
                [
                    'name'       => 'Antoine Ricci',
                    'login'      => 'aricci',
                    'avatar_url' => 'aricci.jpg',
                ]
            );

        $apiMock
            ->expects($this->at(1))
            ->method('repositories')
            ->willReturn([['full_name' => 'aricci/toto']]);

        $gitMock
            ->expects($this->atLeastOnce())
            ->method('api')
            ->willReturn($apiMock);

        $client->getContainer()->set('github.client', $gitMock);
        $crawler = $client->request('GET', '/comment/aricci');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
