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
        <b-navbar-nav v-if="user">
          <b-nav-item
            :class="{'active': route === 'listings'}"
            href="/listings"
          >
            Listings
          </b-nav-item>
        </b-navbar-nav>
        <b-navbar-nav class="ml-auto">
          <b-nav-item
            v-if="!user"
            href="/login"
          >
            Login
          </b-nav-item>
          <b-nav-item
            v-if="!user"
            href="/register"
          >
            Register
          </b-nav-item>

          <b-nav-item-dropdown
            v-if="user"
            right
          >
            <template #button-content>
              {{ user.name }}
            </template>
            <b-dropdown-item
              v-if="role === 'admin'"
              href="/admin/roles"
            >
              Admin Panel
            </b-dropdown-item>
            <b-dropdown-item
              v-if="role === 'admin'"
              href="/passport/clients"
            >
              Passport Clients
            </b-dropdown-item>
            <b-dropdown-item
              v-if="role === 'admin'"
              href="/passport/authorized_clients"
            >
              Passport Authorized
            </b-dropdown-item>
            <b-dropdown-item
              v-if="role === 'admin'"
              href="/passport/access_tokens"
            >
              Passport Access Tokens
            </b-dropdown-item>
            <b-dropdown-divider v-if="role === 'admin'" />
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
    user: {
      required: true,
      type: null
    },
    config: {
      require: false,
      type: String,
      default: 'ESM - Directory'
    },
    route: {
      require: false,
      type: String,
      default: ''
    }
  },
  computed: {
    role () {
      if (this.user.roles.length) {
        return this.user.roles[0].name;
      }
      return ''
    }
  },
  methods: {
    logout () {
      axios.post('/logout').then(() => {
        location.reload()
      })
    }
  }
}
</script>
