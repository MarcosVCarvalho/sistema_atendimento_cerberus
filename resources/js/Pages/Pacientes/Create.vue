<script setup>

import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '/resources/js/Layouts/AppLayout.vue'
import {formatarCpf,formatarTelefone} from '/resources/js/Utils/formacoes.js'

const form = reactive({
    nome: '',
    cpf: '',
    telefone: '',
    whatsapp: '',
    endereco: '',
})

const erros = ref({})
const carregando = ref(false)

const cadastrar = () => {

    carregando.value = true
    erros.value = {}

    router.post('/pacientes', form, {

        onError: (errors) => {
            erros.value = errors
        },

        onSuccess: () => {
            // O Controller pode redirecionar para /pacientes
        },

        onFinish: () => {
            carregando.value = false
        },

    })
}

const voltar = () => {
    router.visit('/pacientes')
}


</script>

<template>

    <AppLayout>

    <div class="min-h-screen bg-slate-50 p-6">

        <div class="max-w-3xl mx-auto">

            <!-- Cabeçalho -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">

                <div>
                    <p class="text-sm font-medium text-indigo-600">
                        Novo Tipo de Atendimento
                    </p>
                    <h1 class="text-3xl font-bold text-slate-800">
                        Novo Paciente
                    </h1>

                    <p class="text-slate-500 mt-1">
                        Cadastre um novo paciente no sistema
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

            <!-- Formulário -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200">

                <div class="p-6">

                    <form @submit.prevent="cadastrar">

                        <!-- Nome -->
                        <div class="form-control mb-5">

                            <label class="label">
                                <span class="label-text font-semibold text-slate-700">
                                    Nome *
                                </span>
                            </label>

                            <input
                                v-model="form.nome"
                                type="text"
                                placeholder="Nome completo"
                                class="input input-bordered w-full"
                                :class="{ 'input-error': erros.nome }"
                            />

                            <label
                                v-if="erros.nome"
                                class="label"
                            >
                                <span class="label-text-alt text-error">
                                    {{ erros.nome }}
                                </span>
                            </label>

                        </div>

                        <!-- CPF -->
                        <div class="form-control mb-5">

                            <label class="label">
                                <span class="label-text font-semibold text-slate-700">
                                    CPF *
                                </span>
                            </label>

                            <input
                                :value="form.cpf"
                                @input="form.cpf = formatarCpf($event.target.value)"
                                type="text"
                                placeholder="000.000.000-00"
                                maxlength="14"
                                inputmode="numeric"
                                class="input input-bordered w-full"
                                :class="{ 'input-error': erros.cpf }"
                            />

                            <label
                                v-if="erros.cpf"
                                class="label"
                            >
                                <span class="label-text-alt text-error">
                                    {{ erros.cpf }}
                                </span>
                            </label>

                        </div>

                        <!-- Telefone / WhatsApp -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <!-- Telefone -->
                            <div class="form-control mb-5">

                                <label class="label">
                                    <span class="label-text font-semibold text-slate-700">
                                        Telefone
                                    </span>
                                </label>

                                <input
                                    :value="form.telefone"
                                    @input="form.telefone = formatarTelefone($event.target.value)"
                                    type="text"
                                    placeholder="(86) 3333-4444"
                                    maxlength="15"
                                    inputmode="numeric"
                                    class="input input-bordered w-full"
                                    :class="{ 'input-error': erros.telefone }"
                                />

                                <label
                                    v-if="erros.telefone"
                                    class="label"
                                >
                                    <span class="label-text-alt text-error">
                                        {{ erros.telefone }}
                                    </span>
                                </label>

                            </div>

                            <!-- WhatsApp -->
                            <div class="form-control mb-5">

                                <label class="label">
                                    <span class="label-text font-semibold text-slate-700">
                                        WhatsApp
                                    </span>
                                </label>

                                <input
                                    :value="form.whatsapp"
                                    @input="form.whatsapp = formatarTelefone($event.target.value)"
                                    type="text"
                                    placeholder="(86) 99999-8888"
                                    maxlength="15"
                                    inputmode="numeric"
                                    class="input input-bordered w-full"
                                    :class="{ 'input-error': erros.whatsapp }"
                                />

                                <label
                                    v-if="erros.whatsapp"
                                    class="label"
                                >
                                    <span class="label-text-alt text-error">
                                        {{ erros.whatsapp }}
                                    </span>
                                </label>

                            </div>

                        </div>

                        <!-- Endereço -->
                        <div class="form-control mb-6">

                            <label class="label">
                                <span class="label-text font-semibold text-slate-700">
                                    Endereço
                                </span>
                            </label>

                            <input
                                v-model="form.endereco"
                                type="text"
                                placeholder="Rua, número, bairro..."
                                class="input input-bordered w-full"
                                :class="{ 'input-error': erros.endereco }"
                            />

                            <label
                                v-if="erros.endereco"
                                class="label"
                            >
                                <span class="label-text-alt text-error">
                                    {{ erros.endereco }}
                                </span>
                            </label>

                        </div>

                        <!-- Botões -->
                        <div class="flex justify-end gap-3">

                            <button
                                type="button"
                                @click="voltar"
                                class="btn btn-ghost"
                            >
                                Cancelar
                            </button>

                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-indigo-700 hover:shadow-md active:scale-95"
                                :disabled="carregando"
                            >

                                <span
                                    v-if="carregando"
                                    class="loading loading-spinner loading-sm"
                                ></span>

                                {{
                                    carregando
                                        ? 'Cadastrando...'
                                        : 'Cadastrar paciente'
                                }}

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>
    </AppLayout>

</template>