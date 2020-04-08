<template>
    <b-modal id="create-package" ref="create-package-modal" title="Create Package">
        <form>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" @keyup="formErrors.name = ''" class="form-control form-control-sm" :class="{ 'is-invalid': formErrors.name }" placeholder="Enter your name." v-model="formData.name" required>
                <div class="invalid-feedback" v-if="formErrors.name">
                    {{ this.formErrors.name[0] }}
                </div>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" @keyup="formErrors.amount = ''" class="form-control form-control-sm" :class="{ 'is-invalid': formErrors.amount }" placeholder="Enter package amount." v-model="formData.amount" required>
                <div class="invalid-feedback" v-if="formErrors.amount">
                    {{ this.formErrors.amount[0] }}
                </div>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control form-control-sm" @keyup="formErrors.description = ''" rows="4" :class="{ 'is-invalid': formErrors.description }" placeholder="Description" v-model="formData.description" required></textarea>
                <div class="invalid-feedback" v-if="formErrors.description">
                    {{ this.formErrors.description[0] }}
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
            formErrors: {},
            isLoading: false,
        }
    },
    methods: {
        submit (event) {
            event.preventDefault()
            this.isLoading = true

            let data = new FormData();
            data.append('name', this.formData.name || '')
            data.append('amount', this.formData.amount || '')
            data.append('description', this.formData.description || '')

            axios.post('/packages', data).then((response) => {
                this.$root.$emit('updateUser')
                this.isLoading = false
                this.formData = {}
                this.hideModal()
            }).catch((error) => {
                this.isLoading = false
                this.formErrors = error.response.data.errors
            })
        },
        hideModal () {
            this.$refs['create-package-modal'].hide()
        },
    }
}
</script>


</template>
