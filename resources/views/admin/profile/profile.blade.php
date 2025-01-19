@extends('layout.app')

@section('title', __('Admin Profile'))

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex justify-between">
                <h2 class="card-title">{{ __('Admin Profile') }}</h2>
                <a href="{{ route('adminResetPasswordPage') }}" class="btn btn-primary ">{{ __('Reset Password') }}</a>
            </div>

            <form action="{{ route('profileUpdateProcess') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-span-2">
                    <div id="profileImagePreview"
                        class="mx-auto flex justify-center w-[141px] h-[141px] bg-blue-300/20 rounded-full bg-cover bg-center bg-no-repeat">
                        @isset($edit)
                            <div class="bg-white/90 rounded-full w-6 h-6 text-center ml-28 mt-4">
                                <input type="file" name="image" id="upload_profile" hidden>
                                <label for="upload_profile">
                                    <svg data-slot="icon" class="w-6 h-5 bg-base-500 text-blue-700" fill="none" stroke-width="1.5"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z">
                                        </path>
                                    </svg>
                                </label>
                            </div>
                        @endisset
                    </div>
                    <div class="divider"></div>

                    <div class="grid sm:block">
                        <div class="grid grid-cols-2 gap-1 sm:block sm:w-full mr-1  overflow-hidden">

                            <label class="form-control p-1">
                                <div class="label">
                                    <span class="label-text">{{ __('First Name') }}</span>
                                </div>
                                <input name="first_name" type="text" class="input input-bordered"
                                    value="{{ $user->first_name ?? '' }}" id="firstName" autocomplete="off"
                                    @if (!isset($edit)) readonly @endif />
                            </label>
                            <label class="form-control p-1">
                                <div class="label">
                                    <span class="label-text">{{ __('Last Name') }}</span>
                                </div>
                                <input name="last_name" type="text" class="input input-bordered"
                                    value="{{ $user->last_name ?? '' }}" id="lastName" autocomplete="off"
                                    @if (!isset($edit)) readonly @endif />
                            </label>
                            <label class="form-control p-1">
                                <div class="label">
                                    <span class="label-text">{{ __('Email') }}</span>
                                </div>
                                <input name="email" type="email" class="input input-bordered" value="{{ $user->email ?? '' }}"
                                    id="email" autocomplete="off" @if (!isset($edit)) readonly @endif />
                            </label>
                        </div>
                    </div>
                </div>

                <div class="grid sm:block">
                    <div class="grid grid-cols-1 gap-1 sm:block sm:w-full mr-1  overflow-hidden">
                        {{-- form button --}}
                        <label class="form-control p-1">
                            @if (isset($edit))
                                <button type="submit" class="btn btn-success w-full d-inline ">{{ __('Update') }}</button>
                            @else
                                <a href="{{ route('adminProfilePage') . '?edit=true' }}"
                                    class="btn btn-info w-full d-inline ">{{ __('Edit') }}</a>
                            @endif
                        </label>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('downjs')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.getElementById('profileImagePreview').style.backgroundImage = `url('{{ $user->getImage() ?? '' }}')`;

            let service = document.siteProviderService

                // Image Preview FilePond
                .newInstance()
                .filePondService("filePond")
                .setCongif(filePondOption)
                .setNodeSeletor('.filepond')
                @if (isset($item->icon) && filled($item->icon))
                    .setdefaultFile('{{ $item->getIcon() }}')
                @endif
                .exit()

            .boot();
        });

        @isset($edit)
            document.getElementById('upload_profile').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const imgDiv = document.getElementById('profileImagePreview');
                        imgDiv.style.backgroundImage = `url(${e.target.result})`;
                        console.log("e.target.result", e.target.result);
                    };

                    reader.readAsDataURL(file);
                }
            });
        @endisset
    </script>
@endsection
