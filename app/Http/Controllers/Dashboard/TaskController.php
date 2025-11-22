<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Client;
use App\Models\Freelancer;
use App\Models\Media;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('View Task');

        $tasks = Task::query()
            ->with(['creator', 'closer', 'freelancers', 'referencedTask'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%' . (string) $request->string('search')->trim() . '%';
                $query->where(function ($subQuery) use ($term) {
                    $subQuery
                        ->where('task_number', 'like', $term)
                        ->orWhere('client_code', 'like', $term)
                        ->orWhereHas('referencedTask', function ($q) use ($term) {
                            $q->where('task_number', 'like', $term);
                        });
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->string('status'));
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('dashboard.tasks.index', compact('tasks'));
    }

    public function create()
    {
        Gate::authorize('Create Task');

        $clients = Client::query()->orderBy('name')->get(['id', 'client_code', 'name']);
        $services = \App\Models\Service::where('status', 'active')->orderBy('name')->get();
        $taskNumber = Task::nextTaskNumber();

        return view('dashboard.tasks.create', compact('clients', 'services', 'taskNumber'));
    }

    public function store(TaskRequest $request)
    {
        Gate::authorize('Create Task');

        DB::beginTransaction();

        try {
            $data = $this->mappedData($request);

            // Ensure language_pair is not empty
            if (empty($data['language_pair'])) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['language_pair' => 'At least one language pair is required.']);
            }

            // Generate task number automatically if not provided
            if (empty($data['task_number'])) {
                $data['task_number'] = Task::nextTaskNumber();
            }

            $task = Task::create(
                $data + ['created_by' => Auth::id()]
            );

            // Sync freelancers
            $validated = $request->validated();
            if (isset($validated['freelancer_codes'])) {
                $freelancerCodes = array_filter($validated['freelancer_codes'], fn ($code) => ! empty(trim($code)));
                if (! empty($freelancerCodes)) {
                    $task->freelancers()->sync($freelancerCodes);
                } else {
                    $task->freelancers()->detach();
                }
            }

            // Sync services
            if (isset($validated['service_ids'])) {
                $task->services()->sync($validated['service_ids']);
            } else {
                $task->services()->detach();
            }

            $this->storeAttachments($request, $task);

            DB::commit();

            return redirect()
                ->route('dashboard.tasks.index')
                ->with('success', 'Task created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Task creation failed: ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create task: ' . $e->getMessage());
        }
    }

    public function show(Task $task)
    {
        Gate::authorize('View Task');

        $task->load(['creator', 'closer', 'media', 'freelancers', 'services', 'referencedTask']);

        return view('dashboard.tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        Gate::authorize('Update Task');

        $task->load(['media', 'freelancers', 'services']);
        $clients = Client::query()->orderBy('name')->get(['id', 'client_code', 'name']);
        $services = \App\Models\Service::where('status', 'active')->orderBy('name')->get();

        return view('dashboard.tasks.edit', compact('task', 'clients', 'services'));
    }

    public function findClientOrFreelancer(Request $request)
    {
        Gate::authorize('Find Client Or Freelancer');

        $code = $request->input('code');

        if (! $code) {
            return response()->json(['found' => false, 'message' => 'Code is required']);
        }

        // Try to find client
        $client = Client::where('client_code', $code)->first();
        if ($client) {
            return response()->json([
                'found' => true,
                'type' => 'client',
                'id' => $client->id,
                'url' => route('dashboard.clients.show', $client),
            ]);
        }

        // Try to find freelancer
        $freelancer = Freelancer::where('freelancer_code', $code)->first();
        if ($freelancer) {
            return response()->json([
                'found' => true,
                'type' => 'freelancer',
                'id' => $freelancer->id,
                'url' => route('dashboard.freelancers.show', $freelancer),
            ]);
        }

        return response()->json([
            'found' => false,
            'message' => 'Client or Freelancer with this code not found.',
        ]);
    }

    public function findTask(Request $request)
    {
        Gate::authorize('Find Task');

        $taskNumber = $request->input('task_number');

        if (! $taskNumber) {
            return response()->json(['found' => false, 'message' => 'Task number is required']);
        }

        $task = Task::where('task_number', $taskNumber)->first();
        if ($task) {
            return response()->json([
                'found' => true,
                'id' => $task->id,
                'url' => route('dashboard.tasks.show', $task),
            ]);
        }

        return response()->json([
            'found' => false,
            'message' => 'Task with this number not found.',
        ]);
    }

    public function uploadFiles(Request $request, Task $task)
    {
        Gate::authorize('Upload Task Files');

        $validated = $request->validate([
            'attachments' => ['required', 'array', 'min:1'],
            'attachments.*' => [
                'file',
                'max:20480',
                'mimetypes:image/jpeg,image/png,image/gif,image/webp,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/zip,application/x-zip-compressed,text/plain',
            ],
        ]);

        DB::beginTransaction();

        try {
            $this->storeAttachments($request, $task);
            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Files uploaded successfully.');
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('File upload failed: ' . $e->getMessage(), [
                'task_id' => $task->id,
                'exception' => $e,
            ]);

            return redirect()
                ->back()
                ->with('error', 'Failed to upload files: ' . $e->getMessage());
        }
    }

    public function update(TaskRequest $request, Task $task)
    {
        Gate::authorize('Update Task');

        DB::beginTransaction();

        try {
            $data = $this->mappedData($request);

            // Ensure language_pair is not empty
            if (empty($data['language_pair'])) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['language_pair' => 'At least one language pair is required.']);
            }

            $task->update($data);

            // Sync freelancers
            $validated = $request->validated();
            if (isset($validated['freelancer_codes'])) {
                $freelancerCodes = array_filter($validated['freelancer_codes'], fn ($code) => ! empty(trim($code)));
                if (! empty($freelancerCodes)) {
                    $task->freelancers()->sync($freelancerCodes);
                } else {
                    $task->freelancers()->detach();
                }
            }

            // Sync services
            if (isset($validated['service_ids'])) {
                $task->services()->sync($validated['service_ids']);
            } else {
                $task->services()->detach();
            }

            $this->storeAttachments($request, $task);

            DB::commit();

            return redirect()
                ->route('dashboard.tasks.index')
                ->with('success', 'Task updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Task update failed: ' . $e->getMessage(), [
                'task_id' => $task->id,
                'exception' => $e,
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update task: ' . $e->getMessage());
        }
    }

    public function destroy(Task $task)
    {
        Gate::authorize('Delete Task');

        DB::transaction(function () use ($task) {
            $disk = Storage::disk('uploads');

            $task->media->each(function (Media $media) use ($disk) {
                if ($media->path && $disk->exists($media->path)) {
                    $disk->delete($media->path);
                }
            });

            $task->media()->delete();
            $task->delete();
        });

        return redirect()
            ->route('dashboard.tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

    public function downloadAttachment(Task $task, Media $media)
    {
        Gate::authorize('Download Task Attachment');

        abort_if(
            $media->mediaable_type !== Task::class || $media->mediaable_id !== $task->id,
            404
        );

        $disk = Storage::disk('uploads');
        abort_unless($disk->exists($media->path), 404);

        return response()->download($disk->path($media->path), $media->original_name);
    }

    public function storeAttachment(Request $request, Task $task)
    {
        Gate::authorize('Store Task Attachment');

        $validated = $request->validate([
            'file_name' => ['required', 'string', 'max:255'],
            'file_status' => ['required', 'in:DTP,Update'],
            'note' => ['nullable', 'string'],
            'attachments' => ['required', 'array', 'min:1'],
            'attachments.*' => [
                'file',
                'max:20480',
                'mimetypes:image/jpeg,image/png,image/gif,image/webp,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/zip,application/x-zip-compressed,text/plain',
            ],
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->file('attachments') as $attachment) {
                $filename = Str::uuid() . '.' . $attachment->getClientOriginalExtension();
                $path = $attachment->storeAs('tasks', $filename, 'uploads');

                $task->media()->create([
                    'type' => $attachment->getClientOriginalExtension(),
                    'path' => $path,
                    'original_name' => $validated['file_name'],
                    'mime_type' => $attachment->getClientMimeType(),
                    'size' => $attachment->getSize(),
                    'note' => $validated['note'] ?? null,
                    'file_status' => $validated['file_status'],
                ]);
            }

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Files uploaded successfully.');
        } catch (Throwable $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to upload files. Please try again.');
        }
    }

    public function destroyAttachment(Task $task, Media $media)
    {
        Gate::authorize('Delete Task Attachment');

        abort_if(
            $media->mediaable_type !== Task::class || $media->mediaable_id !== $task->id,
            404
        );

        $disk = Storage::disk('uploads');
        if ($media->path && $disk->exists($media->path)) {
            $disk->delete($media->path);
        }

        $media->delete();

        return redirect()
            ->back()
            ->with('success', 'Attachment deleted successfully.');
    }

    protected function storeAttachments(Request $request, Task $task): void
    {
        if (! $request->hasFile('attachments')) {
            return;
        }

        foreach ($request->file('attachments') as $attachment) {
            $filename = Str::uuid() . '.' . $attachment->getClientOriginalExtension();
            $path = $attachment->storeAs('tasks', $filename, 'uploads');

            $task->media()->create([
                'type' => $attachment->getClientOriginalExtension(),
                'path' => $path,
                'original_name' => $attachment->getClientOriginalName(),
                'mime_type' => $attachment->getClientMimeType(),
                'size' => $attachment->getSize(),
            ]);
        }
    }

    protected function mappedData(TaskRequest $request): array
    {
        $validated = $request->validated();

        // Process language pairs
        $languages = [];
        if (isset($validated['language_pair']) && is_array($validated['language_pair'])) {
            foreach ($validated['language_pair'] as $pair) {
                if (
                    isset($pair['source']) && isset($pair['target'])
                    && ! empty(trim($pair['source'])) && ! empty(trim($pair['target']))
                ) {
                    $languages[] = [
                        'source' => trim($pair['source']),
                        'target' => trim($pair['target']),
                    ];
                }
            }
        }

        // Clean time values (remove seconds if present)
        if (isset($validated['start_time'])) {
            $validated['start_time'] = substr($validated['start_time'], 0, 5); // Keep only HH:MM
        }
        if (isset($validated['end_time'])) {
            $validated['end_time'] = substr($validated['end_time'], 0, 5); // Keep only HH:MM
        }

        $data = collect($validated)->except('language_pair')->toArray();
        $data['language_pair'] = $languages;

        // Convert reference_number (task_number) to id
        if (isset($data['reference_number']) && ! empty($data['reference_number'])) {
            $referencedTask = Task::where('task_number', $data['reference_number'])->first();
            if ($referencedTask) {
                $data['reference_number'] = $referencedTask->id;
            } else {
                $data['reference_number'] = null;
            }
        } else {
            $data['reference_number'] = null;
        }

        return $data;
    }
}
