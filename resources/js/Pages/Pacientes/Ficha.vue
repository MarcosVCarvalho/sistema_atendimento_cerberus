<script setup>

import { router } from '@inertiajs/vue3'
import Navbar from '/resources/js/Layout/AppLayout.vue'

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

    <Navbar />

    <div class="min-h-screen bg-slate-50 p-6">

        <div class="max-w-6xl mx-auto">

            <!-- Cabeçalho -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">

                <div>

                    <div class="flex items-center gap-3 mb-2">

                        <div
                            class="w-11 h-11 rounded-xl bg-primary text-primary-content
                                   flex items-center justify-center font-bold text-lg"
                        >
                            {{ props.paciente.nome?.charAt(0)?.toUpperCase() }}
                        </div>

                        <div>

                            <h1 class="text-3xl font-bold text-slate-800">
                                {{ props.paciente.nome }}
                            </h1>

                            <p class="text-slate-500">
                                Ficha do paciente
                            </p>

                        </div>

                    </div>

                </div>

                <div class="flex gap-2">

                    <button
                        type="button"
                        @click="voltar"
                        class="btn btn-outline"
                    >
                        ← Voltar
                    </button>

                    <button
                        type="button"
                        @click="editar"
                        class="btn btn-primary"
                    >
                        Editar paciente
                    </button>

                </div>

            </div>

            <!-- Dados do paciente -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-6">

                <div class="p-6">

                    <div class="flex items-center gap-3 mb-6">

                        <div
                            class="w-10 h-10 rounded-lg bg-slate-100
                                   flex items-center justify-center"
                        >
                            👤
                        </div>

                        <div>

                            <h2 class="text-lg font-bold text-slate-800">
                                Dados pessoais
                            </h2>

                            <p class="text-sm text-slate-500">
                                Informações cadastradas
                            </p>

                        </div>

                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                        <!-- CPF -->
                        <div>

                            <span class="text-sm text-slate-500">
                                CPF
                            </span>

                            <p class="font-semibold text-slate-800 mt-1">
                                {{ props.paciente.cpf }}
                            </p>

                        </div>

                        <!-- Telefone -->
                        <div>

                            <span class="text-sm text-slate-500">
                                Telefone
                            </span>

                            <p class="font-semibold text-slate-800 mt-1">
                                {{ props.paciente.telefone || 'Não informado' }}
                            </p>

                        </div>

                        <!-- WhatsApp -->
                        <div>

                            <span class="text-sm text-slate-500">
                                WhatsApp
                            </span>

                            <p class="font-semibold text-slate-800 mt-1">
                                {{ props.paciente.whatsapp || 'Não informado' }}
                            </p>

                        </div>

                        <!-- Endereço -->
                        <div>

                            <span class="text-sm text-slate-500">
                                Endereço
                            </span>

                            <p class="font-semibold text-slate-800 mt-1">
                                {{ props.paciente.endereco || 'Não informado' }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Histórico -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200">

                <div class="p-6">

                    <!-- Cabeçalho -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">

                        <div>

                            <h2 class="text-lg font-bold text-slate-800">
                                Histórico de atendimentos
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                Registro dos atendimentos realizados
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
                        class="text-center py-12"
                    >

                        <div
                            class="w-14 h-14 mx-auto mb-4 rounded-full bg-slate-100
                                   flex items-center justify-center text-2xl"
                        >
                            📋
                        </div>

                        <h3 class="font-semibold text-slate-700">
                            Nenhum atendimento
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Este paciente ainda não possui atendimentos registrados.
                        </p>

                    </div>

                    <!-- Atendimentos -->
                    <div
                        v-else
                        class="space-y-4"
                    >

                        <div
                            v-for="atendimento in props.historico"
                            :key="atendimento.id"
                            class="border border-slate-200 rounded-xl p-5
                                   hover:border-slate-300 transition"
                        >

                            <!-- Cabeçalho -->
                            <div
                                class="flex flex-col sm:flex-row
                                       sm:items-center sm:justify-between
                                       gap-2 mb-5"
                            >

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
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                <!-- Tipo -->
                                <div>

                                    <span class="text-sm text-slate-500">
                                        Tipo de atendimento
                                    </span>

                                    <p class="font-semibold text-slate-800 mt-1">
                                        {{
                                            atendimento.tipo_atendimento?.nome
                                            || 'Não informado'
                                        }}
                                    </p>

                                </div>

                                <!-- Usuário -->
                                <div>

                                    <span class="text-sm text-slate-500">
                                        Usuário responsável
                                    </span>

                                    <p class="font-semibold text-slate-800 mt-1">
                                        {{
                                            atendimento.usuario?.name
                                            || 'Não informado'
                                        }}
                                    </p>

                                </div>

                            </div>

                            <!-- Observações -->
                            <div
                                v-if="atendimento.observacoes"
                                class="mt-5 pt-4 border-t border-slate-100"
                            >

                                <span class="text-sm text-slate-500">
                                    Observações
                                </span>

                                <p class="text-slate-700 mt-1 whitespace-pre-line">
                                    {{ atendimento.observacoes }}
                                </p>

                            </div>

                            <!-- Encaminhamentos -->
                            <div
                                v-if="atendimento.encaminhamentos"
                                class="mt-4"
                            >

                                <span class="text-sm text-slate-500">
                                    Encaminhamentos
                                </span>

                                <p class="text-slate-700 mt-1 whitespace-pre-line">
                                    {{ atendimento.encaminhamentos }}
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</template>