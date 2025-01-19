@extends('layout.app', [ "menu" => "coin_purchase" ])

@section('title', __('Purchase Coins'))

@section('content')
    <div class="card bg-base-100">
        <div class="card-body">
            <h2 class="card-title">{{ __('Purchase Coins') }}</h2>

            <div class="response_data_coin">
                <div class="text-center">{{ __('No Data Available') }}</div>
            </div>

            <form action="{{ route('coinBuyProcess') }}" method="post">
                @csrf
                <div class="serverSideModalDiv"> </div>
            </form>
        </div>
    </div>
@endsection

@section('downjs')
    <script>
        let top_table = `
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>Asset</th>
                        <th>Price</th>
                        <th>24h Change</th>
                        <th class="hidden lg:table-cell">Market Cap</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    `;

        let bottom_table = `
                </tbody>
            </table>
        </div>
        
        `;

        document.addEventListener("DOMContentLoaded", () => {
            let service = document.siteProviderService
                    // Pagination Response
                    .newInstance()
                    .paginationService("buyCoinList")
                    .setBeforeResponse(top_table)
                    .setAfterResponse(bottom_table)
                    .setResourcesPath('{{ route('buyCoinList') }}')
                    .setPage({{ isset($page) ? $page : 1 }})
                    .renderAt(".response_data_coin")
                    .setUtility(false)
                    .exit()

                    // Server side model
                    .newInstance()
                    .serverSideModal("buyCryptoModal")
                    .setModalRoute('')
                    .setModalParent('.serverSideModalDiv')
                    .setCallable(() => document.bind.bindTo('price', 1))
                    .exit()

                    // Storage
                    .newInstance()
                    .storeService("buyCoinStore")
                    .initResource('{{ route('buyPageData') }}')
                    .exit()
                .boot();
                @isset($selectedCoin) document.buyCryptoModal.getModal('{{ route('buyCoinModal', $selectedCoin) }}'); @endisset
        });

        async function getPaymentMethod(currency) {
            let html = "";
            let payments = document.buyCoinStore.finds("paymentMethods", "currency_code", currency);
            if (typeof payments == "object") {
                payments.forEach((payment) => {
                    html += `<option value="${payment.uid}">${payment.title}</option>`;
                })
            }
            return html;
        }

        async function getCoinPrice(value) {
            let crypto = document.getElementsByName("crypto")[0].value;
            let currency = document.getElementsByName("currency")[0].value;
            let amount = document.getElementsByName("amount")[0].value || 1;

            await getPaymentMethod(currency);
            let gateway = document.getElementsByName("gateway")[0].value;
            let returnValue = 0;
            await $.get(
                '{{ route('getBuyCoinPrice') }}', {
                    crypto: crypto,
                    currency: currency,
                    amount: amount,
                },
                (response) => {
                    amount = document.getElementsByName("amount")[0].value || 0;
                    document.bind.bindTo('net_amount', response.data.price * amount);

                    let payment = document.buyCoinStore.where("paymentMethods", {
                        uid: gateway,
                        currency_code: currency
                    }) ?? {};

                    let total = response.data.price * amount;
                    let fees  = payment.fees_type == 1 
                    ? (payment.fees | 0) 
                    : ( ( (payment.fees | 0) * total ) / 100 );
                    let grand = total ? total + fees : 0;

                    document.bind.bindTo('fees', fees);
                    document.bind.bindTo('total_amount', grand);
                    returnValue = response.data.price;
                }
            )
            return returnValue;
        }
    </script>
@endsection
