<template>
    <div class="card shadow">
        <div class="card-body">
            <div class="text-center" v-if="!packages.length">
                <h5 class="card-title">You don't have any packages</h5>
                <p class="card-text">To get started click the button below and create your first package.</p>
                <button class="btn btn-secondary" v-b-modal="'create-package'">Create Package</button>
            </div>
            <div v-if="packages.length">
                <div class="d-flex justify-content-end pb-3">
                    <button class="btn btn-sm btn-secondary" v-b-modal="'create-package'">Create New Package</button>
                </div>
                <table class="table table-hover">
                    <thead>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>&nbsp;</th>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in packages" :key="index">
                            <td class="align-middle">{{ item.name }}</td>
                            <td class="align-middle">{{ item.amount | currency }}</td>
                            <td class="align-middle">{{ item.description | truncate(50) }}</td>
                            <td class="align-middle">
                                <b-dropdown id="packages" no-caret dropright variant="white" class="m-md-2">
                                    <template v-slot:button-content>
                                        <i class="fas fa-ellipsis-v"></i>
                                    </template>
                                    <b-dropdown-item v-b-modal="'view-'+item.id" @click.prevent="setId(item)">View</b-dropdown-item>
                                    <b-dropdown-item v-b-modal="'edit-'+item.id" @click.prevent="setId(item)">Edit</b-dropdown-item>
                                    <b-dropdown-item v-b-modal="'delete-'+item.id" @click.prevent="setId(item)">Delete</b-dropdown-item>
                                </b-dropdown>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <create-package-modal :packages="packages"></create-package-modal>
    </div>
</template>

<script>
    import CreatePackageModal from '../modals/CreatePackageModal'

    export default {
        components: {
            CreatePackageModal
        },
        data () {
            return {
                formData: {},
                formErrors: {},
                formSuccess: false,
                isLoading: false,
                packages: {},
                photoPackage: ''
            }
        },
        created () {
            this.getUser()

            this.$root.$on('updateUser', () => {
                this.getUser()
            })
        },
        methods: {
            getUser () {
                axios.get('/user').then((response) => {
                    this.packages = response.data.packages
                })
            },
            setId (item) {
                this.photoPackage = item
            }
        }
    }
</script>
