<template>
    <div class="app">
        <div class="container mt-3">
            <div class="row">
                <h1 class="text-center">IP Address Search</h1>
            </div>
            <div class="row mt-4">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search IP Address" v-model="searchTerm">
                    <div class="input-group-append">
                        <button class="btn btn-success" v-bind:disabled="this.searchTerm.length === 0" type="button" @click="searchIpAddress()">Search</button>
                    </div>
                </div>
            </div>
            <div class="row mt-3" v-if="errorMessage !== ''">
                <h3 class="text-center text-danger">{{ this.errorMessage }}</h3>
            </div>
            <div v-if="loading" class="row mt-3">
                <h3 class="text-center">Loading...</h3>
            </div>
            <div class="row mt-3" v-if="Object.keys(this.ipData).length > 0">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Two Letter</th>
                        <th scope="col">Three Letter</th>
                        <th scope="col">Country</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ this.ipData.twoLetter }}</td>
                            <td>{{ this.ipData.threeLetter }}</td>
                            <td>{{ this.ipData.country }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import Axios from 'axios'
    export default {
        name: "app",
        components: {
            Axios
        },
        data () {
            return {
                searchTerm: '',
                loading: true,
                errorMessage: '',
                ipData: {}
            }
        },
        props: [
            'currentIP'
        ],
        async mounted() {
            this.ipData = await this.getCurrentIPData()
            this.searchTerm = this.ipData.ipAddress
            this.loading = false
        },
        methods: {
            getCurrentIPData: async () => {
                return new Promise((resolve, reject) => {
                    Axios.get('api/IP/self').then(res => resolve(res.data)).catch(err => resolve({}))
                })
            },
            getDataByIPAddress: async (searchTerm) => {
                return new Promise((resolve, reject) => {
                    Axios.get(`api/IP/${searchTerm}`).then(res => resolve(res.data)).catch(err => resolve({}))
                })
            },
            searchIpAddress: async function () {
                this.ipData = {}
                this.loading = true
                this.errorMessage = ''
                const data = await this.getDataByIPAddress(this.searchTerm)
                this.loading = false

                if (data.status === "success") {
                    this.ipData = data
                } else {
                    this.errorMessage = data.message
                }
            }
        }
    }
</script>

<style scoped>

</style>
