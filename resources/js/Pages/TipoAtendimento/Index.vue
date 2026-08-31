<script setup>

import { router } from '@inertiajs/vue3'
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

        <div class="max-w-7xl mx-auto">

            <!-- Cabeçalho da página -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

                <div>

                    <div class="flex items-center gap-2 text-sm text-slate-500 mb-2">
                        <span>Configurações</span>

                        <span>/</span>

                        <span class="text-slate-700">
                            Tipos de atendimento
                        </span>
                    </div>

                    <h1 class="text-3xl font-bold text-slate-800">
                        Tipos de Atendimento
                    </h1>

                    <p class="text-slate-500 mt-1">
                        Gerencie os tipos de atendimento utilizados no sistema.
                    </p>

                </div>

                <button
                    @click="novoTipo"
                    class="btn btn-primary shadow-sm"
                >
                    <span class="text-lg">+</span>
                    Novo tipo
                </button>

            </div>


            <!-- Resumo -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">

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


                <!-- Status -->
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-medium text-slate-500">
                                Status
                            </p>

                            <p class="text-lg font-bold text-slate-800 mt-1">
                                Ativo
                            </p>

                        </div>

                        <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                            ✓
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
                <div class="overflow-x-auto">

                    <table class="table">

                        <thead>

                            <tr class="bg-slate-50">

                                <th class="text-slate-500 font-semibold">
                                    ID
                                </th>

                                <th class="text-slate-500 font-semibold">
                                    Tipo de atendimento
                                </th>

                                <th class="text-slate-500 font-semibold text-right">
                                    Ações
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <!-- Registros -->
                            <tr
                                v-for="tipo in props.tipos"
                                :key="tipo.id"
                                class="hover:bg-slate-50 transition-colors"
                            >

                                <td class="text-slate-500">
                                    #{{ tipo.id }}
                                </td>

                                <td>

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold"
                                        >
                                            {{ tipo.nome.charAt(0).toUpperCase() }}
                                        </div>

                                        <div>

                                            <p class="font-semibold text-slate-800">
                                                {{ tipo.nome }}
                                            </p>

                                            <p class="text-xs text-slate-500">
                                                Tipo de atendimento
                                            </p>

                                        </div>

                                    </div>

                                </td>

                                <td>

                                    <div class="flex justify-end gap-2">

                                        <!-- Visualizar -->
                                        <button
                                            @click="verTipo(tipo.id)"
                                            class="btn btn-sm btn-ghost text-slate-600"
                                            title="Visualizar"
                                        >
                                            Ver
                                        </button>

                                        <!-- Editar -->
                                        <button
                                            @click="editar(tipo.id)"
                                            class="btn btn-sm btn-outline"
                                        >
                                            Editar
                                        </button>

                                        <!-- Excluir -->
                                        <button
                                            @click="excluir(tipo.id)"
                                            class="btn btn-sm btn-ghost text-error"
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
                                    class="py-16"
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

                                        <button
                                            @click="novoTipo"
                                            class="btn btn-primary btn-sm mt-5"
                                        >
                                            + Cadastrar primeiro tipo
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </AppLayout>

</template>