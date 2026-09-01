<script setup>

import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '/resources/js/Layout/AppLayout.vue'

const form = reactive({
    nome: '',
})

const erros = ref({})
const carregando = ref(false)

const cadastrar = () => {

    carregando.value = true
    erros.value = {}

    router.post('/tipos-atendimento', form, {

        onError: (errors) => {
            erros.value = errors
        },

        onSuccess: () => {
            // O Controller redireciona para /tipos-atendimento
        },

        onFinish: () => {
            carregando.value = false
        },

    })
}

const voltar = () => {
    router.visit('/tipos-atendimento')
}

</script>

<template>


<AppLayout>

    <div class="min-h-screen bg-slate-50 p-6">

        <div class="max-w-3xl mx-auto">

            <!-- Cabeçalho -->

            <div
                class="lex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">

                <div>

                    <p class="text-sm font-medium text-indigo-600">
                        Novo Tipo de Atendimento
                    </p>

                    <h1 class="text-3xl font-bold text-slate-800">
                        Tipo de atendimento
                    </h1>
                    <p class="text-slate-500 mt-1">
                        Registre um tipo de atendimento
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
                class="bg-white rounded-2xl shadow-sm border border-slate-200"
            >

                <div class="p-6">

                    <form @submit.prevent="cadastrar">

                        <!-- Nome -->

                        <div class="form-control mb-6">

                            <label class="label">

                                <span
                                    class="label-text font-semibold text-slate-700"
                                >
                                    Tipo de atendimento *
                                </span>

                            </label>

                            <input
                                v-model="form.nome"
                                type="text"
                                placeholder="Ex: Cardiologia,Dermatologia,Nutrição..."
                                class="input input-bordered w-full"
                                :class="{
                                    'input-error': erros.nome
                                }"
                            />

                            <label class="label mt-2">

                            <span class="label-text font-semibold text-slate-700">
                                Descrição do atendimento *
                            </span>

                            </label>

                            <textarea
                                v-model="form.descricao"
                                placeholder="Ex: Atendimento destinado a pacientes com dores abdominais..."
                                class="textarea textarea-bordered w-full min-h-28"
                                :class="{
                                    'textarea-error': erros.descricao
                                }"
                            ></textarea>

                            <label
                                v-if="erros.descricao"
                                class="label"
                            >
                                <span class="label-text-alt text-error">
                                    {{ erros.descricao[0] }}
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
                                class="btn btn-primary"
                                :disabled="carregando"
                            >

                                <span
                                    v-if="carregando"
                                    class="loading loading-spinner loading-sm"
                                ></span>

                                {{
                                    carregando
                                        ? 'Cadastrando...'
                                        : 'Cadastrar tipo'
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
