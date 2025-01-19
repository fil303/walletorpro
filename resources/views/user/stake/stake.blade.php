@extends('layout.app', [ "menu" => "staking" ])

@section('title', __('Staking Plans'))

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">

            <div class="flex flex-wrap justify-between items-center mt-2">
                <div>
                    <h2 class="card-title">{{ __('Staking Plans') }}</h2>
                </div>
                <div class="flex justify-between">
                    <div class="mr-2">
                        <a href="{{ route('stakingHistoryPage') }}" class="btn btn-primary">{{ __('My Staking') }}</a>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="grid grid-cols-4 sm:grid-cols-2 gap-1 w-10/12 mx-auto">

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
                                <span class="label-text">{{ __('Minimum') }}</span>
                            </div>
                            <input type="text" class="input input-bordered" autocomplete="off"
                                oninput="document.stakeTable.setFilter('min', this.value)" bind-with="filter" data-bind="input" />
                        </label>
                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">{{ __('Duration') }}</span>
                            </div>
                            <input type="text" class="input input-bordered" autocomplete="off"
                                oninput="document.stakeTable.setFilter('duration', this.value)" bind-with="filter"
                                data-bind="input" />
                        </label>
                        <label class="form-control p-1 w-3/6">
                            <div class="label">
                                <span class="label-text">&nbsp;</span>
                            </div>
                            <div class="flex justify-between">
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

    <dialog id="openStakePlan" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-5 top-5">✕</button>
            </form>
            <h3 class="font-bold text-lg">{{ __('Stake') }}</h3>
            <div class="divider"></div>
            <form action="{{ route('userSubmitStake') }}" method="post" id="stakeForm">
                @csrf
                <div id="render_stake_details"></div>
            </form>

            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-sm btn-primary"
                        onclick="document.getElementById('stakeForm').submit()">{{ __('Stake') }}</button>
                    <button class="btn btn-sm btn-ghost">{{ __('Close') }}</button>
                </form>
            </div>
        </div>
    </dialog>

@endsection
@section('downjs')
    <script>
        let top_table =
            '<div class="container mx-auto p-6 grid grid-cols-4 lg:grid-cols-2  md:grid-cols-2 sm:!grid-cols-1 gap-6">';
        let bottom_table = '</div>';

        document.addEventListener("DOMContentLoaded", () => {
            let service = document.siteProviderService
                // Pagination Response
                .newInstance()
                .paginationService("stakeTable")
                .setBeforeResponse(top_table)
                .setAfterResponse(bottom_table)
                .setUtility(false)
                .setResourcesPath('{{ route('userStakePage') }}')
                .setPage({{ isset($page) ? $page : 1 }})
                .renderAt(".response_data_coin")
                .exit()

                .boot();
        });

        async function openStakePlanHandler(id) {
            spinner();
            await $.post(
                '{{ route('userOpenStake') }}', {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                function(response) {
                    if (response.status) {
                        document.getElementById('render_stake_details').innerHTML = response.data.html || '';
                        openStakePlan.showModal();
                    } else {
                        Notiflix.Notify.failure(response.message || 'Something went wrong');
                    }
                }
            );
            spinner(false);
        }
    </script>
@endsection
