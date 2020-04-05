<template>
    <b-navbar toggleable="sm" type="light" variant="white" class="border">
        <div class="container">
            <b-navbar-brand href="/">{{ config }}</b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav v-if="name">
                    <b-nav-item :class="{'active': route === 'listings'}" href="/listings">Listings</b-nav-item>
                    <b-nav-item :class="{'active': route === 'home'}" href="/home">Create Listing</b-nav-item>
                </b-navbar-nav>
                <b-navbar-nav class="ml-auto">
                        <b-nav-item v-if="!name" href="/login">Login</b-nav-item>
                        <b-nav-item v-if="!name" href="/register">Register</b-nav-item>

                        <b-nav-item-dropdown right v-if="name">
                            <template v-slot:button-content>
                                {{ name }}
                            </template>
                            <b-dropdown-item href="#" @click.prevent="logout">Sign Out</b-dropdown-item>
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
        },
        config: {
            require: true,
        },
        route: {
            require: true
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
