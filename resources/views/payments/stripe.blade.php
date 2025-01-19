@extends('layout.app')
@section('content')
<div class="max-w-xl mx-auto p-6">
    <!-- Amount Card -->
    <div class="bg-primary rounded-xl p-6 mb-8 text-primary-content">
        <div class="text-sm opacity-80">Amount to Pay</div>
        <div class="text-3xl font-bold">${{ number_format($inputs['amount'] ?? '0.00', 2) }}</div>
    </div>

    <!-- Credit Card Form -->
    <div class="card bg-base-100 shadow-xl">
        <!-- Card Preview -->
        <div class="relative h-56 bg-gradient-to-r from-neutral to-neutral-focus p-6">
            <div class="absolute top-4 right-4 flex gap-2">
                <img loading="lazy" src="{{ asset('assets/images/visa.png') }}" class="h-6" alt="visa">
                <img loading="lazy" src="{{ asset('assets/images/mastercard.png') }}" class="h-6" alt="mastercard">
            </div>
            <div class="h-full flex flex-col justify-between text-neutral-content">
                <div class="flex items-center gap-2">
                    <div class="w-12 h-8 bg-accent rounded-md"></div>
                    <div class="w-6 h-8 bg-accent rounded-md opacity-50"></div>
                </div>
                <div id="preview-number" class="text-2xl tracking-widest">•••• •••• •••• ••••</div>
                <div class="flex justify-between items-end">
                    <div>
                        <div class="text-xs opacity-75">Card Holder</div>
                        <div id="preview-name" class="font-medium">FULL NAME</div>
                    </div>
                    <div>
                        <div class="text-xs opacity-75">Expires</div>
                        <div id="preview-expiry" class="font-medium">MM/YY</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Fields -->
        <form id="payment-form" class="card-body space-y-4">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Card Number</span>
                </label>
                <input type="text" name="card_number" class="input input-bordered" maxlength="19" placeholder="4242 4242 4242 4242">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Expiry Date</span>
                    </label>
                    <input type="text" name="card_expiry" class="input input-bordered" placeholder="MM/YY" maxlength="5">
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">CVC Code</span>
                    </label>
                    <input type="text" name="card_cvc" class="input input-bordered" placeholder="123" maxlength="3">
                </div>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Card Holder Name</span>
                </label>
                <input type="text" name="card_holder" class="input input-bordered" placeholder="John Doe">
            </div>

            <div id="payment-error" class="alert alert-error hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span></span>
            </div>

            <button type="submit" class="btn btn-primary w-full" id="submit-button">
                <span>Pay Now</span>
                <span class="loading loading-spinner loading-sm hidden"></span>
            </button>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Live card preview updates
    const cardNumber = document.querySelector('[name="card_number"]');
    const cardExpiry = document.querySelector('[name="card_expiry"]');
    const cardHolder = document.querySelector('[name="card_holder"]');

    cardNumber.addEventListener('input', (e) => {
        let value = e.target.value.replace(/\s/g, '');
        value = value.replace(/(\d{4})/g, '$1 ').trim();
        e.target.value = value;
        document.getElementById('preview-number').textContent = value || '•••• •••• •••• ••••';
    });

    cardExpiry.addEventListener('input', (e) => {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.slice(0,2) + '/' + value.slice(2);
        }
        e.target.value = value;
        document.getElementById('preview-expiry').textContent = value || 'MM/YY';
    });

    cardHolder.addEventListener('input', (e) => {
        document.getElementById('preview-name').textContent = e.target.value.toUpperCase() || 'FULL NAME';
    });

    // Stripe payment handling
    // const stripe = Stripe('{{ config("services.stripe.key") }}');
    // const form = document.getElementById('payment-form');
    // const submitButton = document.getElementById('submit-button');
    // const spinner = submitButton.querySelector('svg');
    // const buttonText = submitButton.querySelector('span');
    // const errorDisplay = document.getElementById('payment-error');

    // form.addEventListener('submit', async (e) => {
    //     e.preventDefault();
    //     submitButton.disabled = true;
    //     spinner.classList.remove('hidden');
    //     buttonText.textContent = 'Processing...';
    //     errorDisplay.classList.add('hidden');

    //     try {
    //         const { paymentMethod, error } = await stripe.createPaymentMethod({
    //             type: 'card',
    //             card: {
    //                 number: cardNumber.value.replace(/\s/g, ''),
    //                 exp_month: cardExpiry.value.split('/')[0],
    //                 exp_year: cardExpiry.value.split('/')[1],
    //                 cvc: form.querySelector('[name="card_cvc"]').value,
    //             },
    //             billing_details: {
    //                 name: cardHolder.value,
    //             }
    //         });

    //         if (error) throw error;

    //         const response = await fetch('{{ route("coinBuyProcess") }}', {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json',
    //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //             },
    //             body: JSON.stringify({
    //                 payment_method_id: paymentMethod.id,
    //                 amount: '{{ $inputs["amount"] }}'
    //             })
    //         });

    //         const result = await response.json();
    //         if (result.success) {
    //             window.location.href = result.redirect_url;
    //         }

    //     } catch (error) {
    //         errorDisplay.textContent = error.message;
    //         errorDisplay.classList.remove('hidden');
    //         submitButton.disabled = false;
    //         spinner.classList.add('hidden');
    //         buttonText.textContent = 'Pay Now';
    //     }
    // });
});
</script>
@endsection
