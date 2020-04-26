<template>
  <b-modal
    :id="$options.name"
    title="Delete Package"
    @shown="shown"
  >
    <div class="alert alert-danger">
      Are you sure you want to delete this package?
    </div>
    <div slot="modal-footer">
      <button
        class="btn btn-outline-secondary"
        @click.prevent="closeModal"
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
  name: 'DeletePackageModal',
  mixins: [
    ModalActions
  ],
  props: {
    package: {
      type: Object,
      required: true,
      default: () => {}
    }
  },
  methods: {
    shown () {
      this.formData = this.package
    },
    submit (evt) {
      evt.preventDefault()

      this.deleteItem('/api/packages/')
    }
  }
}
</script>
