function fazerEncomenda() {
    const id_camisola = new URLSearchParams(window.location.search).get('id');
    const quantidade = document.getElementById('quantidade').value;
    const tamanho = document.querySelector('.psize.active').textContent;
    const preco = document.getElementById('preco').textContent;

    const url = `pagamento.php?id_camisola=${id_camisola}&quantidade=${quantidade}&tamanho=${tamanho}&preco=${preco}`;

    const width = 800;
    const height = 600;

    const left = (screen.width - width) / 2;
    const top = (screen.height - height) / 2;

    window.open(url, '_blank', `width=${width},height=${height},top=${top},left=${left}`);
}

document.getElementById('comprar-btn').addEventListener('click', fazerEncomenda);


function selectSize(sizeElement) {

    const sizeElements = document.querySelectorAll('.psize');
    sizeElements.forEach(element => {
        element.classList.remove('active');
    });


    sizeElement.classList.add('active');
}

function updatePrice() {
    const quantidade = document.getElementById('quantidade').value;
    const precoContainer = document.getElementById('preco-container');
    const precoBase = parseFloat(precoContainer.dataset.preco.replace(',', '.'));
    const precoDescontoBase = precoContainer.dataset.precoDesconto ? parseFloat(precoContainer.dataset.precoDesconto.replace(',', '.')) : null;

    const precoFinal = precoDescontoBase !== null ? precoDescontoBase : precoBase;
    const precoTotal = quantidade * precoFinal;
    const precoTotalOriginal = quantidade * precoBase;

    const precoElement = document.getElementById('preco');

    if (precoDescontoBase !== null) {
        precoElement.innerHTML = `<strong class="text-danger">${precoTotal.toFixed(2).replace('.', ',')} €</strong>
                                  <span class="text-muted"><s>${precoTotalOriginal.toFixed(2).replace('.', ',')} €</s></span>`;
    } else {
        precoElement.textContent = precoTotal.toFixed(2).replace('.', ',') + ' €';
    }
}

document.getElementById('quantidade').addEventListener('input', updatePrice);
