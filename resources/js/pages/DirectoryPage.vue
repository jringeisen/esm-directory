<template>
    <div class="pt-5">
        <div class="row justify-content-center">
            <div class="col-md-10 pb-3">
                <b-form-input v-model="search" placeholder="Search by name, location, or keywords...."></b-form-input>
            </div>
            <div class="col-md-10">
                <div class="card text-center" v-if="!filterListings.length">
                    <div class="card-body">
                        <h5 class="card-title">The search term '{{ search }}' returned no results!</h5>
                        <p class="card-text">You can search by city, state, business name, or general keywords. If no results are returned you may need to change up your search.</p>
                    </div>
                </div>
            </div>
        </div>
        <div v-for="(listing, index) in filterListings" :key="index" class="row justify-content-center pb-3">
            <div class="col-md-10">
                <b-card no-body class="overflow-hidden shadow card" v-b-modal="'view-'+listing.id" @click.prevent="setId(listing)">
                    <b-row no-gutters class="d-flex align-items-center">
                        <b-col md="2" class="d-flex justify-content-center">
                            <b-avatar variant="secondary" :src="listing.avatar" size="5rem"></b-avatar>
                        </b-col>
                        <b-col md="10">
                            <b-card-body>
                                <b-card-title>{{ listing.business_name }} <small class="badge badge-secondary float-right">Starting Package: ${{ listing.starting_package }}</small></b-card-title>
                                <b-card-sub-title><i class="fas fa-map-marker-alt"></i> {{ listing.city + ', ' + listing.state }}</b-card-sub-title>
                                <b-card-text>
                                    {{ listing.description | truncate(400) }}
                                </b-card-text>
                            </b-card-body>
                        </b-col>
                    </b-row>
                </b-card>
            </div>
        </div>
        <view-listing-modal :listing="listing" :packages="packages" />
    </div>
</template>

<script>
import ViewListingModal from '../modals/listings/ViewListingModal.vue'
export default {
    components: {
        ViewListingModal
    },
    data () {
        return {
            listings: [],
            listing: [],
            packages: [],
            search: ''
        }
    },
    created () {
        this.getListings()
    },
    computed: {
        filterListings () {
            let data = this.listings || []

            data = data.filter((row) => {
                return Object.keys(row).some((key) => {
                    return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1
                })
            })

            return data
        }
    },
    methods: {
        getListings () {
            axios.get('/').then((response) => {
                this.listings = response.data
            })
        },
        setId (listing) {
            this.listing = listing
            this.packages = listing.packages
        }
    }
}
</script>
