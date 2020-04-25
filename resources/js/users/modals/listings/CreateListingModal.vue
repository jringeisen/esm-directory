<template>
  <b-modal 
    :id="$options.name" 
    title="Create Listing"
  >
    <form>
      <div class="form-group">
        Name
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
        Business Name
        <input
          v-model="formData.business_name"
          type="text"
          class="form-control form-control-sm"
          :class="{ 'is-invalid': formErrors.business_name }"
          placeholder="Enter your business name."
          required
          @keyup="formErrors.business_name = ''"
        >
        <div
          v-if="formErrors.business_name"
          class="invalid-feedback"
        >
          {{ formErrors.business_name[0] }}
        </div>
      </div>
      <div class="form-group">
        Category
        <input
          v-model="formData.category"
          type="text"
          class="form-control form-control-sm"
          :class="{ 'is-invalid': formErrors.category }"
          placeholder="Enter a listing category"
          required
          @keyup="formErrors.category = ''"
        >
        <div
          v-if="formErrors.category"
          class="invalid-feedback"
        >
          {{ formErrors.category[0] }}
        </div>
      </div>
      <div class="form-group">
        City
        <input
          v-model="formData.city"
          type="text"
          class="form-control form-control-sm"
          :class="{ 'is-invalid': formErrors.city }"
          placeholder="Enter your city."
          required
          @keyup="formErrors.city = ''"
        >
        <div
          v-if="formErrors.city"
          class="invalid-feedback"
        >
          {{ formErrors.city[0] }}
        </div>
      </div>
      <div class="form-group">
        State
        <input
          v-model="formData.state"
          type="text"
          class="form-control form-control-sm"
          :class="{ 'is-invalid': formErrors.state }"
          placeholder="Enter your state."
          required
          @keyup="formErrors.state = ''"
        >
        <div
          v-if="formErrors.state"
          class="invalid-feedback"
        >
          {{ formErrors.state[0] }}
        </div>
      </div>
      <div class="form-group">
        Starting Package Price
        <input
          v-model="formData.starting_package"
          type="number"
          class="form-control form-control-sm"
          :class="{ 'is-invalid': formErrors.starting_package }"
          placeholder="Enter your starting package price."
          required
          @keyup="formErrors.starting_package = ''"
        >
        <div
          v-if="formErrors.starting_package"
          class="invalid-feedback"
        >
          {{ formErrors.starting_package[0] }}
        </div>
      </div>
      <div class="form-group">
        Description
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
      <div class="form-group">
        Upload Avatar
        <b-form-file
          size="sm"
          v-model="avatar"
          placeholder="Choose an avatar image..."
          drop-placeholder="Drop file here..."
          :class="{ 'is-invalid': formErrors.avatar }"
          @change="formErrors.avatar = ''"
        />
        <div
          v-if="formErrors.avatar"
          class="invalid-feedback"
        >
          {{ formErrors.avatar[0] }}
        </div>
      </div>
    </form>
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
import ToastMixin from '../../../mixins/ToastMixin.js'
import ModalActions from '../../../mixins/ModalActions.js'
export default {
  name: 'CreateListingModal',
  mixins: [ToastMixin, ModalActions],
  data () {
    return {
      formData: {},
      avatar: [],
      formErrors: {},
      isLoading: false
    }
  },
  methods: {
    submit (event) {
      event.preventDefault()
      this.isLoading = true

      let data = new FormData();
      data.append('avatar', this.avatar || '');
      data.append('name', this.formData.name || '')
      data.append('business_name', this.formData.business_name || '')
      data.append('category', this.formData.category || '')
      data.append('city', this.formData.city || '')
      data.append('state', this.formData.state || '')
      data.append('description', this.formData.description || '')
      data.append('starting_package', this.formData.starting_package || '')

      axios.post('/api/listings', data).then((response) => {
        this.isLoading = false
        this.formData = {}
        this.avatar = []
        this.$root.$emit('updateUser')
        this.closeModal(this.$options.name)
        this.toast('success', 'Success!', 'Your listing was created successfully!')
      }).catch((error) => {
        this.isLoading = false
        this.formErrors = error.response.data.errors
      })
    }
  }
}
</script>