@extends('layout.app', [ 'open_staking_menu' => true, 'menu' => 'staking' ])

@section('title', __('Create Stake Plan'))

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex justify-between">
                <h2 class="card-title">{{ __('Create Stake Plan') }}</h2>
                <a href="{{ route('stakePage') }}" class="btn">
                    <svg class="lucide lucide-undo-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M9 14 4 9l5-5" />
                        <path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11" />
                    </svg>
                    {{ __("Button") }}
                </a>
            </div>
            <form action="{{ route(isset($item) ? 'updateStakePlan' : 'saveStakePlan') }}" method="post">@csrf
                @if (isset($item) && isset($item->id))
                    <input type="hidden" name="id" value="{{ $item->id }}">
                @endif
                <div class="space-y-4">
                    <div class="flex items-center space-x-4 duration-input-group">
                        <div class="flex-1">
                            <label class="label font-semibold">
                                <span>
                                    {{  __('Coin') }}
                                    <span class="text-error">*</span>
                                </span>
                            </label>
                            <select name="coin" class="select select-bordered w-full" id="coinSelect">
                                <option disabled value="" selected>Select a coin for staking</option>
                                {!! view('admin.components.select_option', [
                                    'items' => $coins,
                                    'seleted_item' => $item?->plan_coin?->uid ?? 0,
                                ]) !!}
                            </select>
                        </div>
                        <div class="flex-1">
                            <label class="label font-semibold">
                                <span>
                                    {{  __('Plan Status') }}
                                    <span class="text-error">*</span>
                                </span>
                            </label>
                            <select name="status" class="select select-bordered w-full" id="coinSelect">
                                <option disabled value="" selected>Select Plan Status</option>
                                {!! App\Enums\Status::renderOption($item->status ?? 0) !!}
                            </select>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center space-x-4 duration-input-group">
                        <div class="flex-1">
                            <label class="label font-semibold">
                                <span>
                                    {{  __('Minimum Amount') }}
                                    <span class="text-error">*</span>
                                </span>
                            </label>
                            <input name="min" value="{{ $item->min ?? '' }}" type="number" step="any"
                                class="input input-bordered w-full" />
                        </div>
                        <div class="flex-1">
                            <label class="label font-semibold">
                                <span>
                                    {{  __('Maximum Amount') }}
                                    <span class="text-error">*</span>
                                </span>
                            </label>
                            <input name="max" value="{{ $item->max ?? '' }}" type="number" step="any"
                                class="input input-bordered w-full" />
                        </div>
                    </div>
                </div>

                <div id="durationContainer" class="space-y-4">
                    @if (isset($item) && isset($item->segments))
                        @foreach ($item->segments ?? [] as $segment)
                            <div class="flex items-center space-x-4 duration-input-group">
                                <div class="flex-1">
                                    @if ($loop->first)
                                        <label class="label font-semibold">
                                            <span>
                                                {{  __('Staking Duration') }}
                                                ({{__("Days")}})
                                                <span class="text-error">*</span>
                                            </span>
                                        </label>
                                    @endif
                                    <input name="duration[]" value="{{ $segment->duration }}" type="number"
                                        placeholder="Enter duration in days" class="input input-bordered w-full" />
                                </div>
                                <div class="flex-1">
                                    @if ($loop->first)
                                        <label class="label font-semibold">
                                            <span>
                                                {{  __('Interest Rate') }}
                                                (%)
                                                <span class="text-error">*</span>
                                            </span>
                                        </label>
                                    @endif
                                    <input name="interest[]" value="{{ $segment->interest }}" type="number" step="any"
                                        placeholder="Enter interest rate" class="input input-bordered w-full" />
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="flex items-center space-x-4 duration-input-group">
                            <div class="flex-1">
                                <label class="label font-semibold">
                                    <span>
                                        {{  __('Staking Duration') }}
                                        ({{__("Days")}})
                                        <span class="text-error">*</span>
                                    </span>
                                </label>
                                <input name="duration[]" type="number" placeholder="Enter duration in days"
                                    class="input input-bordered w-full" />
                            </div>
                            <div class="flex-1">
                                <label class="label font-semibold">
                                    <span>
                                        {{  __('Interest Rate') }}
                                        (%)
                                        <span class="text-error">*</span>
                                    </span>
                                </label>
                                <input name="interest[]" type="number" step="any" placeholder="Enter interest rate"
                                    class="input input-bordered w-full" />
                            </div>
                        </div>
                    @endif
                </div>

                <button onclick="addDuration()" class="btn btn-outline btn-primary w-full mt-4">Add Another
                    Duration</button>

                <div class="grid sm:block mt-2">
                    <div class="grid grid-cols-2 gap-1 sm:block sm:w-full mr-1  overflow-hidden">
                        {{-- form button --}}
                        <label class="form-control p-1">
                            <button class="btn btn-primary w-full">{{ isset($item) ? __('Update') : __('Create') }}</button>
                        </label>
                        <label class="form-control p-1">
                            <a href="{{ route('stakePage') }}"
                                class="btn btn-error w-full">{{ __('Back To Stake Plan List') }}</a>
                        </label>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('downjs')
    <script>
        function addDuration() {
            const durationContainer = document.getElementById('durationContainer');

            // Create new duration input group
            const newDurationGroup = document.createElement('div');
            newDurationGroup.className = 'flex items-center space-x-4 duration-input-group mt-4';

            // Duration input
            const durationInput = document.createElement('input');
            durationInput.type = 'number';
            durationInput.setAttribute('name', 'duration[]');
            durationInput.placeholder = 'Enter duration in days';
            durationInput.className = 'input input-bordered w-full';
            durationInput.required = true;

            // Interest input
            const interestInput = document.createElement('input');
            interestInput.type = 'number';
            interestInput.setAttribute('name', 'interest[]');
            interestInput.setAttribute('step', 'any');
            interestInput.placeholder = 'Enter interest rate';
            interestInput.className = 'input input-bordered w-full';
            interestInput.required = true;

            // Append inputs to the new group and then to container
            newDurationGroup.appendChild(durationInput);
            newDurationGroup.appendChild(interestInput);
            durationContainer.appendChild(newDurationGroup);
        }
    </script>
@endsection
