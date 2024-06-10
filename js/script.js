document.addEventListener("DOMContentLoaded", function() {
    const quantidadeInput = document.getElementById("quantidade");
    const opcoesCamisasDiv = document.getElementById("opcoesCamisas");

    quantidadeInput.addEventListener("input", function() {
        const quantidade = quantidadeInput.value;
        opcoesCamisasDiv.innerHTML = '';

        for (let i = 0; i < quantidade; i++) {
            const tamanhoDiv = document.createElement("div");
            tamanhoDiv.classList.add("row");

            const tamanhoLabel = document.createElement("label");
            tamanhoLabel.setAttribute("for", `tamanho${i}`);
            tamanhoLabel.textContent = `TAMANHO (Camisa ${i + 1}):`;
            tamanhoDiv.appendChild(tamanhoLabel);

            const tamanhoSelect = document.createElement("select");
            tamanhoSelect.id = `tamanho${i}`;
            tamanhoSelect.name = `tamanho${i}`;
            tamanhoSelect.required = true;
            ["PP", "P", "M", "G", "GG", "EXG"].forEach(tamanho => {
                const option = document.createElement("option");
                option.value = tamanho;
                option.textContent = tamanho;
                tamanhoSelect.appendChild(option);
            });
            tamanhoDiv.appendChild(tamanhoSelect);

            const modeloDiv = document.createElement("div");
            modeloDiv.classList.add("row");
            const modeloLabel = document.createElement("label");
            modeloLabel.textContent = `MODELO (Camisa ${i + 1}):`;
            modeloDiv.appendChild(modeloLabel);

            const modelos = ["Manga", "Regata", "Nadador", "Babylook"];
            const modelOptionsDiv = document.createElement("div");
            modelOptionsDiv.classList.add("model-options");

            modelos.forEach(modelo => {
                const modelItemDiv = document.createElement("div");
                modelItemDiv.classList.add("model-item");

                const modelRadio = document.createElement("input");
                modelRadio.type = "radio";
                modelRadio.id = `${modelo}${i}`;
                modelRadio.name = `modelo${i}`;
                modelRadio.value = modelo;
                modelRadio.required = true;
                modelItemDiv.appendChild(modelRadio);

                const modelLabel = document.createElement("label");
                modelLabel.setAttribute("for", `${modelo}${i}`);
                modelLabel.textContent = modelo;
                modelItemDiv.appendChild(modelLabel);

                modelOptionsDiv.appendChild(modelItemDiv);
            });

            modeloDiv.appendChild(modelOptionsDiv);
            opcoesCamisasDiv.appendChild(tamanhoDiv);
            opcoesCamisasDiv.appendChild(modeloDiv);
        }
    });

    // Dispara o evento input para inicializar a quantidade
    quantidadeInput.dispatchEvent(new Event('input'));
});
