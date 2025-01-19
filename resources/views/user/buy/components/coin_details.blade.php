
    <tr class="hover:bg-base-200/50">
        <td class="flex items-center gap-3">
            <img class="w-12 h-12" src="{{ $coin->getIcon() ?? '' }}"
                alt="{{ $coin->name }}" loading="lazy" >
            <div>
                <div class="font-bold">{{ $coin->name }}</div>
                <div class="badge badge-ghost">{{ $coin->coin }}</div>
            </div>
        </td>
        <td>
            <div class="text-xl font-bold">${{ $coin->coin_price }}</div>
        </td>
        <td>
            <div class="text-xl font-bold {{ ($coin->change_24h ?? 0) < 0 ? 'text-error' : 'text-success' }}">
                {{ number_format($coin->change_24h ?? 0, "2") }}%
            </div>
        </td>
        <td class="hidden lg:table-cell">
            <div class="text-xl font-bold">
                ${{ numberShortFormat($coin->volume ?? 0) }}
            </div>
        </td>
        <td>
            <button onclick="document.buyCryptoModal.getModal('{{ route('buyCoinModal', $coin->coin) }}')"
                class="btn btn-primary btn-md">
                {{ _t("Purchase")}}
            </button>
        </td>
    </tr>
