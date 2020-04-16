<template>
  <b-navbar
    toggleable="sm"
    type="light"
    variant="white"
    class="border"
  >
    <div class="container">
      <b-navbar-brand href="/">
        {{ config }}
      </b-navbar-brand>

      <b-navbar-toggle target="nav-collapse" />

      <b-collapse
        id="nav-collapse"
        is-nav
      >
        <b-navbar-nav v-if="name">
          <b-nav-item
            :class="{'active': route === 'admin/roles'}"
            href="/admin/roles"
          >
            Roles
          </b-nav-item>
          <b-nav-item
            :class="{'active': route === 'permissions'}"
            href="/permissions"
          >
            Permissions
          </b-nav-item>
          <b-nav-item
            :class="{'active': route === 'user'}"
            href="/user"
          >
            Users
          </b-nav-item>
        </b-navbar-nav>
        <b-navbar-nav class="ml-auto">
          <b-nav-item
            v-if="!name"
            href="/login"
          >
            Login
          </b-nav-item>
          <b-nav-item
            v-if="!name"
            href="/register"
          >
            Register
          </b-nav-item>

          <b-nav-item-dropdown
            v-if="name"
            right
          >
            <template #button-content>
              {{ name }}
            </template>
            <b-dropdown-item href="/admin">
              Admin Panel
            </b-dropdown-item>
            <b-dropdown-item href="/passport/clients">
              Passport Clients
            </b-dropdown-item>
            <b-dropdown-item href="/passport/authorized_clients">
              Passport Authorized
            </b-dropdown-item>
            <b-dropdown-item href="/passport/access_tokens">
              Passport Access Tokens
            </b-dropdown-item>
            <b-dropdown-divider />
            <b-dropdown-item
              href="#"
              @click.prevent="logout"
            >
              Sign Out
            </b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
      </b-collapse>
    </div>
  </b-navbar>
</template>

<script>
export default {
  props: {
    name: {
      required: true,
      type: String
    },
    config: {
      require: false,
      type: String,
      default: "ESM - Directory"
    },
    route: {
      require: false,
      type: String,
      default: ""
    }
  },
  methods: {
    logout() {
      axios.post("/logout").then(() => {
        location.reload();
      });
    }
  }
};
</script>
