<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreMethod()
    {
        // Mock data to be sent in the request
        $categoryData = [
            'category_name' => 'Test Category',
            'category_desc' => 'This is a test category.',
        ];

        // Make a POST request to your store endpoint
        $response = $this->json('POST', '/api/category', $categoryData);

        // Assert the response status
        $response->assertStatus(201);

        // Assert the response structure or content
        $response->assertJson([
            'message' => 'Category created successfully',
        ]);

        // Additional assertions based on your application logic

        // For example, you might want to assert that a category was created in the database
        $this->assertDatabaseHas('category', [
            'category_name' => 'Test Category',
            'category_desc' => 'This is a test category.',
        ]);
    }
}
