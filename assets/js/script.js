function vote(candidato) {
    // Enviar o voto para o servidor via PHP
    fetch('votar.php', {
        method: 'POST',
        body: new URLSearchParams({ candidato: candidato })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Exibir agradecimento
            document.getElementById('votacao-sucesso').style.display = 'block';

            // Exibir as percentagens de votos
            let resultadosHTML = '<h3>Resultados da Votação:</h3>';
            data.percentagens.forEach(result => {
                resultadosHTML += `
                    <p>${result.candidato}: ${result.percentagem}% (${result.votos} votos)</p>
                `;
            });
            resultadosHTML += `<p>Total de votos: ${data.total_votos}</p>`;

            // Exibir resultados na página
            document.getElementById('votacao-sucesso').innerHTML += resultadosHTML;
        }
    })
    .catch(error => console.error('Erro ao votar:', error));
}
