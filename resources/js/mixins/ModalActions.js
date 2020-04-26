import ToastMixin from './ToastMixin.js'
export default {
  mixins: [
    ToastMixin
  ],
  data () {
    return {
      formData: {},
      formErrors: [],
      isLoading: false
    }
  },
  methods: {
    // Set's formData with default data
    shown () {
      this.formData = this.item
    },

    // Action to open modal and set formData
    openModal (modalName, data = {}) {
      this.formData = data
      this.$root.$emit('bv::show::modal', modalName)
    },

    // Action to close modal
    closeModal () {
      this.$root.$emit('bv::hide::modal', this.$options.name)
    },

    // Method to create item resource
    createItem (url, data = {}, event = '') {
      this.isLoading = true
      axios.post(url, data).then(() => {
        this.isLoading = false
        this.$root.$emit(event)
        this.closeModal()
        this.toast('success', 'Success!', 'Item was created successfully!')
      }).catch((error) => {
        this.isLoading = false
        if (error.response.status === 422) {
          this.formErrors = error.response.data.errors
        } else {
          this.toast('danger', 'Something went wrong!', 'Whoops.. Looks like something went wrong.')
        }
      })
    },

    // Method to update item resource
    updateItem (url, event = '') {
      this.isLoading = true
      axios.put(url + this.formData.id, this.formData).then((response) => {
        this.isLoading = false
        this.$root.$emit(event)
        this.closeModal()
        this.toast('success', 'Success!', 'Item was updated successfully!')
      }).catch((error) => {
        this.isLoading = false
        if (error.response.status === 422) {
          this.formErrors = error.response.data.errors
        } else {
          this.toast('danger', 'Something went wrong!', 'Whoops.. Looks like something went wrong.')
        }
      })
    },

    // Method to delete item resource
    deleteItem (url, event = '') {
      this.isLoading = true
      axios.delete(url + this.formData.id).then(() => {
        this.isLoading = false
        this.$root.$emit(event)
        this.closeModal()
        this.toast('success', 'Success!', 'Item was deleted successfully!')
      }).catch((error) => {
        this.isLoading = false
        if (error.response.status === 422) {
          this.formErrors = error.response.data.errors
        } else {
          this.toast('danger', 'Something went wrong!', 'Whoops.. Looks like something went wrong.')
        }
      })
    }
  }
};