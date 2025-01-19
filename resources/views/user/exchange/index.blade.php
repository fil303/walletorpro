@extends('layout.app', [ "menu" => "exchange" ])

@section('title', __('Exchange Coins'))

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <h2 class="card-title">{{ __('Exchange Coins') }}</h2>
            <div class="py-5">
                <form action="{{ route('exchangeCoinProcess') }}" method="post">@csrf
                    <div class="grid w-full mx-auto sm:block">
                        <div class="grid grid-cols-1 gap-1 mr-1  overflow-hidden">
                            <label class="form-control p-1">
                                <div class="label">
                                    <span class="label-text">
                                        {{ __('Exchange From') }}
                                        <span class="text-error">*</span>
                                    </span>
                                    <span class="label-text-alt">
                                        {{ __('Available Balance') }} :
                                        <span data-bind="text" bind-with="from_balance">0</span>
                                        <span data-bind="text" bind-with="from"></span>
                                    </span>
                                </div>
                                <div class="join join-horizontal">
                                    <div class="w-full">
                                        <div class="w-full">
                                            <input id="from_amount" oninput="hitRateApi(getRate)" name="amount"
                                                class="input input-bordered join-item w-full" />
                                        </div>
                                    </div>
                                    <select name="from_coin" id="from" class="select select-bordered join-item"
                                        autocomplete="off" onchange="changeExchangeFromOption()">
                                    </select>
                                </div>
                            </label>

                            <label class="mx-auto mt-8">
                                <svg onclick="swapExchange()" class="w-[40px] h-[40px]" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-arrow-down-up">
                                    <path d="m3 16 4 4 4-4" />
                                    <path d="M7 20V4" />
                                    <path d="m21 8-4-4-4 4" />
                                    <path d="M17 4v16" />
                                </svg>
                            </label>

                            <label class="form-control p-1">
                                <div class="label">
                                    <span class="label-text">{{ __('Exchange To') }}</span>
                                    <span class="label-text-alt">
                                        {{ __('Available Balance') }} :
                                        <span data-bind="text" bind-with="to_balance">0</span>
                                        <span data-bind="text" bind-with="to"></span>
                                    </span>
                                </div>
                                <div class="join join-horizontal">
                                    <div class="w-full">
                                        <div class="w-full">
                                            <input id="to_amount" class="input input-bordered join-item w-full"
                                                data-bind="input" bind-with="total_rate" readonly />
                                        </div>
                                    </div>
                                    <select name="to_coin" id="to" class="select select-bordered join-item"
                                        autocomplete="off" onchange="changeExchangeToOption()">
                                    </select>
                                </div>
                            </label>
                        </div>

                        <div class="text-center mt-1">
                            <span>{{ _t('Rate') }}:</span>
                            <span>
                                <span>1</span>
                                <span data-bind="text" bind-with="from"></span>
                            </span>
                            =
                            <span>
                                <span data-bind="text" bind-with="rate">1</span>
                                <span data-bind="text" bind-with="to"></span>
                            </span>
                        </div>

                        <div class="divider"></div>
                        <div class="grid grid-cols-1 gap-1 sm:block sm:w-full mr-1  overflow-hidden">
                            <label class="form-control p-1">
                                <button type="submit" class="btn btn-success">{{ __('Exchange') }}</button>
                            </label>
                            <label class="form-control p-1 hidden">
                                <button type="button" onclick="" class="btn btn-error">{{ __('Close') }}</button>
                            </label>
                        </div>
                    </div>
                </from>
            </div>
        </div>
    </div>

@endsection
@section('downjs')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let service = document.siteProviderService

                // Storage
                .newInstance()
                .storeService("coinStore")
                .callable(initExchangeFromCoins)
                .initResource('{{ route('exchangeCoins') }}')
                .exit()

                .boot();
        });

        async function initExchangeFromCoins(store) {
            let coins = store.get('coins');
            let formSelectElement = document.querySelector("#from");
            renderCoinsToSelectOptions(coins, formSelectElement);
            changeExchangeFromOption();
        }

        async function renderCoinsToSelectOptions(coins, renderElement, exceptThisCoin = null, existCoin = null) {
            let option = "";
            coins.forEach((coin) => {
                if (coin.coin == exceptThisCoin) {} else {
                    let select = coin.coin == existCoin ? "selected" : ""
                    option += `<option value="${coin.coin}" ${select}>${coin.name}</option>`;
                }
            });
            renderElement.innerHTML = option;
        }

        async function getAvailableBalance(coin, bindTo = "exchangeFrom") {
            let url = '{{ route('cryptoWalletBalance', '') }}/' + coin;
            $.get(url, function(response) {
                if (response.status) {
                    let balance = response.data.wallet.balance;

                    let expiration = bindTo == "exchangeFrom";
                    if (expiration) document.bind.bindTo('from_balance', balance);
                    else document.bind.bindTo('to_balance', balance);
                } else {
                    Notiflix.Notify.failure(response.message || 'Something went wrong');
                }
            })
        }

        async function changeExchangeFromOption() {
            let formSelectElement = document.querySelector("#from");
            getAvailableBalance(formSelectElement.value);
            document.bind.bindTo('from', formSelectElement.value);
            let toSelectElement = document.querySelector("#to");
            let coins = document.coinStore.get('coins');
            await renderCoinsToSelectOptions(coins, toSelectElement, formSelectElement.value, toSelectElement.value);
            toSelectElement = document.querySelector("#to");
            getAvailableBalance(toSelectElement.value, "exchangeTo");
            document.bind.bindTo('to', toSelectElement.value);
            getRate();
        }

        async function changeExchangeToOption() {
            let toSelectElement = document.querySelector("#to");
            getAvailableBalance(toSelectElement.value, "exchangeTo");
            document.bind.bindTo('to', toSelectElement.value);
            getRate();
        }

        async function swapExchange() {
            let coins = document.coinStore.get('coins');

            // from
            let formSelectElement = document.querySelector("#from");
            let toSelectElement = document.querySelector("#to");
            let swap_coin = formSelectElement.value;
            await renderCoinsToSelectOptions(coins, formSelectElement, null, toSelectElement.value);
            getAvailableBalance(toSelectElement.value);
            document.bind.bindTo('from', toSelectElement.value);

            // to
            formSelectElement = document.querySelector("#from");
            toSelectElement = document.querySelector("#to");
            await renderCoinsToSelectOptions(coins, toSelectElement, formSelectElement.value, swap_coin);
            getAvailableBalance(swap_coin, "exchangeTo");
            document.bind.bindTo('to', swap_coin);
            getRate();
        }

        async function getRate() {
            let formSelectElement = document.querySelector("#from");
            let toSelectElement = document.querySelector("#to");
            let formInputElement = document.querySelector("#from_amount");
            let url = '{{ route('exchangeRate') }}';
            let data = {
                from_coin: formSelectElement.value,
                to_coin: toSelectElement.value,
                amount: formInputElement.value > 0 ? formInputElement.value : 1
            };

            await $.get(url, data, (response) => {
                if (response.status) {
                    let rate = response.data.rate;
                    let totalRate = response.data.total_rate;
                    document.bind.bindTo('rate', rate);
                    if (formInputElement.value > 0)
                        document.bind.bindTo('total_rate', totalRate);
                } else {
                    Notiflix.Notify.failure(response.message || 'Something went wrong');
                }
            });
        }

        function selectOptionByCoin(element, coin) {
            element.childNodes.forEach((option) => {
                option.removeAttribute("selected");

                if (option.getAttribute("value") == coin) {
                    option.setAttribute("selected", "");
                }
            });
        }

        var myTimeout = null;

        function hitRateApi(func) {
            if (myTimeout) clearTimeout(myTimeout);
            myTimeout = setTimeout(func, 2000);
        }
    </script>
@endsection
