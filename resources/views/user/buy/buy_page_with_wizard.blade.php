@extends('layout.app')

@section('title', __('Buy Crypto'))

@section('content')

    <div class="mt-1"></div>
    <div class="grid grid-cols-2 md:grid-cols-1 gap-1">
        <div class="lg:w-full rounded border-r-2">
            <h2 class="card-title">{{ __('Buy Crypto') }}</h2>
            <div class="divider"></div>
            <div class="grid sm:block p-3">
                <form class="" method="POST">
                    @csrf
                    <div class="c_wizard">
                        <div class="wizard_step_1">
                            <div class="grid grid-cols-1 gap-1 sm:block sm:w-full mr-1  overflow-hidden">

                                <label class="form-control p-1 bg-base-500">
                                    <div class="label">
                                        <span class="label-text">{{ __('Coin') }}</span>
                                    </div>
                                    <select onchange="document.bind.bindTo('buy_coin', this.value)" name="provider"
                                        class="select select-bordered bg-base-500" autocomplete="off"
                                        wizard-validate-step="1" data-rules="required|">
                                        <option value="">{{ __('Select a coin') }}</option>
                                        {!! view('user.components.select_option', [
                                            'items' => $coins,
                                            'attrs' => [
                                                'data-test' => 55,
                                            ],
                                        ]) !!}
                                    </select>
                                </label>

                                <label class="form-control p-1">
                                    <div class="label">
                                        <span class="label-text">{{ __('Amount') }}</span>
                                    </div>
                                    <input name="code" type="number"
                                        oninput="document.bind.bindTo('buy_coin_amount', this.value)"
                                        value="{{ $item->code ?? old('code') }}" placeholder="0" step="0.00000001"
                                        class="input input-bordered" autocomplete="off" wizard-validate-step="1"
                                        data-rules="required|" required />
                                </label>

                                <label class="form-control p-1 bg-base-500">
                                    <div class="label">
                                        <span class="label-text">{{ __('Payment Method') }}</span>
                                    </div>
                                    <select name="payment" class="select select-bordered bg-base-500" autocomplete="off"
                                        wizard-validate-step="1" data-rules="required|">
                                        <option value="">{{ __('Select a method') }}</option>
                                        {!! view('user.components.select_option', [
                                            'items' => $gateways,
                                            'attrs' => [
                                                'data-test' => 55,
                                            ],
                                        ]) !!}
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="wizard_step_2">
                            <div class="grid grid-cols-1 gap-1 sm:block sm:w-full mr-1  overflow-hidden">
                                <div class="w-5/6 mx-auto">
                                    <div class="flex justify-between mb-2">
                                        <div>
                                            <span>{{ __('I want to buy') }}:</span>
                                        </div>
                                        <div>
                                            <span data-bind="text" bind-with="buy_coin_amount"></span>
                                            <span data-bind="text" bind-with="buy_coin"></span>
                                        </div>
                                    </div>
                                    <div class="flex justify-between mb-2">
                                        <div>
                                            <span>{{ __('Exchange Rate') }}:</span>
                                        </div>
                                        <div>
                                            <span>1</span>
                                            <span data-bind="text" bind-with="buy_coin"></span>
                                            =
                                            <span>100 </span>
                                            <span data-bind="text" bind-with="buy_coin"></span>
                                        </div>
                                    </div>
                                    <div class="flex justify-between mb-2">
                                        <div>
                                            <span>{{ __('Convert Amount') }}:</span>
                                        </div>
                                        <div>
                                            <span>100 </span>
                                            <span data-bind="text" data-callback="convertAmount"
                                                bind-with="buy_coin"></span>
                                        </div>
                                    </div>
                                    <div class="flex justify-between mb-2">
                                        <div>
                                            <span>{{ __('Network Fees') }}:</span>
                                        </div>
                                        <div>
                                            <span>0.001 </span>
                                            <span data-bind="text" bind-with="buy_coin"></span>
                                        </div>
                                    </div>
                                    <div class="flex justify-between mb-2">
                                        <div>
                                            <span>{{ __('I will pay') }}:</span>
                                        </div>
                                        <div>
                                            <span>100 </span>
                                            <span data-bind="text" bind-with="buy_coin"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="join grid grid-cols-3 w-2/3 mx-auto mt-3">
                        <button type="button" class="step_p join-item btn btn-sm btn-primary"
                            onclick="(document.c_wizard).previousStep()" disabled>
                            <<< /button>
                                <button type="submit" class="step_s join-item btn btn-sm btn-success"
                                    disabled>{{ __('Buy') }} <span data-bind="text"
                                        bind-with="buy_coin"></span></button>
                                <button type="button" class="step_n join-item btn btn-sm btn-primary"
                                    onclick="(document.c_wizard).nextStep()">>></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:w-full rounded">
            <div class="hidden sm:block md:block">
                <div class="divider"></div>
            </div>

            <h2 class="card-title">{{ __('Buy Crypto FAQ:') }}</h2>
            <div class="divider"></div>
            <div class="overflow-auto ">
                @if (isset($faqs[0]))
                    @foreach ($faqs as $faq)
                        <div class="collapse collapse-arrow">
                            <input type="radio" name="my-accordion-2" checked="checked" />
                            <div class="collapse-title text-xl font-medium">
                                {{ $faq->question }}
                            </div>
                            <div class="collapse-content">
                                <p>{{ $faq->answer }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="divider"></div>
    <h2 class="card-title">{{ __('Buy Crypto Report') }}</h2>
    <div class="divider"></div>
    <div class="response_data_coin">
        <div class="text-center">{{ __('No Data Available') }}</div>
    </div>

@endsection
@section('downjs')
    <script>
        function convertAmount(value) {
            return value;
        }

        document.addEventListener("DOMContentLoaded", () => {
            let service = document.siteProviderService
                // Wizard
                .newInstance()
                .wizardService("c_wizard")
                .setStep(2)
                .setRenderNodes(".c_wizard")
                .setStepNodesElement([".wizard_step_1", ".wizard_step_2"])
                .setNextButton(".step_n")
                .setPreviousButton(".step_p")
                .setSubmitButton(".step_s")
                //.setCurrentStep(3)
                .exit()

                // pagination data
                .newInstance()
                .paginationService("pagination1")
                .setBeforeResponse('<div class="grid"><div class="grid grid-cols-2 xl:grid-cols-1 gap-1 mr-1">')
                .setAfterResponse('</div></div>')
                .setResourcesPath('{{ route('cryptoWalletPage') }}')
                .setPage({{ isset($page) ? $page : 1 }})
                .renderAt(".response_data_coin")
                .exit()

                .boot();
        });
    </script>
@endsection
