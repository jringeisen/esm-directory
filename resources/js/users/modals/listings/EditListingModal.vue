<template>
  <b-modal
    :id="$options.name"
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
        @click.prevent="closeModal($options.name)"
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
import ModalActions from '../../../mixins/ModalActions.js'
export default {
  name: 'EditListingModal',
  mixins: [
    ModalActions
  ],
  props: {
    item: {
      required: true,
      type: Object
    }
  },
  data () {
    return {
      listings: {},
    }
  },
  methods: {
    submit (evt) {
      evt.preventDefault()
      
      // Accepts two params: URL, name for $emit event.
      this.updateItem('/api/listings/', 'getUser')
    }
  }
}
</script>
