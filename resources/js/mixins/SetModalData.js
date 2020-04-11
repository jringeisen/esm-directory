export default {
    methods: {
        setModalData (listing) {
            this.listing = listing
            this.packages = listing.packages
        }
    }
  };