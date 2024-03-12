<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\Travel;
use LogicException;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use Tests\TestCase;
use Throwable;

class BusinessCaseTest extends TestCase
{
    private string $apiToken = '';

    private array $tour = [];

    public function testUseCaseAdmin()
    {
        $email = 'sjunior.dev@gmail.com';
        $pass = 'password';
        $payload = [
            'email' => $email,
            'password' => $pass,
        ];

        $test = $this->json('POST', 'api/login', $payload);

        $this->apiToken = $test->json()['data']['apiToken'];

        $test->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'apiToken',
                ],
            ]);
        $payloadTravel = [
            'name' => 'test',
            'description' => 'test',
            'numberOfDays' => 1,
            'public' => true,
            'moods' => [
                'nature' => 10,
                'relax' => 10,
                'history' => 10,
                'culture' => 10,
            ],
        ];

        $testTravel = $this->withHeader('Authorization', 'Bearer ' . $this->apiToken)
            ->json('POST', 'api/travel', $payloadTravel);

        $travel = $testTravel->json()['data'];
        $testTravel->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'numberOfDays',
                    'numberOfNights',
                    'public',
                    'moods',
                ],
            ]);

        $payloadTour = [
            'name' => 'ITJOR20211112',
            'startingDate' => '2024-03-17',
            'endingDate' => '2024-03-24',
            'price' => 180000,
        ];
        $testTour = $this->withHeader('Authorization', 'Bearer ' . $this->apiToken)
            ->json('POST', 'api/travel/' . $travel['id'] . '/tour', $payloadTour);

        $tour = $testTour->json()['data'];
        $testTour->assertStatus(201)
            ->assertJsonStructure([
            'data' => [
                'id',
                'travelId',
                'name',
                'startingDate',
                'endingDate',
                'price',
            ],
        ]);

        $payloadTour['name'] = 'ITJOR20211111';
        $this->withHeader('Authorization', 'Bearer ' . $this->apiToken)
            ->json('PUT', 'api/tour/' . $tour['id'], $payloadTour)
            ->assertStatus(403);

    }

    /**
     * @depends testUseCaseAdmin
     */
    public function testUseCaseEditor()
    {
        $travel = Travel::factory()->create();
        $tour = Tour::factory()->create(['travelId' => $travel->id]);

        $email = 'sjunior.dev1@gmail.com';
        $pass = 'password';
        $payload1 = [
            'email' => $email,
            'password' => $pass,
        ];

        $testLogin = $this->json('POST', 'api/login', $payload1);
        $this->apiToken = $testLogin->json()['data']['apiToken'];

        $payloadTour = [
            'name' => 'ITJOR202111153',
            'startingDate' => '2024-03-17',
            'endingDate' => '2024-03-24',
            'price' => 120000,
        ];

        $this->withHeader('Authorization', 'Bearer ' . $this->apiToken)
            ->json('PUT', 'api/tour/' . $tour->uuid, $payloadTour)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'travelId',
                    'name',
                    'startingDate',
                    'endingDate',
                    'price',
                ],
            ]);
    }

    /**
     * @depends testUseCaseEditor
     */
    public function testSearch()
    {
        $travel = Travel::factory()
            ->has(Tour::factory()->count(50))
            ->create();

        Tour::factory(['price' => (fake()->numberBetween(3000, 5000)*100)])->count(5)->create(['travelId' => $travel->id]);

        $this->json('GET', 'api/search/'. $travel->slug)
            ->assertStatus(200);

        $this->json('GET', 'api/search/'. $travel->slug.'?priceFrom=300000&priceTo=1500000')
            ->assertStatus(200)
            ->assertJsonCount(5, 'data');

        Tour::factory([
            'startingDate' => now()->addDays(fake()->numberBetween(5, 10)), 'endingDate' => now()->addDays(fake()->numberBetween(11, 15))
        ])->count(10)->create(['travelId' => $travel->id]);

        $this->json('GET', 'api/search/'. $travel->slug.'?dateFrom='. now()->addDays(5).'&dateTo='.now()->addDays(10))
            ->assertStatus(200)
            ->assertJsonCount(10, 'data');
    }
}
