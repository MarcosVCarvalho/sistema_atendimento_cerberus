<script setup>

import { router, Link } from '@inertiajs/vue3'
import AppLayout from '/resources/js/Layouts/AppLayout.vue'

const props = defineProps({
    atendimento: {
        type: Object,
        required: true,
    },
})

const voltar = () => {
    router.visit('/atendimentos')
}

const formatarDataHora = (data) => {

    if (!data) {
        return '-'
    }

    const dataObj = new Date(data)

    return dataObj.toLocaleString('pt-BR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    })
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
                        Gestão de atendimentos
                    </p>

                    <h1 class="mt-1 text-3xl font-bold text-slate-900">
                        Atendimento #{{ atendimento.id }}
                    </h1>

                    <p class="mt-2 text-slate-500">
                        Visualização dos dados do atendimento.
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


            <!-- Card principal -->

            <div
                class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden"
            >

                <!-- Cabeçalho do atendimento -->

                <div
                    class="p-6 border-b border-slate-200 bg-slate-50"
                >

                    <div class="flex items-center gap-4">

                        <!-- Avatar -->

                        <div
                            class="w-14 h-14 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-bold shrink-0"
                        >
                            {{
                                atendimento.paciente?.nome
                                    ?.charAt(0)
                                    ?.toUpperCase()
                            }}
                        </div>

                        <div>

                            <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">
                                Paciente
                            </p>

                            <h2 class="text-xl font-bold text-slate-800">
                                {{ atendimento.paciente?.nome ?? 'Paciente não informado' }}
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                Atendimento #{{ atendimento.id }}
                            </p>

                        </div>

                    </div>

                </div>


                <!-- Informações -->
                <div class="p-6">

                    <!-- Cabeçalho do atendimento -->
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                        <div class="min-w-0">

                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Paciente
                            </p>

                            <h2 class="mt-1 text-xl font-bold text-slate-800">
                                {{ atendimento.paciente?.nome ?? 'Não informado' }}
                            </h2>

                            <p class="mt-1 text-sm text-slate-500">
                                CPF:
                                <span class="font-medium text-slate-700">
                                    {{ atendimento.paciente?.cpf ?? 'Não informado' }}
                                </span>
                            </p>

                        </div>


                        <!-- Tipo + data -->
                        <div class="flex flex-col items-start gap-2 sm:items-end">

                            <span
                                class="inline-flex items-center rounded-lg bg-indigo-50 px-3 py-1.5 text-sm font-semibold text-indigo-700"
                            >
                                {{ atendimento.tipo_atendimento?.nome ?? 'Não informado' }}
                            </span>

                            <p class="text-sm font-medium text-slate-500">
                                {{ formatarDataHora(atendimento.data_hora) }}
                            </p>

                        </div>

                    </div>


                    <!-- Separador -->
                    <div class="my-6 border-t border-slate-200"></div>

                    <!-- Endereço -->
                    <div class="mt-5 rounded-xl border border-slate-200 bg-slate-50 p-4">

                        <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Endereço
                        </p>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                            <!-- Rua -->
                            <div>
                                <p class="text-xs font-medium text-slate-400">
                                    Rua
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-700">
                                    {{ atendimento.paciente?.rua ?? 'Não informado' }}
                                </p>
                            </div>


                            <!-- Bairro -->
                            <div>
                                <p class="text-xs font-medium text-slate-400">
                                    Bairro
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-700">
                                    {{ atendimento.paciente?.bairro ?? 'Não informado' }}
                                </p>
                            </div>


                            <!-- Cidade -->
                            <div>
                                <p class="text-xs font-medium text-slate-400">
                                    Cidade
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-700">
                                    {{ atendimento.paciente?.cidade ?? 'Não informado' }}
                                </p>
                            </div>

                        </div>

                    </div>

                    <!-- Separador -->
                    <div class="my-6 border-t border-slate-200"></div>


                    <!-- Contatos -->
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                        <!-- Telefone -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Telefone
                            </p>

                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ atendimento.paciente?.telefone ?? 'Não informado' }}
                            </p>

                        </div>


                        <!-- WhatsApp -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                WhatsApp
                            </p>

                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ atendimento.paciente?.whatsapp ?? 'Não informado' }}
                            </p>

                        </div>


                        <!-- Responsável -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Responsável
                            </p>

                            <p
                                v-if="atendimento.usuario"
                                class="mt-1 text-sm font-semibold text-slate-700"
                            >
                                {{ atendimento.usuario.name }}
                            </p>

                            <p
                                v-else
                                class="mt-1 text-sm italic text-slate-400"
                            >
                                Não informado
                            </p>

                        </div>

                    </div>


                    <!-- Observações -->
                    <div class="mt-6">

                        <div class="mb-2 flex items-center justify-between">

                            <p class="text-sm font-semibold text-slate-700">
                                Observações
                            </p>

                        </div>

                        <div class="rounded-xl border border-slate-200 bg-white p-4">

                            <p
                                v-if="atendimento.observacoes"
                                class="whitespace-pre-line text-sm leading-6 text-slate-600"
                            >
                                {{ atendimento.observacoes }}
                            </p>

                            <p
                                v-else
                                class="text-sm italic text-slate-400"
                            >
                                Nenhuma observação registrada.
                            </p>

                        </div>

                    </div>


                    <!-- Encaminhamentos -->
                    <div class="mt-5">

                        <p class="mb-2 text-sm font-semibold text-slate-700">
                            Encaminhamentos
                        </p>

                        <div class="rounded-xl border border-slate-200 bg-white p-4">

                            <p
                                v-if="atendimento.encaminhamentos"
                                class="whitespace-pre-line text-sm leading-6 text-slate-600"
                            >
                                {{ atendimento.encaminhamentos }}
                            </p>

                            <p
                                v-else
                                class="text-sm italic text-slate-400"
                            >
                                Nenhum encaminhamento registrado.
                            </p>

                        </div>

                    </div>


                    <!-- Ações -->
                    <div
                        class="mt-6 flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end"
                    >

                        <button
                            type="button"
                            @click="voltar"
                            class="btn btn-ghost"
                        >
                            Voltar
                        </button>

                        <Link
                            :href="`/atendimentos/${atendimento.id}/edit`"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-indigo-700 hover:shadow-md active:scale-95"
                        >
                            Editar atendimento
                        </Link>

                    </div>

                </div>

            </div>

        </div>

    </div>

</AppLayout>
```

</template>
