<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Project;

class ProjectTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function it_displays_projects_on_the_page()
    {
        $project1 = Project::create([
            'title' => 'Project 1',
            'category' => 'Category 1',
            'description' => 'Description 1',
            'status' => 'Status 1',
            'budget_min' => 100,
            'budget_max' => 200,
            'deadline' => '2023-06-01',
            'created_at' => '2023-05-01',
        ]);

        $response = $this->get('/index');
        $response->assertStatus(200);
        $response->assertSee($project1->title);
        $response->assertSee($project1->category);
    }
}
