<?php

namespace Tests\Feature\Dashboard;

use App\Models\Client;
use App\Models\ClientPo;
use App\Models\Service;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ClientPoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_client_po_with_pdf(): void
    {
        Storage::fake('uploads');

        $user = User::factory()->create();
        $task = $this->createTask($user);
        $client = Client::create([
            'client_code' => 'CL-100',
            'name' => 'Client Test',
            'email' => 'client@example.com',
            'phone' => '123456789',
            'agency' => 'Agency',
            'currency' => 'USD',
        ]);
        $service = Service::create([
            'name' => 'Desktop Publishing',
            'description' => 'DTP work',
            'status' => 'active',
        ]);

        $payload = [
            'client_code' => $client->client_code,
            'date_20' => now()->toDateString(),
            'date_80' => now()->addWeeks(2)->toDateString(),
            'payment_20' => 100,
            'payment_80' => 400,
            'total_price' => 500,
            'service_ids' => [$service->id],
            'note' => 'PO note',
            'po_file' => UploadedFile::fake()->create('client-po.pdf', 150, 'application/pdf'),
        ];

        $response = $this
            ->actingAs($user)
            ->post(route('dashboard.tasks.client-pos.store', $task), $payload);

        $response->assertRedirect(route('dashboard.tasks.client-pos.index', $task));

        $this->assertDatabaseHas('client_pos', [
            'task_code' => $task->task_number,
            'client_code' => $client->client_code,
            'payment_20' => 100,
            'payment_80' => 400,
            'total_price' => 500,
        ]);

        $clientPo = ClientPo::first();
        $this->assertNotNull($clientPo);
        $this->assertTrue($clientPo->services->contains($service));

        $media = $clientPo->media;
        $this->assertNotNull($media);
        Storage::disk('uploads')->assertExists($media->path);
        $this->assertEquals('PO note', $media->note);
    }

    protected function createTask(User $user): Task
    {
        return Task::create([
            'task_number' => 'TASK-001',
            'reference_number' => null,
            'page_numbers' => '10',
            'words_count' => '2000',
            'client_code' => 'CL-100',
            'language_pair' => [['source' => 'en', 'target' => 'ar']],
            'start_date' => now()->toDateString(),
            'end_date' => now()->addWeek()->toDateString(),
            'start_time' => '09:00',
            'end_time' => '17:00',
            'notes' => null,
            'created_by' => $user->id,
            'status' => 'pending',
        ]);
    }
}
