@extends('layout.app', [ "menu" => "coins" ])
@section('title', __('Add New User'))

@use(App\Enums\CurrencyType)
@use(App\Enums\CryptoProvider)

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex justify-between">
                <h2 class="card-title">{{ __('Add New Crypto') }}</h2>
                <a href="{{ route('coinsPage') }}" class="btn">
                    <svg class="lucide lucide-undo-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M9 14 4 9l5-5" />
                        <path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11" />
                    </svg>
                    {{ __("Button") }}
                </a>
            </div>
            <form action="{{ route('coinSave') }}" method="post" enctype="multipart/form-data">
                @csrf
                @isset($item)
                    <input type="hidden" name="uid" value="{{ $item->uid ?? '' }}">
                @endisset
                <div class="grid sm:block">
                    <div class="grid grid-cols-2 gap-1 sm:block sm:w-full mr-1  overflow-hidden">



                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">{{ __('Name') }}
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <input name="name" type="text" value="{{ $item->name ?? old('name') }}"
                                class="input input-bordered" />
                        </label>

                        <label class="fiat_type_field form-control p-1">
                            <div class="label">
                                <span class="label-text">{{ __('Code') }}
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <select name="currency" class="select select-bordered">
                                <option value="BDT">BDT</option>
                                <option value="USD">USD</option>
                            </select>
                        </label>

                        <label class="crypto_type_field form-control p-1">
                            <div class="label">
                                <span class="label-text">{{ __('Code') }}
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <input name="code" type="text" value="{{ $item->code ?? old('code') }}"
                                class="input input-bordered" />
                        </label>

                        <label class="crypto_type_field form-control p-1">
                            <div class="label">
                                <span class="label-text">{{ __('Coin') }}
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <input name="coin" type="text" value="{{ $item->coin ?? '' }}" class="input input-bordered" />
                        </label>

                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">{{ __('Decimal') }}
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <input name="decimal" type="number" value="{{ $item->decimal ?? '' }}" class="input input-bordered" />
                        </label>

                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">{{ __('Symbol') }}
                                </span>
                            </div>
                            <input name="symbol" type="text" value="{{ $item->symbol ?? '' }}" class="input input-bordered" />
                        </label>

                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">{{ __('Rate') }} (USD)
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <input name="rate" type="text" value="{{ $item->rate ?? '' }}" class="input input-bordered" />
                        </label>

                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">{{ __('Status') }}
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <select name="status" class="select select-bordered">
                                <option value="1">{{ 'Enable' }}</option>
                                <option value="0">{{ 'Disable' }}</option>
                            </select>
                        </label>

                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">{{ __('Icon') }}</span>
                            </div>
                            <input name="icon" type="file" class="filepond" />
                        </label>

                        {{-- form button --}}
                        <label class="form-control p-1">
                            <button type="submit" class="btn btn-success w-full d-inline ">{{ __('Save') }}</button>
                        </label>
                        <label class="form-control p-1">
                            <a href="{{ route('coinsPage') }}" class="btn btn-error w-full">{{ __('Back To Coin List') }}</a>
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
            let service = document.siteProviderService

                .newInstance()
                .filePondService("pondd")
                .setCongif(filePondOption)
                .setNodeSeletor('.filepond')
            @if (isset($item->icon) && filled($item->icon))
                .setdefaultFile('{{ $item->getIcon() }}')
            @endif
            .exit()

                .boot();
        });

        function cryptoFiledHide() {
            let cryptoFileds = document.querySelectorAll(".crypto_type_field");
            if (cryptoFileds) {
                cryptoFileds.forEach((element) => {
                    $(element).hide();
                });
            }
        }

        function fiatFiledHide() {
            let fiatFileds = document.querySelectorAll(".fiat_type_field");
            if (fiatFileds) {
                fiatFileds.forEach((element) => {
                    $(element).hide();
                });
            }
        }

        function cryptoFiledShow() {
            let cryptoFileds = document.querySelectorAll(".crypto_type_field");
            if (cryptoFileds) {
                cryptoFileds.forEach((element) => {
                    $(element).show();
                });
            }
        }

        function fiatFiledShow() {
            let fiatFileds = document.querySelectorAll(".fiat_type_field");
            if (fiatFileds) {
                fiatFileds.forEach((element) => {
                    $(element).show();
                });
            }
        }

        function setFormForSelectedCurrencyType(type) {
            fiatFiledHide();
            cryptoFiledHide();

            if (type == 'c') cryptoFiledShow();
            if (type == 'f') fiatFiledShow();
        }

        setFormForSelectedCurrencyType('{{ $item->type ?? 'c' }}');
    </script>
@endsection
