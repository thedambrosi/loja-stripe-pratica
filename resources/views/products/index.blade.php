<x-layouts::shop>
    <h1 class="mb-8 text-2xl font-bold text-gray-900 dark:text-white">Produtos</h1>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($products as $product)
            <div class="flex flex-col rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $product->name }}</h2>

                @if ($product->description)
                    <p class="mt-2 flex-1 text-sm text-gray-600 dark:text-neutral-400">{{ $product->description }}</p>
                @endif

                <p class="mt-4 text-xl font-bold text-indigo-600">
                    R$ {{ number_format($product->price_cents / 100, 2, ',', '.') }}
                </p>

                <form method="POST" action="{{ route('checkout.store', $product) }}" class="mt-4 flex flex-col gap-2">
                    @csrf

                    <input
                        type="email"
                        name="customer_email"
                        placeholder="seu@email.com"
                        required
                        class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-600 focus:outline-none dark:border-neutral-700 dark:bg-neutral-800 dark:text-white"
                    >

                    <button
                        type="submit"
                        class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-700"
                    >
                        Comprar
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</x-layouts::shop>
