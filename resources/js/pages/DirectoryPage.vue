<template>
  <div class="pt-5">
    <div class="row justify-content-center">
      <div class="col-md-10 pb-3">
        <b-form-input
          id="search"
          v-model="search"
          placeholder="Search by name, location, or keywords...."
        />
      </div>
      <div class="col-md-10">
        <div
          v-if="!filterListings.length"
          class="card text-center no-results"
        >
          <div class="card-body">
            <h5 class="card-title">
              The search term '{{ search }}' returned no results!
            </h5>
            <p class="card-text">
              You can search by city, state, business name, or general keywords. If no results are returned you may need to change up your search.
            </p>
          </div>
        </div>
      </div>
    </div>
    <div 
      class="listings"
      v-if="filterListings.length">
      <div
        v-for="(item, index) in filterListings"
        :key="index"
        class="row justify-content-center pb-3"
      >
        <div class="col-md-10">
          <b-card
            v-b-modal="'view-'+item.id"
            no-body
            class="overflow-hidden shadow card"
            @click.prevent="setModalData(item)"
          >
            <b-row
              no-gutters
              class="d-flex align-items-center"
            >
              <b-col
                md="2"
                class="d-flex justify-content-center"
              >
                <b-avatar
                  variant="secondary"
                  :src="item.avatar"
                  size="5rem"
                />
              </b-col>
              <b-col md="10">
                <b-card-body>
                  <b-card-title><h4>{{ item.business_name }}</h4> <small class="badge badge-secondary float-right">Starting Package: ${{ item.starting_package }}</small></b-card-title>
                  <b-card-sub-title><i class="fas fa-map-marker-alt" /> {{ item.city + ', ' + item.state }}</b-card-sub-title>
                  <b-card-text>
                    {{ item.description | truncate(400) }}
                  </b-card-text>
                </b-card-body>
              </b-col>
            </b-row>
          </b-card>
        </div>
      </div>
    </div>
    <view-listing-modal
      :listing="listing"
      :packages="packages"
    />
  </div>
</template>

<script>
import ViewListingModal from '../modals/listings/ViewListingModal.vue'
import SetModalData from '../mixins/SetModalData.js'
import axios from 'axios'
export default {
  components: {
    ViewListingModal
  },
  mixins: [SetModalData],
  data () {
    return {
      listings: [],
      listing: {},
      packages: [],
      search: ''
    }
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
  created () {
    this.getListings()
  },
  methods: {
    getListings () {
      axios.get('/').then((response) => {
        this.listings = response.data
      }).catch((error) => {
        console.log(error)
      })
    }
  }
}
</script>
