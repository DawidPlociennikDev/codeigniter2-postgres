<?php

namespace App\Tests\Controllers\Api;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class RestapiTest extends TestCase
{
    protected $httpClient;
    private $apiUrl;
    private $token;

    protected function setUp(): void
    {
        $this->httpClient = new Client();
        $this->apiUrl = 'http://localhost:8080/api';
        $this->token = 'Bearer cN87xmIMRRxbUkV4q34KWbGRlMZz0fKnCJtw264J';
    }

    public function testGetCommentFromApi(): void
    {
        $response = $this->httpClient->get($this->apiUrl . '/get', [
            'headers' => [
                'Authorization' => $this->token,
            ]
        ]);
        $statusCode = $response->getStatusCode();
        $this->assertEquals(200, $statusCode);
    }

    public function testPaginationInGetCommentFromApi(): void
    {
        $response = $this->httpClient->get($this->apiUrl . '/get', [
            'headers' => [
                'Authorization' => $this->token,
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        $this->assertIsArray($data);
        $this->assertArrayHasKey('pagination', $data);
        $this->assertArrayHasKey('current_page', $data['pagination']);
        $this->assertArrayHasKey('per_page', $data['pagination']);
        $this->assertArrayHasKey('total_rows', $data['pagination']);
        $this->assertArrayHasKey('total_pages', $data['pagination']);
    }

    public function testKeysInGetCommentFromApi(): void
    {
        $response = $this->httpClient->get($this->apiUrl . '/get', [
            'headers' => [
                'Authorization' => $this->token,
            ]
        ]);

        $data = json_decode($response->getBody(), true)['data'][0];
        $this->assertIsArray($data);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('user_id', $data);
        $this->assertArrayHasKey('comment', $data);
        $this->assertArrayHasKey('created_at', $data);
    }

    /** 
     * @dataProvider getCommentsId
     */
    public function testGetOneCommentFromApi(int $id): void
    {
        $response = $this->httpClient->get($this->apiUrl . '/get/' . $id, [
            'headers' => [
                'Authorization' => $this->token,
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        $this->assertIsArray($data);
        $this->assertArrayHasKey('id', $data['data']);
        $this->assertArrayHasKey('user_id', $data['data']);
        $this->assertArrayHasKey('comment', $data['data']);
        $this->assertArrayHasKey('created_at', $data['data']);
    }

    public function getCommentsId()
    {
        yield [1];
        yield [2];
        yield [3];
        yield [4];
    }

    public function testPutCommentInApi(): void
    {
        $requestData = [
            'user_id' => 1,
            'comment' => 'updated_value_from_test'
        ];

        $response = $this->httpClient->put($this->apiUrl . '/put/1', [
            'headers' => [
                'Authorization' => $this->token,
            ],
            'json' => $requestData
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $content = $response->getBody()->getContents();
        $this->assertJson($content);
        $this->assertArrayHasKey('message', json_decode($content, true));

        $expectedJson = '{"message":"Resource updated successfully"}';
        $this->assertJsonStringEqualsJsonString($expectedJson, $content);
    }

    /**
     * @depends testPutCommentInApi
     */
    public function testGetOneCommentFromApiAfterPutUpdated(): void
    {
        $response = $this->httpClient->get($this->apiUrl . '/get/1', [
            'headers' => [
                'Authorization' => $this->token,
            ]
        ]);

        $expectedValue = json_decode($response->getBody(), true)['data']['comment'];
        $this->assertEquals($expectedValue, 'updated_value_from_test');
    }

    public function testPatchCommentInApi(): void
    {
        $requestData = [
            'user_id' => 1,
            'comment' => 'updated_value_from_test2'
        ];

        $response = $this->httpClient->patch($this->apiUrl . '/patch/2', [
            'headers' => [
                'Authorization' => $this->token,
            ],
            'json' => $requestData
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $content = $response->getBody()->getContents();
        $this->assertJson($content);
        $this->assertArrayHasKey('message', json_decode($content, true));

        $expectedJson = '{"message":"Resource updated successfully"}';
        $this->assertJsonStringEqualsJsonString($expectedJson, $content);
    }

    /**
     * @depends testPatchCommentInApi
     */
    public function testGetOneCommentFromApiAfterPatchUpdated(): void
    {
        $response = $this->httpClient->get($this->apiUrl . '/get/2', [
            'headers' => [
                'Authorization' => $this->token,
            ]
        ]);

        $expectedValue = json_decode($response->getBody(), true)['data']['comment'];
        $this->assertEquals($expectedValue, 'updated_value_from_test2');
    }

    public function testPostCommentInApi(): void
    {
        $requestData = [
            'user_id' => 1,
            'comment' => 'new_comment'
        ];

        $response = $this->httpClient->post($this->apiUrl . '/post', [
            'headers' => [
                'Authorization' => $this->token,
            ],
            'form_params' => $requestData
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $content = $response->getBody()->getContents();
        $this->assertJson($content);
        $contentArray = json_decode($content, true);
        $this->assertArrayHasKey('message', json_decode($content, true));
        $requestDataId = $contentArray['id'];
        $expectedJson = '{"message":"Resource created successfully", "id":"'.$requestDataId.'"}';
        $this->assertJsonStringEqualsJsonString($expectedJson, $content);

        $response = $this->httpClient->get($this->apiUrl . '/get/'.$requestDataId, [
            'headers' => [
                'Authorization' => $this->token,
            ]
        ]);

        $expectedValue = json_decode($response->getBody(), true)['data']['comment'];
        $this->assertEquals($expectedValue, 'new_comment');
    }

    public function testDeleteCommentInApi(): void
    {
        $response = $this->httpClient->delete($this->apiUrl . '/delete/10', [
            'headers' => [
                'Authorization' => $this->token,
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $content = $response->getBody()->getContents();
        $this->assertJson($content);
        $this->assertArrayHasKey('message', json_decode($content, true));

        $expectedJson = '{"message":"Resource deleted successfully"}';
        $this->assertJsonStringEqualsJsonString($expectedJson, $content);
    }
}
