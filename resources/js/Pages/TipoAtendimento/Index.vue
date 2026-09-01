<script setup>

import { router, Link } from '@inertiajs/vue3'
import AppLayout from '/resources/js/Layout/AppLayout.vue'

const props = defineProps({
    tipos: {
        type: Array,
        required: true,
    },
})

function novoTipo() {
    router.visit('/tipos-atendimento/create')
}

function editar(id) {
    router.visit(`/tipos-atendimento/${id}/edit`)
}

function verTipo(id) {
    router.visit(`/tipos-atendimento/${id}`)
}

function excluir(id) {

    if (!confirm('Tem certeza que deseja excluir este tipo de atendimento?')) {
        return
    }

    router.delete(`/tipos-atendimento/${id}`, {
        preserveScroll: true,
    })
}

</script>

<template>

    <AppLayout>

        <div class="min-h-screen bg-slate-50 p-6">

        <div class="max-w-7xl mx-auto">

            <!-- Cabeçalho da página -->

            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8"
            >

                <div>

                    <p class="text-sm font-medium text-indigo-600">
                        Gestão de Tipos de atendimentos
                    </p>

                    <h1 class="mt-1 text-3xl font-bold text-slate-900">
                        Tipos de Atendimentos
                    </h1>

                    <p class="mt-2 text-slate-500">
                        Consulte e gerencie os tipos de atendimentos registrados no sistema.
                    </p>

                </div>

                <Link
                    href="/tipos-atendimento/create"
                    class="btn btn-primary"
                >
                    + Novo tipo
                </Link>

            </div>


            <!-- Resumo -->
            <div class="w-full mb-6">

                <!-- Total -->
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-medium text-slate-500">
                                Total cadastrados
                            </p>

                            <p class="text-2xl font-bold text-slate-800 mt-1">
                                {{ props.tipos.length }}
                            </p>

                        </div>

                        <div class="w-11 h-11 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-xl">
                            ☰
                        </div>

                    </div>

                </div>

            </div>


            <!-- Tabela -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                <!-- Cabeçalho do card -->
                <div class="px-6 py-5 border-b border-slate-200">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                        <div>

                            <h2 class="text-lg font-bold text-slate-800">
                                Tipos cadastrados
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                Lista de tipos de atendimento disponíveis.
                            </p>

                        </div>

                        <span class="badge badge-ghost">
                            {{ props.tipos.length }} registro(s)
                        </span>

                    </div>

                </div>


            <!-- Conteúdo -->
            <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white">


            <table class="table w-full">

                <thead>

                    <tr class="bg-slate-50 border-b border-slate-200">

                        <th class="px-6 py-4 text-slate-500 font-semibold text-sm">
                            ID
                        </th>

                        <th class="px-6 py-4 text-slate-500 font-semibold text-sm">
                            Tipo de atendimento
                        </th>

                        <th class="px-6 py-4 text-slate-500 font-semibold text-sm">
                            Descrição
                        </th>

                        <th class="px-6 py-4 text-slate-500 font-semibold text-sm text-right">
                            Ações
                        </th>

                    </tr>

                </thead>
            <tbody>

                <!-- Registros -->

                <tr
                    v-for="tipo in props.tipos"
                    :key="tipo.id"
                    class="border-b border-slate-100 hover:bg-slate-50 transition-colors"
                >

                    <!-- ID -->

                    <td class="px-5 py-4 w-24 text-slate-500 font-medium">
                        #{{ tipo.id }}
                    </td>


                    <!-- Tipo -->

                    <td class="px-5 py-4">

                        <div class="flex items-center gap-3">

                            <div
                                class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold shrink-0"
                            >
                                {{ tipo.nome.charAt(0).toUpperCase() }}
                            </div>

                            <div>

                                <p class="font-semibold text-slate-800">
                                    {{ tipo.nome }}
                                </p>

                                <p class="text-xs text-slate-400 mt-0.5">
                                    Tipo de atendimento
                                </p>

                            </div>

                        </div>

                    </td>

                    <td class="px-5 py-4 w-24 text-slate-1200 font-medium">
                        {{ tipo.descricao }}
                    </td>


                    <!-- Ações -->

                    <td class="px-5 py-4 w-64">

                        <div class="flex justify-end items-center gap-1">

                            <!-- Visualizar -->

                            <Link
                                :href="`/tipos-atendimento/${tipo.id}`"
                                class="btn btn-sm btn-ghost text-slate-900 hover:bg-slate-200 order-slate-300"
                            >
                                Ver
                            </Link>


                            <!-- Editar -->

                            <Link
                                :href="`/tipos-atendimento/${tipo.id}/edit`"
                                class="btn btn-sm btn-ghost text-slate-900 hover:bg-slate-200 order-slate-300"
                            >
                                Editar
                            </Link>


                            <!-- Excluir -->

                            <button
                                @click="excluir(tipo.id)"
                                class="btn btn-sm btn-ghost text-error hover:bg-red-200 order-slate-300"
                            >
                                Excluir
                            </button>

                        </div>

                    </td>

                </tr>


                <!-- Nenhum registro -->

                <tr v-if="props.tipos.length === 0">

                    <td
                        colspan="3"
                        class="px-6 py-16"
                    >

                        <div class="flex flex-col items-center justify-center text-center">

                            <div
                                class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-2xl mb-4"
                            >
                                ☰
                            </div>

                            <h3 class="text-lg font-bold text-slate-800">
                                Nenhum tipo cadastrado
                            </h3>

                            <p class="text-sm text-slate-500 mt-1 max-w-md">
                                Você ainda não possui tipos de atendimento cadastrados.
                                Crie um para começar a utilizar o sistema.
                            </p>

                            <Link
                                href="/tipos-atendimento/create"
                                class="btn btn-primary btn-sm mt-5"
                            >
                                + Cadastrar primeiro tipo
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