<template>
  <div class="pt-5">
    <div class="d-flex flex-column justify-content-center">
      <div class="col-md-12 pb-3">
        Total Records Found: <strong>{{ filterListings.length }}</strong>
      </div>
      <div class="col-md-12 pb-3">
        <b-form-input
          id="search"
          :debounce="300"
          v-model="search"
          autocomplete="off"
          placeholder="Search by name, location, category or any keywords...."
        />
      </div>
      <div class="col-md-12">
        <div
          v-if="!filterListings.length"
          class="card text-center no-results"
        >
          <div class="card-body">
            <h5
              class="card-title"
              v-if="!status"
            >
              <span v-if="!search">Enter a search term to begin finding photographers!</span>
              <span v-if="search && filterListings.length === 0">Search term "{{ search }}" returned no results!</span>
            </h5>
            <div
              class="alert alert-danger"
              v-if="status"
            >
              {{ status }}
            </div>
            <p class="card-text">
              You can search by city, state, business name, or general keywords. If no results are returned you may need to change up your search.
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex flex-column justify-content-between">
      <div 
        class="listings"
        v-if="filterListings.length"
      >
        <div
          v-for="(item, index) in filterListings"
          :key="index"
          class="pb-3"
        >
          <div class="col-12">
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
                <div class="col-lg-2 col-md-12 col-sm-12 text-center p-4">
                  <b-avatar
                    variant="secondary"
                    :src="item.avatar"
                    size="5rem"
                  />
                </div>
                <div class="col-lg-10 col-md-12 col-sm-12">
                  <b-card-body>
                    <b-card-title>
                      <div class="d-flex flex-lg-row flex-column text-center justify-content-between">
                        <h4>{{ item.business_name }}</h4>
                        <h4>
                          <b-badge variant="secondary">
                            Starting Package: ${{ item.starting_package }}
                          </b-badge>
                        </h4>
                      </div>
                    </b-card-title>
                    <b-card-sub-title class="d-flex flex-lg-row flex-column text-center">
                      <span><i class="fas fa-map-marker-alt" /> {{ item.city + ', ' + item.state }} | {{ item.category }}</span>
                    </b-card-sub-title>
                    <b-card-text>
                      {{ item.description | truncate(400) }}
                    </b-card-text>
                  </b-card-body>
                </div>
              </b-row>
            </b-card>
          </div>
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
      isLoading: false,
      listings: [],
      listing: {},
      packages: [],
      search: '',
      status: '',
    }
  },
  computed: {
    filterListings () {
      if (this.search) {
        let data = this.listings || []

        data = data.filter((row) => {
          return Object.keys(row).some((key) => {
            return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1
          })
        })

        if (data.length > 50) {
          this.status = "Your search has returned more than 50 records. Try narrowing down your search more to narrow down your results."
          return []
        }

        return data
      } else {
        return []
      }
    }
  },
  created () {
    this.getListings()
  },
  methods: {
    getListings () {
      axios.get('/api/directory').then((response) => {
        this.listings = response.data
      }).catch((error) => {
        console.log(error)
      })
    }
  }
}
</script>
