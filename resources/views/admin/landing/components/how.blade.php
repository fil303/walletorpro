<div x-show="currentTab === 'how'" class="space-y-4">
    <h2 class="text-2xl font-bold">How It Works Section</h2>
    <form action="{{ route('landingHowSectionSetting') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="section" value="how">
        
        <div class="form-control">
            <label class="label">Section Badge</label>
            <input type="text" name="how_section_badge_text" class="input input-bordered" value="{{ $landing->how_section_badge_text ?? '' }}">
        </div>

        <!-- Coin Purchase -->
        <h2 class="font-bold mb-2">Coin Purchase</h2>
        <div class="card bg-base-200 p-4">
            <!-- Step 1 -->
            <h3 class="font-bold mb-2">Step 1</h3>
            <div class="form-control">
                <label class="label">Title</label>
                <input type="text" name="how_section_step1_title" class="input input-bordered" value="{{ $landing->how_section_step1_title ?? '' }}">
            </div>
            <div class="form-control">
                <label class="label">Description</label>
                <textarea name="how_section_step1_description" class="textarea textarea-bordered">{{ $landing->how_section_step1_description ?? '' }}</textarea>
            </div>
            
            <!-- Step 2 -->
            <h3 class="font-bold mb-2">Step 2</h3>
            <div class="form-control">
                <label class="label">Title</label>
                <input type="text" name="how_section_step2_title" class="input input-bordered" value="{{ $landing->how_section_step2_title ?? '' }}">
            </div>
            <div class="form-control">
                <label class="label">Description</label>
                <textarea name="how_section_step2_description" class="textarea textarea-bordered">{{ $landing->how_section_step2_description ?? '' }}</textarea>
            </div>

            <!-- Step 3 -->
            <h3 class="font-bold mb-2">Step 3</h3>
            <div class="form-control">
                <label class="label">Title</label>
                <input type="text" name="how_section_step3_title" class="input input-bordered" value="{{ $landing->how_section_step3_title ?? '' }}">
            </div>
            <div class="form-control">
                <label class="label">Description</label>
                <textarea name="how_section_step3_description" class="textarea textarea-bordered">{{ $landing->how_section_step3_description ?? '' }}</textarea>
            </div>
        </div>
        
        <!-- Staking -->
        <h2 class="font-bold mb-2">Staking</h2>
        <div class="card bg-base-200 p-4">
            <!-- Step 1 -->
            <h3 class="font-bold mb-2">Step 1</h3>
            <div class="form-control">
                <label class="label">Title</label>
                <input type="text" name="how_section_staking_step1_title" class="input input-bordered" value="{{ $landing->how_section_staking_step1_title ?? '' }}">
            </div>
            <div class="form-control">
                <label class="label">Description</label>
                <textarea name="how_section_staking_step1_description" class="textarea textarea-bordered">{{ $landing->how_section_staking_step1_description ?? '' }}</textarea>
            </div>
            
            <!-- Step 2 -->
            <h3 class="font-bold mb-2">Step 2</h3>
            <div class="form-control">
                <label class="label">Title</label>
                <input type="text" name="how_section_staking_step2_title" class="input input-bordered" value="{{ $landing->how_section_staking_step2_title ?? '' }}">
            </div>
            <div class="form-control">
                <label class="label">Description</label>
                <textarea name="how_section_staking_step2_description" class="textarea textarea-bordered">{{ $landing->how_section_staking_step2_description ?? '' }}</textarea>
            </div>

            <!-- Step 3 -->
            <h3 class="font-bold mb-2">Step 3</h3>
            <div class="form-control">
                <label class="label">Title</label>
                <input type="text" name="how_section_staking_step3_title" class="input input-bordered" value="{{ $landing->how_section_staking_step3_title ?? '' }}">
            </div>
            <div class="form-control">
                <label class="label">Description</label>
                <textarea name="how_section_staking_step3_description" class="textarea textarea-bordered">{{ $landing->how_section_staking_step3_description ?? '' }}</textarea>
            </div>
        </div>
        
        <!-- Exchange -->
        <h1 class="font-bold mb-2">Exchange</h1>
        <div class="card bg-base-200 p-4">
            <!-- Step 1 -->
            <h3 class="font-bold mb-2">Step 1</h3>
            <div class="form-control">
                <label class="label">Title</label>
                <input type="text" name="how_section_exchange_step1_title" class="input input-bordered" value="{{ $landing->how_section_exchange_step1_title ?? '' }}">
            </div>
            <div class="form-control">
                <label class="label">Description</label>
                <textarea name="how_section_exchange_step1_description" class="textarea textarea-bordered">{{ $landing->how_section_exchange_step1_description ?? '' }}</textarea>
            </div>
            
            <!-- Step 2 -->
            <h3 class="font-bold mb-2">Step 2</h3>
            <div class="form-control">
                <label class="label">Title</label>
                <input type="text" name="how_section_exchange_step2_title" class="input input-bordered" value="{{ $landing->how_section_exchange_step2_title ?? '' }}">
            </div>
            <div class="form-control">
                <label class="label">Description</label>
                <textarea name="how_section_exchange_step2_description" class="textarea textarea-bordered">{{ $landing->how_section_exchange_step2_description ?? '' }}</textarea>
            </div>

            <!-- Step 3 -->
            <h3 class="font-bold mb-2">Step 3</h3>
            <div class="form-control">
                <label class="label">Title</label>
                <input type="text" name="how_section_exchange_step3_title" class="input input-bordered" value="{{ $landing->how_section_exchange_step3_title ?? '' }}">
            </div>
            <div class="form-control">
                <label class="label">Description</label>
                <textarea name="how_section_exchange_step3_description" class="textarea textarea-bordered">{{ $landing->how_section_exchange_step3_description ?? '' }}</textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>