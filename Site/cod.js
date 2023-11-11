function searchTCC() {
    const fakeResults = [
        { title: 'TCC 1', preview: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.' },
        { title: 'TCC 2', preview: 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.' },
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
