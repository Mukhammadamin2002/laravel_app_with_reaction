<template>

    <div class="mt-3 d-flex">
        <div class="px-1" v-for="(count, reaction) in reactions_summary" :key="reaction" v-show="count">
            <img style="width: 20px" :src="image(reaction)">
            <span class="px-1">{{count}}</span>
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

        props: ["summary", "reacted"],

        data() {
            return {
                show_reaction_types: false,
                types: ["like", "love", "haha", "angry", "sad", "wow"],
                reactions_summary: { ... this.summary},
                auth_reaction: this.reacted ? this.reacted.type : null,
            };
        },
        methods: {
            image(type) {
                return `/themes/reactions/images/reactions_${type}.jpg`;
            },
            toggleRaction(reaction) {
                let path = window.location.href;
                let old_reaction = this.auth_reaction;

                axios.post(`${path}/reaction`, {reaction})
                .catch(() => {
                    this.saveReaction(old_reaction, reaction);
                })

                this.show_reaction_types = false;
                this.saveReaction(reaction, old_reaction);

            },

            saveReaction(new_reaction, old_reaction) {
                this.resetReactionsSummary(new_reaction, old_reaction);
                if(this.auth_reaction === new_reaction) {
                    this.auth_reaction = null;
                    return;
                } 
                    this.auth_reaction = new_reaction;
            },

            resetReactionsSummary(new_reaction, old_reaction) {
                if(old_reaction) {
                    this.reactions_summary[old_reaction]--;
                } 

                if(new_reaction && new_reaction !== old_reaction) {
                    if(!this.reactions_summary[new_reaction]) {
                        this.reactions_summary[new_reaction] = 1;
                        return;
                    }
                    this.reactions_summary[new_reaction]++;
                }
            },
        },
    };
</script>
