<style scoped>
.action-link {
  cursor: pointer;
}
</style>

<template>
  <div>
    <div class="card card-default">
      <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <span>OAuth Clients</span>

          <a
            class="action-link"
            tabindex="-1"
            @click.prevent="showCreateClientForm"
          >Create New Client</a>
        </div>
      </div>

      <div class="card-body">
        <!-- Current Clients -->
        <p
          class="mb-0"
          v-if="clients.length === 0"
        >
          You have not created any OAuth clients.
        </p>

        <table
          class="table table-borderless mb-0"
          v-if="clients.length > 0"
        >
          <thead>
            <tr>
              <th>Client ID</th>
              <th>Name</th>
              <th>Secret</th>
              <th />
              <th />
            </tr>
          </thead>

          <tbody>
            <tr
              v-for="client in clients"
              :key="client.id"
            >
              <!-- ID -->
              <td style="vertical-align: middle;">
                {{ client.id }}
              </td>

              <!-- Name -->
              <td style="vertical-align: middle;">
                {{ client.name }}
              </td>

              <!-- Secret -->
              <td style="vertical-align: middle;">
                <code>{{ client.secret }}</code>
              </td>

              <!-- Edit Button -->
              <td style="vertical-align: middle;">
                <a
                  class="action-link"
                  tabindex="-1"
                  @click.prevent="edit(client)"
                >Edit</a>
              </td>

              <!-- Delete Button -->
              <td style="vertical-align: middle;">
                <a
                  class="action-link text-danger"
                  @click="destroy(client)"
                >Delete</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <create-client-modal />
    <edit-client-modal :client="clientObject" />
  </div>
</template>

<script>
import CreateClientModal from "../../modals/passport/CreateClientModal.vue";
import EditClientModal from "../../modals/passport/EditClientModal.vue";
export default {
  components: {
    CreateClientModal,
    EditClientModal
  },
  data() {
    return {
      clientObject: {},
      clients: []
    };
  },

  /**
   * Prepare the component (Vue 1.x).
   */
  ready() {
    this.prepareComponent();
  },

  /**
   * Prepare the component (Vue 2.x).
   */
  mounted() {
    this.$root.$on('getClients', (() => {
      this.getClients()
    })),

    this.prepareComponent()
  },

  methods: {
    /**
     * Prepare the component.
     */
    prepareComponent() {
      this.getClients();
    },

    /**
     * Get all of the OAuth clients for the user.
     */
    getClients() {
      axios.get("/oauth/clients").then(response => {
        this.clients = response.data;
      });
    },

    /**
     * Show the form for creating new clients.
     */
    showCreateClientForm() {
      this.$root.$emit("bv::show::modal", "modal-create-client");
    },

    /**
     * Edit the given client.
     */
    edit(client) {
      this.clientObject = client;

      this.$nextTick(() => {
        this.$root.$emit(
          "bv::show::modal",
          "modal" + client.id + "-edit-client"
        );
      });
    },

    /**
     * Destroy the given client.
     */
    destroy(client) {
      axios.delete("/oauth/clients/" + client.id).then(response => {
        this.getClients();
      });
    }
  }
};
</script>
