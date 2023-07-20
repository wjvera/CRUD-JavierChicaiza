document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('crudForm');
    const tableBody = document.querySelector('#data tbody');
    const messageDiv = document.getElementById('message');
    let currentId = null;

    function clearForm() {
        form.reset();
        currentId = null;
    }

    function showMessage(message, isSuccess = true) {
        messageDiv.textContent = message;
        messageDiv.style.color = isSuccess ? 'green' : 'red';
        setTimeout(function () {
            messageDiv.textContent = '';
        }, 3000);
    }

    function fetchData() {
        fetch('api.php')
            .then(response => response.json())
            .then(data => {
                tableBody.innerHTML = '';
                data.forEach(row => {
                    tableBody.innerHTML += `
                        <tr>
                            <td>${row.id}</td>
                            <td>${row.nombre}</td>
                            <td>${row.edad}</td>
                            <td>
                                <button onclick="editData(${row.id})">Editar</button>
                                <button onclick="deleteData(${row.id})">Borrar</button>
                            </td>
                        </tr>
                    `;
                });
            })
            .catch(error => console.error('Error al obtener los datos:', error));
    }

    function saveData(event) {
        event.preventDefault();
        const formData = new FormData(form);
        const postData = {};
        formData.forEach((value, key) => { postData[key] = value; });

        const url = currentId ? `api.php?id=${currentId}` : 'api.php';
        const method = currentId ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            body: JSON.stringify(postData),
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                clearForm();
                showMessage(data.message);
                fetchData();
            })
            .catch(error => console.error('Error al guardar los datos:', error));
    }

    function editData(id) {
        fetch(`api.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('id').value = data.id;
                document.getElementById('nombre').value = data.nombre;
                document.getElementById('edad').value = data.edad;
                currentId = data.id;
            })
            .catch(error => console.error('Error al obtener los datos para editar:', error));
    }

    function deleteData(id) {
        if (confirm('¿Estás seguro de que deseas borrar este registro?')) {
            fetch(`api.php?id=${id}`, {
                method: 'DELETE'
            })
                .then(response => response.json())
                .then(data => {
                    showMessage(data.message);
                    fetchData();
                })
                .catch(error => console.error('Error al borrar los datos:', error));
        }
    }

    form.addEventListener('submit', saveData);

    fetchData();
});
