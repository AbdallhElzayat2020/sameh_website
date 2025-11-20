<?php

namespace Tests\Feature\Dashboard;

use App\Models\Freelancer;
use App\Models\FreelancerPo;
use App\Models\Service;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VendorPoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_vendor_po_with_pdf(): void
    {
        Storage::fake('uploads');

        $user = User::factory()->create();
        $task = $this->createTask($user);
        $freelancer = Freelancer::create([
            'freelancer_code' => 'FR-100',
            'name' => 'Vendor One',
            'email' => 'vendor@example.com',
            'phone' => '123456789',
            'language_pair' => [['source' => 'en', 'target' => 'ar']],
            'quota' => 10,
            'price_hr' => 25,
            'currency' => 'USD',
        ]);
        $service = Service::create([
            'name' => 'Translation',
            'description' => 'Test service',
            'status' => 'active',
        ]);

        $payload = [
            'freelancer_code' => $freelancer->freelancer_code,
            'project_name' => 'Project Alpha',
            'page_number' => '12',
            'price' => 150.5,
            'start_date' => now()->toDateString(),
            'payment_date' => now()->addWeek()->toDateString(),
            'service_ids' => [$service->id],
            'note' => 'Urgent delivery',
            'po_file' => UploadedFile::fake()->create('po.pdf', 150, 'application/pdf'),
        ];

        $response = $this
            ->actingAs($user)
            ->post(route('dashboard.tasks.vendor-pos.store', $task), $payload);

        $response->assertRedirect(route('dashboard.tasks.vendor-pos.index', $task));

        $this->assertDatabaseHas('freelancer_pos', [
            'freelancer_code' => $freelancer->freelancer_code,
            'task_code' => $task->task_number,
            'project_name' => 'Project Alpha',
            'price' => 150.5,
        ]);

        $vendorPo = FreelancerPo::first();
        $this->assertNotNull($vendorPo);
        $this->assertEquals($user->id, $vendorPo->created_by);
        $this->assertEquals('pending', $vendorPo->status);
        $this->assertTrue($vendorPo->services->contains($service));

        $media = $vendorPo->media;
        $this->assertNotNull($media);
        Storage::disk('uploads')->assertExists($media->path);
        $this->assertEquals('Urgent delivery', $media->note);
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
