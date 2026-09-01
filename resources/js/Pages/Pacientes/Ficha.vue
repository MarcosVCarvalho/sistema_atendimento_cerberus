<script setup>
import { router } from '@inertiajs/vue3'
import AppLayout from '/resources/js/Layout/AppLayout.vue'

const props = defineProps({
    paciente: {
        type: Object,
        required: true,
    },

    historico: {
        type: Array,
        default: () => [],
    },
})

function voltar() {
    router.visit('/pacientes')
}

function editar() {
    router.visit(`/pacientes/${props.paciente.id}/edit`)
}
</script>

<template>
    <AppLayout>

        <div class="min-h-screen bg-slate-50 p-6">

            <div class="max-w-4xl mx-auto">

                <!-- Cabeçalho -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

                    <div>
                        <p class="text-sm font-medium text-indigo-600">
                        Gestão de pacientes
                        </p>

                        <h1 class="mt-1 text-3xl font-bold text-slate-900">
                            Ficha do Paciente #{{ props.paciente.id }}
                        </h1>

                        <p class="text-slate-500 mt-1">
                            Informações e histórico de atendimentos
                        </p>
                    </div>

                    <div class="flex gap-2">
                        <button
                            @click="voltar"
                            class="btn btn-outline"
                        >
                            ← Voltar
                        </button>

                        <button
                            @click="editar"
                            class="btn btn-primary"
                        >
                            Editar paciente
                        </button>
                    </div>

                </div>

               <!-- Informações do paciente -->

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-6">

                    <!-- Cabeçalho -->

                    <div class="px-6 py-5 border-b border-slate-100">

                        <div class="flex items-center gap-4">

                            <!-- Inicial -->

                            <div
                                class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg font-bold shrink-0"
                            >
                                {{ props.paciente.nome.charAt(0).toUpperCase() }}
                            </div>

                            <!-- Nome -->

                            <div>

                                <h2 class="text-xl font-bold text-slate-800">
                                    {{ props.paciente.nome }}
                                </h2>

                                <p class="text-sm text-slate-500 mt-0.5">
                                    Informações do paciente
                                </p>

                            </div>

                        </div>

                    </div>


                    <!-- Dados -->

                    <div class="p-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                            <!-- CPF -->

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    CPF
                                </p>

                                <p class="text-sm font-medium text-slate-800 mt-1">
                                    {{ props.paciente.cpf || 'Não informado' }}
                                </p>

                            </div>


                            <!-- Telefone -->

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Telefone
                                </p>

                                <p class="text-sm font-medium text-slate-800 mt-1">
                                    {{ props.paciente.telefone || 'Não informado' }}
                                </p>

                            </div>


                            <!-- WhatsApp -->

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    WhatsApp
                                </p>

                                <p class="text-sm font-medium text-slate-800 mt-1">
                                    {{ props.paciente.whatsapp || 'Não informado' }}
                                </p>

                            </div>


                            <!-- Endereço -->

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Endereço
                                </p>

                                <p class="text-sm font-medium text-slate-800 mt-1">
                                    {{ props.paciente.endereco || 'Não informado' }}
                                </p>

                            </div>

                        </div>

                    </div>

                </div> 

                <!-- Histórico -->

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200">

                    <!-- Cabeçalho -->

                    <div class="px-6 py-5 border-b border-slate-100">

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                            <div>

                                <h2 class="text-lg font-bold text-slate-800">
                                    Histórico de atendimentos
                                </h2>

                                <p class="text-sm text-slate-500 mt-1">
                                    Histórico registrado no sistema
                                </p>

                            </div>

                            <!-- Total -->

                            <span
                                class="inline-flex items-center w-fit rounded-lg bg-primary/10 px-3 py-1.5 text-sm font-semibold text-primary"
                            >
                                {{ props.historico.length }}
                                {{ props.historico.length === 1 ? 'atendimento' : 'atendimentos' }}
                            </span>

                        </div>

                    </div>


                    <!-- Conteúdo -->

                    <div class="p-6">

                        <!-- Sem histórico -->

                        <div
                            v-if="props.historico.length === 0"
                            class="flex flex-col items-center justify-center text-center py-12"
                        >

                            <div
                                class="w-14 h-14 rounded-xl bg-slate-100 flex items-center justify-center text-xl mb-4"
                            >
                                📋
                            </div>

                            <h3 class="text-base font-bold text-slate-800">
                                Nenhum atendimento registrado
                            </h3>

                            <p class="text-sm text-slate-500 mt-1 max-w-md">
                                Este paciente ainda não possui atendimentos registrados no sistema.
                            </p>

                        </div>


                        <!-- Histórico -->

                        <div
                            v-else
                            class="space-y-3"
                        >

                            <div
                                v-for="atendimento in props.historico"
                                :key="atendimento.id"
                                class="border border-slate-200 rounded-xl p-5 hover:bg-slate-50 transition-colors"
                            >

                                <!-- Cabeçalho do atendimento -->

                                <div
                                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-4 border-b border-slate-100"
                                >

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="w-9 h-9 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold shrink-0"
                                        >
                                            {{ atendimento.tipo_atendimento?.nome?.charAt(0).toUpperCase() || 'A' }}
                                        </div>

                                        <div>

                                            <p class="font-semibold text-slate-800">
                                                Atendimento #{{ atendimento.id }}
                                            </p>

                                            <p class="text-xs text-slate-400 mt-0.5">
                                                {{ atendimento.tipo_atendimento?.nome || 'Tipo não informado' }}
                                            </p>

                                        </div>

                                    </div>

                                    <span class="text-sm text-slate-500">
                                        {{ atendimento.data_hora }}
                                    </span>

                                </div>


                                <!-- Informações -->

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5 pt-4">

                                    <!-- Tipo -->

                                    <div>

                                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                            Tipo de atendimento
                                        </p>

                                        <p class="text-sm font-medium text-slate-800 mt-1">
                                            {{ atendimento.tipo_atendimento?.nome || 'Não informado' }}
                                        </p>

                                    </div>


                                    <!-- Usuário -->

                                    <div>

                                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                            Usuário responsável
                                        </p>

                                        <p class="text-sm font-medium text-slate-800 mt-1">
                                            {{ atendimento.usuario?.name || 'Não informado' }}
                                        </p>

                                    </div>

                                </div>


                                <!-- Observações -->

                                <div
                                    v-if="atendimento.observacoes"
                                    class="mt-5 pt-4 border-t border-slate-100"
                                >

                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                        Observações
                                    </p>

                                    <p class="text-sm text-slate-700 mt-1 leading-relaxed">
                                        {{ atendimento.observacoes }}
                                    </p>

                                </div>


                                <!-- Encaminhamentos -->

                                <div
                                    v-if="atendimento.encaminhamentos"
                                    class="mt-5 pt-4 border-t border-slate-100"
                                >

                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                        Encaminhamentos
                                    </p>

                                    <p class="text-sm text-slate-700 mt-1 leading-relaxed">
                                        {{ atendimento.encaminhamentos }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </AppLayout>
</template>