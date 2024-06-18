<script>
    import { onMount, afterUpdate, createEventDispatcher } from 'svelte';
    import 'datatables.net-dt/css/jquery.dataTables.css';
    import jQuery from 'jquery';
    import 'datatables.net';
    import axios from 'axios';
    import './styles/custom.css'; // Asegúrate de que la ruta sea correcta
    import { createEmployee } from './services/employeeService'; // Importa el servicio de creación de empleados

    export let employees = [];
    export let favorites = [];
    const dispatch = createEventDispatcher();

    let table;
    let showModal = false;

    const fetchData = async (length = 5, start = 0, search = '') => {
        try {
            const response = await axios.get('http://localhost:8000/api/employees', { // Verifica que esta URL es correcta
                params: {
                    limit: length,
                    start: start,
                    search: search
                }
            });
            console.log('Response data:', response.data);
            employees = response.data.data; // Ajusta según la estructura de tu respuesta
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    };

    const initializeDataTable = () => {
        table = jQuery('#employeeTable').DataTable({
            serverSide: true,
            ajax: (data, callback) => {
                fetchData(data.length, data.start, data.search.value).then(() => {
                    callback({
                        draw: data.draw,
                        recordsTotal: employees.length,
                        recordsFiltered: employees.length,
                        data: employees.map(employee => {
                            const isFavorite = favorites.some(fav => fav.id === employee.id);
                            return [
                                employee.name,
                                employee.email,
                                `<img src="${employee.logo}" alt="${employee.company} logo" width="50" height="50"> ${employee.company}`,
                                employee.category,
                                employee.satisfaction_level,
                                `<button class="btn btn-primary btn-sm add-to-favorites" data-id="${employee.id}" ${isFavorite ? 'disabled' : ''}>Add to Favorites</button>`
                            ];
                        })
                    });
                });
            },
            columns: [
                { title: "Name" },
                { title: "Email" },
                { title: "Company" },
                { title: "Category" },
                { title: "Satisfaction Level" },
                { title: "Actions", orderable: false }
            ],
            pageLength: 5,
            paging: true,
            searching: true,
            destroy: true,
            dom: '<"d-flex justify-content-between"lf>rt<"bottom"ip><"clear">',
            lengthMenu: [5, 10, 15, 20] // Opciones de límite
        });

        jQuery('#employeeTable tbody').on('click', 'button.add-to-favorites', function () {
            const id = jQuery(this).data('id');
            const employee = employees.find(emp => emp.id == id);
            dispatch('addFavorite', employee);
            jQuery(this).prop('disabled', true); // Deshabilitar el botón inmediatamente
        });
    };

    const addEmployee = async (employee) => {
        try {
            await createEmployee(employee);
            await fetchData();
            table.ajax.reload();
        } catch (error) {
            console.error('Error creating employee:', error);
        }
    };

    onMount(() => {
        initializeDataTable();
    });

    afterUpdate(() => {
        if (jQuery.fn.DataTable.isDataTable('#employeeTable')) {
            table.ajax.reload();
        }
    });
</script>

<!-- Botón para abrir el modal de creación de empleado -->
<button class="btn btn-success mb-3" on:click={() => showModal = true}>Crear Empleado</button>

<!-- Modal para crear un nuevo empleado -->
{#if showModal}
    <div class="modal show d-block" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Empleado</h5>
                    <button type="button" class="close" on:click={() => showModal = false}>&times;</button>
                </div>
                <div class="modal-body">
                    <form on:submit|preventDefault={async (e) => {
                        const formData = new FormData(e.target);
                        const employee = {
                            name: formData.get('name'),
                            email: formData.get('email'),
                            company: formData.get('company'),
                            category: formData.get('category'),
                            satisfaction_level: formData.get('satisfaction_level'),
                            logo: formData.get('logo')
                        };
                        await addEmployee(employee);
                        showModal = false;
                    }}>
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="company">Empresa</label>
                            <input type="text" class="form-control" id="company" name="company" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Categoría</label>
                            <input type="text" class="form-control" id="category" name="category" required>
                        </div>
                        <div class="form-group">
                            <label for="satisfaction_level">Nivel de Satisfacción</label>
                            <input type="number" class="form-control" id="satisfaction_level" name="satisfaction_level" required min="0" max="100">
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="text" class="form-control" id="logo" name="logo">
                        </div>
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
{/if}

<table id="employeeTable" class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Company</th>
            <th>Category</th>
            <th>Satisfaction Level</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        {#each employees as employee}
            <tr>
                <td>{employee.name}</td>
                <td>{employee.email}</td>
                <td>
                    <img src="{employee.logo}" alt="{employee.company} logo" width="50" height="50"> {employee.company}
                </td>
                <td>{employee.category}</td>
                <td>{employee.satisfaction_level}</td>
                <td>
                    <button class="btn btn-primary btn-sm add-to-favorites" on:click={() => dispatch('addFavorite', employee)} disabled={favorites.some(fav => fav.id === employee.id)}>Add to Favorites</button>
                </td>
            </tr>
        {/each}
    </tbody>
</table>
