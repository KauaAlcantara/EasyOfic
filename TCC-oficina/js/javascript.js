// scripts.js

function showMessage(message, type) {
  var mensagem = document.createElement('div');
  mensagem.className = 'mensagem ' + type + ' show'; // Adiciona a classe de tipo e mostra a mensagem
  mensagem.textContent = message;

  // Adiciona a mensagem ao corpo da página
  document.body.appendChild(mensagem);

  // Oculta a mensagem após 5 segundos
  setTimeout(() => {
      mensagem.className = 'mensagem ' + type + ' hide'; // Adiciona a classe de esconder e inicia a animação
      setTimeout(() => mensagem.remove(), 500); // Remove o elemento do DOM após a animação
  }, 5000);
}

// Exemplo de uso
document.getElementById('formClientes').addEventListener('submit', function(event) {
  event.preventDefault(); // Previne o comportamento padrão de envio do formulário

  var formData = new FormData(this);

  fetch('cadastro_clientes.php', {
      method: 'POST',
      body: formData
  })
  .then(response => response.json())
  .then(data => {
      if (data.status === 'success') {
          showMessage(data.message, 'success');
      } else {
          showMessage(data.message, 'error');
      }
  })
  .catch(error => {
      showMessage('Erro ao enviar o formulário.', 'error');
  });
});
