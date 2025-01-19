@extends('layout.app')

@section('title', __('Buy Crypto'))

@section('content')

    <div class="card w-full bg-base-100 shadow-xl glass">
        <div class="card-body">
            <h2 class="card-title">{{ __('Buy Crypto') }}</h2>
            <div class="divider"></div>

            <div class="lg:w-full w-3/5 mx-auto rounded shadow1 glass">
                <div class="grid sm:block p-3">
                    <form class="wizard mt-5" method="POST">
                        <aside class="wizard-content container" style="padding: 0;">
                            <div class="wizard-step">
                                @csrf
                                <div class="grid grid-cols-1 gap-1 sm:block sm:w-full mr-1  overflow-hidden">

                                    <label class="form-control p-1 bg-base-500">
                                        <div class="label">
                                            <span class="label-text">{{ __('Coin') }}</span>
                                        </div>
                                        <select name="provider" class="select select-bordered bg-base-500">
                                            <option value="1">A</option>
                                            <option value="2">B</option>
                                            <option value="3">V</option>
                                            <option value="4">l</option>
                                            <option value="5">x</option>
                                            <option value="6">c</option>
                                            <option value="7">z</option>
                                        </select>
                                    </label>

                                    <label class="form-control p-1">
                                        <div class="label">
                                            <span class="label-text">{{ __('Amount') }}</span>
                                        </div>
                                        <input name="code" type="number" value="{{ $item->code ?? old('code') }}"
                                            placeholder="0" step="0.00000001" class="input input-bordered" required />
                                    </label>

                                    <label class="form-control  p-1">
                                        <input type="submit" value="Pay With Paypal"
                                            class="input input-bordered bg-[blue] " />
                                    </label>
                                    <label class="form-control p-1">
                                        <input type="submit" value="Pay With Strip"
                                            class="input input-bordered bg-primary" />
                                    </label>
                                </div>
                            </div>
                            <div class="wizard-step">
                                stem 2
                            </div>
                        </aside>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('downjs')
    <script>
        let args = {
            "nav": false,
            "buttons": true,
            "finish": "Save!",

            "wz_class": ".wizard",
            "wz_buttons": ".join",
            "wz_button": ".a",
            "wz_button_style": ".join-item .btn .btn-primary",
            "wz_ori": "horizontal",
        };

        const wizard = new Wizard(args);
        wizard.init();

        let wz_class = ".wizard";
        let $wz_doc = document.querySelector(wz_class)

        $wz_doc.addEventListener("wz.form.submit", function(e) {
            console.log("submit", e);
            alert("Form Submit");
            let form = e.target.submit();
        });
    </script>
@endsection
