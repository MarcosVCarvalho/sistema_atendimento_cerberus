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

            <div class="max-w-6xl mx-auto">

                <!-- Cabeçalho -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

                    <div>
                        <h1 class="text-3xl font-bold text-slate-800">
                            Ficha do Paciente
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

                <!-- Dados do paciente -->
                <div class="card bg-white shadow-sm border border-slate-200 mb-6">

                    <div class="card-body">

                        <h2 class="card-title text-slate-800 mb-4">
                            {{ props.paciente.nome }}
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            <div>
                                <span class="text-sm font-semibold text-slate-500">
                                    CPF
                                </span>

                                <p class="text-slate-800 mt-1">
                                    {{ props.paciente.cpf }}
                                </p>
                            </div>

                            <div>
                                <span class="text-sm font-semibold text-slate-500">
                                    Telefone
                                </span>

                                <p class="text-slate-800 mt-1">
                                    {{ props.paciente.telefone || 'Não informado' }}
                                </p>
                            </div>

                            <div>
                                <span class="text-sm font-semibold text-slate-500">
                                    WhatsApp
                                </span>

                                <p class="text-slate-800 mt-1">
                                    {{ props.paciente.whatsapp || 'Não informado' }}
                                </p>
                            </div>

                            <div>
                                <span class="text-sm font-semibold text-slate-500">
                                    Endereço
                                </span>

                                <p class="text-slate-800 mt-1">
                                    {{ props.paciente.endereco || 'Não informado' }}
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- Histórico -->
                <div class="card bg-white shadow-sm border border-slate-200">

                    <div class="card-body">

                        <div class="flex items-center justify-between mb-4">

                            <div>
                                <h2 class="card-title text-slate-800">
                                    Histórico de atendimentos
                                </h2>

                                <p class="text-sm text-slate-500 mt-1">
                                    Histórico registrado no sistema
                                </p>
                            </div>

                            <div class="badge badge-primary">
                                {{ props.historico.length }}
                                atendimento(s)
                            </div>

                        </div>

                        <!-- Sem histórico -->
                        <div
                            v-if="props.historico.length === 0"
                            class="text-center py-10 text-slate-400"
                        >
                            <p class="text-lg font-semibold">
                                Nenhum atendimento registrado
                            </p>

                            <p class="text-sm mt-1">
                                Este paciente ainda não possui atendimentos.
                            </p>
                        </div>

                        <!-- Histórico -->
                        <div
                            v-else
                            class="space-y-4"
                        >

                            <div
                                v-for="atendimento in props.historico"
                                :key="atendimento.id"
                                class="border border-slate-200 rounded-xl p-5 hover:bg-slate-50 transition"
                            >

                                <!-- Cabeçalho -->
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">

                                    <div>
                                        <span class="font-bold text-slate-800">
                                            Atendimento #{{ atendimento.id }}
                                        </span>
                                    </div>

                                    <span class="text-sm text-slate-500">
                                        {{ atendimento.data_hora }}
                                    </span>

                                </div>

                                <!-- Informações -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                    <div>
                                        <span class="text-sm font-semibold text-slate-500">
                                            Tipo
                                        </span>

                                        <p class="text-slate-800 mt-1">
                                            {{ atendimento.tipo_atendimento?.nome || 'Não informado' }}
                                        </p>
                                    </div>

                                    <div>
                                        <span class="text-sm font-semibold text-slate-500">
                                            Usuário
                                        </span>

                                        <p class="text-slate-800 mt-1">
                                            {{ atendimento.usuario?.name || 'Não informado' }}
                                        </p>
                                    </div>

                                </div>

                                <!-- Observações -->
                                <div
                                    v-if="atendimento.observacoes"
                                    class="mt-4"
                                >
                                    <span class="text-sm font-semibold text-slate-500">
                                        Observações
                                    </span>

                                    <p class="text-slate-700 mt-1">
                                        {{ atendimento.observacoes }}
                                    </p>
                                </div>

                                <!-- Encaminhamentos -->
                                <div
                                    v-if="atendimento.encaminhamentos"
                                    class="mt-4"
                                >
                                    <span class="text-sm font-semibold text-slate-500">
                                        Encaminhamentos
                                    </span>

                                    <p class="text-slate-700 mt-1">
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