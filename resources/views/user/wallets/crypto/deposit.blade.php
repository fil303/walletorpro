@extends('layout.app', [ "menu" => "wallet" ])

@section('title', __('My Crypto Wallets'))
@use(App\Enums\FileDestination)
@section('content')

    <div class="container mx-auto p-4">

        <div class="flex justify-between">
            <h2 class="card-title"></h2>
            <a href="{{ route('cryptoWalletPage') }}" class="btn">
                <svg class="lucide lucide-undo-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M9 14 4 9l5-5" />
                    <path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11" />
                </svg>
                {{ __("Button") }}
            </a>
        </div>

        <!-- Wallet Balance and Coin Details -->
        <div class="card w-full bg-base-100 shadow-lg mb-6 p-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img src="{{ $wallet->icon }}"
                    alt="{{ $wallet->name ?? '' }}" class="w-10 h-10" loading="lazy">
                <div>
                    <p class="text-lg font-semibold">{{ $wallet->name ?? '' }}</p>
                    <p class="text-sm text-gray-500">{{ __('Balance') }}: {{ $wallet->balance }} {{ $wallet->coin }}</p>
                </div>
            </div>
            <div class="text-lg font-semibold">≈ ${{ $wallet->balance * $wallet->coin_table->rate  }} USD</div>
        </div>

        <div class="grid sm:block md:grid-cols-1 grid-cols-1 gap-8 items-start">
            <!-- Deposit Section -->
            <div class="card w-full bg-base-100 shadow-lg p-6">
                <!-- Network Selection -->
                @if ($wallet->multiNetworkCoin ?? false)
                    <label class="label font-semibold">{{ __('Select Network') }}</label>
                    <select onchange="generateNewAddress()" class="select select-bordered w-full mb-4" id="networkSelect">
                        <option value="" disabled selected>{{ __('Choose a network') }}</option>
                        {!! view('admin.components.select_option', [
                            'items' => $wallet->coins ?? [],
                            'seleted_item' => $wallet->coin_code ?? null,
                        ]) !!}
                    </select>
                @endif

                <!-- Deposit Address -->
                <label class="label font-semibold">Your Deposit Address</label>
                <div class="flex items-center mb-4">
                    <input type="text" id="depositAddress" class="input input-bordered w-full"
                        value="{{ $wallet->address ?? __('Address not found!') }}" readonly />
                    <button class="btn btn-outline btn-primary ml-2" onclick="copyToClipboard()">Copy</button>
                </div>

                <!-- QR Code (Demo) -->
                @if (filled($wallet->address))
                    <div class="flex flex-col items-center">
                        <div class="glass p-5">
                            {!! app('qrcode')->size(150)->generate($wallet->address) !!}
                        </div>
                        <p class="text-sm text-gray-500 mt-2">{{ __('Scan this code to deposit') }}</p>
                    </div>
                @else
                    @if ($wallet->multiNetworkCoin ?? false)
                        <button class="btn btn-primary" onclick="generateNewAddress()" type="button">Generate
                            Address</button>
                    @else
                        <p>Address not found!</p>
                    @endif
                @endif


                <!-- Instructions -->
                <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 mt-4 p-4">
                    <h2 class="font-semibold text-lg mb-2">Deposit Instructions</h2>
                    <ul class="list-disc list-inside text-sm text-gray-700">
                        <li>Only send the selected network’s coin to this address.</li>
                        <li>Sending any other coin may result in a loss of funds.</li>
                        <li>Confirm the network and address before depositing.</li>
                        <li>Deposit processing may take 5-10 minutes.</li>
                    </ul>
                </div>
            </div>

            <div class="card w-full bg-base-100 shadow-lg p-6 space-y-4">
                <!-- Recent Deposits -->
                <h2 class="font-semibold text-lg mb-2">Recent Deposits</h2>
                <div class="response_data_coin">
                    <div class="text-center">{{ __('No Data Available') }}</div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('downjs')
    <script>
        @if ($wallet->multiNetworkCoin ?? false)
            function generateNewAddress() {
                let network = document.getElementById("networkSelect").value;
                if (!network) {
                    alert("select a network");
                    return;
                }
                window.location.href = '{{ route('cryptoWalletDepositPage', ['coin' => $wallet->coin]) }}?coin_code=' +
                    network;
            }
        @endif
    </script>

    <script>
        function copyToClipboard() {
            const address = document.getElementById('depositAddress');
            address.select();
            address.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(address.value);
        }
    </script>

    <script>
        let top_table = `
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{ __('Type') }}</th>
                        <th>{{ __('Address') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Transition Hash') }}</th>
                        <th>{{ __('Date') }}</th>
                        
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
                    .paginationService("depositTable")
                    .setBeforeResponse(top_table)
                    .setAfterResponse(bottom_table)
                    .setUtility(false)
                    .setResourcesPath('{{ route('depositReportPage') }}?limit=10&coin_id={{ $wallet?->coin_table?->id ?? 0 }}')
                    .setPage({{ isset($page) ? $page : 1 }})
                    .renderAt(".response_data_coin")
                    .exit()

                    .boot();
            });
    </script>
@endsection
