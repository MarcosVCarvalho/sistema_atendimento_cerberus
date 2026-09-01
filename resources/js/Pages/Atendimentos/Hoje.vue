<script setup>

import { router, Link } from '@inertiajs/vue3'
import AppLayout from '/resources/js/Layout/AppLayout.vue'

const props = defineProps({
    data: {
        type: String,
        default: '',
    },

    total: {
        type: Number,
        default: 0,
    },

    atendimentos: {
        type: Array,
        default: () => [],
    },
})

const voltar = () => {
    router.visit('/atendimentos')
}

const formatarHora = (data) => {

    if (!data) {
        return '-'
    }

    const dataObj = new Date(data)

    return dataObj.toLocaleTimeString('pt-BR', {
        hour: '2-digit',
        minute: '2-digit',
    })
}

</script>

<template>


<AppLayout>

    <div class="min-h-screen bg-slate-50 p-6">

        <div class="max-w-6xl mx-auto">

            <!-- Cabeçalho -->

            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6"
            >

                <div>

                    <p class="text-sm font-medium text-indigo-600">
                        Agenda
                    </p>

                    <h1 class="mt-1 text-3xl font-bold text-slate-900">
                        Atendimentos de hoje
                    </h1>

                    <p class="mt-2 text-slate-500">
                        Atendimentos registrados em {{ data }}.
                    </p>

                </div>

                <div class="flex gap-3">

                    <button
                        type="button"
                        @click="voltar"
                        class="btn btn-outline"
                    >
                        ← Todos os atendimentos
                    </button>

                    <Link
                        href="/atendimentos/create"
                        class="btn btn-primary"
                    >
                        + Novo atendimento
                    </Link>

                </div>

            </div>


            <!-- Resumo -->

            <div
                class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
            >

                <div class="flex items-center gap-4">

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 font-bold"
                    >
                        {{ total }}
                    </div>

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Total de atendimentos
                        </p>

                        <p class="text-lg font-bold text-slate-800">
                            {{ total }}
                            {{ total === 1 ? 'atendimento' : 'atendimentos' }}
                            hoje
                        </p>

                    </div>

                </div>

            </div>


            <!-- Lista -->

            <div
                class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden"
            >

                <!-- Cabeçalho da tabela -->

                <div
                    class="border-b border-slate-200 px-6 py-5"
                >

                    <h2 class="font-semibold text-slate-900">
                        Agenda do dia
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Atendimentos organizados por horário.
                    </p>

                </div>


                <!-- Nenhum atendimento -->

                <div
                    v-if="atendimentos.length === 0"
                    class="p-12 text-center"
                >

                    <div
                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-2xl"
                    >
                        ✓
                    </div>

                    <h3 class="mt-4 text-lg font-bold text-slate-800">
                        Nenhum atendimento hoje
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Não existem atendimentos registrados para esta data.
                    </p>

                    <Link
                        href="/atendimentos/create"
                        class="btn btn-primary btn-sm mt-5"
                    >
                        + Registrar atendimento
                    </Link>

                </div>


                <!-- Tabela -->

                <div
                    v-else
                    class="overflow-x-auto"
                >

                    <table class="w-full">

                        <thead>

                            <tr class="bg-slate-50 border-b border-slate-200">

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500"
                                >
                                    Horário
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500"
                                >
                                    Paciente
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500"
                                >
                                    Tipo de atendimento
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-500"
                                >
                                    Observações
                                </th>

                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wide text-slate-500"
                                >
                                    Ações
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <tr
                                v-for="atendimento in atendimentos"
                                :key="atendimento.id"
                                class="border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors"
                            >

                                <!-- Horário -->

                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 font-bold"
                                        >
                                            🕐
                                        </div>

                                        <div>

                                            <p class="font-bold text-slate-800">
                                                {{ formatarHora(atendimento.data_hora) }}
                                            </p>

                                            <p class="text-xs text-slate-500">
                                                Hoje
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                <!-- Paciente -->

                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-600 font-bold"
                                        >
                                            {{
                                                atendimento.paciente?.nome
                                                    ?.charAt(0)
                                                    ?.toUpperCase()
                                            }}
                                        </div>

                                        <div>

                                            <p class="font-semibold text-slate-800">
                                                {{ atendimento.paciente?.nome ?? 'Não informado' }}
                                            </p>

                                            <p class="text-xs text-slate-500">
                                                CPF:
                                                {{ atendimento.paciente?.cpf ?? 'Não informado' }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                <!-- Tipo -->

                                <td class="px-6 py-5">

                                    <span
                                        class="inline-flex items-center rounded-lg bg-indigo-50 px-3 py-1.5 text-sm font-semibold text-indigo-700"
                                    >
                                        {{
                                            atendimento.tipo_atendimento?.nome
                                                ?? 'Não informado'
                                        }}
                                    </span>

                                </td>


                                <!-- Observações -->

                                <td class="px-6 py-5">

                                    <p
                                        v-if="atendimento.observacoes"
                                        class="max-w-xs text-sm text-slate-600 line-clamp-2"
                                    >
                                        {{ atendimento.observacoes }}
                                    </p>

                                    <span
                                        v-else
                                        class="text-sm text-slate-400 italic"
                                    >
                                        Sem observações
                                    </span>

                                </td>


                                <!-- Ações -->

                                <td class="px-6 py-5">

                                    <div class="flex justify-end gap-2">

                                        <Link
                                            :href="`/atendimentos/${atendimento.id}`"
                                            class="btn btn-sm btn-outline"
                                        >
                                            Ver
                                        </Link>

                                        <Link
                                            :href="`/atendimentos/${atendimento.id}/edit`"
                                            class="btn btn-sm btn-outline"
                                        >
                                            Editar
                                        </Link>

                                    </div>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</AppLayout>


</template>
