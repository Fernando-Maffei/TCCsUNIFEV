function searchTCC() {
    var searchCriteria = document.getElementById("searchCriteria").value;
    var searchTerm = document.getElementById("searchInput").value;

    console.log("Critério de pesquisa: " + searchCriteria);
    console.log("Termo de pesquisa: " + searchTerm);
}

function searchTCC() {
    const fakeResults = [
        { title: 'TCC 1', preview: '' },
        { title: 'TCC 2', preview: '' },
    ];

    displayResults(fakeResults);
}

function displayResults(results) {
    const resultsContainer = document.getElementById('searchResults');
    resultsContainer.innerHTML = '';

    if (results.length === 0) {
        resultsContainer.innerHTML = 'Nenhum resultado encontrado.';
    } else {
        results.forEach(result => {
            const resultElement = document.createElement('div');
            resultElement.innerHTML = `<h3>${result.title}</h3><p>${result.preview}</p>`;
            resultsContainer.appendChild(resultElement);
        });
    }
}
