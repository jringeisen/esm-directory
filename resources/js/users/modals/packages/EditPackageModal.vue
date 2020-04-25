<template>
  <b-modal
    :id="$options.name"
    title="Edit Package"
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
  name: 'EditPackageModal',
  mixins: [
    ModalActions
  ],
  props: {
    package: {
      required: true,
      type: Object
    }
  },
  methods: {
    shown () {
      this.formData = this.package
    },
    submit (event) {
      event.preventDefault()

      this.updateItem('/api/packages/')
    }
  }
}
</script>