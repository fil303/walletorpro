<div x-show="currentTab === 'service'" class="space-y-4">
    <h2 class="text-2xl font-bold">Service Section</h2>
    <form action="{{ route('landingServiceSectionSetting') }}" method="POST" enctype="multipart/form-data" class="space-y-4">@csrf
        <div class="form-control">
            <label class="label">Section Badge</label>
            <input type="text" name="service_section_badge_text" class="input input-bordered" value="{{ $landing->service_section_badge_text ?? '' }}">
        </div>

        <div class="form-control">
            <label class="label">Section Title</label>
            <input type="text" name="service_section_title" class="input input-bordered" value="{{ $landing->service_section_title ?? '' }}">
        </div>

        <div class="form-control">
            <label class="label">Section Sub Title</label>
            <input type="text" name="service_section_description" class="input input-bordered" value="{{ $landing->service_section_description ?? '' }}">
        </div>

        <!-- Feature 1 -->
        <div class="card bg-base-200 p-4">
            <h3 class="font-bold mb-2">Feature 1</h3>
            <div class="form-control">
                <label class="label">Title</label>
                <input type="text" name="service_section_feature1_title" class="input input-bordered" value="{{ $landing->service_section_feature1_title ?? '' }}">
            </div>
            <div class="form-control">
                <label class="label">Description</label>
                <textarea name="service_section_feature1_description" class="textarea textarea-bordered">{{ $landing->service_section_feature1_description ?? '' }}</textarea>
            </div>
        </div>

        <!-- Feature 2 -->
        <div class="card bg-base-200 p-4">
            <h3 class="font-bold mb-2">Feature 2</h3>
            <div class="form-control">
                <label class="label">Title</label>
                <input type="text" name="service_section_feature2_title" class="input input-bordered" value="{{ $landing->service_section_feature2_title ?? '' }}">
            </div>
            <div class="form-control">
                <label class="label">Description</label>
                <textarea name="service_section_feature2_description" class="textarea textarea-bordered">{{ $landing->service_section_feature2_description ?? '' }}</textarea>
            </div>
        </div>

        <!-- Feature 3 -->
        <div class="card bg-base-200 p-4">
            <h3 class="font-bold mb-2">Feature 3</h3>
            <div class="form-control">
                <label class="label">Title</label>
                <input type="text" name="service_section_feature3_title" class="input input-bordered" value="{{ $landing->service_section_feature3_title ?? '' }}">
            </div>
            <div class="form-control">
                <label class="label">Description</label>
                <textarea name="service_section_feature3_description" class="textarea textarea-bordered">{{ $landing->service_section_feature3_description ?? '' }}</textarea>
            </div>
        </div>

        <div class="form-control">
            <label class="label">Image</label>
            <input name="service_section_image" type="file" class="serviceFilePond" />
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>