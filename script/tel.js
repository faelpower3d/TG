function aplicarFormatoTelefone(event) {
    var input = event.target;
    var telefone = input.value.replace(/\D/g, ''); // Remove caracteres não numéricos
    telefone = telefone.replace(/(\d{2})(\d)/, '($1) $2'); // Adiciona parênteses e espaço
    telefone = telefone.replace(/(\d{5})(\d)/, '$1-$2'); // Adiciona o hífen
    input.value = telefone;
}