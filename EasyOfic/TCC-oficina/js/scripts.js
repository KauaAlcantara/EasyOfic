// Função para exibir a seção selecionada
function showSection(sectionId) {
    const sections = document.querySelectorAll('.content > div');
    sections.forEach(section => section.classList.add('hidden'));
    document.getElementById(sectionId).classList.remove('hidden');
    hideFeedback();
}

// Função para ocultar a mensagem de feedback
function hideFeedback() {
    document.getElementById('feedback').classList.add('hidden');
}

// Função para exibir uma mensagem de feedback após o envio do formulário
function showFeedback(message) {
    const feedbackElement = document.getElementById('feedback');
    document.getElementById('feedbackMessage').textContent = message;
    feedbackElement.classList.remove('hidden');
    setTimeout(hideFeedback, 3000); // Oculta a mensagem após 3 segundos
}

// Função de tratamento de envio dos formulários
function handleSubmit(event, sectionName) {
    event.preventDefault(); // Impede o envio do formulário
    showFeedback(`${sectionName.charAt(0).toUpperCase() + sectionName.slice(1)} cadastrado com sucesso!`);
    event.target.reset(); // Reseta o formulário após o envio
}
