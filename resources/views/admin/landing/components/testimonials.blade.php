<div x-show="currentTab === 'testimonials'" class="space-y-4">
    <h2 class="text-2xl font-bold">Testimonials Section</h2>
    
    <!-- Section Settings -->
    <form action="{{ route('landingTestimonialSectionSetting') }}" method="POST" class="space-y-4 mb-8">@csrf
        <div class="form-control">
            <label class="label">Section Badge</label>
            <input type="text" name="testimonial_section_badge_text" class="input input-bordered" value="Client Stories">
        </div>

        <div class="form-control">
            <label class="label">Section Title</label>
            <input type="text" name="testimonial_section_title" class="input input-bordered" value="What Our Clients Say">
        </div>
        
        <div class="form-control">
            <label class="label">Section Sub Title</label>
            <input type="text" name="testimonial_section_description" class="input input-bordered" value="What Our Clients Say">
        </div>

        <button type="submit" class="btn btn-primary">Save Section Settings</button>
    </form>
</div>