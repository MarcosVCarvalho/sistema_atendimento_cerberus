<script setup>

import { Link, router } from '@inertiajs/vue3'
import AppLayout from '/resources/js/Layout/AppLayout.vue'

const props = defineProps({
    atendimentos: {
        type: Object,
        default: () => ({
            data: [],
            links: [],
            current_page: 1,
            last_page: 1,
            total: 0,
        }),
    },
})

const excluir = (id) => {

    if (!confirm('Tem certeza que deseja excluir este atendimento?')) {
        return
    }

    router.delete(`/atendimentos/${id}`)
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

        <div class="max-w-7xl mx-auto">

            <!-- Cabeçalho -->

            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

                <div>

                    <p class="text-sm font-medium text-indigo-600">
                        Gestão de atendimentos
                    </p>

                    <h1 class="mt-1 text-3xl font-bold text-slate-900">
                        Atendimentos
                    </h1>

                    <p class="mt-2 text-slate-500">
                        Consulte e gerencie os atendimentos registrados no sistema.
                    </p>

                </div>

                <Link
                    href="/atendimentos/create"
                    class="btn btn-primary"
                >
                    + Novo atendimento
                </Link>

            </div>


            <!-- Card da tabela -->

            <div
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <!-- Cabeçalho da tabela -->

                <div
                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-b border-slate-200 p-6">

                    <div>

                        <h2 class="font-semibold text-slate-900">
                            Lista de atendimentos
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            {{ atendimentos.total }} atendimento(s) registrado(s)
                        </p>

                    </div>

                    <Link
                        href="/atendimentos/hoje"
                        class="btn btn-sm btn-outline"
                    >
                        Atendimentos de hoje
                    </Link>

                </div>


                <!-- Tabela -->

                <div class="overflow-x-auto">

                    <table class="table w-full">

                        <thead>

                            <tr class="bg-slate-50 border-b border-slate-200">

                                <th class="px-6 py-4 text-slate-500 font-semibold text-sm">
                                    ID
                                </th>

                                <th class="px-6 py-4 text-slate-500 font-semibold text-sm">
                                    Paciente
                                </th>

                                <th class="px-6 py-4 text-slate-500 font-semibold text-sm">
                                    Tipo de atendimento
                                </th>

                                <th class="px-6 py-4 text-slate-500 font-semibold text-sm">
                                    Data e hora
                                </th>

                                <th class="px-6 py-4 text-slate-500 font-semibold text-sm">
                                    Responsável
                                </th>

                                <th class="px-6 py-4 text-slate-500 font-semibold text-sm text-right">
                                    Ações
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <!-- Registros -->

                            <tr
                                v-for="atendimento in atendimentos.data"
                                :key="atendimento.id"
                                class="border-b border-slate-100 hover:bg-slate-50 transition-colors"
                            >

                                <!-- ID -->

                                <td class="px-6 py-5">

                                    <span class="font-medium text-slate-500">
                                        #{{ atendimento.id }}
                                    </span>

                                </td>


                                <!-- Paciente -->

                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold shrink-0"
                                        >
                                            {{
                                                atendimento.paciente?.nome
                                                    ?.charAt(0)
                                                    ?.toUpperCase()
                                            }}
                                        </div>

                                        <div>

                                            <p class="font-semibold text-slate-800">
                                                {{ atendimento.paciente?.nome ?? 'Paciente não informado' }}
                                            </p>

                                            <p class="text-xs text-slate-400 mt-0.5">
                                                CPF: {{ atendimento.paciente?.cpf ?? '-' }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                <!-- Tipo -->

                                <td class="px-6 py-5">

                                    <span
                                        class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1.5 text-sm font-medium text-slate-700"
                                    >
                                        {{ atendimento.tipo_atendimento?.nome ?? 'Não informado'}}
                                    </span>

                                </td>


                                <!-- Data -->

                                <td class="px-6 py-5">

                                    <p class="text-sm font-medium text-slate-700">
                                        {{ formatarDataHora(atendimento.data_hora) }}
                                    </p>

                                </td>


                                <!-- Usuário -->

                                <td class="px-6 py-5">

                                    <p class="text-sm text-slate-600">
                                        {{ atendimento.usuario?.name ?? 'Não informado' }}
                                    </p>

                                </td>


                                <!-- Ações -->

                                <td class="px-6 py-5">

                                    <div
                                        class="flex justify-end items-center gap-2"
                                    >

                                        <!-- Ver -->

                                        <Link
                                            :href="`/atendimentos/${atendimento.id}`"
                                            class="btn btn-sm btn-outline border-slate-300 text-slate-900 hover:bg-slate-200"
                                        >
                                            Ver
                                        </Link>


                                        <!-- Editar -->

                                        <Link
                                            :href="`/atendimentos/${atendimento.id}/edit`"
                                            class="btn btn-sm btn-outline border-slate-300 text-slate-900 hover:bg-slate-200 "
                                        >
                                            Editar
                                        </Link>


                                        <!-- Excluir -->

                                        <button
                                            type="button"
                                            @click="excluir(atendimento.id)"
                                            class="btn btn-sm btn-ghost text-error hover:bg-red-200"
                                        >
                                            Excluir
                                        </button>

                                    </div>

                                </td>

                            </tr>


                            <!-- Nenhum registro -->

                            <tr v-if="atendimentos.data.length === 0">

                                <td
                                    colspan="6"
                                    class="px-6 py-16"
                                >

                                    <div
                                        class="flex flex-col items-center justify-center text-center"
                                    >

                                        <div
                                            class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-2xl mb-4"
                                        >
                                            ☰
                                        </div>

                                        <h3 class="text-lg font-bold text-slate-800">
                                            Nenhum atendimento cadastrado
                                        </h3>

                                        <p class="text-sm text-slate-500 mt-1 max-w-md">
                                            Ainda não existem atendimentos registrados no sistema.
                                        </p>

                                        <Link
                                            href="/atendimentos/create"
                                            class="btn btn-primary btn-sm mt-5"
                                        >
                                            + Cadastrar primeiro atendimento
                                        </Link>

                                    </div>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>


                <!-- Paginação -->

                <div
                    v-if="atendimentos.last_page > 1"
                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-t border-slate-200 p-5"
                >

                    <p class="text-sm text-slate-500">
                        Página {{ atendimentos.current_page }}
                        de {{ atendimentos.last_page }}
                    </p>

                    <div class="flex items-center gap-1">

                        <template
                            v-for="link in atendimentos.links"
                            :key="link.label"
                        >

                            <Link
                                v-if="link.url"
                                :href="link.url"
                                preserve-scroll
                                class="btn btn-sm"
                                :class="{
                                    'btn-primary': link.active,
                                    'btn-ghost': !link.active
                                }"
                                v-html="link.label"
                            />

                            <span
                                v-else
                                class="btn btn-sm btn-disabled"
                                v-html="link.label"
                            />

                        </template>

                    </div>

                </div>

            </div>

        </div>

    </div>

</AppLayout>

</template>
