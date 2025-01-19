<dialog id="buyCoinModalId" class="modal">
  <div class="modal-box w-11/12 max-w-5xl glass">
    <h3 class="text-lg text-center font-bold">Purchase Modal</h3>
    <div class="card">
        <div class="w-11/12 mx-auto py-5 sm:w-4/5 p-3">
            <div class="grid w-full mx-auto sm:block">
                <div class="grid grid-cols-2 gap-1 sm:block sm:w-full mr-1  overflow-hidden">

                    <label class="form-control p-1">
                        <div class="label">
                            <span class="label-text">
                                {{ __("Coin") }}
                                <span class="text-error">*</span>
                            </span>
                        </div>
                        <select name="crypto"
                                class="select select-bordered"
                                autocomplete="off" readonly
                                oninput="
                                    document.bind.bindTo('crypto', this.value);
                                    document.bind.bindTo('price', this.value)
                                " 
                        >
                            {!! view("user.components.select_option", [ "items" => $coins, 'seleted_item' => $coin ]) !!}
                        </select>
                    </label>

                    <label class="form-control p-1">
                        <div class="label">
                            <span class="label-text">
                                {{ __("Pay With") }}
                                <span class="text-error">*</span>
                            </span>
                        </div>
                        <select name="currency" 
                                class="select select-bordered"
                                autocomplete="off"
                                onchange="
                                    document.bind.bindTo('payment_method', this.value);
                                    document.bind.bindTo('fiat', this.value);
                                    document.bind.bindTo('price', this.value);
                                "
                        >
                            {!! view("user.components.select_option", [ "items" => $currencies ]) !!}
                        </select>
                    </label>

                    <label class="form-control p-1">
                        <div class="label">
                            <span class="label-text">
                                {{ __("Amount") }}
                                <span class="text-error">*</span>
                            </span>
                        </div>
                        <input autocomplete="off"
                                name="amount"
                                type="number"
                                placeholder="0"
                                step="0.000001"
                                oninput="
                                    document.bind.bindTo('amount', this.value);
                                    document.bind.bindTo('price', this.value);
                                "
                                class="input input-bordered"
                                    />
                    </label>
                    
                    <label class="form-control p-1">
                        <div class="label">
                            <span class="label-text">
                                {{ __("Payment Method") }}
                                <span class="text-error">*</span>
                            </span>
                        </div>
                        <select name="gateway" class="select select-bordered" autocomplete="off"
                                data-bind="select" bind-with="payment_method" data-callback="getPaymentMethod"
                                onchange="document.bind.bindTo('price', '')"
                        >
                            {!! view("user.components.select_option", [ "items" => $gateways ]) !!}
                        </select>
                    </label>
                </div>

                <div class="mt-6 grid grid-cols-1 p-4 mr-1 glass text-xl">
                    <div></div>
                    <div class="space-y-2 ltr:text-right rtl:text-left items-center">
                        <div class="flex items-center ">
                            <div class="flex-1 text-center">
                                1 
                                <span data-bind="text" bind-with="crypto">{{ $selected_crypto }}</span>
                            </div>
                            <div class="w-[37%]">
                                <span data-bind="text" bind-with="price" data-callback="getCoinPrice">{{ $price ?? 0 }}</span> 
                                <span data-bind="text" bind-with="fiat">{{ $selected_fiat }}</span>
                            </div>
                        </div>
                        <div class="flex items-center ">
                            <div class="flex-1 text-center">
                                <span data-bind="text" bind-with="amount">0</span> 
                                <span data-bind="text" bind-with="crypto">{{ $selected_crypto }}</span>
                            </div>
                            <div class="w-[37%] color-red"> 
                                <span data-bind="text" bind-with="net_amount">0</span>
                                <span data-bind="text" bind-with="fiat">{{ $selected_fiat }}</span>
                            </div>
                        </div>
                        <div class="flex items-center  text-lg font-semibold">
                            <div class="flex-1 text-center">{{ __('Fees') }}</div>
                            <div class="w-[37%] text-[red]"> +
                                <span data-bind="text" bind-with="fees">0</span>
                                <span data-bind="text" bind-with="fiat">{{ $selected_fiat }}</span>
                            </div>
                        </div>
                        <div class="flex items-center text-lg font-semibold">
                            <div class="flex-1 text-center text-bold">{{ __('I Will Pay') }}</div>
                            <div class="w-[37%] text-bold">
                                <span data-bind="text" bind-with="total_amount">{{ 0 }}</span> 
                                <span data-bind="text" bind-with="fiat">{{ $selected_fiat }}</span>
                            </div>
                        </div>
                        <div class="flex items-center  text-lg font-semibold">
                            <div class="flex-1 text-center text-bold">{{ __('I Will Get') }}</div>
                            <div class="w-[37%] text-bold"> 
                                <span data-bind="text" bind-with="amount">0</span>
                                <span data-bind="text" bind-with="crypto">{{ $selected_crypto }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="grid grid-cols-2 gap-1 sm:block sm:w-full mr-1  overflow-hidden">
                    <label class="form-control p-1">
                        <button type="submit" class="btn btn-success">{{ __("Purchase") }}</button>
                    </label>
                    <label class="form-control p-1">
                        <button type="button" onclick="document.buyCryptoModal.closeModal()" class="btn btn-error">{{ __("Close") }}</button>
                    </label>
                </div>
            </div>
        </div>
    </div>
  </div>
</dialog>