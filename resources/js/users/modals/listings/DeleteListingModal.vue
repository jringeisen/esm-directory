<template>
  <b-modal
    :id="$options.name"
    title="Delete Listing"
    @shown="shown"
  >
    <div class="alert alert-danger">
      Are you sure you want to delete this listing?
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
  name: 'DeleteListingModal',
  mixins: [
    ModalActions
  ],
  props: {
    item: {
      type: Object,
      required: true,
      default: () => {}
    }
  },
  methods: {
    submit (evt) {
      evt.preventDefault()

      // Accepts two params: URL, name for $emit event.
      this.deleteItem('/api/listings/', 'getUser')
    }
  }
}
</script>

