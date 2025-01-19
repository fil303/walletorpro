
        <div class="grid grid-cols-2 gap-1 sm:block sm:w-full mr-1  overflow-hidden">
            
            <label class="form-control p-1">
                <div class="label">
                    <span class="label-text">{{ __("Duration") }}</span>
                </div>
                <input name="duration[]" value="{{ $item->duration ?? '' }}" type="text" class="input input-bordered" />
            </label>
            
            <label class="form-control p-1">
                <div class="label">
                    <span class="label-text">{{ __("Interest") }} ( % )</span>
                </div>
                <input name="interest[]" value="{{ $item->interest ?? '' }}" type="text" class="input input-bordered" />
            </label>
        </div>
    </div>
</div>