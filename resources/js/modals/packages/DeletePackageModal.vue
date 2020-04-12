<template>
  <b-modal
    :id="'delete-package-'+item.id"
    :ref="'delete-package-modal'+item.id"
    title="Delete Package"
  >
    <div class="alert alert-danger">
      Are you sure you want to delete this package?
    </div>
    <div slot="modal-footer">
      <button
        class="btn btn-outline-secondary"
        @click.prevent="hideModal(item.id)"
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
    item: {
      required: true,
      type: Object
    }
  },
  data () {
    return {
      isLoading: false
    }
  },
  methods: {
    submit () {
      this.isLoading = true
      axios.delete(`/packages/${this.item.id}`).then((response) => {
        this.$root.$emit('updateUser')
        this.isLoading = false
        this.hideModal()
        this.toast('success', 'Success!', 'Your package was deleted successfully!')
      })
    },
    hideModal (id) {
      this.$refs['delete-package-modal'+id].hide()
    }
  }
}
</script>
