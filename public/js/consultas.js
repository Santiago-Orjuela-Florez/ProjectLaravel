document.addEventListener('DOMContentLoaded', function() {
    const btnConsultar = document.getElementById('btn_consultar');

    if (btnConsultar) {
        btnConsultar.addEventListener('click', function() {
            // 1. Extraer la URL y el Token desde los atributos 'data' del botón
            const url = this.getAttribute('data-url');
            const token = this.getAttribute('data-token');

            // 2. Obtener valores de los inputs
            let material = document.getElementsByName('purchase_order')[0].value;
            let documento = document.getElementsByName('material_number')[0].value;

            // 3. Petición Fetch
            fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token
                },
                body: JSON.stringify({ 
                    material: material, 
                    documento: documento 
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Datos recibidos:', data); // Debug: Ver respuesta en consola

                if (data && data.total_quantity !== undefined) {
                    // Rellenar el campo quantity
                    document.getElementsByName('quantity')[0].value = data.total_quantity;
                    
                    // Rellenar el campo 'batch' (principal)
                    if (data.primary_batch) {
                        document.getElementsByName('batch')[0].value = data.primary_batch;
                    }

                    // Rellenar el campo 'batches' (extras)
                    // Si viene vacío, limpiamos el campo para que no quede basura
                    let extraBatchesInput = document.getElementsByName('batches')[0];
                    if (data.extra_batches_list) {
                        extraBatchesInput.value = data.extra_batches_list;
                    } else {
                        extraBatchesInput.value = ''; 
                    }

                    // Rellenar el campo fecha si existe
                    if (data.delivery_date) {
                        document.getElementsByName('delivery_date')[0].value = data.delivery_date;
                    }

                } else {
                    alert("No se encontraron registros para estos criterios.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Ocurrió un error al consultar los datos.");
            });
        });
    }
});
