@extends('layout.app', [ 'open_user_menu' => true, 'menu' => 'user_management', 'sub_menu' => 'add_user' ])

@section('title', __('Add New User'))

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <h2 class="card-title">{{ __('Add New User') }}</h2>
            <form action="{{ route('addUser') }}" method="post">
                @csrf
                <div class="grid sm:block">
                    <div class="grid grid-cols-2 gap-1 sm:block sm:w-full mr-1  overflow-hidden">

                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">
                                    {{ __('First Name') }}
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <input name="first_name" type="text" value="{{ $email->first_name ?? '' }}"
                                placeholder="{{ __('Enter First Name') }}" class="input input-bordered" />
                        </label>

                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">
                                    {{ __('Last Name') }}
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <input name="last_name" type="text" value="{{ $email->last_name ?? '' }}"
                                placeholder="{{ __('Enter Last Name') }}" class="input input-bordered" />
                        </label>
                        
                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">
                                    {{ __('Username') }}
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <input name="username" type="text" value="{{ $email->username ?? '' }}"
                                placeholder="{{ __('Enter Unique Username') }}" class="input input-bordered" />
                        </label>

                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">
                                    {{ __('Email') }}
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <input name="email" type="text" value="{{ $email->email ?? '' }}"
                                placeholder="{{ __('Enter Email Address') }}" class="input input-bordered" />
                        </label>

                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">
                                    {{ __('Country') }}
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <select name="country" class="select select-bordered">
                                <option disabled selected>{{ __('Select A Country') }}</option>
                                <option value="bn">{{ 'Bangladesh' }}</option>
                                <option value="in">{{ 'India' }}</option>
                                <option value="pk">{{ 'Pakistan' }}</option>
                            </select>
                        </label>

                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">
                                    {{ __('Phone') }}
                                </span>
                            </div>
                            <input name="phone" type="text" value="{{ $user->phone ?? '' }}"
                                placeholder="{{ __('Enter Phone Number') }}" class="input input-bordered" />
                        </label>
                    </div>
                </div>


                <div class="card-actions justify-center">
                    <button type="submit" class="btn btn-success w-3/5">{{ __('Create User') }}</button>
                </div>
            </form>
        </div>
    </div>

@endsection
