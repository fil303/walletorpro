<div x-show="currentTab === 'about'" class="space-y-4">
    <h2 class="text-2xl font-bold">About Section</h2>
    <form action="{{ route('landingAboutSectionSetting') }}" method="POST" class="space-y-4" enctype="multipart/form-data"> @csrf
        <input type="hidden" name="section" value="about">

        <div class="form-control">
            <label class="label">Section Badge</label>
            <input type="text" name="about_section_badge_text" class="input input-bordered" value="{{ $landing->about_section_badge_text ?? '' }}">
        </div>

        <div class="form-control">
            <label class="label">Main Title</label>
            <input type="text" name="about_section_title" class="input input-bordered" value="{{ $landing->about_section_title ?? '' }}">
        </div>

        <div class="form-control">
            <label class="label">Description</label>
            <textarea name="about_section_description" class="textarea textarea-bordered h-24">{{ $landing->about_section_description ?? '' }}</textarea>
        </div>

        <div class="form-control">
            <label class="label">Image</label>
            <input name="about_section_image" type="file" class="aboutFilePond" />
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>