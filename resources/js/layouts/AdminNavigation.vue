<template>
  <b-navbar
    toggleable="sm"
    type="light"
    variant="white"
    class="border"
  >
    <div class="container">
      <b-navbar-brand href="/">
        {{ $appName }}
      </b-navbar-brand>

      <b-navbar-toggle target="nav-collapse" />

      <b-collapse
        id="nav-collapse"
        is-nav
      >
        <b-navbar-nav v-if="$user">
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
            :class="{'active': route === 'admin/users'}"
            href="/admin/users"
          >
            Users
          </b-nav-item>
          <b-nav-item-dropdown
            active
            v-if="$user"
          >
            <template #button-content>
              Passport
            </template>
            <b-dropdown-item href="/passport/clients">
              Passport Clients
            </b-dropdown-item>
            <b-dropdown-item href="/passport/authorized_clients">
              Passport Authorized
            </b-dropdown-item>
            <b-dropdown-item href="/passport/access_tokens">
              Passport Access Tokens
            </b-dropdown-item>            
          </b-nav-item-dropdown>
        </b-navbar-nav>
        <b-navbar-nav class="ml-auto">
          <b-nav-item
            v-if="$user"
            right
            href="#"
          >
            <span class="badge badge-secondary">{{ $role | capitalize }}</span>
          </b-nav-item>

          <b-nav-item
            v-if="!$user"
            href="/login"
          >
            Login
          </b-nav-item>
          <b-nav-item
            v-if="!$user"
            href="/register"
          >
            Register
          </b-nav-item>

          <b-nav-item-dropdown
            v-if="$user"
            right
          >
            <template #button-content>
              {{ $user.name }}
            </template>
            <b-dropdown-item href="/admin/roles">
              Admin Panel
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
