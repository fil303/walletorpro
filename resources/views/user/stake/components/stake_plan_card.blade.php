  <div class="card bg-base-200 shadow-lg rounded-lg p-6 hover:shadow-2xl transition-shadow duration-300">
    <div class="flex justify-between items-center mb-4">
      <div class="flex items-center space-x-3">
        <img src=" {{ $plan->plan_coin?->getIcon() }}" alt="Coin Icon" class="w-10 h-10 rounded-full" loading="lazy" />
        <div>
          <h3 class="text-xl font-semibold">{{ $plan->plan_coin?->name }}</h3>
          <p class="text-sm text-gray-500">{{ $plan->coin }}</p>
        </div>
      </div>
    </div>

    <div class="border-t border-gray-200 py-4">
      <p><span class="font-semibold">{{__("Minimum")}}:</span> {{ $plan->min }} {{ $plan->coin }}</p>
      <p><span class="font-semibold">{{__("Maximum")}}:</span> {{ $plan->max }} {{ $plan->coin }}</p>
    </div>

    <div class="mt-4">
      <h4 class="font-semibold mb-2">{{__("Staking Durations")}}</h4>
      <ul class="space-y-2">
        @foreach ($plan->segments ?? [] as $segment)
            <li class="flex justify-between items-center bg-base-50 border-r-2 border-b-2 border-primary p-3 rounded-lg">
            <span class="font-medium ">{{ $segment->duration }} {{__("Days")}}</span>
            <span class="text-green-600 font-bold">{{ $segment->interest }}% {{__("Interest")}}</span>
            </li>
        @endforeach
      </ul>
    </div>

    <div class="card-actions mt-4">
      <button class="btn btn-sm btn-outline btn-info"
        data-stake-id="{{ $plan->id }}"
        data-stake-coin="{{ $plan->coin }}"
        data-stake-min="{{ $plan->min }}"
        data-stake-max="{{ $plan->max }}"
        data-stake-duration="{{ $plan->duration }}"
        data-stake-interest="{{ $plan->interest }}"
        onclick="openStakePlanHandler({{ $plan->id }})"
        >{{__("Start Staking")}}</button>
    </div>
  </div>