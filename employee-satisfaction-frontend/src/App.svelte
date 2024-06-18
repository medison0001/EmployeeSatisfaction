<script>
    import { onMount } from 'svelte';
    import axios from 'axios';
    import EmployeeList from './EmployeeList.svelte';
    import Pagination from './Pagination.svelte';
    import FavoritesModal from './FavoritesModal.svelte';
    import 'bootstrap/dist/css/bootstrap.min.css';
    import 'bootstrap/dist/js/bootstrap.bundle.min.js';

    let employees = [];
    let favorites = [];
    let currentPage = 1;
    let totalPages = 1;

    const fetchEmployees = async (page = 1) => {
        const response = await axios.get(`http://localhost:8000/api/employees`, {
            params: {
                page: page
            }
        });
        employees = response.data.data;
        currentPage = response.data.current_page;
        totalPages = response.data.last_page;
    };

    const handlePageChange = (event) => {
        fetchEmployees(event.detail);
    };

    const addToFavorites = (event) => {
        const employee = event.detail;
        if (!favorites.some(fav => fav.id === employee.id)) {
            favorites = [...favorites, employee];
        }
    };

    const updateFavorites = (event) => {
        favorites = event.detail;
    };

    onMount(() => {
        fetchEmployees();
    });
</script>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Employee Satisfaction</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#favoritesModal">View Favorites</button>
            </li>
        </ul>
    </div>
</nav>

<main class="container mt-5">
    <EmployeeList {employees} {favorites} on:addFavorite={addToFavorites} />
    <Pagination {currentPage} {totalPages} on:pageChange={handlePageChange} />
    <FavoritesModal {favorites} on:updateFavorites={updateFavorites} />
</main>
