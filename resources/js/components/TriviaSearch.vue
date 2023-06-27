<template>
    <div>
        Search for trivia
    </div>
    <div class="flex flex-row ">
        <Select v-model="triviaFilters.category" :options="categories" label="Category"/>
        <Select v-model="triviaFilters.difficulty" :options="difficulties" class="ml-2" label="Difficulty"/>
        <Select v-model="triviaFilters.type" :options="types" class="ml-2" label="Type"/>
        <Button @click="search" color="default" class="mt-auto ml-2" >Search</Button>
    </div>
    <div>
        <div v-if="trivia.question">
            <p class="mb-2">{{ trivia.question }}</p>
            <p class="mb-2">{{ trivia.correct_answer }}</p>
            <p class="mb-2">{{ trivia.incorrect_answers }}</p>
        </div>
    </div>
</template>
<script>
import { Input, Button, Select } from 'flowbite-vue';

export default {
    data() {
        return {
            categories: [],
            difficulties: [
                {
                    name: 'Easy',
                    value: 'easy',
                },
                {
                    name: 'Medium',
                    value: 'medium',
                },
                {
                    name: 'Hard',
                    value: 'hard',
                }
            ],
            types: [
                {
                    name: 'Multiple Choice',
                    value: 'multiple',
                },
                {
                    name: 'True / False',
                    value: 'boolean',
                },
            ],
            triviaFilters: {
                category: '',
                difficulty: '',
                type: '',
            },
            trivia: {
                category: '',
                type: '',
                difficulty: '',
                question: '',
                correct_answer: '',
                incorrect_answers: [],
            },
            loading: true,
        }
    },
    methods: {
        async search() {
            try {
                const response = await axios.post(`/json/trivia/search`, {
                    params: this.triviaFilters,
                });
                this.trivia = response.data;
            } catch (error) {
                console.error(error);
            }
        }
    },
    async created() {
        try {
            const response = await axios.get(`/json/trivia/categories`);
            this.categories = response.data;
            this.loading = false;
        } catch (error) {
            console.error(error);
            this.loading = false;
        }
    },

    components: {
        Input,
        Button,
        Select,
    },
}
</script>
