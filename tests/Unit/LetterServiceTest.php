<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\LetterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\LetterStatusEnum;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
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

    #[Test]
    public function is_assigns_manager (){
        $message = Letter::factory()->create([
            'status' => LetterStatusEnum::Pending->value,
        ]);

        $this->messageService->assignManager($message, 1);
        $this->assertEquals(1, $message->fresh()->manager_id);
    }

    #[Test]
    public function is_answer_message (){
        $message = Letter::factory()->create([
            'status' => LetterStatusEnum::Pending->value,
        ]);
        
        $answer = 'This is a test answer.';
        $managerId = 1;
        $newMessaage = $this->messageService->answer($message, $answer, $managerId);

        $this->assertEquals($answer, $newMessaage->fresh()->answer);
        $this->assertEquals($managerId, $newMessaage->fresh()->manager_id);
        
    }

    #[Test]

    public function test_throws_exception_when_creating_with_invalid_data () {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('All fields are required.');

        $this->messageService->create([
            'client_name' => '',
            'email' => '',
            'message' => '',
        ]);
    }

    #[Test]
    public function is_thows_exception_when_assigning_invalid_manager () {
        $message = Letter::factory()->create([
            'status' => LetterStatusEnum::Pending->value,
        ]);

        $managerId = 99999999;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Manager not found');
        $this->messageService->assignManager($message, $managerId);
    }

    #[Test]
    public function is_user_authorized()
    {
        $message = Letter::factory()->create([
            'status' => LetterStatusEnum::Pending->value,
        ]);

        $manager = User::factory()->create();

        $this->actingAs($manager);
        $this->messageService->assignManager($message, $manager->id);
        $this->assertEquals($manager->id, $message->fresh()->manager_id);
    }

    #[Test]
    public function is_thows_exception_when_unauthorized_user_ssign_manager () {
        $message = Letter::factory()->create([
            'status' => LetterStatusEnum::Pending->value,
        ]);

        $manager = User::factory()->create();

        $this->actingAs($manager);
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('You are not authorized to perform this action.');
        $this->messageService->assignManager($message, $manager->id);
    }

    #[Test]
    #[DataProvider('statusProvider')]

    public function it_can_change_status_for_any_enums(LetterStatusEnum $status)
    {
        $message = Letter::factory()->create();

        $this->messageService->changeStatus($message, $status);
        $this->assertEquals($status->value, $message->fresh()->status);
    }

    public static function statusProvider(): array
    {
        return [
            [LetterStatusEnum::Pending],
            [LetterStatusEnum::Processed],
            [LetterStatusEnum::Closed],
        ];
    }

    #[Test]
    public function is_thows_exception_when_assigning_invalid_answer () {
        $message = Letter::factory()->create([
            'status' => LetterStatusEnum::Pending->value,
        ]);

        $answer = '';
        $managerId = 1;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Answer is required.');
        $this->messageService->answer($message, $answer, $managerId);
    }

    #[Test]
    public function is_answer_status_closed_when_answer_is_provided()
    {
        $message = Letter::factory()->create([
            'status' => LetterStatusEnum::Closed->value,
        ]);

        $managerId = 1;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Message is not pending.');
        $this->messageService->answer($message, 'Test answer', $managerId);

    }

    #[Test]
    public function is_thows_exception_when_assigning_invalid_manager_id () {
        $message = Letter::factory()->create([
            'status' => LetterStatusEnum::Pending->value,
        ]);

        $managerId = 99999999;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Manager not found');
        $this->messageService->assignManager($message, $managerId);
    }

    #[Test]
    public function is_manager_authorized_to_answer_messages()
    {
        $message = Letter::factory()->create([
            'status' => LetterStatusEnum::Pending->value,
        ]);

        $manager = User::factory()->create();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('You are not authorized to perform this action.');
        $this->messageService->assignManager($message, $manager->id);
    }
}
