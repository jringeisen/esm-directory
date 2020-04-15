<template>
  <!-- Edit Client Modal -->
  <b-modal 
    :id="'modal'+client.id+'-edit-client'" 
    @ok="update"
    title="Edit Client"
  >
    <div
      class="alert alert-danger"
      v-if="editForm.errors.length > 0"
    >
      <p class="mb-0">
        <strong>Whoops!</strong> Something went wrong!
      </p>
      <br>
      <ul>
        <li
          v-for="error in editForm.errors"
          :key="error.id"
        >
          {{ error }}
        </li>
      </ul>
    </div>

    <!-- Edit Client Form -->
    <form role="form">
      <!-- Name -->
      <div class="form-group">
        <label class="col-form-label">Name</label>
        <input
          id="edit-client-name"
          type="text"
          class="form-control"
          @keyup.enter="update"
          v-model="editForm.name"
        >

        <span class="form-text text-muted">Something your users will recognize and trust.</span>
      </div>

      <!-- Redirect URL -->
      <div class="form-group">
        <label class="col-form-label">Redirect URL</label>
        <input
          type="text"
          class="form-control"
          name="redirect"
          @keyup.enter="update"
          v-model="editForm.redirect"
        >

        <span class="form-text text-muted">Your application's authorization callback URL.</span>
      </div>
    </form>
  </b-modal>
</template>

<script>
export default {
  props: {
    client: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      editForm: {
        errors: [],
        name: "",
        redirect: ""
      }
    };
  },
  mounted () {
    this.$root.$on('bv::modal::shown', (bvEvent, bvModalId) => {
      if (bvModalId === 'modal'+this.client.id+'-edit-client') {
        this.editForm.name = this.client.name,
        this.editForm.redirect = this.client.redirect
      }
    })
  },
  methods: {
    /**
     * Persist the client to storage using the given form.
     */
    update(bvt) {
      bvt.preventDefault()

      axios.put(`/oauth/clients/${this.client.id}`, this.editForm)
        .then(response => {
          this.$root.$emit('getClients')

          this.editForm.name = "";
          this.editForm.redirect = "";
          this.editForm.errors = [];

          this.$root.$emit('bv::hide::modal', 'modal'+this.client.id+'-edit-client')
        })
        .catch(error => {
          if (typeof error.response.data === "object") {
            this.editForm.errors = _.flatten(_.toArray(error.response.data.errors));
          } else {
            this.editForm.errors = ["Something went wrong. Please try again."];
          }
        });
    }
  }
};
</script>

