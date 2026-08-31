<script setup>
import { ref } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import AppLayout from '/resources/js/Layout/AppLayout.vue'

const props = defineProps({
    pacientes: {
        type: Object,
        required: true,
    },

    filtros: {
        type: Object,
        default: () => ({
            busca: '',
        }),
    },
})

const busca = ref(props.filtros.busca || '')

function buscar() {
    router.get(
        '/pacientes',
        {
            busca: busca.value || undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
        }
    )
}

function limparBusca() {
    busca.value = ''

    router.get(
        '/pacientes',
        {},
        {
            preserveState: true,
            preserveScroll: true,
        }
    )
}

function excluir(id) {
    if (!confirm('Tem certeza que deseja excluir este paciente?')) {
        return
    }

    router.delete(`/pacientes/${id}`, {
        preserveScroll: true,
    })
}
</script>

<template>
    <AppLayout>
        <div class="space-y-6">

            <!-- Cabeçalho -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>
                    <h1 class="text-3xl font-bold text-slate-800">
                        Pacientes
                    </h1>

                    <p class="text-slate-500 mt-1">
                        Gerenciamento de pacientes cadastrados
                    </p>
                </div>

                <Link
                    href="/pacientes/create"
                    class="btn btn-primary"
                >
                    + Novo paciente
                </Link>

            </div>


            <!-- Busca -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">

                <form
                    @submit.prevent="buscar"
                    class="flex flex-col sm:flex-row gap-3"
                >

                    <div class="flex-1">
                        <input
                            v-model="busca"
                            type="text"
                            placeholder="Buscar por nome, CPF ou telefone..."
                            class="input input-bordered w-full"
                        />
                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Buscar
                    </button>

                    <button
                        v-if="busca"
                        type="button"
                        @click="limparBusca"
                        class="btn btn-outline"
                    >
                        Limpar
                    </button>

                </form>

            </div>


            <!-- Tabela -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

                <!-- Cabeçalho da tabela -->
                <div class="px-6 py-4 border-b border-slate-200">

                    <div class="flex items-center justify-between">

                        <div>
                            <h2 class="font-semibold text-slate-800">
                                Pacientes cadastrados
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                {{ pacientes.total }} paciente(s)
                            </p>
                        </div>

                    </div>

                </div>


                <!-- Tabela -->
                <div class="overflow-x-auto">

                    <table class="table w-full">

                        <thead>
                            <tr class="text-slate-500">

                                <th>ID</th>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Telefone</th>
                                <th>WhatsApp</th>
                                <th class="text-right">
                                    Ações
                                </th>

                            </tr>
                        </thead>


                        <tbody>

                            <tr
                                v-for="paciente in pacientes.data"
                                :key="paciente.id"
                                class="hover:bg-slate-50"
                            >

                                <td>
                                    <span class="text-slate-500">
                                        #{{ paciente.id }}
                                    </span>
                                </td>


                                <td>
                                    <div class="font-semibold text-slate-800">
                                        {{ paciente.nome }}
                                    </div>
                                </td>


                                <td>
                                    {{ paciente.cpf }}
                                </td>


                                <td>
                                    {{ paciente.telefone || '-' }}
                                </td>


                                <td>
                                    {{ paciente.whatsapp || '-' }}
                                </td>


                                <!-- Ações -->
                                <td>

                                    <div class="flex justify-end gap-2">

                                        <Link
                                            :href="`/pacientes/${paciente.id}/ficha`"
                                            class="btn btn-sm btn-outline"
                                        >
                                            Ficha
                                        </Link>


                                        <Link
                                            :href="`/pacientes/${paciente.id}/edit`"
                                            class="btn btn-sm btn-outline"
                                        >
                                            Editar
                                        </Link>


                                        <button
                                            type="button"
                                            @click="excluir(paciente.id)"
                                            class="btn btn-sm btn-error btn-outline"
                                        >
                                            Excluir
                                        </button>

                                    </div>

                                </td>

                            </tr>


                            <!-- Nenhum paciente -->
                            <tr v-if="pacientes.data.length === 0">

                                <td
                                    colspan="6"
                                    class="text-center py-12"
                                >

                                    <div class="text-slate-400">

                                        <div class="text-4xl mb-3">
                                            👤
                                        </div>

                                        <p class="font-semibold text-slate-600">
                                            Nenhum paciente encontrado
                                        </p>

                                        <p class="text-sm mt-1">
                                            Tente realizar uma nova busca.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>


                <!-- Paginação -->
                <div
                    v-if="pacientes.links && pacientes.links.length > 3"
                    class="px-6 py-4 border-t border-slate-200 flex justify-center"
                >

                    <div class="join">

                        <Link
                            v-for="(link, index) in pacientes.links"
                            :key="index"
                            :href="link.url || '#'"
                            class="join-item btn btn-sm"
                            :class="{
                                'btn-primary': link.active,
                                'btn-disabled': !link.url
                            }"
                            preserve-scroll
                            v-html="link.label"
                        />

                    </div>

                </div>

            </div>

        </div>
    </AppLayout>
</template>