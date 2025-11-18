<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePriceRequestRequest;
use App\Models\ProjectRequest;
use App\Models\Service;
use DateTimeZone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class PriceRequestController extends Controller
{
    public function index()
    {
        return view('website.price-request', [
            'services' => Service::query()->orderBy('name')->get(['id', 'name']),
            'fallbackServices' => $this->defaultServices(),
            'timeZones' => DateTimeZone::listIdentifiers(DateTimeZone::ALL),
        ]);
    }

    public function store(StorePriceRequestRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $projectRequest = ProjectRequest::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'project_name' => $data['project_name'],
                'description' => $data['description'],
                'time_zone' => $data['time_zone'],
                'start_date' => $data['start_date'],
                'start_date_time' => $data['start_time'],
                'end_date' => $data['end_date'],
                'end_date_time' => $data['end_time'],
                'preferred_payment_type' => $data['preferred_payment_type'],
                'source_language' => $data['source_language'],
                'target_language' => $data['target_language'],
                'currency' => $data['currency'],
            ]);

            if (! empty($data['services'])) {
                $serviceIds = [];

                foreach ($data['services'] as $serviceValue) {
                    if (is_numeric($serviceValue)) {
                        $serviceIds[] = (int) $serviceValue;

                        continue;
                    }

                    $name = trim($serviceValue);

                    if ($name === '') {
                        continue;
                    }

                    $service = Service::firstOrCreate(
                        ['name' => $name],
                        [
                            'description' => 'Website price request option',
                            'status' => 'active',
                        ]
                    );

                    $serviceIds[] = $service->id;
                }

                if (! empty($serviceIds)) {
                    $projectRequest->services()->sync($serviceIds);
                }
            }

            if ($request->hasFile('attachments')) {
                $directory = 'project-requests';

                foreach ($request->file('attachments') as $attachment) {
                    $filename = Str::uuid() . '.' . $attachment->getClientOriginalExtension();
                    $path = $attachment->storeAs($directory, $filename, 'uploads');

                    $projectRequest->media()->create([
                        'type' => $attachment->getClientOriginalExtension(),
                        'path' => $path,
                        'original_name' => $attachment->getClientOriginalName(),
                        'mime_type' => $attachment->getClientMimeType(),
                        'size' => $attachment->getSize(),
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('price-request')
                ->with('success', 'Your request has been submitted successfully.');
        } catch (Throwable $throwable) {
            DB::rollBack();

            Log::error('Failed to submit price request', [
                'error' => $throwable->getMessage(),
                'trace' => $throwable->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['price_request' => 'Something went wrong while submitting your request. Please try again.']);
        }
    }

    private function defaultServices(): array
    {
        return [
            'Translation',
            'Desktop Publishing (DTP)',
            'Interpreting',
            'Localization',
            'Subtitling / Closed Captioning',
            'Transcription',
            'Transcreation',
        ];
    }
}
