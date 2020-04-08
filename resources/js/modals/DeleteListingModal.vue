<template>
    <b-modal :id="'delete-'+listing.id" @ok="submit" title="Delete Listing">
        <div class="alert alert-danger">Are you sure you want to delete this listing?</div>
    </b-modal>
</template>

<script>
export default {
    props: {
        listing: {
            required: true
        }
    },
    methods: {
        submit () {
            axios.delete(`/listings/${this.listing.id}`).then((response) => {
                this.$root.$emit('updateUser')
            })
        }
    }
}
</script>

