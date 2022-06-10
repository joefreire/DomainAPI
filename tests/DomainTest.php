<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Faker\Factory as Faker;
use App\Models\Domain;


class DomainTest extends TestCase
{
    protected  $url = 'domain/';
    public function testFailCreateWithoutAuthDomain()
    {
        $response = $this->call('POST', $this->url, [
            'domain_name' => 'google',
            'tld' => '.com',
        ]);
        $this->assertEquals(401, $response->status());
    }
    public function createDomain()
    {
        $faker = Faker::create();
        $domain = $faker->domainWord;
        $tld = '.' . $faker->tld;
        while (!empty(Domain::where('domain_name', $domain)->first())) {
            $domain = $faker->domainWord;
        }
        $response = $this->call('POST', $this->url, [
            'domain_name' => $domain,
            'tld' => $tld,
        ], [
            'headers' => [
                'Authorization' => 'bearer ' . $this->userLoginData->token
            ]
        ]);
        $this->assertEquals(200, $response->status());
        $this->seeInDatabase('domains', ['domain_name' => $domain, 'tld' => $tld]);
        return $domain;
    }
    public function testCreateDomain()
    {
        $this->getData();
        $this->createDomain();
    }
    public function testGetOneDomain()
    {
        $this->getData();
        $domain = Domain::factory()->create();
        $response = $this->call(
            'GET',
            $this->url . $domain->id,
            [],
            [
                'headers' => [
                    'Authorization' => 'bearer ' . $this->userLoginData->token
                ]
            ]
        );
        $this->assertEquals(200, $response->status());
        $this->seeInDatabase('domains', ['id' => $domain->id]);
    }
    public function testGetAllDomains()
    {
        $this->getData();
        $response = $this->call(
            'GET',
            $this->url,
            [],
            [
                'headers' => [
                    'Authorization' => 'bearer ' . $this->userLoginData->token
                ]
            ]
        );
        $this->assertEquals(200, $response->status());
    }

    public function testExportDomains()
    {
        $this->getData();
        $response = $this->call(
            'GET',
            $this->url.'export/all',
            [],
            [
                'headers' => [
                    'Authorization' => 'bearer ' . $this->userLoginData->token
                ]
            ]
        );
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testFailValidationDomain()
    {
        $this->getData();
        $faker = Faker::create();
        $domain = $faker->domainWord;
        $response = $this->call('POST', $this->url, [
            'domain_name' => $domain,
            'tld' => 'com',
        ], [
            'headers' => [
                'Authorization' => 'bearer ' . $this->userLoginData->token
            ]
        ]);
        $this->assertEquals(400, $response->status());
    }
    public function testDeleteDomain()
    {
        $this->getData();
        $domain = $this->createDomain();
        $domain = Domain::where('domain_name', $domain)->first();
        $this->seeInDatabase('domains', ['id' => $domain->id]);
        $response = $this->call('DELETE', $this->url . $domain->id, [], [
            'headers' => [
                'Authorization' => 'bearer ' . $this->userLoginData->token
            ]
        ]);
        $this->assertEquals(200, $response->status());
        $this->notSeeInDatabase('domains', ['id' => $domain->id]);
    }
    public function testUpdateDomain()
    {
        $this->getData();
        $domain = $this->createDomain();
        $domain = Domain::where('domain_name', $domain)->first();
        $this->seeInDatabase('domains', ['id' => $domain->id]);
        $faker = Faker::create();
        $domainNew = $faker->domainWord;
        $tldNew = '.' . $faker->tld;
        $response = $this->call('PATCH', $this->url . $domain->id, [
            'domain_name' => $domainNew,
            'tld' => $tldNew,
        ], [
            'headers' => [
                'Authorization' => 'bearer ' . $this->userLoginData->token
            ]
        ]);
        $this->assertEquals(200, $response->status());
        $this->seeInDatabase('domains', ['id' => $domain->id, 'domain_name' => $domainNew, 'tld' => $tldNew]);
    }
}
