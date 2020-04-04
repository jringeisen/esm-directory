<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <b-card header-tag="header">
                    <template v-slot:header>
                        <h6 class="mb-0">Create Your Listing</h6>
                    </template>
                    <b-card-text>
                        <transition name="fade" v-if="formSuccess">
                            <div class="alert alert-success">Your listing has been submitted successfully!</div>
                        </transition>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" @keyup="formErrors.name = ''" class="form-control form-control-sm" :class="{ 'is-invalid': formErrors.name }" placeholder="Enter your name." v-model="formData.name" required>
                            <div class="invalid-feedback" v-if="formErrors.name">
                                {{ this.formErrors.name[0] }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="business_name">Business Name</label>
                            <input type="text" @keyup="formErrors.business_name = ''" class="form-control form-control-sm" :class="{ 'is-invalid': formErrors.business_name }" placeholder="Enter your business name." v-model="formData.business_name" required>
                            <div class="invalid-feedback" v-if="formErrors.business_name">
                                {{ this.formErrors.business_name[0] }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" @keyup="formErrors.city = ''" class="form-control form-control-sm" :class="{ 'is-invalid': formErrors.city }" placeholder="Enter your city." v-model="formData.city" required>
                            <div class="invalid-feedback" v-if="formErrors.city">
                                {{ this.formErrors.city[0] }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" @keyup="formErrors.state = ''" class="form-control form-control-sm" :class="{ 'is-invalid': formErrors.state }" placeholder="Enter your state." v-model="formData.state" required>
                            <div class="invalid-feedback" v-if="formErrors.state">
                                {{ this.formErrors.state[0] }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control form-control-sm" @keyup="formErrors.description = ''" rows="4" :class="{ 'is-invalid': formErrors.description }" placeholder="Description" v-model="formData.description" required></textarea>
                            <div class="invalid-feedback" v-if="formErrors.description">
                                {{ this.formErrors.description[0] }}
                            </div>
                        </div>
                        <button class="btn btn-sm btn-secondary" @click.prevent="submit">Submit</button>
                    </b-card-text>
                </b-card>
            </div>
        </div>
    </div>
</template>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>

<script>
    export default {
        data () {
            return {
                formData: {},
                formErrors: {},
                formSuccess: false
            }
        },
        methods: {
            submit () {
                axios.post('/listings', this.formData).then((response) => {
                    this.formData = {}
                    this.formSuccess = true
                    setTimeout(() => { 
                        this.formSuccess = false
                    }, 3000);
                }).catch((error) => {
                    this.formErrors = error.response.data.errors
                })
            }
        }
    }
</script>
