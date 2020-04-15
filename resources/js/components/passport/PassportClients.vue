<template>
  <div>
    <div class="card card-default">
      <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <span>OAuth Clients</span>

          <b-button
            variant="secondary"
            size="sm"
            @click.prevent="$root.$emit('bv::show::modal', 'modal-create-client')"
          >
            Create New Client
          </b-button>
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
              <td
                class="float-right"
                style="vertical-align: middle;"
              >
                <b-button
                  variant="secondary"
                  size="sm"
                  @click.prevent="edit(client)"
                >
                  Edit
                </b-button>

                <b-button
                  variant="danger"
                  size="sm"
                  @click="destroy(client)"
                >
                  Delete
                </b-button>
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
