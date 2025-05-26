<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Message;

class MessageControllerTest extends TestCase
{
    public function test_show_single_message_by_id()
    {
        $message = Message::factory()->create();

        $response = $this->getJson(route('message.show', ['id' => $message->id]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'sender' => [
                        'id',
                        'name',
                        'surname',
                    ],
                    'receiver' => [
                        'id',
                        'name',
                        'surname',
                    ],
                    'project_id',
                    'message',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    public function test_show_message_not_found()
    {
        $response = $this->getJson(route('message.show', ['id' => 999]));

        $response->assertStatus(404)
            ->assertJson(['error' => 'Message not found']);
    }
}