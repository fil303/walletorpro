<div x-show="currentTab === 'privacy_policy'" class="space-y-4">
    <h2 class="text-2xl font-bold">Privacy Policy</h2>
    <form action="{{ route('landingPrivacyPolicySettingRequest') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <textarea id="summernote_privacy_policy" name="privacy_policy" class="form-control bg-white">{{ $landing->privacy_policy ?? '' }}</textarea>
                </div>
            </div>
            <div class="col-12 text-end mt-3">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </form>
</div>