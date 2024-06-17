<script>
import {ref} from 'vue';
import axios from 'axios';
import isUrl from 'is-url';

export default {
    data() {
        return {
            originalUrl: '',
            shortUrl: '',
            error: '',
            currentUrl: window.location.href
        }
    },
    methods: {
        shortenUrl() {
            if (isUrl(this.originalUrl.replaceAll(' ',''))) {
                try {
                    const url = this.originalUrl.slice(-1) === '/'
                        ? this.originalUrl.substring(0, this.originalUrl.length - 1)
                        : this.originalUrl
                    const response = axios.post(window.routes.shortUrl, { url: url })
                        .then(response => {
                            this.shortUrl = response.data.url.short_url;
                            this.originalUrl = response.data.url.original_url;
                            this.error = null;
                        })
                        .catch(error => {
                            this.shortUrl = null;
                            if (error.response && error.response.data && error.response.data.error) {
                                this.error = error.response.data.error;
                            } else {
                                this.error = 'Failed to shorten the URL. Please try again.';
                            }
                        });
                } catch (error) {
                    this.error = 'Failed to shorten the URL. Please try again.';
                }
            } else {
                this.error = 'Please provide url formatted like https://google.com';
            }
        }
    }
}
</script>

<template>
    <div>
        <form class="col-5 m-5" @submit.prevent="shortenUrl">
            <div class="form-group d-flex mb-5">
                <label for="originalUrl">Enter URL to shorten:</label>
                <input class="form-control" type="text" id="originalUrl" v-model="originalUrl" required placeholder="Type in your url">
            </div>
            <div v-if="shortUrl">
                <p>Shortened URL: <a :href="originalUrl" target="_blank">{{ this.currentUrl + this.shortUrl }}</a></p>
            </div>
            <div v-if="error">
                <p>{{ error }}</p>
            </div>
        </form>
    </div>
</template>

<style scoped>

</style>
