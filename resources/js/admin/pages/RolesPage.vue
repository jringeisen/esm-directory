<template>
  <div class="card shadow">
    <div class="card-header">
      Roles
      <b-button
        variant="secondary"
        class="float-right"
        size="sm"
        v-b-modal="'create-role'"
      >
        Create Role
      </b-button>
    </div>
    <div class="card-body">
      <table class="table table-hover table-sm">
        <thead>
          <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Guard Name</th>
            <th>Created On</th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(role, index) in roles"
            :key="index"
          >
            <td
              class="align-middle"
              scope="row"
            >
              {{ role.id }}
            </td>
            <td class="align-middle">
              {{ role.name }}
            </td>
            <td class="align-middle">
              {{ role.guard_name }}
            </td>
            <td class="align-middle">
              {{ role.created_at | moment('LLL') }}
            </td>
            <td class="text-right align-middle">
              <b-dropdown
                id="roles-dropdown"
                no-caret
                dropright
                variant="white"
                class="m-md-2"
              >
                <template #button-content>
                  <i class="fas fa-ellipsis-v" />
                </template>
                <b-dropdown-item>Edit Role</b-dropdown-item>
                <b-dropdown-item>Delete Role</b-dropdown-item>
              </b-dropdown>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <create-role-modal />
  </div>
</template>

<script>
import CreateRoleModal from './modals/CreateRoleModal.vue'
export default {
  components: {
    CreateRoleModal
  },
  data () {
    return {
      roles: []
    }
  },
  mounted () {
    this.$root.$on('getRoles', (() => {
      this.getRoles()
    }))

    this.getRoles()
  },
  methods: {
    getRoles () {
      axios.get('/api/roles').then((response) => {
        this.roles = response.data
      }).catch((error) => {
        console.log('something went wrong')
      })
    }
  }
};
</script>