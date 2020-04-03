<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <b-card header-tag="header">
                    <template v-slot:header>
                        <h6 class="mb-0">Example</h6>
                    </template>
                    <b-card-text>Example Card with Button</b-card-text>
                    <b-button href="#" variant="primary">Go somewhere</b-button>
                </b-card>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
