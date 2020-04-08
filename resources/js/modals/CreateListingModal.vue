<template>
    <b-modal 
        id="create-listing" 
        ref="create-listing-modal" 
        title="Create Listing">
        <form>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" @keyup="formErrors.name = ''" class="form-control" :class="{ 'is-invalid': formErrors.name }" placeholder="Enter your name." v-model="formData.name" required>
                <div class="invalid-feedback" v-if="formErrors.name">
                    {{ this.formErrors.name[0] }}
                </div>
            </div>
            <div class="form-group">
                <label for="business_name">Business Name</label>
                <input type="text" @keyup="formErrors.business_name = ''" class="form-control" :class="{ 'is-invalid': formErrors.business_name }" placeholder="Enter your business name." v-model="formData.business_name" required>
                <div class="invalid-feedback" v-if="formErrors.business_name">
                    {{ this.formErrors.business_name[0] }}
                </div>
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" @keyup="formErrors.city = ''" class="form-control" :class="{ 'is-invalid': formErrors.city }" placeholder="Enter your city." v-model="formData.city" required>
                <div class="invalid-feedback" v-if="formErrors.city">
                    {{ this.formErrors.city[0] }}
                </div>
            </div>
            <div class="form-group">
                <label for="state">State</label>
                <input type="text" @keyup="formErrors.state = ''" class="form-control" :class="{ 'is-invalid': formErrors.state }" placeholder="Enter your state." v-model="formData.state" required>
                <div class="invalid-feedback" v-if="formErrors.state">
                    {{ this.formErrors.state[0] }}
                </div>
            </div>
            <div class="form-group">
                <label for="starting_package">Starting Package Price</label>
                <input type="number" @keyup="formErrors.starting_package = ''" class="form-control" :class="{ 'is-invalid': formErrors.starting_package }" placeholder="Enter your starting package price." v-model="formData.starting_package" required>
                <div class="invalid-feedback" v-if="formErrors.starting_package">
                    {{ this.formErrors.starting_package[0] }}
                </div>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" @keyup="formErrors.description = ''" rows="4" :class="{ 'is-invalid': formErrors.description }" placeholder="Description" v-model="formData.description" required></textarea>
                <div class="invalid-feedback" v-if="formErrors.description">
                    {{ this.formErrors.description[0] }}
                </div>
            </div>
            <div class="form-group">
                <b-form-file
                    v-model="avatar"
                    @change="formErrors.avatar = ''"
                    placeholder="Choose an avatar image..."
                    drop-placeholder="Drop file here..."
                    :class="{ 'is-invalid': formErrors.avatar }"
                ></b-form-file>
                <div class="invalid-feedback" v-if="formErrors.avatar">
                    {{ this.formErrors.avatar[0] }}
                </div>
            </div>
        </form>
        <div slot="modal-footer">
            <button class="btn btn-outline-secondary" @click.prevent="hideModal">Cancel</button>
            <button class="btn btn-secondary" :disabled="isLoading" @click.prevent="submit">
                <b-spinner v-if="isLoading" small type="grow"></b-spinner>
                {{ isLoading ? 'Loading...' : 'Submit'}}
            </button>
        </div>
    </b-modal>
</template>

<script>
export default {
    data () {
        return {
            formData: {},
            avatar: [],
            formErrors: {},
            isLoading: false
        }
    },
    methods: {
        submit (event) {
            event.preventDefault()
            this.isLoading = true

            let data = new FormData();
            data.append('avatar', this.avatar || '');
            data.append('name', this.formData.name || '')
            data.append('business_name', this.formData.business_name || '')
            data.append('city', this.formData.city || '')
            data.append('state', this.formData.state || '')
            data.append('description', this.formData.description || '')
            data.append('starting_package', this.formData.starting_package || '')

            axios.post('/listings', data).then((response) => {
                this.isLoading = false
                this.formData = {}
                this.avatar = []
                this.$root.$emit('updateUser')
                this.hideModal()
                this.toast('success', 'Success!', 'Your listing was created successfully!')
            }).catch((error) => {
                this.isLoading = false
                this.formErrors = error.response.data.errors
            })
        },
        hideModal () {
            this.$refs['create-listing-modal'].hide()
        },
        toast (variant, title, body) {
            this.$bvToast.toast(body, {
                title: title,
                variant: variant,
                solid: true
            })
        }
    }
}
</script>