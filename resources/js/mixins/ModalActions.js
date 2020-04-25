export default {
  data () {
    return {
      modalData: {}
    }
  },
  methods: {
    openModal (modalName, data = {}) {
      this.modalData = data
      this.$root.$emit('bv::show::modal', modalName)
    },
    closeModal (modalName) {
      this.$root.$emit('bv::hide::modal', modalName)
    }
  }
};