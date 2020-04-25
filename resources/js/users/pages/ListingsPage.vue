<template>
  <div class="card shadow">
    <div class="card-header">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <span>Listings</span>

        <button
          @click.prevent="openModal('CreateListingModal')"
          class="btn btn-sm btn-secondary"
        >
          Create Listing
        </button>
      </div>
    </div>
    <div class="card-body">
      <div
        v-if="!listings.length"
        class="text-center"
      >
        <h5 class="card-title">
          You don't have any listings
        </h5>
        <p class="card-text">
          To get started click the button below and create your first listing.
        </p>
        <button
          id="createListingButton"
          v-b-modal="'create-listing'"
          class="btn btn-secondary"
        >
          Create Listing
        </button>
      </div>
      <div v-if="listings.length">
        <table class="table table-borderless table-hover">
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
            <tr
              v-for="(item, index) in listings"
              :key="index"
            >
              <td class="align-middle">
                <b-avatar :src="item.avatar" />
              </td>
              <td class="align-middle">
                {{ item.business_name }}
              </td>
              <td class="align-middle">
                {{ item.city + ', ' + item.state }}
              </td>
              <td
                width="40%"
                class="align-middle"
              >
                {{ item.description | truncate(100) }}
              </td>
              <td class="align-middle">
                {{ item.starting_package | currency }}
              </td>
              <td class="text-right align-middle">
                <b-dropdown
                  id="dropdown-1"
                  no-caret
                  dropright
                  variant="white"
                  class="m-md-2"
                >
                  <template #button-content>
                    <i class="fas fa-ellipsis-v" />
                  </template>
                  <b-dropdown-item
                    @click.prevent="openModal('CreatePackageModal', item)"
                  >
                    Add Package
                  </b-dropdown-item>
                  <b-dropdown-item
                    @click.prevent="openModal('ViewListingModal', item)"
                  >
                    View Listing
                  </b-dropdown-item>
                  <b-dropdown-item
                    @click.prevent="openModal('EditListingModal', item)"
                  >
                    Edit Listing
                  </b-dropdown-item>
                  <b-dropdown-item
                    @click.prevent="openModal('DeleteListingModal', item)"
                  >
                    Delete Listing
                  </b-dropdown-item>
                </b-dropdown>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <create-listing-modal />
    <create-package-modal :listing="listing" />
    <view-listing-modal
      :listing="listing"
      :packages="packages"
      :user="user"
    />
    <edit-listing-modal :listing="modalData" />
    <delete-listing-modal :listing="listing" />
  </div>
</template>

<script>
import CreateListingModal from '../modals/listings/CreateListingModal.vue'
import CreatePackageModal from '../modals/packages/CreatePackageModal.vue'
import ViewListingModal from '../modals/listings/ViewListingModal.vue'
import EditListingModal from '../modals/listings/EditListingModal.vue'
import DeleteListingModal from '../modals/listings/DeleteListingModal.vue'
import ModalActions from '../../mixins/ModalActions.js'
import axios from 'axios'
export default {
  name: 'ListingsPage',
  components: {
    CreateListingModal,
    CreatePackageModal,
    ViewListingModal,
    EditListingModal,
    DeleteListingModal
  },
  mixins: [ModalActions],
  data () {
    return {
      user: {},
      listings: [],
      packages: [],
      listing: {}
    }
  },
  created () {
    this.getUser()

    this.$root.$on('updateUser', () => {
      this.getUser()
    })
  },
  methods: {
    getUser () {
      axios.get('/api/user').then((response) => {
        this.user = response.data
        this.listings = this.user.listings
      }).catch((error) => {
        console.log(error)
      })
    }
  }
}
</script>
