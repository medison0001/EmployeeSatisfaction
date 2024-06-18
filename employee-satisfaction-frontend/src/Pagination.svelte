<script>
    import { createEventDispatcher } from 'svelte';

    export let currentPage;
    export let totalPages;

    const dispatch = createEventDispatcher();

    const changePage = (page) => {
        dispatch('pageChange', page);
    };
</script>

<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <li class="page-item {currentPage === 1 ? 'disabled' : ''}">
            <button class="page-link" on:click|preventDefault={() => changePage(currentPage - 1)}>Previous</button>
        </li>
        <li class="page-item disabled">
            <span class="page-link">Page {currentPage} of {totalPages}</span>
        </li>
        <li class="page-item {currentPage === totalPages ? 'disabled' : ''}">
            <button class="page-link" on:click|preventDefault={() => changePage(currentPage + 1)}>Next</button>
        </li>
    </ul>
</nav>
