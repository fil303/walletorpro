@if(isset($segments))
    <label for="detailsModal{{ $plan->id }}" class="btn btn-sm btn-outline btn-primary" onclick="setModalData(\''.$plan->coin.'\',\''.json_encode($plan->segments).'\' )">
        {{__("View Details")}}
    </label>

    <input type="checkbox" id="detailsModal{{ $plan->id }}" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
        <h3 class="font-bold text-lg mb-4" id="modalCoinTitle">{{__("Staking Plan Details")}}</h3>

        <div class="space-y-2">
            @foreach ($segments as $segment)
                <div class="flex justify-between items-center p-2 border-b">
                    <span>{{__("Duration")}}: {{ $segment->duration . ' ' . __('Days')}}</span><span>{{__("Interest")}}: {{ $segment->interest . ' ' . '%' }}</span>
                </div>
            @endforeach
        </div>

        <div class="modal-action">
            <label for="detailsModal{{ $plan->id }}" class="btn">{{__("Close")}}</label>
        </div>
        </div>
    </div>
@endif
