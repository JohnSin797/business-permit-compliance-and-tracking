<template>
    <div class="w-full flex flex-col md:flex-row justify-center items-center gap-2 mb-10">
        <section class="w-72 rounded-lg shadow-xl p-5 bg-slate-900">
            <header class="mb-5 text-gray-200">
                <h1 class="text-xl font-bold">Incomplete Requests</h1>
            </header>
            <div class="flex justify-center items-center gap-3">
                <div class="w-20 h-20 flex justify-center items-center rounded border border-gray-400 bg-gray-200">
                    <v-icon name="fa-minus-circle" class="text-slate-700" scale="1.9" />
                </div>
                <div class="w-20 h-20 flex justify-center items-center rounded border border-gray-200">
                    <p class="text-gray-400 text-2xl font-bold">10</p>
                </div>
            </div>
        </section>
        <section class="w-72 rounded-lg shadow-xl p-5 bg-slate-900">
            <header class="mb-5 text-gray-200">
                <h1 class="text-xl font-bold">Pending Requests</h1>
            </header>
            <div class="flex justify-center items-center gap-3">
                <div class="w-20 h-20 flex justify-center items-center rounded border border-gray-400 bg-gray-200">
                    <v-icon name="md-pendingactions" class="text-slate-700" scale="1.9" />
                </div>
                <div class="w-20 h-20 flex justify-center items-center rounded border border-gray-200">
                    <p class="text-gray-400 text-2xl font-bold">10</p>
                </div>
            </div>
        </section>
        <section class="w-72 rounded-lg shadow-xl p-5 bg-slate-900">
            <header class="mb-5 text-gray-200">
                <h1 class="text-xl font-bold">Rejected Requests</h1>
            </header>
            <div class="flex justify-center items-center gap-3">
                <div class="w-20 h-20 flex justify-center items-center rounded border border-gray-400 bg-gray-200">
                    <v-icon name="fa-trash-alt" class="text-slate-700" scale="1.9" />
                </div>
                <div class="w-20 h-20 flex justify-center items-center rounded border border-gray-200">
                    <p class="text-gray-400 text-2xl font-bold">10</p>
                </div>
            </div>
        </section>
    </div>
</template>