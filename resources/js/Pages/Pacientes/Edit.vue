<script setup>

import { useForm, router } from '@inertiajs/vue3'
import Navbar from '../../Components/Navbar.vue'

const props = defineProps({
    paciente: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    nome: props.paciente.nome ?? '',
    cpf: props.paciente.cpf ?? '',
    telefone: props.paciente.telefone ?? '',
    whatsapp: props.paciente.whatsapp ?? '',
    endereco: props.paciente.endereco ?? '',
})

function atualizar() {

    form.put(`/pacientes/${props.paciente.id}`, {
        preserveScroll: true,
    })

}

function voltar() {
    router.visit('/pacientes')
}

</script>

<template>

    <Navbar />

    <div class="min-h-screen bg-slate-50 p-6">

        <div class="max-w-3xl mx-auto">

            <!-- Cabeçalho -->
            <div
                class="flex flex-col sm:flex-row sm:items-center
                       sm:justify-between gap-4 mb-8"
            >

                <div>

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
                                    Nome *
                                </span>

                            </label>

                            <input
                                v-model="form.nome"
                                type="text"
                                placeholder="Nome completo"
                                class="input input-bordered w-full"
                                :class="{
                                    'input-error': form.errors.nome
                                }"
                            />

                            <label
                                v-if="form.errors.nome"
                                class="label"
                            >

                                <span class="label-text-alt text-error">
                                    {{ form.errors.nome }}
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
                                v-model="form.cpf"
                                type="text"
                                placeholder="000.000.000-00"
                                maxlength="14"
                                class="input input-bordered w-full"
                                :class="{
                                    'input-error': form.errors.cpf
                                }"
                            />

                            <label
                                v-if="form.errors.cpf"
                                class="label"
                            >

                                <span class="label-text-alt text-error">
                                    {{ form.errors.cpf }}
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
                                    v-model="form.telefone"
                                    type="text"
                                    placeholder="(86) 3333-4444"
                                    class="input input-bordered w-full"
                                    :class="{
                                        'input-error': form.errors.telefone
                                    }"
                                />

                                <label
                                    v-if="form.errors.telefone"
                                    class="label"
                                >

                                    <span class="label-text-alt text-error">
                                        {{ form.errors.telefone }}
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
                                    v-model="form.whatsapp"
                                    type="text"
                                    placeholder="(86) 99999-8888"
                                    class="input input-bordered w-full"
                                    :class="{
                                        'input-error': form.errors.whatsapp
                                    }"
                                />

                                <label
                                    v-if="form.errors.whatsapp"
                                    class="label"
                                >

                                    <span class="label-text-alt text-error">
                                        {{ form.errors.whatsapp }}
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
                                :class="{
                                    'input-error': form.errors.endereco
                                }"
                            />

                            <label
                                v-if="form.errors.endereco"
                                class="label"
                            >

                                <span class="label-text-alt text-error">
                                    {{ form.errors.endereco }}
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
                                :disabled="form.processing"
                            >
                                Cancelar
                            </button>

                            <button
                                type="submit"
                                class="btn btn-primary"
                                :disabled="form.processing"
                            >

                                <span
                                    v-if="form.processing"
                                    class="loading loading-spinner loading-sm"
                                ></span>

                                {{
                                    form.processing
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

</template>