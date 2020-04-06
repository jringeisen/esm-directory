<template>
    <b-modal :id="'view-'+listing.id" @ok="submit" title="View Listing" size="lg">
        <div class="d-flex flex-column align-items-center">
            <b-avatar :src="listing.avatar" variant="secondary" size="6rem"></b-avatar>
            <h3 class="p-3">{{ listing.business_name }}</h3>
        </div>
        <b-tabs content-class="mt-3" align="center">
            <b-tab title="Description"><p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p></b-tab>
            <b-tab title="Packages">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Package One</h5>
                        <small><span class="badge badge-success">$1000</span></small>
                        </div>
                        <p class="mb-1">This package includes 4 hours of shoot time and 200 professionally edited images.</p>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Package Two</h5>
                        <small><span class="badge badge-success">$1500</span></small>
                        </div>
                        <p class="mb-1">This package includes 6 hours of shoot time and 300 professionally edited images.</p>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Package Three</h5>
                        <small><span class="badge badge-success">$3000</span></small>
                        </div>
                        <p class="mb-1">This package includes 8 hours of shoot time and 400 professionally edited images.</p>
                    </a>
                </div>
            </b-tab>
            <b-tab title="Gallery">
                <b-container fluid class="p-4 bg-light">
                    <b-row class="mb-3">
                        <b-col>
                            <b-img thumbnail fluid src="https://picsum.photos/250/250/?image=54" alt="Image 1"></b-img>
                        </b-col>
                        <b-col>
                            <b-img thumbnail fluid src="https://picsum.photos/250/250/?image=58" alt="Image 2"></b-img>
                        </b-col>
                        <b-col>
                            <b-img thumbnail fluid src="https://picsum.photos/250/250/?image=59" alt="Image 3"></b-img>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col>
                            <b-img thumbnail fluid src="https://picsum.photos/250/250/?image=54" alt="Image 1"></b-img>
                        </b-col>
                        <b-col>
                            <b-img thumbnail fluid src="https://picsum.photos/250/250/?image=58" alt="Image 2"></b-img>
                        </b-col>
                        <b-col>
                            <b-img thumbnail fluid src="https://picsum.photos/250/250/?image=59" alt="Image 3"></b-img>
                        </b-col>
                    </b-row>
                </b-container>
            </b-tab>
        </b-tabs>
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
                this.$root.$emit('updateListings')
            })
        }
    }
}
</script>

