<template>
  <b-modal id="modal-create-token" @ok="store" title="Create Token">
    <div class="alert alert-danger" v-if="form.errors.length > 0">
      <p class="mb-0">
        <strong>Whoops!</strong> Something went wrong!
      </p>
      <br>
      <ul>
        <li v-for="error in form.errors" :key="error.id">{{ error }}</li>
      </ul>
    </div>
    <form role="form" @submit.prevent="store">
      <div class="form-group">
        <label class="col-form-label">Name</label>
        <input
          id="create-token-name"
          type="text"
          class="form-control"
          name="name"
          v-model="form.name"
        >
      </div>
      <div class="form-group" v-if="scopes.length > 0">
        <label class="col-form-label">Scopes</label>
        <div v-for="scope in scopes" :key="scope.id">
          <div class="checkbox">
            <label>
              <input
                type="checkbox"
                @click="toggleScope(scope.id)"
                :checked="scopeIsAssigned(scope.id)"
              >
              {{ scope.id }}
            </label>
          </div>
        </div>
      </div>
    </form>
  </b-modal>
</template>

<script>
export default {
  data() {
    return {
      accessToken: "",
      scopes: [],
      tokens: [],
      form: {
        name: "",
        scopes: [],
        errors: []
      }
    };
  },
  methods: {
    store(bvt) {
      bvt.preventDefault();
      this.accessToken = null;

      this.form.errors = [];

      axios
        .post("/oauth/personal-access-tokens", this.form)
        .then(response => {
          this.form.name = "";
          this.form.scopes = [];
          this.form.errors = [];

          this.tokens.push(response.data.token);

          this.showAccessToken(response.data.accessToken);
        })
        .catch(error => {
          if (typeof error.response.data === "object") {
            this.form.errors = _.flatten(_.toArray(error.response.data.errors));
          } else {
            this.form.errors = ["Something went wrong. Please try again."];
          }
        });
    },

    toggleScope(scope) {
      if (this.scopeIsAssigned(scope)) {
        this.form.scopes = _.reject(this.form.scopes, s => s == scope);
      } else {
        this.form.scopes.push(scope);
      }
    },

    scopeIsAssigned(scope) {
      return _.indexOf(this.form.scopes, scope) >= 0;
    },

    showAccessToken(accessToken) {
      this.$root.$emit("bv::hide::modal", "modal-create-token");

      this.$nextTick(() => {
        this.$root.$emit("bv::show::modal", "modal-access-token");
        this.$root.$emit("setAccessToken", accessToken);
        this.$root.$emit("getAccessTokens");
      });
    }
  }
};
</script>

