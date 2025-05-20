document.addEventListener('DOMContentLoaded', function() {
    const uploadForm = document.getElementById('uploadForm');
    const resultCard = document.getElementById('resultCard');
    const resultMessage = document.getElementById('resultMessage');
    const previewTable = document.getElementById('previewTable');
    
    uploadForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Mostrar loading
        resultMessage.innerHTML = '<p>Procesando archivo, por favor espere...</p>';
        resultCard.style.display = 'block';
        
        fetch('upload.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                resultMessage.innerHTML = `<div class="success-message">${data.message}</div>`;
                
                // Generar tabla de vista previa
                if(data.preview && data.preview.length > 0) {
                    let table = '<table>';
                    
                    // Cabeceras
                    table += '<tr>';
                    for(const key in data.preview[0]) {
                        table += `<th>${key}</th>`;
                    }
                    table += '</tr>';
                    
                    // Datos
                    data.preview.forEach(row => {
                        table += '<tr>';
                        for(const key in row) {
                            table += `<td>${row[key]}</td>`;
                        }
                        table += '</tr>';
                    });
                    
                    table += '</table>';
                    previewTable.innerHTML = table;
                } else {
                    previewTable.innerHTML = '<p>No hay datos para mostrar.</p>';
                }
                
            } else {
                resultMessage.innerHTML = `<div class="error-message">${data.message}</div>`;
                previewTable.innerHTML = '';
            }
        })
        .catch(error => {
            resultMessage.innerHTML = `<div class="error-message">Error en la solicitud: ${error.message}</div>`;
            previewTable.innerHTML = '';
        });
    });
    
    // Reset del formulario
    uploadForm.addEventListener('reset', function() {
        resultCard.style.display = 'none';
        resultMessage.innerHTML = '';
        previewTable.innerHTML = '';
    });
});
