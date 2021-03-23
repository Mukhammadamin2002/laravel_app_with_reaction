<template>

    <div class="mt-3 d-flex">
        <div class="px-1">
            <img style="width: 20px" src="/themes/reactions/images/reactions_like.jpg">
            <span class="px-1">2</span>
        </div>
        <div class="px-1">
            <img style="width: 20px" src="/themes/reactions/images/reactions_haha.jpg">
            <span class="px-1">2</span>
        </div>
        <div class="px-1">
            <img style="width: 20px" src="/themes/reactions/images/reactions_wow.jpg">
            <span class="px-1">2</span>
        </div>
    </div>

    <div class="border-top position-relative">

        <div class="bg-white border rounded shadow-sm position-absolute" style="bottom: 40px"
        v-show="show_reaction_types"
        >
            <button @click="toggleRaction(type)" 
            class="btn bg-light" 
            v-for="type in types" :key="type">
                <img style="width: 20px" :src="image(type)">
            </button>
        </div>

        <button
            @click="show_reaction_types = !show_reaction_types"
            class="btn btn-link">
            <span v-if="auth_reaction">
                <img :src="image(auth_reaction)" class="w-25">
                {{auth_reaction}}
            </span>
            <span v-else>Like</span>
        </button>

    </div>
</template>

<script>
    export default {

        props: ['reacted'],

        data() {
            return {
                show_reaction_types: false,
                types: ["like", "love", "haha", "angry", "sad", "wow"],
                auth_reaction: this.reacted ? this.reacted.type : null,
            };
        },
        methods: {
            image(type) {
                return `/themes/reactions/images/reactions_${type}.jpg`;
            },
            toggleRaction(reaction) {
                let path = window.location.href;

                axios.post(`${path}/reaction`, {reaction});

                this.show_reaction_types = false;

                this.auth_reaction = reaction;
            },
        },
    };
</script>
