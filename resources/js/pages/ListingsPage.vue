<template>
    <div class="card shadow">
        <div class="card-body">
            <div class="text-center" v-if="!listings.length">
                <h5 class="card-title">You don't have any listings</h5>
                <p class="card-text">To get started click the button below and create your first listing.</p>
                <button class="btn btn-secondary" v-b-modal="'create-listing'">Create Listings</button>
            </div>
            <table class="table table-hover" v-if="listings.length">
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
                            <b-dropdown id="dropdown-1" no-caret dropright variant="white" class="m-md-2">
                                <template v-slot:button-content>
                                    <i class="fas fa-ellipsis-v"></i>
                                </template>
                                <b-dropdown-item v-b-modal="'view-'+listing.id" @click.prevent="setId(listing)">View</b-dropdown-item>
                                <b-dropdown-item v-b-modal="'edit-'+listing.id" @click.prevent="setId(listing)">Edit</b-dropdown-item>
                                <b-dropdown-item v-b-modal="'delete-'+listing.id" @click.prevent="setId(listing)">Delete</b-dropdown-item>
                            </b-dropdown>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <create-listing-modal />
        <view-listing-modal :listing="listing" :packages="packages" />
        <edit-listing-modal :listing="listing" />
        <delete-listing-modal :listing="listing" />
    </div>
</template>

<script>
import CreateListingModal from '../modals/CreateListingModal.vue'
import ViewListingModal from '../modals/ViewListingModal.vue'
import EditListingModal from '../modals/EditListingModal.vue'
import DeleteListingModal from '../modals/DeleteListingModal.vue'

export default {
    components: {
        CreateListingModal,
        ViewListingModal,
        EditListingModal,
        DeleteListingModal
    },
    data () {
        return {
            user: {},
            listings: {},
            packages: {},
            listing: {}
        }
    },
    created () {
        this.getUser()

        this.$root.$on('updateListings', () => {
            this.getUser()
        })
    },
    methods: {
        getUser () {
            axios.get('/listings').then((response) => {
                this.user = response.data
                this.listings = this.user.listings
                this.packages = this.user.packages
            })
        },
        setId (listing) {
            this.listing = listing
        }
    }
}
</script>

