<script setup>

import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '/resources/js/Layouts/AppLayout.vue'

const props = defineProps({
    tipo: Object,
})

const form = reactive({
    id: props.tipo.id,
    nome: props.tipo.nome,
    descricao: props.tipo.descricao,
})

const erros = ref({})
const carregando = ref(false)

const atualizar = () => {

    carregando.value = true
    erros.value = {}

    router.put(`/tipos-atendimento/${props.tipo.id}`, form, {

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

        <div class="max-w-4xl mx-auto">

            <!-- Cabeçalho -->

            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6"
            >

                <div>

                    <p class="text-sm font-medium text-indigo-600">
                        Gestão de tipos de atendimentos
                    </p>
                    
                    <h1 class="mt-1 text-3xl font-bold text-slate-900">
                        Tipo de Atendimento #{{ tipo.id }}
                    </h1>

                    <p class="text-slate-500 mt-1">
                        Altere as informações do tipo de atendimento
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

                    <form @submit.prevent="atualizar">

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
                                placeholder="Ex: Cardiologia, Dermatologia, Nutrição..."
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
                                    {{ erros.nome[0] }}
                                </span>

                            </label>

                            <!-- Descrição -->

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
