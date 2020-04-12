<template>
  <b-modal
    :id="'edit-'+listing.id"
    :ref="'edit-'+listing.id+'-modal'"
    title="Edit Listing"
    @shown="shown"
    @ok="submit"
  >
    <div class="form-group">
      <label for="name">Name</label>
      <input
        v-model="formData.name"
        type="text"
        class="form-control"
      > 
    </div>
    <div class="form-group">
      <label for="business_name">Business Name</label>
      <input
        v-model="formData.business_name"
        type="text"
        class="form-control"
      > 
    </div>
    <div class="form-group">
      <label for="city">City</label>
      <input
        v-model="formData.city"
        type="text"
        class="form-control"
      > 
    </div>
    <div class="form-group">
      <label for="state">State</label>
      <input
        v-model="formData.state"
        type="text"
        class="form-control"
      > 
    </div>
    <div class="form-group">
      <label for="starting_package">Starting Package Price</label>
      <input
        v-model="formData.starting_package"
        type="number"
        class="form-control"
      > 
    </div>
    <div class="form-group">
      <label for="description">Description</label>
      <textarea
        v-model="formData.description"
        class="form-control"
        rows="4"
      />
    </div>
    <div slot="modal-footer">
      <button
        class="btn btn-outline-secondary"
        @click.prevent="hideModal(listing.id)"
      >
        Cancel
      </button>
      <button
        class="btn btn-secondary"
        :disabled="isLoading"
        @click.prevent="submit"
      >
        <b-spinner
          v-if="isLoading"
          small
          type="grow"
        />
        {{ isLoading ? 'Loading...' : 'Submit' }}
      </button>
    </div>
  </b-modal>
</template>

<script>
import ToastMixin from '../../mixins/ToastMixin.js'
export default {
  mixins: [ToastMixin],
  props: {
    listing: {
      required: true,
      type: Object
    }
  },
  data () {
    return {
      listings: {},
      formData: {},
      isLoading: false
    }
  },
  methods: {
    shown () {
      this.formData = this.listing
    },
    submit () {
      this.isLoading = true
      axios.put(`/listings/${this.listing.id}`, this.formData).then((response) => {
        this.isLoading = false
        this.hideModal()
        this.toast('success', 'Success!', 'Your listing was deleted successfully!')
      })
    },
    hideModal (id) {
      this.$refs['edit-'+id+'-modal' ].hide()
    }
  }
}
</script>
