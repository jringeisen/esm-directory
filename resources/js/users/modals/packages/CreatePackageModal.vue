<template>
  <b-modal
    id="create-package"
    ref="create-package-modal"
    title="Create Package"
  >
    <form>
      <div class="form-group">
        <label for="name">Name</label>
        <input
          v-model="formData.name"
          type="text"
          class="form-control form-control-sm"
          :class="{ 'is-invalid': formErrors.name }"
          placeholder="Enter your name."
          required
          @keyup="formErrors.name = ''"
        >
        <div
          v-if="formErrors.name"
          class="invalid-feedback"
        >
          {{ formErrors.name[0] }}
        </div>
      </div>
      <div class="form-group">
        <label for="amount">Amount</label>
        <input
          v-model="formData.amount"
          type="number"
          class="form-control form-control-sm"
          :class="{ 'is-invalid': formErrors.amount }"
          placeholder="Enter package amount."
          required
          @keyup="formErrors.amount = ''"
        >
        <div
          v-if="formErrors.amount"
          class="invalid-feedback"
        >
          {{ formErrors.amount[0] }}
        </div>
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <textarea
          v-model="formData.description"
          class="form-control form-control-sm"
          rows="4"
          :class="{ 'is-invalid': formErrors.description }"
          placeholder="Description"
          required
          @keyup="formErrors.description = ''"
        />
        <div
          v-if="formErrors.description"
          class="invalid-feedback"
        >
          {{ formErrors.description[0] }}
        </div>
      </div>
    </form>
    <div slot="modal-footer">
      <button
        class="btn btn-outline-secondary"
        @click.prevent="hideModal"
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
import ToastMixin from '../../../mixins/ToastMixin.js'
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
      formData: {},
      formErrors: {},
      isLoading: false,
    }
  },
  methods: {
    submit (event) {
      event.preventDefault()
      this.isLoading = true

      var data = Object.assign({listing_id: this.listing.id}, this.formData)

      axios.post('/api/packages', data).then((response) => {
        this.$root.$emit('updateUser')
        this.isLoading = false
        this.formData = {}
        this.hideModal()
        this.toast('success', 'Success!', 'Your package was created successfully!')
      }).catch((error) => {
        this.isLoading = false
        this.formErrors = error.response.data.errors
      })
    },
    hideModal () {
      this.$refs['create-package-modal'].hide()
    },
  }
}
</script>