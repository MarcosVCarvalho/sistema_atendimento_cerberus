export const formatarCpf = (valor) => {
    if (!valor) return '-'

    const cpf = String(valor).replace(/\D/g, '')

    if (cpf.length !== 11) {
        return valor
    }

    return cpf.replace(
        /(\d{3})(\d{3})(\d{3})(\d{2})/,
        '$1.$2.$3-$4'
    )
}

export const formatarTelefone = (valor) => {
    if (!valor) return '-'

    const telefone = String(valor).replace(/\D/g, '')

    if (telefone.length === 11) {
        return telefone.replace(
            /(\d{2})(\d{5})(\d{4})/,
            '($1) $2-$3'
        )
    }

    if (telefone.length === 10) {
        return telefone.replace(
            /(\d{2})(\d{4})(\d{4})/,
            '($1) $2-$3'
        )
    }

    return valor
}