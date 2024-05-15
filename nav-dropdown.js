// Seleciona o elemento dropdown
const dropdown = document.getElementById('dropdownSport');

// Adiciona um listener de evento para quando o mouse passa sobre o texto "Desporto"
dropdown.addEventListener('mouseover', function() {
    // Abre o dropdown alterando a classe para "show"
    this.querySelector('.dropdown-content').classList.add('show');
});

// Adiciona um listener de evento para quando o mouse deixa o dropdown
dropdown.addEventListener('mouseleave', function() {
    // Fecha o dropdown removendo a classe "show"
    this.querySelector('.dropdown-content').classList.remove('show');
});


    function setDesporto(desporto) {
        document.cookie = "desporto=" + desporto + ";path=/";
    }

