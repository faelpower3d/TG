function buscarEndereco() {
    var cep = document.getElementById('cep').value;
    if (cep.length === 8) { // Verifica se o CEP tem 8 dígitos
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'https://viacep.com.br/ws/' + cep + '/json/', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var dados = JSON.parse(xhr.responseText);
                if (!dados.erro) {
                    document.getElementById('rua').value = dados.logradouro;
                    document.getElementById('estado').value = dados.uf;
                    document.getElementById('cidade').value = dados.localidade;
                    
                } else {
                    alert('CEP não encontrado.');
                    document.getElementById('rua').value = '';
                    document.getElementById('estado').value = '';
                    document.getElementById('cidade').value = '';
                    
                }
            }
        };
        xhr.send();
    } else {
        document.getElementById('rua').value = '';
        document.getElementById('estado').value = '';
        document.getElementById('cidade').value = '';
        
    }
}