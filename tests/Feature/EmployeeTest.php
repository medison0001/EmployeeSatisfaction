<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    use RefreshDatabase;

    /** @test */
    public function it_creates_an_employee()
    {
        $employee = Employee::create([
            'name' => 'Edison Monsalve',
            'date' => '2023-06-18',
            'email' => 'edison.lopera@example.com',
            'area' => 'IT',
            'category' => 'Empleado',
            'logo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR9eK4Hq5eiNKpYiOZNTkyiGoTu8SrrmZ8f_Q&s',
            'company' => 'Example Corp',
            'satisfaction_level' => 20,
        ]);

        $this->assertDatabaseHas('employees', ['email' => 'john.doe@example.com']);
    }
}
