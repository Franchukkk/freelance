<?php

namespace Tests\Unit;

use App\Services\LetterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\LetterStatusEnum;
use Tests\TestCase as LaravelTestCase;
use App\Models\Letter;
use PHPUnit\Framework\Attributes\Test;

class LetterServiceTest extends LaravelTestCase
{
    use RefreshDatabase;
    protected LetterService $messageService;

    /**
     * A basic unit test example.
     */
    #[Test]

    protected function setUp(): void
    {
        parent::setUp();
        $this->messageService = new LetterService();
    }
    public function test_create_message_with_valid_data () {
        $data = [
            'client_name' => 'Test User',
            'email' => 'test@example.com',
            'message' => 'This is a test message.',
        ];

        $message = $this->messageService->create($data);

        $this->assertDatabaseHas('messages', [
            'client_name' => $data['client_name'],
            'email' => $data['email'],
            'message' => $data['message'],
            'status' => LetterStatusEnum::Pending->value,
        ]);
    }

    #[Test]
    public function is_changes_message_status () {
        $message = Letter::factory()->create([
            'status' => LetterStatusEnum::Pending->value,
        ]);

        $this->messageService->changeStatus($message, LetterStatusEnum::Processed);
        $this->assertEquals(LetterStatusEnum::Processed->value, $message->fresh()->status);
    }

    #[Test]
    public function is_assign_manager_to_message () {
        $message = Letter::factory()->create();
        $managerId = 1;
        $this->messageService->assignManager($message, $managerId);
        $this->assertEquals($managerId, $message->fresh()->manager_id);
    }

    #[Test]
    public function is_answer_to_message () {
        $message = Letter::factory()->create();
        $answer = 'This is a test answer.';
        $managerId = 1;
        $this->messageService->answer($message, $answer, $managerId);
        $this->assertEquals($answer, $message->fresh()->answer);
        $this->assertEquals($managerId, $message->fresh()->manager_id);
        $this->assertEquals(LetterStatusEnum::Closed->value, $message->fresh()->status);
    }
}
