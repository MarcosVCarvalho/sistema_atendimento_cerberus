<script setup>
defineProps({
    mensagem: String
});
</script>

<template>
    <div>
        <h1>{{ mensagem }}</h1>
        <p>Laravel + Inertia + Vue funcionando!</p>
    </div>
</template>