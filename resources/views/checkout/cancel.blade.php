<x-layouts::shop>
    <div class="rounded-xl border border-gray-200 bg-white p-10 text-center shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Checkout cancelado</h1>
        <p class="mt-2 text-gray-600 dark:text-neutral-400">
            Nenhuma cobrança foi feita. Você pode voltar e tentar novamente quando quiser.
        </p>
        <a href="{{ route('home') }}" class="mt-6 inline-block rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-700">
            Voltar para a loja
        </a>
    </div>
</x-layouts::shop>
