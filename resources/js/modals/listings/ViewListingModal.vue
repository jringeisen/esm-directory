<template>
    <b-modal :id="'view-'+listing.id" title="View Listing" size="lg" :hide-footer="true">
        <div class="d-flex flex-column align-items-center">
            <b-avatar :src="listing.avatar" variant="secondary" size="6rem"></b-avatar>
            <h3 class="p-3">{{ listing.business_name }}</h3>
        </div>
        <b-tabs content-class="mt-3" align="center" lazy>
            <b-tab title="Description"><p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p></b-tab>
            <b-tab title="Packages">
                <div class="list-group">
                    <div v-if="!packages.length">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">I have not added my packages yet.</h5>
                                <p class="card-text">If you would like to know my prices please push the button below to email me.</p>
                                <a href="mailto:support@essentialstudiomanager.com" class="btn btn-secondary">Email Photographer</a>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="list-group-item list-group-item-action" v-for="(item, index) in packages" :key="index">
                        <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ item.name }}</h5>
                        <small><span class="badge badge-success">{{ item.amount | currency }}</span></small>
                        </div>
                        <p class="mb-1">{{ item.description }}</p>
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
        },
        packages: {
            required: true
        }
    }
}
</script>

