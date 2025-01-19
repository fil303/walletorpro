<div x-show="currentTab === 'wallet'" class="space-y-4">
    <h2 class="text-2xl font-bold">Wallet Features Section</h2>
    <form action="{{ route('landingWalletSectionSetting') }}" method="POST" class="space-y-4">@csrf
        <div class="form-control">
            <label class="label">Section Badge</label>
            <input type="text" name="wallet_section_badge_text" class="input input-bordered" value="Features">
        </div>

        <div class="form-control">
            <label class="label">Section Title</label>
            <input type="text" name="wallet_section_title" class="input input-bordered" value="Advanced Wallet Features">
        </div>

        <!-- Feature 1 -->
        <div class="card bg-base-200 p-4">
            <h3 class="font-bold mb-2">Feature 1</h3>
            <div class="form-control">
                <label class="label">Title</label>
                <input type="text" name="wallet_section_feature1_title" class="input input-bordered" value="Secure Storage">
            </div>
            <div class="form-control">
                <label class="label">Description</label>
                <textarea name="wallet_section_feature1_description" class="textarea textarea-bordered">Military-grade encryption for your digital assets</textarea>
            </div>
        </div>

        <!-- Feature 2 -->
        <div class="card bg-base-200 p-4">
            <h3 class="font-bold mb-2">Feature 2</h3>
            <div class="form-control">
                <label class="label">Title</label>
                <input type="text" name="wallet_section_feature2_title" class="input input-bordered" value="Instant Transfers">
            </div>
            <div class="form-control">
                <label class="label">Description</label>
                <textarea name="wallet_section_feature2_description" class="textarea textarea-bordered">Lightning-fast transactions between wallets</textarea>
            </div>
        </div>

        <!-- Feature 3 -->
        <div class="card bg-base-200 p-4">
            <h3 class="font-bold mb-2">Feature 3</h3>
            <div class="form-control">
                <label class="label">Title</label>
                <input type="text" name="wallet_section_feature3_title" class="input input-bordered" value="24/7 Access">
            </div>
            <div class="form-control">
                <label class="label">Description</label>
                <textarea name="wallet_section_feature3_description" class="textarea textarea-bordered">Access your wallet anytime, anywhere</textarea>
            </div>
        </div>
        <!-- Feature 4 -->
        <div class="card bg-base-200 p-4">
            <h3 class="font-bold mb-2">Feature 1</h3>
            <div class="form-control">
                <label class="label">Title</label>
                <input type="text" name="wallet_section_feature4_title" class="input input-bordered" value="Secure Storage">
            </div>
            <div class="form-control">
                <label class="label">Description</label>
                <textarea name="wallet_section_feature4_description" class="textarea textarea-bordered">Military-grade encryption for your digital assets</textarea>
            </div>
        </div>

        <!-- Feature 5 -->
        <div class="card bg-base-200 p-4">
            <h3 class="font-bold mb-2">Feature 2</h3>
            <div class="form-control">
                <label class="label">Title</label>
                <input type="text" name="wallet_section_feature5_title" class="input input-bordered" value="Instant Transfers">
            </div>
            <div class="form-control">
                <label class="label">Description</label>
                <textarea name="wallet_section_feature5_description" class="textarea textarea-bordered">Lightning-fast transactions between wallets</textarea>
            </div>
        </div>

        <!-- Feature 6 -->
        <div class="card bg-base-200 p-4">
            <h3 class="font-bold mb-2">Feature 3</h3>
            <div class="form-control">
                <label class="label">Title</label>
                <input type="text" name="wallet_section_feature6_title" class="input input-bordered" value="24/7 Access">
            </div>
            <div class="form-control">
                <label class="label">Description</label>
                <textarea name="wallet_section_feature6_description" class="textarea textarea-bordered">Access your wallet anytime, anywhere</textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>