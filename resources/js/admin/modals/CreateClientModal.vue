<template>
  <!-- Create Client Modal -->
  <b-modal
    @ok="store"
    title="Create Client"
    id="modal-create-client"
  >
    <!-- Form Errors -->
    <div
      class="alert alert-danger"
      v-if="createForm.errors.length > 0"
    >
      <p class="mb-0">
        <strong>Whoops!</strong> Something went wrong!
      </p>
      <br>
      <ul>
        <li
          v-for="error in createForm.errors"
          :key="error.id"
        >
          {{ error }}
        </li>
      </ul>
    </div>

    <!-- Create Client Form -->
    <form role="form">
      <!-- Name -->
      <div class="form-group">
        <label class="col-form-label">Name</label>
        <input
          id="create-client-name"
          type="text"
          class="form-control"
          @keyup.enter="store"
          v-model="createForm.name"
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
          @keyup.enter="store"
          v-model="createForm.redirect"
        >

        <span class="form-text text-muted">Your application's authorization callback URL.</span>
      </div>

      <!-- Confidential -->
      <div class="form-group">
        <label class="col-form-label">Confidential</label>
        <div class="checkbox">
          <label>
            <input
              type="checkbox"
              v-model="createForm.confidential"
            >
          </label>
        </div>

        <span
          class="form-text text-muted"
        >Require the client to authenticate with a secret. Confidential clients can hold credentials in a secure way without exposing them to unauthorized parties. Public applications, such as native desktop or JavaScript SPA applications, are unable to hold secrets securely.</span>
      </div>
    </form>
  </b-modal>
</template>

<script>
export default {
  name: 'CreateClientModal',
  data() {
    return {
      createForm: {
        errors: [],
        name: "",
        redirect: "",
        confidential: true
      }
    };
  },
  methods: {
    /**
     * Create a new OAuth client for the user.
     */
    store(bv) {
      bv.preventDefault();

      this.persistClient(
        "post",
        "/oauth/clients",
        this.createForm,
        "#modal-create-client"
      );
    },
    /**
     * Persist the client to storage using the given form.
     */
    persistClient(method, uri, form, modal) {
      form.errors = [];

      axios[method](uri, form)
        .then(response => {
          this.$root.$emit('getClients')

          form.name = "";
          form.redirect = "";
          form.errors = [];

          this.$root.$emit('bv::hide::modal', 'modal-create-client')
        })
        .catch(error => {
          if (typeof error.response.data === "object") {
            form.errors = _.flatten(_.toArray(error.response.data.errors));
          } else {
            form.errors = ["Something went wrong. Please try again."];
          }
        });
    }
  }
};
</script>

