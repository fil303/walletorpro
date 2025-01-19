<div x-show="currentTab === 'colors'" class="space-y-4">
    <h2 class="text-2xl font-bold">Theme Colors</h2>
    <div class="card bg-base-200 p-6">
        <form action="{{ route('landingThemeColorSetting') }}" method="POST" class="grid grid-cols-2 gap-6">
            @csrf
            <!-- Primary Color -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Primary Color</span>
                </label>
                <div class="flex gap-4">
                    <input type="color" name="primary_color" value="{{ $landing->primary_color ?? '' }}" class="w-24 h-12">
                    <input type="text" value="{{ $landing->primary_color ?? '' }}" class="input input-bordered" pattern="^#[0-9A-Fa-f]{6}$">
                </div>
            </div>

            <!-- Secondary Color -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Secondary Color</span>
                </label>
                <div class="flex gap-4">
                    <input type="color" name="secondary_color" value="{{ $landing->secondary_color ?? '' }}" class="w-24 h-12">
                    <input type="text" value="{{ $landing->secondary_color ?? '' }}" class="input input-bordered" pattern="^#[0-9A-Fa-f]{6}$">
                </div>
            </div>

            <!-- Success Color -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Success Color</span>
                </label>
                <div class="flex gap-4">
                    <input type="color" name="success_color" value="{{ $landing->success_color ?? '' }}" class="w-24 h-12">
                    <input type="text" value="{{ $landing->success_color ?? '' }}" class="input input-bordered" pattern="^#[0-9A-Fa-f]{6}$">
                </div>
            </div>

            <!-- Info Color -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Info Color</span>
                </label>
                <div class="flex gap-4">
                    <input type="color" name="info_color" value="{{ $landing->info_color ?? '' }}" class="w-24 h-12">
                    <input type="text" value="{{ $landing->info_color ?? '' }}" class="input input-bordered" pattern="^#[0-9A-Fa-f]{6}$">
                </div>
            </div>

            <div class="col-span-2">
                <button type="submit" class="btn btn-primary">Save Color Settings</button>
            </div>
        </form>
    </div>
</div>