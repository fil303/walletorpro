@extends('layout.app', [ 'menu' => 'payment' ])

@section('title', __('Automated Gateway'))
@use(App\Enums\FeesType)
@section('content')

    <form action="{{ route('updateAutomatedGateway') }}" method="post" class="" >@csrf
        <div class="card w-full bg-base-100 shadow-xl p-8 rounded-lg space-y-8">
            <input type="hidden" name="uid" value="{{ $gateway->uid ?? '' }}">
            <div class="flex justify-between">
                <h2 class="card-title">{{ __('Gateway Details') }}</h2>
                <a href="{{ route('autoGatewayList') }}" class="btn">
                    <svg class="lucide lucide-undo-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M9 14 4 9l5-5" />
                        <path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11" />
                    </svg>
                    {{ __("Button") }}
                </a>
            </div>
            <div class="grid grid-cols-3 gap-1">
                <div class="col-span-2">
                    <div class="grid grid-cols-3 gap-1">
                        <div class="sm:col-span-2">
                            <input name="icon" type="file" class="filepond" />
                        </div>
                        <div class="ml-3">
                            <div class="text-xl font-bold">{{ $gateway->title ?? 'Gateway Name' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            @if (isset($gateway_attr[0]))
                <div class="grid">
                    <div class="grid grid-cols-2 gap-2 sm:block sm:w-full mr-1  overflow-hidden">

                        @foreach ($gateway_attr as $attr)
                            <label class="form-control p-1">
                                <div class="label">
                                    <span class="label-text">
                                        {{ __($attr->title) }}
                                        @if ($attr->required)
                                            <span class="label-text text-[red]">*</span>
                                        @endif
                                    </span>
                                </div>
                                @if ($attr->type == 'input')
                                    <input class="input input-bordered" type="text" name="{{ $attr->slug }}"
                                        value="{{ $attr->value ?? old($attr->slug) }}"
                                        @if ($attr->readonly) readonly @endif
                                        @if ($attr->required) required @endif />
                                @endif
                                @if ($attr->type == 'select')
                                    <select name="{{ $attr->slug }}" class="select select-bordered"
                                        @if ($attr->readonly) readonly @endif
                                        @if ($attr->required) required @endif>
                                        <option value="test" @if($attr->value == 'test') selected @endif >{{ _t('Test') }}</option>
                                        <option value="live" @if($attr->value == 'live') selected @endif >{{ _t('Live') }}</option>
                                    </select>
                                @endif
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="grid sm:block grid-cols-2 gap-1 mt-2 sm:w-full">
            @if (isset($gateway_currency[0]) && isset($gateway_currency[0]->currency))
                @foreach ($gateway_currency as $gateway_currency)

                    <input type="hidden" name="currency[]" value="{{ $gateway_currency->currency_code ?? '' }}">
                        <div class="border-2 border-secondary rounded">
                            <div class="p-2 text-xl bg-secondary text-center flex justify-around">
                                <div>{{ $gateway_currency->currency_code }} ( {{ $gateway_currency->currency->name ?? '' }} )</div>
                                <button 
                                    onclick="document.getElementById('removeAnchor').setAttribute('href', this.dataset.url); document.getElementById('currencyDeleteModel').showModal()" 
                                    data-url="{{ route('autoGatewayCurrencyDelete', ['uid' => $gateway->uid ?? '', 'currency_code' => $gateway_currency->currency_code ]) }}" 
                                    class="btn btn-sm btn-error right-5 top-5"
                                    type="button">
                                    {{ __("Remove") }}
                                </button>
                            </div>
                            <div class="grid grid-cols-2 gap-2 w-11/12 mx-auto">

                                <label class="form-control p-1 overflow-hidden">
                                    <div class="label">
                                        <span class="label-text">
                                            {{ __('Fees') }}
                                            <span class="label-text text-[red]">*</span>
                                        </span>
                                    </div>
                                    <label class="input input-bordered flex items-center gap-2">
                                        <span>{{ $gateway_currency->currency->symbol ?? "$" }}</span>
                                        <input name="fees[]" type="number" class="grow bg-base-100"
                                            value="{{ $gateway_currency->fees ?? '' }}" step="any" placeholder="0" />
                                    </label>
                                </label>

                                <label class="crypto_type_field form-control p-1">
                                    <div class="label">
                                        <span class="label-text">{{ __('Fees Type') }}
                                            <span class="text-error">*</span>
                                        </span>
                                    </div>
                                    <select name="fees_type[]" class="select select-bordered">
                                        <option value="" disabled>{{ __('Select Fees Type') }}</option>
                                        {!! FeesType::renderOption($gateway_currency->fees_type ?? '') !!}
                                    </select>
                                </label>
                            </div>
                        </div>
                        
                    @endforeach
                @endif
            </div>
            <div class="divider"></div>
            <div class="mt-2 grid gap-4 grid-cols-2">
                <button class="w-full btn btn-primary" type="submit">{{ __('Update Gateway') }}</button>
                <button class="w-full btn btn-success" onclick="document.getElementById('openGateWayCurrencyModal').showModal()" type="button">{{ __('Add Currency') }}</button>
            </div>
        </div>
    </form>

<dialog id="openGateWayCurrencyModal" class="modal">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-5 top-5">✕</button>
        </form>
        <h3 class="font-bold text-lg">{{ __('Add Currency') }}</h3>
        <div class="divider"></div>
        <form action="{{ route('addGatewayCurrency') }}" method="post" id="addCurrencyForm">@csrf
            <input type="hidden" name="uid" value="{{$gateway->uid ?? ''}}">
            <label class="form-control p-1 overflow-hidden">
                <div class="label">
                    <span class="label-text">
                        {{ __('Currency Code') }}
                        <span class="label-text text-[red]">*</span>
                    </span>
                </div>
                <label class="input input-bordered flex items-center gap-2">
                    <input name="currency_code" type="text" class="grow bg-base-100" placeholder="Ex : USD" />
                </label>
            </label>
            <div class="grid grid-cols-2 gap-2">
                <label class="form-control p-1 overflow-hidden">
                    <div class="label">
                        <span class="label-text">
                            {{ __('Fees') }}
                            <span class="label-text text-[red]">*</span>
                        </span>
                    </div>
                    <label class="input input-bordered flex items-center gap-2">
                        <span>$</span>
                        <input name="fees" type="number" class="grow bg-base-100" />
                    </label>
                </label>

                <label class="crypto_type_field form-control p-1">
                    <div class="label">
                        <span class="label-text">{{ __('Fees Type') }}
                            <span class="text-error">*</span>
                        </span>
                    </div>
                    <select name="fees_type" class="select select-bordered">
                        <option value="" disabled>{{ __('Select Fees Type') }}</option>
                        {!! FeesType::renderOption() !!}
                    </select>
                </label>
            </div>
        </form>
        <div class="modal-action">
            <form method="dialog">
                <button class="btn btn-sm btn-primary"
                    onclick="document.getElementById('addCurrencyForm').submit()">{{ __('Add Currency') }}</button>
                <button class="btn btn-sm btn-ghost">{{ __('Close') }}</button>
            </form>
        </div>
    </div>
</dialog>
<dialog id="currencyDeleteModel" class="modal">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-5 top-5">✕</button>
        </form>
        <h3 class="font-bold text-lg">{{ __('Remove Currency') }}</h3>
        <div class="divider"></div>
        <p>{{ __("Are you sure, you want to remove this currency ?") }}</p>
        <div class="modal-action">
            <form method="dialog">
                <a href="#" id="removeAnchor" class="btn btn-sm btn-primary">{{ __('Remove Currency') }}</a>
                <button class="btn btn-sm btn-ghost">{{ __('Close') }}</button>
            </form>
        </div>
    </div>
</dialog>

@endsection
@section('downjs')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let service = document.siteProviderService
                // DataTable
                .newInstance()
                .filePondService("filePond")
                .setCongif(filePondOption)
                .setNodeSeletor('.filepond')
                .setdefaultFile(
                    '{{ asset_bind($gateway->icon ?? "") }}'
                    )
                .exit()



                .boot();
        });
    </script>
@endsection
