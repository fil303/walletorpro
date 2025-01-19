<div x-show="currentTab === 'hero'" class="space-y-4">
    <h2 class="text-2xl font-bold">Hero Section</h2>
    <form action="{{ route('landingHeroSectionSetting') }}" method="POST" class="space-y-4" enctype="multipart/form-data"> @csrf
        <div class="form-control">
            <label class="label">Badge Text</label>
            <input type="text" name="hero_section_badge_text" class="input input-bordered" value="{{ $landing->hero_section_badge_text ?? '' }}">
        </div>

        <div class="form-control">
            <label class="label">Heading</label>
            <input type="text" name="hero_section_heading" class="input input-bordered" value="{{ $landing->hero_section_heading ?? '' }}">
        </div>

        <div class="form-control">
            <label class="label">Subheading</label>
            <textarea name="hero_section_subheading" class="textarea textarea-bordered">{{ $landing->hero_section_subheading ?? '' }}</textarea>
        </div>

        <div class="form-control">
            <label class="label">CTA Button Text</label>
            <input type="text" name="hero_section_cta_text" class="input input-bordered" value="{{ $landing->hero_section_cta_text ?? '' }}">
        </div>

        <div class="form-control">
            <label class="label">Image</label>
            <input name="hero_section_image" type="file" class="filePond" />
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>