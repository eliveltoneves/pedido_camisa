document.addEventListener("DOMContentLoaded", function() {
    const quantidadeInput = document.getElementById('quantidade');
    const camisasContainer = document.getElementById('camisas-container');

    function updateCamisaOptions() {
        const quantidade = parseInt(quantidadeInput.value, 10);
        camisasContainer.innerHTML = '';
        
        for (let i = 0; i < quantidade; i++) {
            const camisaDiv = document.createElement('div');
            camisaDiv.className = 'camisa';

            const tamanhoLabel = document.createElement('label');
            tamanhoLabel.htmlFor = `tamanho-${i}`;
            tamanhoLabel.innerText = `Tamanho da Camisa ${i + 1}:`;
            camisaDiv.appendChild(tamanhoLabel);

            const tamanhoSelect = document.createElement('select');
            tamanhoSelect.id = `tamanho-${i}`;
            tamanhoSelect.name = `tamanho[${i}]`;
            ['PP', 'P', 'M', 'G', 'GG', 'EXG'].forEach(size => {
                const option = document.createElement('option');
                option.value = size;
                option.innerText = size;
                tamanhoSelect.appendChild(option);
            });
            camisaDiv.appendChild(tamanhoSelect);

            const modeloLabel = document.createElement('label');
            modeloLabel.htmlFor = `modelo-${i}`;
            modeloLabel.innerText = `Modelo da Camisa ${i + 1}:`;
            camisaDiv.appendChild(modeloLabel);

            ['Manga', 'Regata', 'Nadador', 'Babylook'].forEach(model => {
                const modelItem = document.createElement('div');
                modelItem.className = 'model-item';
                const input = document.createElement('input');
                input.type = 'radio';
                input.id = `modelo-${model}-${i}`;
                input.name = `modelo[${i}]`;
                input.value = model;
                const label = document.createElement('label');
                label.htmlFor = input.id;
                label.innerText = model;
                modelItem.appendChild(input);
                modelItem.appendChild(label);
                camisaDiv.appendChild(modelItem);
            });

            camisasContainer.appendChild(camisaDiv);
        }
    }

    quantidadeInput.addEventListener('change', updateCamisaOptions);
    updateCamisaOptions();
});
