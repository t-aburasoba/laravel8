<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('あなたの投稿が腹痛民を救います。') }}
        </h1>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-5">
            {{ __('Toileatter（トイレアッター）は駅構内のトイレを評価しシェアするアプリです。') }}
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <livewire:students />
            </div>
        </div>
    </div>
</x-app-layout>
