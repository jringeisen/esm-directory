<template>
  <b-modal
    id="request-booking"
    title="Request A Booking"
  >
    <div class="row justify-content-center">
      <div class="col-12">
        <form>
          <div class="form-group">
            <label>Name</label>
            <input
              type="text"
              class="form-control"
              placeholder="Enter your full name..."
            >
          </div>
          <div class="form-group">
            <label>Email</label>
            <input
              type="email"
              class="form-control"
              placeholder="Enter your email address..."
            >
          </div>
          <div class="form-group">
            <label>Choose a package</label>
            <select class="form-control">
              <option>Choose a package:</option>
              <option
                v-for="(item, index) in photographyPackages"
                :key="index"
              >
                {{ item.name + ' - ' + item.amount }}
              </option>
            </select>
            <small
              id="passwordHelpBlock"
              class="form-text text-muted"
            >
              Visit the package tab above to see what these packages include.
            </small>
          </div>
          <div class="form-group">
            <label>Message</label>
            <textarea
              class="form-control"
              rows="4"
              placeholder="Enter your message..."
            />
          </div>
        </form>
      </div>
    </div>
  </b-modal>
</template>

<script>
export default {
  props: {
    photographyPackages: {
      type: Array,
      required: true,
      default: () => []
    }
  }
        
}
</script>