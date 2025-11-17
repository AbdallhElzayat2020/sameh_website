<div class="row g-4">
    <div class="col-md-6">
        <label for="client_code" class="form-label">Client Code</label>
        <input type="text" class="form-control" id="client_code" name="client_code"
            value="{{ old('client_code', $client->client_code ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $client->name ?? '') }}"
            required>
    </div>
    <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email"
            value="{{ old('email', $client->email ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $client->phone ?? '') }}"
            required>
    </div>
    <div class="col-md-6">
        <label for="agency" class="form-label">Agency</label>
        <input type="text" class="form-control" id="agency" name="agency"
            value="{{ old('agency', $client->agency ?? '') }}">
    </div>
    <div class="col-md-6">
        <label for="currency" class="form-label">Preferred Currency</label>
        <input type="text" class="form-control" id="currency" name="currency"
            value="{{ old('currency', $client->currency ?? '') }}">
    </div>
    <div class="col-12">
        <label for="attachments" class="form-label">Attachments</label>
        <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
        <small class="text-muted">Images, PDF, Word, Excel up to 20MB each.</small>
    </div>
</div>
