<template>
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Business Name</th>
                        <th>Location</th>
                        <th>Description</th>
                        <th>Starting Price</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(listing, index) in listings" :key="index">
                        <td class="align-middle"><b-avatar :src="listing.avatar"></b-avatar></td>
                        <td class="align-middle">{{ listing.business_name }}</td>
                        <td class="align-middle">{{ listing.city + ', ' + listing.state }}</td>
                        <td width="40%" class="align-middle">{{ listing.description | truncate(100) }}</td>
                        <td class="align-middle">{{ listing.starting_package | currency }}</td>
                        <td class="text-right align-middle">
                            <b-button v-b-modal="'edit-'+listing.id" @click.prevent="setId(listing)" class="btn btn-sm btn-secondary"><i class="fas fa-edit"></i></b-button>
                            <b-button v-b-modal="'delete-'+listing.id" @click.prevent="setId(listing)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></b-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <edit-listing-modal :listing="listing" />
        <delete-listing-modal :listing="listing" />
    </div>
</template>

<script>
import EditListingModal from '../modals/EditListingModal.vue'
import DeleteListingModal from '../modals/DeleteListingModal.vue'

export default {
    props: {
        listings: {
            require: true
        }
    },
    components: {
        EditListingModal,
        DeleteListingModal
    },
    data () {
        return {
            listing: {}
        }
    },
    methods: {
        setId (listing) {
            this.listing = listing
        }
    }
}
</script>

