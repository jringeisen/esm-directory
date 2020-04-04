<template>
    <div class="pt-5">
        <div class="row justify-content-center">
            <div class="col-md-10 pb-3">
                <b-form-input v-model="search" placeholder="Search by name, location, or keywords...."></b-form-input>
            </div>
        </div>
        <div v-for="(listing, index) in filterListings()" :key="index" class="row justify-content-center pb-3">
            <div class="col-md-10">
                <b-card no-body class="overflow-hidden shadow card">
                    <b-row no-gutters class="d-flex align-items-center">
                        <b-col md="2" class="d-flex justify-content-center">
                            <b-avatar variant="secondary" src="https://placekitten.com/300/300" size="5rem"></b-avatar>
                        </b-col>
                        <b-col md="10">
                            <b-card-body>
                                <b-card-title>{{ listing.business_name }}</b-card-title>
                                <b-card-sub-title><i class="fas fa-map-marker-alt"></i> {{ listing.city + ', ' + listing.state }}</b-card-sub-title>
                                <b-card-text>
                                    {{ listing.description }}
                                </b-card-text>
                            </b-card-body>
                        </b-col>
                    </b-row>
                </b-card>
            </div>
        </div>
    </div>
</template>

<style>
.card {
    cursor: pointer;
    font-size: 12px;
}

.card:hover {
    border-color: #6c757d !important;
    border-width: 1.2px;
}
</style>

<script>
export default {
    props: {
        listings: {
            required: true
        }
    },
    data () {
        return {
            cardHovered: false,
            search: ''
        }
    },
    methods: {
        filterListings () {
            let data = this.listings || []

            data = data.filter(row => {
                return Object.keys(row).some((key) => {
                    return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1
                })
            })

            return data
        }
    }
}
</script>
