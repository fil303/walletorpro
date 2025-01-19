@extends('layout.app', [ "menu" => "staking" ])

@section('title', __('My Staking'))

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex flex-wrap justify-between items-center mt-2">
                <div>
                    <h2 class="card-title">{{ __('My Staking') }}</h2>
                </div>
                <div class="flex justify-between">
                    <div class="mr-2">
                        <a href="{{ route('userStakePage') }}" class="btn btn-primary">{{ __('Start Staking') }}</a>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="grid grid-cols-3  gap-1 w-10/12 mx-auto">

                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">{{ __('Coin') }}</span>
                            </div>
                            <select name="coin" class="select select-bordered" autocomplete="off"
                                onchange="document.stakeTable.setFilter('coin', this.value)" bind-with="filter" data-bind="select">
                                <option value="">{{ __('All') }}</option>
                                {!! view('admin.components.select_option', ['items' => $coins]) !!}
                            </select>
                        </label>
                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">{{ __('Search') }}</span>
                            </div>
                            <input type="text" class="input input-bordered" autocomplete="off"
                                oninput="document.stakeTable.setFilter('search', this.value)" bind-with="filter"
                                data-bind="input" />
                        </label>
                        <label class="form-control p-1 w-3/6">
                            <div class="label">
                                <span class="label-text">&nbsp;</span>
                            </div>
                            <div class="flex gap-2 ">
                                <button title="{{ __('Search') }}" type="button" class="btn btn-primary"
                                    onclick="document.stakeTable.renderPage()">
                                    <span class="text-2xl icon-[line-md--search-twotone]"></span>
                                </button>
                                <button title="{{ __('Reset') }}" type="button" class="btn btn-error"
                                    onclick="
                                document.stakeTable.filter = {}; 
                                document.stakeTable.renderPage(); 
                                document.bind.flush('filter');
                            ">
                                    <img src="{{ asset_bind('assets/lucide/rotate.svg') }}" />
                                </button>
                            </div>
                        </label>

                    </div>
                </div>
            </div>

            <div class="response_data_coin">
                <div class="text-center">{{ __('No Data Available') }}</div>
            </div>
        </div>
    </div>

@endsection
@section('downjs')
    <script>
        let top_table = `
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                <tr>
                    <th>{{ __('Coin') }}</th>
                    <th>{{ __('Amount') }}</th>
                    <th>{{ __('Interest | Percent') }}</th>
                    <th>{{ __('Total Return') }}</th>
                    <th>{{ __('Start Date') }}</th>
                    <th>{{ __('End Date') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Auto Staking') }}</th>
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
                .paginationService("stakeTable")
                .setBeforeResponse(top_table)
                .setAfterResponse(bottom_table)
                .setUtility(false)
                .setResourcesPath('{{ route('stakingHistoryPage') }}')
                .setPage({{ isset($page) ? $page : 1 }})
                .renderAt(".response_data_coin")
                .exit()

                .boot();
        });

        function updateAutoStakingStatus($id) {
             $.post(
                '{{ route('stopAutoStake') }}', {
                    _token: '{{ csrf_token() }}',
                    id: $id
                },
                (response) => {
                    if (response.status) {
                        Notiflix.Notify.success(response.message || '{{ __("Success") }}');
                    } else {
                        Notiflix.Notify.failure(response.message || '{{ __("Failed") }}');
                    }
                }
            )
        }
    </script>
@endsection
