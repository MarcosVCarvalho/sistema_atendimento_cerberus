<script setup>

import { router } from '@inertiajs/vue3'
import AppLayout from '/resources/js/Layouts/AppLayout.vue'

const props = defineProps({
    tipo: Object,
})

const voltar = () => {
    router.visit('/tipos-atendimento')
}

const editar = () => {
    router.visit(`/tipos-atendimento/${props.tipo.id}/edit`)
}

</script>

<template>


<AppLayout>

    <div class="min-h-screen bg-slate-50 p-6">

        <div class="max-w-4xl mx-auto">

            <!-- Cabeçalho -->

            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6"
            >

                <div>

                    <p class="text-sm font-medium text-indigo-600">
                        Gestão de tipos de atendimentos
                    </p>

                    <h1 class="mt-1 text-3xl font-bold text-slate-900">
                        Tipo de Atendimento #{{ tipo.id }}
                    </h1>

                    <p class="text-slate-500 mt-1">
                        Visualização dos dados do tipo de atendimento
                    </p>

                </div>

                <button
                    type="button"
                    @click="voltar"
                    class="btn btn-outline"
                >
                    ← Voltar
                </button>

            </div>


            <!-- Card -->

            <div
                class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden"
            >

                <!-- Cabeçalho do card -->

                <div
                    class="px-6 py-5 border-b border-slate-200 bg-slate-50"
                >

                    <div class="flex items-center gap-4">

                        <!-- Inicial -->

                        <div
                            class="w-14 h-14 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-bold shrink-0"
                        >
                            {{ tipo.nome.charAt(0).toUpperCase() }}
                        </div>

                        <div>

                            <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">
                                Tipo de atendimento
                            </p>

                            <h2 class="text-xl font-bold text-slate-800">
                                {{ tipo.nome }}
                            </h2>

                        </div>

                    </div>

                </div>


                <!-- Informações -->

                <div class="p-6">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                        <!-- ID -->

                        <div>

                            <p class="text-sm font-medium text-slate-500 mb-1">
                                ID
                            </p>

                            <p class="text-base font-semibold text-slate-800">
                                #{{ tipo.id }}
                            </p>

                        </div>


                        <!-- Nome -->

                        <div>

                            <p class="text-sm font-medium text-slate-500 mb-1">
                                Nome
                            </p>

                            <p class="text-base font-semibold text-slate-800">
                                {{ tipo.nome }}
                            </p>

                        </div>

                        <div>

                            <p class="text-sm font-medium text-slate-500 mb-1">
                                Descrição
                            </p>

                            <p class="text-base font-semibold text-slate-800">
                                {{ tipo.descricao }}
                            </p>

                        </div>

                    </div>


                    <!-- Ações -->

                    <div
                        class="flex justify-end gap-3 mt-8 pt-6 border-t border-slate-200"
                    >

                        <button
                            type="button"
                            @click="voltar"
                            class="btn btn-ghost"
                        >
                            Voltar
                        </button>

                        <button
                            type="button"
                            @click="editar"
                            class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-indigo-700 hover:shadow-md active:scale-95"
                        >
                            Editar
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</AppLayout>
```

</template>
