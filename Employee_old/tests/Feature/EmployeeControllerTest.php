<?php

namespace Tests\Feature;

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Response;
use App\Models\Employee;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithoutMiddleware;
    /**
     * A basic feature test example.
     */
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
    }

    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testIndexReturnsDataInValidFormat()
    {
        $token = 'secrete-auth-token';
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/employee');
        $this->json('get', 'api/employee')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    '*' => ['id', 'name', 'salary']
                ]
            );
    }

    public function testEmployeeCreatedSuccessfully()
    {
        $employee = Employee::factory()->create();
        $data = [
            'name' => $employee->name,
            'salary' => $employee->salary,
        ];

        $token = 'secrete-auth-token';
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson('/api/employee', $data);
        $response->assertStatus(200);
        $response->assertJson([
            "message" => "Employee details added successfully!"
        ]);
        $this->assertDatabaseHas('employee', $data);
    }

    public function test_can_update_employee()
    {
        $employee = Employee::factory()->create();
        $token = 'secrete-auth-token';
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/employee');
        $updateData = [
            'name' => $this->faker->name,
            'salary' => $this->faker->numberBetween(1000, 100000)
        ];
        $response = $this->putJson("/api/employee/{$employee->id}", $updateData);

        // Assert a successful response
        $response->assertJson([
            "message" => "Data updated successfully.",
            "Updated Details" => [
                'name' => $updateData['name'],
                'salary' => $updateData['salary'],
            ]
        ]);
        $this->assertDatabaseHas('employee', $updateData);
    }

    public function test_show_employee()
    {
        $employee = Employee::factory()->create();
        $token = 'secrete-auth-token';
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->getJson('/api/employee');
        $response->assertStatus(200);
        $response->assertJsonFragment(
            [
                'id' => $employee->id,
                'name' => $employee->name,
                'salary' => $employee->salary,
                'created_at' => $employee->created_at,
                'updated_at' => $employee->updated_at,
            ]
        );
    }

    public function test_can_delete_employee()
    {
        $employee = Employee::factory()->create();
        $token = 'secrete-auth-token';
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->deleteJson("/api/employee/{$employee->id}");
        $response->assertStatus(200);
        $response->assertJson([
            "message" => "Employee deleted successfully."
        ]);
        //$this->assertDatabaseMissing('employee',['id' => $employee->id]);
    }

    public function test_can_get_employee_details()
    {
        $employee = Employee::factory()->create();
        $token = 'secrete-auth-token';
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->getJson("/api/employee/$employee->id");
        $response->assertStatus(200);
        $response->assertJsonFragment(
            [
                'id' => $employee->id,
                'name' => $employee->name,
                'salary' => $employee->salary,
                'created_at' => $employee->created_at,
                'updated_at' => $employee->updated_at,
            ]
        );
        $this->assertDatabaseHas('employee', ['id' => $employee->id]);
    }
}
