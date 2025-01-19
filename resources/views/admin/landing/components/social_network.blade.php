<div x-show="currentTab === 'social'" class="space-y-4">
    <h2 class="text-2xl font-bold">Social Network URL</h2>
    <form action="{{ route('landingSocialNetworkSetting') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="section" value="social_network">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Facebook -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Facebook URL</span>
                </label>
                <input type="text" name="social_facebook_url" class="input input-bordered" placeholder="https://facebook.com/yourpage">
            </div>

            <!-- Twitter -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Twitter URL</span>
                </label>
                <input type="text" name="social_twitter_url" class="input input-bordered" placeholder="https://twitter.com/yourhandle">
            </div>

            <!-- LinkedIn -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text">LinkedIn URL</span>
                </label>
                <input type="text" name="social_linkedin_url" class="input input-bordered" placeholder="https://linkedin.com/company/yourcompany">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="form-control mt-6">
            <button type="submit" class="btn btn-primary">Save Social Network Settings</button>
        </div>
    </form>
</div>
