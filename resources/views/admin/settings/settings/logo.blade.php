@extends('layout.app', [ 'menu' => 'setting' ])

@section('title', __('Logo Setting'))

@section('content')

    <div class="flex justify-between">
        <h2 class="card-title">{{ __('Logo Setting') }}</h2>
        <a href="{{ route('settingPage') }}" class="btn">
            <svg class="lucide lucide-undo-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M9 14 4 9l5-5" />
                <path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11" />
            </svg>
            {{ __("Button") }}
        </a>
    </div>
    <div class="divider"></div>

    <!-- Logo Settings -->
    <form action="{{ route('logoSettingSave') }}" method="post" enctype="multipart/form-data">@csrf
        <div class="grid sm:block grid-cols-2 md:grid-cols-1 gap-6">
            <!-- Logo -->
            <div class="card bg-base-100 shadow-md p-6">
                <h2 class="card-title">Logo</h2>
                <input name="logo" type="file" id="logo" accept="image/*" />
                <!-- Error Message -->
                @error('logo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Favicon -->
            <div class="card bg-base-100 shadow-md p-6">
                <h2 class="card-title">Favicon</h2>
                <input name="fav" type="file" id="favicon" accept="image/*" />
                <!-- Error Message -->
                @error('fav')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-10 text-center">
            <button class="btn btn-primary w-full max-w-md">{{ __('Update') }}</button>
        </div>
    </form>

@endsection

@section('downjs')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let service = document.siteProviderService

                // Logo
                .newInstance()
                .filePondService("logoFilePond")
                .setCongif({
                    ...filePondOption,
                    labelIdle: '{{ _t('Drag & Drop your file') }} {{ _t('or') }} <span class="filepond--label-action"> {{ _t('Browse') }} </span><br><p>{{ _t('Supported file types') }}: png,jpg,jpeg,svg,webp</p>',
                    allowImagePreview: true,
                    imagePreviewHeight: 200,
                    allowFileTypeValidation: true,
                    labelFileTypeNotAllowed: 'Only image files are allowed.'
                })
                @if(isset($app->app_logo))
                    .setdefaultFile('{{ asset_bind($app->app_logo ?? "") }}')
                @endif
                .setNodeSeletor('#logo')
                .exit()

                // Favicon
                .newInstance()
                .filePondService("logoFilePond")
                .setCongif({
                    ...filePondOption,
                    labelIdle: '{{ _t('Drag & Drop your file') }} {{ _t('or') }} <span class="filepond--label-action"> {{ _t('Browse') }} </span><br><p>{{ _t('Supported file types') }}: ico,png,jpg,jpeg,gif</p>',
                    allowImagePreview: true,
                    imagePreviewHeight: 100,
                    allowFileTypeValidation: true,
                    acceptedFileTypes: ['image/*'],
                    labelFileTypeNotAllowed: 'Only image files are allowed.'
                })
                @if(isset($app->app_fav))
                    .setdefaultFile('{{ asset_bind($app->app_fav ?? "") }}')
                @endif
                .setNodeSeletor('#favicon')
                .exit()

                .boot();
        });
    </script>
@endsection
