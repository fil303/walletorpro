<div x-show="currentTab === 'faq'" class="space-y-4">
    <h2 class="text-2xl font-bold">FAQ Section</h2>
    
    <!-- Section Settings -->
    <form action="{{ route('landingFaqSectionSetting') }}" method="POST" enctype="multipart/form-data" class="space-y-4 mb-8">
        @csrf

        <div class="form-control">
            <label class="label">Section Badge</label>
            <input type="text" name="faq_section_badge_text" class="input input-bordered" value="{{ $landing->faq_section_badge_text ?? '' }}">
        </div>

        <div class="form-control">
            <label class="label">Section Title</label>
            <input type="text" name="faq_section_title" class="input input-bordered" value="{{ $landing->faq_section_title ?? '' }}">
        </div>

        <div class="form-control">
            <label class="label">Section Sub Title</label>
            <input type="text" name="faq_section_description" class="input input-bordered" value="{{ $landing->faq_section_description ?? '' }}">
        </div>

        <div class="form-control">
            <label class="label">Image</label>
            <input name="faq_section_image" type="file" class="faqFilePond" />
        </div>

        <button type="submit" class="btn btn-primary">Save Section Settings</button>
    </form>
</div>