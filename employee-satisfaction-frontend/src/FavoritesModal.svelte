<script>
    import { createEventDispatcher } from 'svelte';

    export let favorites = [];

    const dispatch = createEventDispatcher();
    let searchQuery = '';

    const removeFromFavorites = (favorite) => {
        favorites = favorites.filter(f => f.id !== favorite.id);
        dispatch('updateFavorites', favorites);
    };

    // Función para filtrar los favoritos según el término de búsqueda
    $: filteredFavorites = favorites.filter(favorite =>
        favorite.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
        favorite.company.toLowerCase().includes(searchQuery.toLowerCase()) ||
        favorite.category.toLowerCase().includes(searchQuery.toLowerCase())
    );
</script>

<div class="modal fade" id="favoritesModal" tabindex="-1" aria-labelledby="favoritesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="favoritesModalLabel">Favorites</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control mb-3" placeholder="Search by name, company or category" bind:value={searchQuery} />

                <ul class="list-group">
                    {#each filteredFavorites as favorite}
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {favorite.name} - {favorite.company} - {favorite.category}
                            <button class="btn btn-danger btn-sm" on:click={() => removeFromFavorites(favorite)}>Remove</button>
                        </li>
                    {/each}
                </ul>
            </div>
        </div>
    </div>
</div>
