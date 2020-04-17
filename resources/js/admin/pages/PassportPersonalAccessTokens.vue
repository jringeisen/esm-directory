<template>
  <div class="card card-default">
    <div class="card-header">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <span>Personal Access Tokens</span>

        <b-button
          variant="secondary"
          size="sm"
          @click="$root.$emit('bv::show::modal', 'modal-create-token')"
        >
          Create New Token
        </b-button>
      </div>
    </div>

    <div class="card-body">
      <p
        class="mb-0"
        v-if="tokens.length === 0"
      >
        You have not created any personal access tokens.
      </p>

      <table
        class="table table-borderless mb-0"
        v-if="tokens.length > 0"
      >
        <thead>
          <tr>
            <th>Name</th>
            <th />
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="token in tokens"
            :key="token.id"
          >
            <td style="vertical-align: middle;">
              {{ token.name }}
            </td>

            <td
              class="float-right"
              style="vertical-align: middle;"
            >
              <b-button
                variant="danger"
                size="sm"
                @click="revoke(token)"
              >
                Delete
              </b-button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <create-token-modal />
    <view-access-token />
  </div>
</template>

<script>
import CreateTokenModal from "./modals/CreateTokenModal.vue";
import ViewAccessToken from "./modals/ViewAccessToken.vue";
export default {
  components: {
    CreateTokenModal,
    ViewAccessToken
  },

  /*
   * The component's data.
   */
  data() {
    return {
      accessToken: null,

      tokens: [],
      scopes: [],

      form: {
        name: "",
        scopes: [],
        errors: []
      }
    };
  },

  /**
   * Prepare the component (Vue 2.x).
   */
  mounted() {
    this.$root.$on("getAccessTokens", () => {
      this.getTokens();
      this.getScopes();
    });

    this.getTokens();
    this.getScopes();
  },

  methods: {
    /**
     * Get all of the personal access tokens for the user.
     */
    getTokens() {
      axios.get("/oauth/personal-access-tokens").then(response => {
        this.tokens = response.data;
      });
    },

    /**
     * Get all of the available scopes.
     */
    getScopes() {
      axios.get("/oauth/scopes").then(response => {
        this.scopes = response.data;
      });
    },

    /**
     * Revoke the given token.
     */
    revoke(token) {
      axios
        .delete("/oauth/personal-access-tokens/" + token.id)
        .then(response => {
          this.getTokens();
        });
    }
  }
};
</script>
