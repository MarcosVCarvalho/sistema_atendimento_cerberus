<script setup>

import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '/resources/js/Layouts/AppLayout.vue'
import {formatarCpf,formatarTelefone} from '/resources/js/Utils/formacoes.js'

const props = defineProps({
    paciente: Object,
})

const form = reactive({
    nome: props.paciente.nome ?? '',
    cpf: formatarCpf(props.paciente.cpf),
    telefone: formatarTelefone(props.paciente.telefone),
    whatsapp: formatarTelefone(props.paciente.whatsapp),
    rua: props.paciente.rua ?? '',
    bairro: props.paciente.bairro ?? '',
    cidade: props.paciente.cidade ?? '',
})

const erros = ref({})
const carregando = ref(false)

function atualizar() {
    carregando.value = true
    erros.value = {}

    router.put(`/pacientes/${props.paciente.id}`, form, {
        preserveScroll: true,

        onError: (errors) => {
            erros.value = errors
        },

        onFinish: () => {
            carregando.value = false
        },
    })
}

function voltar() {
    router.visit('/pacientes')
}

</script>

<template>

    <AppLayout>

    <div class="min-h-screen bg-slate-50 p-6">

        <div class="max-w-3xl mx-auto">

            <!-- Cabeçalho -->
            <div
                class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6"
            >

                <div>

                    <p class="text-sm font-medium text-indigo-600">
                        Gestão de pacientes
                    </p>

                    <h1 class="text-3xl font-bold text-slate-800">
                        Editar Paciente
                    </h1>

                    <p class="text-slate-500 mt-1">
                        Atualize os dados de {{ paciente.nome }}
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
            <div
                class="bg-white rounded-2xl shadow-sm
                       border border-slate-200"
            >

                <div class="p-6">

                    <form @submit.prevent="atualizar">

                        <!-- Nome -->
                        <div class="form-control mb-5">

                            <label class="label">

                                <span class="label-text font-semibold text-slate-700">
                                    Nome 
                                </span>

                            </label>

                            <input
                                v-model="form.nome"
                                type="text"
                                placeholder="Nome completo"
                                class="input input-bordered w-full"
                                :class="{
                                    'input-error': erros.nome
                                }"
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
                                    CPF 
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

                            <label v-if="erros.cpf" class="label">
                                <span class="label-text-alt text-error">
                                    {{ erros.cpf }}
                                </span>
                            </label>

                        </div>

                        <!-- Telefones -->
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

                                <label v-if="erros.telefone" class="label">
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

                                <label v-if="erros.whatsapp" class="label">
                                    <span class="label-text-alt text-error">
                                        {{ erros.whatsapp }}
                                    </span>
                                </label>

                            </div>

                        </div>

                        <!-- Rua -->
                        <div class="form-control mb-6">

                            <label class="label">
                                <span class="label-text font-semibold text-slate-700">
                                    Rua
                                </span>
                            </label>

                            <input
                                v-model="form.rua"
                                type="text"
                                placeholder="Nome da rua"
                                class="input input-bordered w-full"
                                :class="{
                                    'input-error': erros.rua
                                }"
                            />

                            <label
                                v-if="erros.rua"
                                class="label"
                            >
                                <span class="label-text-alt text-error">
                                    {{ erros.rua }}
                                </span>
                            </label>

                        </div>


                        <!-- Bairro -->
                        <div class="form-control mb-6">

                            <label class="label">
                                <span class="label-text font-semibold text-slate-700">
                                    Bairro
                                </span>
                            </label>

                            <input
                                v-model="form.bairro"
                                type="text"
                                placeholder="Nome do bairro"
                                class="input input-bordered w-full"
                                :class="{
                                    'input-error': erros.bairro
                                }"
                            />

                            <label
                                v-if="erros.bairro"
                                class="label"
                            >
                                <span class="label-text-alt text-error">
                                    {{ erros.bairro }}
                                </span>
                            </label>

                        </div>


                        <!-- Cidade -->
                        <div class="form-control mb-6">

                            <label class="label">
                                <span class="label-text font-semibold text-slate-700">
                                    Cidade
                                </span>
                            </label>

                            <input
                                v-model="form.cidade"
                                type="text"
                                placeholder="Nome da cidade"
                                class="input input-bordered w-full"
                                :class="{
                                    'input-error': erros.cidade
                                }"
                            />

                            <label
                                v-if="erros.cidade"
                                class="label"
                            >
                                <span class="label-text-alt text-error">
                                    {{ erros.cidade }}
                                </span>
                            </label>

                        </div>

                        <!-- Botões -->
                        <div
                            class="flex flex-col-reverse sm:flex-row
                                   justify-end gap-3"
                        >

                            <button
                                type="button"
                                @click="voltar"
                                class="btn btn-ghost"
                                :disabled="carregando"
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
                                        ? 'Salvando...'
                                        : 'Salvar alterações'
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