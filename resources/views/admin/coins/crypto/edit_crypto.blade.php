@extends('layout.app', [ "menu" => "coins" ])
@section('title', __('Add New User'))

@use(App\Enums\CurrencyType)
@use(App\Enums\CryptoProvider)
@use(App\Enums\FeesType)

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex justify-between">
                <h2 class="card-title">{{ __('Edit Coin') }}</h2>
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
            <form action="{{ route('coinUpdate') }}" method="post" enctype="multipart/form-data">
                @csrf
                @isset($item)
                    <input type="hidden" name="uid" value="{{ $item->uid ?? '' }}">
                @endisset
                <div class="grid sm:block">
                    <div class="grid grid-cols-3 gap-1 lg:grid-cols-2 sm:block sm:w-full mr-1  overflow-hidden">

                        @if(false)
                            <label class="form-control p-1">
                                <div class="label">
                                    <span class="label-text">{{ __('Currency Type') }}
                                        <span class="text-error">*</span>
                                    </span>
                                </div>
                                <select name="type" class="select select-bordered"
                                    onchange="setFormForSelectedCurrencyType(this.value)">
                                    {!! CurrencyType::renderOption($item->type ?? 'c') !!}
                                </select>
                            </label>
                        @endif

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
                                class="input input-bordered" readonly />
                        </label>

                        <label class="crypto_type_field form-control p-1">
                            <div class="label">
                                <span class="label-text">{{ __('Coin') }}
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <input name="coin" type="text" value="{{ $item->coin ?? '' }}" class="input input-bordered" readonly />
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
                                    <span class="text-error">*</span>
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
                                <span class="label-text">{{ __('Print Decimal') }}
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <input name="print_decimal" type="number" value="{{ $item->print_decimal ?? '' }}" class="input input-bordered" />
                        </label>

                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">{{ __('Minimum Withdrawal') }}
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <input name="withdrawal_min" type="text" value="{{ $item->withdrawal_min ?? '' }}"
                                class="input input-bordered" />
                        </label>

                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">{{ __('Maximum Withdrawal') }}
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <input name="withdrawal_max" type="text" value="{{ $item->withdrawal_max ?? '' }}"
                                class="input input-bordered" />
                        </label>

                        <br class="hidden md:block lg:block sm:!hidden" />

                        <!-- Withdrawal Status -->
                        <div class="card bg-base-100 shadow-md sm:mb-2 p-6">
                            <h2 class="card-title">{{ __('Withdrawal Status And Fees') }}</h2>
                            <p class="text-sm text-gray-500">{{ __('You can enable or disable the withdrawal feature based on your needs and set flexible withdrawal fees to ensure seamless transactions.') }}</p>
                            <label class="cursor-pointer flex items-center mt-2">
                                {!! view('admin.components.toggle', [
                                    'items' => ['name' => 'withdrawal_status'],
                                    'selected' => $item->withdrawal_status ?? 0,
                                ]) !!}
                                @if ($item->withdrawal_status ?? 0)
                                    <span class="ml-2">{{ __('Enabled Withdrawal') }}</span>
                                @else
                                    <span class="ml-2">{{ __('Disabled Withdrawal') }}</span>
                                @endif
                            </label>
                            <div class="grid grid-cols-2 gap-4 mt-4">

                                <label class="form-control p-1">
                                    <div class="label">
                                        <span class="label-text">{{ __('Fees') }}
                                            <span class="text-error">*</span>
                                        </span>
                                    </div>
                                    <input name="withdrawal_fees" type="text" value="{{ $item->withdrawal_fees ?? '' }}" class="input input-bordered" />
                                </label>

                                <label class="crypto_type_field form-control p-1">
                                    <div class="label">
                                        <span class="label-text">{{ __('Fee Type') }}
                                            <span class="text-error">*</span>
                                        </span>
                                    </div>
                                    <select name="withdrawal_fees_type" class="select select-bordered">
                                        <option value="" disabled>{{ __('Select Fees Type') }}</option>
                                        {!! FeesType::renderOption($item->withdrawal_fees_type ?? '') !!}
                                    </select>
                                </label>

                            </div>
                        </div>

                        <!-- Exchange Status -->
                        <div class="card bg-base-100 shadow-md sm:mb-2 p-6">
                            <h2 class="card-title">{{ __('Exchange Status And Fees') }}</h2>
                            <p class="text-sm text-gray-500">{{ __('Enable or disable the exchange functionality and set precise fees for each exchange transaction.') }}</p>
                            <label class="cursor-pointer flex items-center mt-2">
                                {!! view('admin.components.toggle', [
                                    'items' => ['name' => 'exchange_status'],
                                    'selected' => $item->exchange_status ?? 0,
                                ]) !!}
                                @if ($item->exchange_status ?? 0)
                                    <span class="ml-2">{{ __('Enabled Exchange') }}</span>
                                @else
                                    <span class="ml-2">{{ __('Disabled Exchange') }}</span>
                                @endif
                            </label>
                            <div class="grid grid-cols-2 gap-4 mt-4">

                                <label class="form-control p-1">
                                    <div class="label">
                                        <span class="label-text">{{ __('Fees') }}
                                            <span class="text-error">*</span>
                                        </span>
                                    </div>
                                    <input name="exchange_fees" type="text" value="{{ $item->exchange_fees ?? '' }}" class="input input-bordered" />
                                </label>

                                <label class="crypto_type_field form-control p-1">
                                    <div class="label">
                                        <span class="label-text">{{ __('Fee Type') }}
                                            <span class="text-error">*</span>
                                        </span>
                                    </div>
                                    <select name="exchange_fees_type" class="select select-bordered">
                                        <option value="" disabled>{{ __('Select Fees Type') }}</option>
                                        {!! FeesType::renderOption($item->exchange_fees_type ?? '') !!}
                                    </select>
                                </label>

                            </div>
                        </div>

                        <!-- Coin Buy Status -->
                        <div class="card bg-base-100 shadow-md sm:mb-2 p-6">
                            <h2 class="card-title">{{ __('Coin Buy Status') }}</h2>
                            <p class="text-sm text-gray-500">{{ __('Enable or disable the option for users to buy coins.') }}</p>
                            <label class="cursor-pointer flex items-center mt-2">
                                {!! view('admin.components.toggle', ['items' => ['name' => 'buy_status'], 'selected' => $item->buy_status ?? 0]) !!}
                                @if ($item->buy_status ?? 0)
                                    <span class="ml-2">{{ __('Enabled Coin Buy') }}</span>
                                @else
                                    <span class="ml-2">{{ __('Disabled Coin Buy') }}</span>
                                @endif
                            </label>
                            <div class="grid grid-cols-2 gap-4 mt-4"></div>
                        </div>

                        <!-- Coin Status -->
                        <div class="card bg-base-100 shadow-md sm:mb-2 p-6">
                            <h2 class="card-title">{{ __('Coin Status') }}</h2>
                            <p class="text-sm text-gray-500">{{ __('Enable or disable individual coins for buying, selling, or exchange, ensuring the right coins are available for your audience.') }}</p>
                            <label class="cursor-pointer flex items-center mt-2">
                                {!! view('admin.components.toggle', ['items' => ['name' => 'status'], 'selected' => $item->status ?? 0]) !!}
                                @if ($item->status ?? 0)
                                    <span class="ml-2">{{ __('Enabled Coin') }}</span>
                                @else
                                    <span class="ml-2">{{ __('Disabled Coin') }}</span>
                                @endif
                            </label>
                        </div>

                        <!-- Coin Icon -->
                        <div class="card bg-base-100 shadow-md sm:mb-2 p-6">
                            <h2 class="card-title">{{ __('Coin Icon') }}</h2>
                            <p class="text-sm text-gray-500">{{ __('Set your coin icon here.') }}</p>
                            <label class="form-control p-1">
                                <div class="label">
                                    <span class="label-text">{{ __('Icon') }}</span>
                                </div>
                                <input name="icon" type="file" class="filepond" />
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-1 sm:block sm:w-full mr-1  overflow-hidden">
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
