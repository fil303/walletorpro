<div x-show="currentTab === 'terms_condition'" class="space-y-4">
    <h2 class="text-2xl font-bold">Terms & Conditions</h2>
    <form action="{{ route('landingTermsAndConditionSettingRequest') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <textarea id="summernote_terms_condition" name="terms_condition" class="form-control bg-white">{{ $landing->terms_condition ?? '' }}</textarea>
                </div>
            </div>
            <div class="col-12 text-end mt-3">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </form>
</div>