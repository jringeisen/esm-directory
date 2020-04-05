<template>
    <b-modal :id="'delete-'+listing.id" title="Delete Listing">
        <div class="alert alert-danger">Are you sure you want to delete this listing?</div>
    </b-modal>
</template>

<script>
export default {
    props: {
        listing: {
            required: true
        }
    }
}
</script>

