<template>
    <b-modal :id="'edit-package-'+item.id" :ref="'edit-package-modal'+item.id" title="Edit Package">
        <form>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" @keyup="formErrors.name = ''" class="form-control form-control-sm" :class="{ 'is-invalid': formErrors.name }" placeholder="Enter your name." v-model="item.name" required>
                <div class="invalid-feedback" v-if="formErrors.name">
                    {{ this.formErrors.name[0] }}
                </div>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" @keyup="formErrors.amount = ''" class="form-control form-control-sm" :class="{ 'is-invalid': formErrors.amount }" placeholder="Enter package amount." v-model="item.amount" required>
                <div class="invalid-feedback" v-if="formErrors.amount">
                    {{ this.formErrors.amount[0] }}
                </div>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control form-control-sm" @keyup="formErrors.description = ''" rows="4" :class="{ 'is-invalid': formErrors.description }" placeholder="Description" v-model="item.description" required></textarea>
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
import ToastMixin from '../../mixins/ToastMixin.js'
export default {
    props: {
        item: {
            required: true,
        }
    },
    mixins: [ToastMixin],
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

            axios.put(`/packages/${this.item.id}`, this.item).then((response) => {
                this.$root.$emit('updateUser')
                this.isLoading = false
                this.formData = {}
                this.hideModal()
                this.toast('success', 'Success!', 'Your package was updated successfully!')
            }).catch((error) => {
                this.isLoading = false
                this.formErrors = error.response.data.errors
            })
        },
        hideModal () {
            this.$refs['edit-package-modal'+this.item.id].hide()
        },
    }
}
</script>