<script setup>
import AppLayout from '../Layout/AppLayout.vue'
import { router, Link } from '@inertiajs/vue3'

defineProps({
    estatisticas: {
        type: Object,
        default: () => ({
            pacientes: 0,
            atendimentosHoje: 0,
            pendentes: 0,
        }),
    },

    atendimentos: {
        type: Array,
        default: () => [],
    },
})
</script>

<template>
    <AppLayout>

        <!-- Cabeçalho -->
        <div class="mb-8">
            <p class="text-sm font-medium text-indigo-600">
                Visão geral
            </p>

            <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">
                Dashboard
            </h1>

            <p class="mt-2 text-slate-500">
                Acompanhe os atendimentos e pacientes do sistema.
            </p>
        </div>

        <!-- Indicadores -->
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

            <!-- Pacientes -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total de pacientes
                        </p>

                        <p class="mt-2 text-3xl font-bold text-slate-900">
                            {{ estatisticas.pacientes }}
                        </p>

                        <p class="mt-2 text-xs text-slate-500">
                            Pacientes cadastrados
                        </p>
                    </div>

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600"
                    >
                        P
                    </div>
                </div>
            </div>

            <!-- Atendimentos -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Atendimentos hoje
                        </p>

                        <p class="mt-2 text-3xl font-bold text-slate-900">
                            {{ estatisticas.atendimentosHoje }}
                        </p>

                        <p class="mt-2 text-xs text-slate-500">
                            Registrados hoje
                        </p>
                    </div>

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600"
                    >
                        A
                    </div>
                </div>
            </div>

            <!-- Pendentes -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Pendentes
                        </p>

                        <p class="mt-2 text-3xl font-bold text-slate-900">
                            {{ estatisticas.pendentes }}
                        </p>

                        <p class="mt-2 text-xs text-slate-500">
                            Aguardando atendimento
                        </p>
                    </div>

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600"
                    >
                        !
                    </div>
                </div>
            </div>

        </div>

        <!-- Conteúdo -->
        <div class="mt-8 grid gap-6 lg:grid-cols-3">

            <!-- Atendimentos -->
            <div
                class="rounded-2xl border border-slate-200 bg-white shadow-sm lg:col-span-2"
            >
                <div class="flex items-center justify-between border-b border-slate-200 p-6">

                    <div>
                        <h2 class="font-semibold text-slate-900">
                            Atendimentos de hoje
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Últimos atendimentos registrados
                        </p>
                    </div>

                    <Link
                        href="/atendimentos"
                        class="text-sm font-medium text-indigo-600 hover:text-indigo-700"
                    >
                        Ver todos
                    </Link>
                </div>

                <div
                    v-if="atendimentos.length === 0"
                    class="p-10 text-center"
                >
                    <p class="font-medium text-slate-700">
                        Nenhum atendimento hoje
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        Os atendimentos registrados aparecerão aqui.
                    </p>
                </div>

                <div v-else class="divide-y divide-slate-100">

                    <div
                        v-for="atendimento in atendimentos"
                        :key="atendimento.id"
                        class="flex items-center justify-between p-5"
                    >
                        <div>
                            <p class="font-medium text-slate-900">
                                {{ atendimento.paciente?.nome }}
                            </p>

                            <p class="mt-1 text-sm text-slate-500">
                                {{ atendimento.tipo_atendimento?.nome }}
                            </p>
                        </div>

                        <span class="text-sm text-slate-500">
                            {{ atendimento.data_hora }}
                        </span>
                    </div>

                </div>
            </div>

            <!-- Ações -->
            <div
                class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
            >
                <h2 class="font-semibold text-slate-900">
                    Ações rápidas
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Acesse rapidamente as funções principais.
                </p>

                <div class="mt-6 space-y-3">

                    <Link
                        href="/pacientes/create"
                        class="flex w-full items-center justify-center rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700"
                    >
                        + Novo paciente
                    </Link>

                    <Link
                        href="/atendimentos/create"
                        class="flex w-full items-center justify-center rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        + Novo atendimento
                    </Link>

                    <Link
                        href="/tipos-atendimento/create"
                        class="flex w-full items-center justify-center rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700"
                    >    
                        + Novo tipo de atendimento
                    </Link>

                </div>
            </div>

        </div>

    </AppLayout>
</template>